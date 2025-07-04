package com.example.demo.controller;

import com.example.demo.model.MedicalRecord;
import com.example.demo.service.MedicalRecordService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.format.annotation.DateTimeFormat;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.time.LocalDateTime;
import java.util.List;

@RestController
@RequestMapping("/api/medical-records")
public class MedicalRecordController {

    @Autowired
    private MedicalRecordService service;

    @GetMapping
    public ResponseEntity<List<MedicalRecord>> getAll() {
        return ResponseEntity.ok(service.getAll());
    }

    @PostMapping
    public ResponseEntity<MedicalRecord> create(@RequestBody MedicalRecord record) {
        return ResponseEntity.ok(service.create(record));
    }

    @PutMapping("/{id}")
    public ResponseEntity<MedicalRecord> update(@PathVariable String id, @RequestBody MedicalRecord record) {
        return ResponseEntity.ok(service.update(id, record));
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> delete(@PathVariable String id) {
        service.delete(id);
        return ResponseEntity.noContent().build();
    }

    @GetMapping("/patient")
    public ResponseEntity<List<MedicalRecord>> findByPatient(@RequestParam String patientId) {
        return ResponseEntity.ok(service.findByPatient(patientId));
    }

    @GetMapping("/room")
    public ResponseEntity<List<MedicalRecord>> findByRoom(@RequestParam String roomId) {
        return ResponseEntity.ok(service.findByRoom(roomId));
    }

    @GetMapping("/doctor")
    public ResponseEntity<List<MedicalRecord>> findByDoctor(@RequestParam String doctorId) {
        return ResponseEntity.ok(service.findByDoctor(doctorId));
    }

    @GetMapping("/date-range")
    public ResponseEntity<List<MedicalRecord>> findByDateRange(
            @RequestParam @DateTimeFormat(iso = DateTimeFormat.ISO.DATE_TIME) LocalDateTime start,
            @RequestParam @DateTimeFormat(iso = DateTimeFormat.ISO.DATE_TIME) LocalDateTime end
    ) {
        return ResponseEntity.ok(service.findByVisitDateRange(start, end));
    }
}

