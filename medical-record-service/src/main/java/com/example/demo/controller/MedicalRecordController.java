package com.example.demo.controller;

import com.example.demo.model.MedicalRecord;
import com.example.demo.service.MedicalRecordService;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import jakarta.validation.Valid;
import java.util.List;

@RestController
@RequestMapping("/api/medical-records")
public class MedicalRecordController {

    @Autowired
    private MedicalRecordService medicalRecordService;

    @PostMapping
    public ResponseEntity<MedicalRecord> createMedicalRecord(@Valid @RequestBody MedicalRecord record) {
        return ResponseEntity.ok(medicalRecordService.createMedicalRecord(record));
    }

    @PutMapping("/{recordId}")
    public ResponseEntity<MedicalRecord> updateMedicalRecord(@PathVariable String recordId, @Valid @RequestBody MedicalRecord record) {
        MedicalRecord updated = medicalRecordService.updateMedicalRecord(recordId, record);
        return updated != null ? ResponseEntity.ok(updated) : ResponseEntity.notFound().build();
    }

    @GetMapping
    public ResponseEntity<List<MedicalRecord>> getAllRecords() {
        return ResponseEntity.ok(medicalRecordService.getAllRecords());
    }

    @GetMapping("/paged")
    public ResponseEntity<Page<MedicalRecord>> getRecordsPaged(@RequestParam int page, @RequestParam int size) {
        return ResponseEntity.ok(medicalRecordService.getRecordsPaged(page, size));
    }

    @GetMapping("/{recordId}")
    public ResponseEntity<MedicalRecord> getRecordById(@PathVariable String recordId) {
        MedicalRecord record = medicalRecordService.getRecordById(recordId);
        return record != null ? ResponseEntity.ok(record) : ResponseEntity.notFound().build();
    }

    @DeleteMapping("/{recordId}")
    public ResponseEntity<Void> deleteRecord(@PathVariable String recordId) {
        boolean deleted = medicalRecordService.softDeleteRecord(recordId);
        return deleted ? ResponseEntity.ok().build() : ResponseEntity.notFound().build();
    }
    
    @GetMapping("/search")
    public ResponseEntity<List<MedicalRecord>> searchRecords(
            @RequestParam(required = false) String recordId,
            @RequestParam(required = false) String patientId,
            @RequestParam(required = false) String roomId,
            @RequestParam(required = false) String doctorId,
            @RequestParam(required = false) String doctorName,
            @RequestParam(required = false) String createdAt) {
        return ResponseEntity.ok(medicalRecordService.searchRecords(recordId, patientId, roomId, doctorId, doctorName, createdAt));
    }

}
