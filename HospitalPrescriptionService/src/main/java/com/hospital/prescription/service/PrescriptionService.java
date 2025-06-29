package com.hospital.prescription.service;

import com.hospital.prescription.dto.PrescriptionDTO;
import com.hospital.prescription.dto.PrescriptionDetailDTO;
import com.hospital.prescription.model.Prescription;
import com.hospital.prescription.model.PrescriptionDetail;
import com.hospital.prescription.repository.PrescriptionDetailRepository;
import com.hospital.prescription.repository.PrescriptionRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.ArrayList;
import java.util.List;
import java.util.Optional;

@Service
public class PrescriptionService {
    @Autowired
    private PrescriptionRepository prescriptionRepository;

    @Autowired
    private PrescriptionDetailRepository detailRepository;

    public PrescriptionDTO createPrescription(PrescriptionDTO dto) {
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
            }
            detailRepository.saveAll(details);
        }

        savedPrescription.setDetails(details);
        return mapToDTO(savedPrescription);
    }

    public PrescriptionDTO getPrescriptionById(Integer id) {
        Optional<Prescription> prescription = prescriptionRepository.findById(id);
        return prescription.map(this::mapToDTO).orElse(null);
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
            return mapToDTO(updatedPrescription);
        }
        return null;
    }
    
    public boolean deletePrescription(Integer id)
    {
    	if (prescriptionRepository.existsById(id)) {
            prescriptionRepository.deleteById(id);
            return true;
        }
        return false;
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