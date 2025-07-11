package com.hospital.prescription.controller;

import com.hospital.prescription.dto.PrescriptionDTO;
import com.hospital.prescription.service.PrescriptionService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Map;

@RestController
@RequestMapping("/api/prescriptions")
public class PrescriptionController {
    @Autowired
    private PrescriptionService prescriptionService;

    @PostMapping
    public ResponseEntity<?> createPrescription(@RequestBody PrescriptionDTO dto) {
        try {
            PrescriptionDTO created = prescriptionService.createPrescription(dto);
            return ResponseEntity.ok(created);
        } catch (RuntimeException e) {
            return new ResponseEntity<String>(e.getMessage(), HttpStatus.BAD_REQUEST);
        }
    }

    @GetMapping("/{id}")
    public ResponseEntity<PrescriptionDTO> getPrescription(@PathVariable Integer id) {
        PrescriptionDTO dto = prescriptionService.getPrescriptionById(id);
        if (dto == null) {
            return ResponseEntity.notFound().build();
        }
        return ResponseEntity.ok(dto);
    }
    
    @PutMapping("/{id}/status")
    public ResponseEntity<PrescriptionDTO> updatePrescriptionStatus(@PathVariable Integer id, @RequestBody String status) {
        PrescriptionDTO updated = prescriptionService.updatePrescriptionStatus(id, status);
        if (updated == null) {
            return ResponseEntity.notFound().build();
        }
        return ResponseEntity.ok(updated);
    }

    @GetMapping
    public ResponseEntity<List<PrescriptionDTO>> getAllPrescriptions() {
        List<PrescriptionDTO> dtos = prescriptionService.getAllPrescriptions();
        return ResponseEntity.ok(dtos);
    }
    
    @DeleteMapping("/{id}")
    public ResponseEntity<?> deletePrescription(@PathVariable Integer id) {
        try {
            boolean deleted = prescriptionService.deletePrescription(id);
            if (!deleted) {
                return ResponseEntity.notFound().build();
            }
            return ResponseEntity.noContent().build();
        } catch (RuntimeException e) {
            return new ResponseEntity<String>(e.getMessage(), HttpStatus.BAD_REQUEST);
        }
    }

    // --------------------- Thống kê ---------------------

    @GetMapping("/count")
    public ResponseEntity<Long> countAllPrescriptions() {
        Long count = prescriptionService.countAllPrescriptions();
        return ResponseEntity.ok(count);
    }

    @GetMapping("/count-by-month")
    public ResponseEntity<Long> countPrescriptionsByMonth(@RequestParam int year, @RequestParam int month) {
        Long count = prescriptionService.countPrescriptionsByMonth(year, month);
        return ResponseEntity.ok(count);
    }

    @GetMapping("/count-by-status")
    public ResponseEntity<Map<String, Long>> countPrescriptionsByStatus() {
        Map<String, Long> statusCount = prescriptionService.countPrescriptionsByStatus();
        return ResponseEntity.ok(statusCount);
    }
}