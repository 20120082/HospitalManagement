package com.hospital.prescription.service;

import com.hospital.prescription.dto.PrescriptionDTO;
import com.hospital.prescription.dto.PrescriptionDetailDTO;
import com.hospital.prescription.model.Prescription;
import com.hospital.prescription.model.PrescriptionDetail;
import com.hospital.prescription.repository.PrescriptionDetailRepository;
import com.hospital.prescription.repository.PrescriptionRepository;
import com.rabbitmq.client.Channel;
import com.rabbitmq.client.Connection;
import com.rabbitmq.client.ConnectionFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.web.client.RestTemplate;
import org.springframework.http.HttpEntity;
import org.springframework.http.HttpMethod;
import org.springframework.http.ResponseEntity;
import org.springframework.web.client.HttpClientErrorException;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Optional;
import com.fasterxml.jackson.databind.ObjectMapper;

@Service
public class PrescriptionService {
    @Autowired
    private PrescriptionRepository prescriptionRepository;

    @Autowired
    private PrescriptionDetailRepository detailRepository;

    @Autowired
    private RestTemplate restTemplate;

    private static final String MEDICINE_SERVICE_URL = "http://localhost:8084/api/medicines";
    private static final String PATIENT_SERVICE_URL = "http://localhost:8090/api/patients";
    private static final String RABBITMQ_HOST = "localhost";
    private static final String QUEUE_NAME = "prescription_notifications";

    private final ObjectMapper objectMapper = new ObjectMapper();

    private void publishToRabbitMQ(PrescriptionDTO prescriptionDTO, String patientEmail, String patientName) {
        try {
            ConnectionFactory factory = new ConnectionFactory();
            factory.setHost(RABBITMQ_HOST);
            try (Connection connection = factory.newConnection();
                 Channel channel = connection.createChannel()) {
                channel.queueDeclare(QUEUE_NAME, true, false, false, null);
                
                Map<String, Object> message = new HashMap<>();
                message.put("to", patientEmail);
                message.put("patientName", patientName);
                message.put("prescriptionTime", prescriptionDTO.getCreatedDate().toString());
                
                List<String> detailLines = new ArrayList<>();
                float totalAmount = 0;
                for (PrescriptionDetailDTO detail : prescriptionDTO.getDetails()) {
                    ResponseEntity<Map> medicineResponse = restTemplate.getForEntity(
                        MEDICINE_SERVICE_URL + "/" + detail.getIdMedicine(), Map.class);
                    Map<String, Object> medicine = medicineResponse.getBody();
                    String medicineName = (String) medicine.get("name");
                    String line = medicineName + " x" + detail.getQuantity() + " (" + 
                        numberFormat(detail.getPrice() * detail.getQuantity()) + " VND)";
                    detailLines.add(line);
                    totalAmount += detail.getPrice() * detail.getQuantity();
                }
                message.put("prescriptionDetail", String.join(", ", detailLines) + 
                    "\nTổng giá tiền: " + numberFormat(totalAmount) + " VND");

                String messageJson = objectMapper.writeValueAsString(message);
                channel.basicPublish("", QUEUE_NAME, null, messageJson.getBytes("UTF-8"));
            }
        } catch (Exception e) {
            throw new RuntimeException("Error publishing to RabbitMQ: " + e.getMessage());
        }
    }

    private String numberFormat(float value) {
        return String.format("%.2f", value);
    }

