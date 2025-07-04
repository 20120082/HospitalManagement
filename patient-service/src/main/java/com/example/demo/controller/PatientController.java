package com.example.demo.controller;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
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
import com.example.demo.repository.PatientRepository;
import com.example.demo.service.PatientService;

@RestController
@RequestMapping("/api/patients")
public class PatientController {
    @Autowired
    private PatientService service;
    
    @Autowired
    private PatientRepository repo;

    @PostMapping
    public ResponseEntity<Patient> create(@RequestBody Patient p) {
        return new ResponseEntity<>(service.add(p), HttpStatus.CREATED);
    }

    @GetMapping
    public List<Patient> getAllPatients() {
        return service.getAllPatients();
    }

    @GetMapping("/{id}")
    public ResponseEntity<Patient> getPatientByPatientId(@PathVariable String id) {
        return service.getById(id)
            .map(ResponseEntity::ok)
            .orElse(ResponseEntity.notFound().build());
    }

    @PutMapping("/{id}")
    public ResponseEntity<Patient> update(@PathVariable String id, @RequestBody Patient p) {
        return ResponseEntity.ok(service.update(id, p));
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> delete(@PathVariable String id,
                                       @RequestParam(defaultValue = "false") boolean hard) {
        service.delete(id, hard);
        return ResponseEntity.noContent().build();
    }
    
    @GetMapping("/search")
    public ResponseEntity<List<Patient>> searchByName(@RequestParam String name) {
        return ResponseEntity.ok(repo.findByFullNameContainingIgnoreCaseAndDeleteCheckFalse(name));
    }
    
    @GetMapping("/count")
    public ResponseEntity<Long> getTotalPatients() {
        return ResponseEntity.ok(service.countAll());
    }

    @GetMapping("/count-by-month")
    public ResponseEntity<Long> getPatientsByMonth(@RequestParam int month, @RequestParam int year) {
        return ResponseEntity.ok(service.countByMonth(month, year));
    }

    @GetMapping("/phone")
    public ResponseEntity<Patient> findByPhone(@RequestParam String phone) {
        return service.findByPhone(phone).map(ResponseEntity::ok).orElse(ResponseEntity.notFound().build());
    }

    @GetMapping("/email")
    public ResponseEntity<Patient> findByEmail(@RequestParam String email) {
        return service.findByEmail(email).map(ResponseEntity::ok).orElse(ResponseEntity.notFound().build());
    }
    
    @GetMapping("/search-advanced")
    public ResponseEntity<List<Patient>> searchAdvanced(
        @RequestParam(required = false) String name,
        @RequestParam(required = false) String phone,
        @RequestParam(required = false) String email) {
        return ResponseEntity.ok(service.searchByCriteria(name, phone, email));
    }
}