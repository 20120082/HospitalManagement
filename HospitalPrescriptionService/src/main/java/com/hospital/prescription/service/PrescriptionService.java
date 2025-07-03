package com.hospital.prescription.service;

import com.hospital.prescription.dto.PrescriptionDTO;
import com.hospital.prescription.dto.PrescriptionDetailDTO;
import com.hospital.prescription.model.Prescription;
import com.hospital.prescription.model.PrescriptionDetail;
import com.hospital.prescription.repository.PrescriptionDetailRepository;
import com.hospital.prescription.repository.PrescriptionRepository;
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

@Service
public class PrescriptionService {
    @Autowired
    private PrescriptionRepository prescriptionRepository;

    @Autowired
    private PrescriptionDetailRepository detailRepository;

    @Autowired
    private RestTemplate restTemplate;
    private static final String MEDICINE_SERVICE_URL = "http://localhost:8084/api/medicines";

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

        List<PrescriptionDetail> details = new ArrayList<PrescriptionDetail>();
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

                    Map<String, Object> updateRequest = new HashMap<String, Object>();
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
                        new HttpEntity<Map>(updateRequest),
                        Void.class
                    );
                } catch (HttpClientErrorException e) {
                    throw new RuntimeException("Error updating medicine quantity: ID " + detailDTO.getIdMedicine() + " - " + e.getMessage());
                }
            }
            detailRepository.saveAll(details);
        }

        savedPrescription.setDetails(details);
        return mapToDTO(savedPrescription);
    }

    public PrescriptionDTO getPrescriptionById(Integer id) {
        Optional<Prescription> prescription = prescriptionRepository.findById(id);
        return prescription.isPresent() ? mapToDTO(prescription.get()) : null;
    }

    public List<PrescriptionDTO> getAllPrescriptions() {
        List<Prescription> prescriptions = prescriptionRepository.findAll();
        List<PrescriptionDTO> dtos = new ArrayList<PrescriptionDTO>();
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
            return mapToDTO(updatedPrescription);
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

                        Map<String, Object> updateRequest = new HashMap<String, Object>();
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
                            new HttpEntity<Map>(updateRequest),
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

        List<PrescriptionDetailDTO> detailDTOs = new ArrayList<PrescriptionDetailDTO>();
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