    @Transactional
    public PrescriptionDTO createPrescription(PrescriptionDTO dto) {
        if (dto.getDetails() != null) {
            for (PrescriptionDetailDTO detailDTO : dto.getDetails()) {
                try {
                    ResponseEntity<Map> response = restTemplate.getForEntity(
                        MEDICINE_SERVICE_URL + "/" + detailDTO.getIdMedicine(), Map.class);
                    if (!response.getStatusCode().is2xxSuccessful()) {
                        throw new RuntimeException("Medicine not found: ID " + detailDTO.getIdMedicine());
                    }
                    Map<String, Object> medicine = response.getBody();
                    Integer availableQuantity = (Integer) medicine.get("quantity");
                    String medicineName = (String) medicine.get("name");

                    if (detailDTO.getQuantity() > availableQuantity) {
                        throw new RuntimeException("Insufficient quantity for medicine: " + medicineName);
                    }
                } catch (HttpClientErrorException e) {
                    throw new RuntimeException("Error fetching medicine: ID " + detailDTO.getIdMedicine() + " - " + e.getMessage());
                }
            }
        }

        Prescription prescription = new Prescription();
        prescription.setIdPatient(dto.getIdPatient());
        prescription.setCreatedDate(dto.getCreatedDate());
        prescription.setStatus(dto.getStatus());

        Prescription savedPrescription = prescriptionRepository.save(prescription);

        List<PrescriptionDetail> details = new ArrayList<>();
        if (dto.getDetails() != null) {
            for (PrescriptionDetailDTO detailDTO : dto.getDetails()) {
                PrescriptionDetail detail = new PrescriptionDetail();
                detail.setIdPrescription(savedPrescription.getId());
                detail.setIdMedicine(detailDTO.getIdMedicine());
                detail.setQuantity(detailDTO.getQuantity());
                detail.setUnit(detailDTO.getUnit());
                detail.setPrice(detailDTO.getPrice());
                details.add(detail);

                try {
                    ResponseEntity<Map> response = restTemplate.getForEntity(
                        MEDICINE_SERVICE_URL + "/" + detailDTO.getIdMedicine(), Map.class);
                    Map<String, Object> medicine = response.getBody();
                    Integer currentQuantity = (Integer) medicine.get("quantity");
                    int newQuantity = currentQuantity - detailDTO.getQuantity().intValue();

                    Map<String, Object> updateRequest = new HashMap<>();
                    updateRequest.put("id", medicine.get("id"));
                    updateRequest.put("code", medicine.get("code"));
                    updateRequest.put("name", medicine.get("name"));
                    updateRequest.put("category", medicine.get("category"));
                    updateRequest.put("description", medicine.get("description"));
                    updateRequest.put("unit", medicine.get("unit"));
                    updateRequest.put("price", medicine.get("price"));
                    updateRequest.put("quantity", newQuantity);
                    updateRequest.put("manufacturer", medicine.get("manufacturer"));
                    updateRequest.put("expiryDate", medicine.get("expiryDate"));
                    updateRequest.put("createdAt", medicine.get("createdAt"));
                    updateRequest.put("updatedAt", medicine.get("updatedAt"));

                    restTemplate.exchange(
                        MEDICINE_SERVICE_URL + "/" + detailDTO.getIdMedicine(),
                        HttpMethod.PUT,
                        new HttpEntity<>(updateRequest),
                        Void.class
                    );
                } catch (HttpClientErrorException e) {
                    throw new RuntimeException("Error updating medicine quantity: ID " + detailDTO.getIdMedicine() + " - " + e.getMessage());
                }
            }
            detailRepository.saveAll(details);
        }

        savedPrescription.setDetails(details);
        PrescriptionDTO resultDTO = mapToDTO(savedPrescription);

        // Fetch patient info and publish to RabbitMQ
        try {
            ResponseEntity<Map> patientResponse = restTemplate.getForEntity(
                PATIENT_SERVICE_URL + "/" + dto.getIdPatient(), Map.class);
            if (patientResponse.getStatusCode().is2xxSuccessful()) {
                Map<String, Object> patient = patientResponse.getBody();
                String patientEmail = (String) patient.get("email");
                String patientName = (String) patient.get("fullName");
                publishToRabbitMQ(resultDTO, patientEmail, patientName);
            }
        } catch (HttpClientErrorException e) {
            throw new RuntimeException("Error fetching patient: ID " + dto.getIdPatient() + " - " + e.getMessage());
        }

        return resultDTO;
    }

    public PrescriptionDTO getPrescriptionById(Integer id) {
        Optional<Prescription> prescription = prescriptionRepository.findById(id);
        return prescription.isPresent() ? mapToDTO(prescription.get()) : null;
    }

    public List<PrescriptionDTO> getAllPrescriptions() {
        List<Prescription> prescriptions = prescriptionRepository.findAll();
        List<PrescriptionDTO> dtos = new ArrayList<>();
        for (Prescription prescription : prescriptions) {
            dtos.add(mapToDTO(prescription));
        }
        return dtos;
    }

