package com.example.demo.controller;

import java.time.LocalDate;
import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.format.annotation.DateTimeFormat;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import com.example.demo.model.Patient;
import com.example.demo.service.PatientService;

import jakarta.validation.Valid;

@RestController
@RequestMapping("/api/patients")
public class PatientController {
	@Autowired
    private PatientService patientService;

    // --------------------- CRUD ---------------------

    @PostMapping
    public ResponseEntity<Patient> createPatient(@Valid @RequestBody Patient patient) {
    	Patient created = patientService.createPatient(patient);
        return ResponseEntity.status(HttpStatus.CREATED).body(created);
    }

    @GetMapping("{patientId}")
    public ResponseEntity<Patient> getPatientById(@PathVariable String patientId) {
        Patient patient = patientService.getPatientById(patientId);
        return patient != null ? ResponseEntity.ok(patient) : ResponseEntity.notFound().build();
    }

    @PutMapping("{patientId}")
    public ResponseEntity<Patient> updatePatient(@PathVariable String patientId, @Valid @RequestBody Patient patient) {
        Patient updated = patientService.updatePatient(patientId, patient);
        return updated != null ? ResponseEntity.ok(updated) : ResponseEntity.notFound().build();
    }

    @DeleteMapping("{patientId}")
    public ResponseEntity<Void> deletePatient(@PathVariable String patientId) {
        boolean deleted = patientService.softDeletePatient(patientId);
        return deleted ? ResponseEntity.noContent().build() : ResponseEntity.notFound().build();
    }

    // --------------------- Lấy danh sách + phân trang ---------------------

    @GetMapping
    public ResponseEntity<List<Patient>> getAllPatients() {
        return ResponseEntity.ok(patientService.getAllActivePatients());
    }

    @GetMapping("/paged")
    public ResponseEntity<Page<Patient>> getAllPaged(Pageable pageable) {
        return ResponseEntity.ok(patientService.getAllPatientsPaged(pageable));
    }

    // --------------------- Đếm số lượng ---------------------

    @GetMapping("/count")
    public ResponseEntity<Long> countAllPatients() {
        return ResponseEntity.ok(patientService.countAllActivePatients());
    }

    @GetMapping("/count-by-month")
    public ResponseEntity<Long> countPatientsByMonth(@RequestParam int year, @RequestParam int month) {
        return ResponseEntity.ok(patientService.countPatientsByMonth(year, month));
    }

    // --------------------- Tìm kiếm nâng cao ---------------------

    @GetMapping("/search")
    public ResponseEntity<List<Patient>> searchPatients(
            @RequestParam(required = false) String fullName,
            @RequestParam(required = false) String gender,
            @RequestParam(required = false) @DateTimeFormat(iso = DateTimeFormat.ISO.DATE) LocalDate dateOfBirth,
            @RequestParam(required = false) String phoneNumber,
            @RequestParam(required = false) String email,
            @RequestParam(required = false) String address
    ) {
        return ResponseEntity.ok(
                patientService.searchPatients(fullName, gender, dateOfBirth, phoneNumber, email, address)
        );
    }
}