    public PrescriptionDTO updatePrescriptionStatus(Integer id, String status) {
        Optional<Prescription> optionalPrescription = prescriptionRepository.findById(id);
        if (optionalPrescription.isPresent()) {
            Prescription prescription = optionalPrescription.get();
            prescription.setStatus(status);
            Prescription updatedPrescription = prescriptionRepository.save(prescription);
            PrescriptionDTO resultDTO = mapToDTO(updatedPrescription);

            // Publish to RabbitMQ if status is "Chưa lấy"
            if ("Chưa lấy".equals(status)) {
                try {
                    ResponseEntity<Map> patientResponse = restTemplate.getForEntity(
                        PATIENT_SERVICE_URL + "/" + prescription.getIdPatient(), Map.class);
                    if (patientResponse.getStatusCode().is2xxSuccessful()) {
                        Map<String, Object> patient = patientResponse.getBody();
                        String patientEmail = (String) patient.get("email");
                        String patientName = (String) patient.get("fullName");
                        publishToRabbitMQ(resultDTO, patientEmail, patientName);
                    }
                } catch (HttpClientErrorException e) {
                    throw new RuntimeException("Error fetching patient: ID " + prescription.getIdPatient() + " - " + e.getMessage());
                }
            }
            return resultDTO;
        }
        return null;
    }

    @Transactional
    public boolean deletePrescription(Integer id) {
        Optional<Prescription> optionalPrescription = prescriptionRepository.findById(id);
        if (!optionalPrescription.isPresent()) {
            return false;
        }

        Prescription prescription = optionalPrescription.get();
        if ("Chưa lấy".equals(prescription.getStatus())) {
            List<PrescriptionDetail> details = prescription.getDetails();
            if (details != null) {
                for (PrescriptionDetail detail : details) {
                    try {
                        ResponseEntity<Map> response = restTemplate.getForEntity(
                            MEDICINE_SERVICE_URL + "/" + detail.getIdMedicine(), Map.class);
                        if (!response.getStatusCode().is2xxSuccessful()) {
                            throw new RuntimeException("Medicine not found: ID " + detail.getIdMedicine());
                        }
                        Map<String, Object> medicine = response.getBody();
                        Integer currentQuantity = (Integer) medicine.get("quantity");
                        int newQuantity = currentQuantity + detail.getQuantity().intValue();

                        Map<String, Object> updateRequest = new HashMap<>();
                        updateRequest.put("id", medicine.get("id"));
                        updateRequest.put("code", medicine.get("code"));
                        updateRequest.put("name", medicine.get("name"));
                        updateRequest.put("category", medicine.get("category"));
                        updateRequest.put("description", medicine.get("description"));
                        updateRequest.put("unit", medicine.get("unit"));
                        updateRequest.put("price", medicine.get("price"));
                        updateRequest.put("quantity", newQuantity);
                        updateRequest.put("manufacturer", medicine.get("manufacturer"));
                        updateRequest.put("expiryDate", medicine.get("expiryDate"));
                        updateRequest.put("createdAt", medicine.get("createdAt"));
                        updateRequest.put("updatedAt", medicine.get("updatedAt"));

                        restTemplate.exchange(
                            MEDICINE_SERVICE_URL + "/" + detail.getIdMedicine(),
                            HttpMethod.PUT,
                            new HttpEntity<>(updateRequest),
                            Void.class
                        );
                    } catch (HttpClientErrorException e) {
                        throw new RuntimeException("Error restoring medicine quantity: ID " + detail.getIdMedicine() + " - " + e.getMessage());
                    }
                }
            }
        }

        prescriptionRepository.deleteById(id);
        return true;
    }

    private PrescriptionDTO mapToDTO(Prescription prescription) {
        PrescriptionDTO dto = new PrescriptionDTO();
        dto.setId(prescription.getId());
        dto.setIdPatient(prescription.getIdPatient());
        dto.setCreatedDate(prescription.getCreatedDate());
        dto.setStatus(prescription.getStatus());

        List<PrescriptionDetailDTO> detailDTOs = new ArrayList<>();
        if (prescription.getDetails() != null) {
            for (PrescriptionDetail detail : prescription.getDetails()) {
                PrescriptionDetailDTO detailDTO = new PrescriptionDetailDTO();
                detailDTO.setId(detail.getId());
                detailDTO.setIdPrescription(detail.getIdPrescription());
                detailDTO.setIdMedicine(detail.getIdMedicine());
                detailDTO.setQuantity(detail.getQuantity());
                detailDTO.setUnit(detail.getUnit());
                detailDTO.setPrice(detail.getPrice());
                detailDTOs.add(detailDTO);
            }
        }
        dto.setDetails(detailDTOs);
        return dto;
    }
}