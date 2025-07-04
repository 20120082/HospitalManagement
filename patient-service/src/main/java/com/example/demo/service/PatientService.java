package com.example.demo.service;

import com.example.demo.model.Patient;
import com.example.demo.repository.PatientRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.time.LocalDate;
import java.time.LocalDateTime;
import java.util.List;
import java.util.NoSuchElementException;
import java.util.Optional;
import java.util.stream.Collectors;

@Service
public class PatientService {

    @Autowired
    private PatientRepository repo;

    public Patient add(Patient p) {
    	long count = repo.count() + 1;
        p.setPatientId(String.format("BN%04d", count));
        p.setCreatedAt(LocalDateTime.now());
        return repo.save(p);
    }

    public List<Patient> getAllPatients() {
        return repo.findAll(); //thiếu kiểm tra deletecheck
    }

    public Optional<Patient> getById(String patientId) {
        return repo.findByPatientId(patientId).filter(p -> !p.isDeleteCheck());
    }

    public Patient update(String patientId, Patient data) {
        return repo.findByPatientId(patientId).map(p -> {
            p.setFullName(data.getFullName());
            p.setGender(data.getGender());
            p.setDateOfBirth(data.getDateOfBirth());
            p.setAddress(data.getAddress());
            p.setEmail(data.getEmail());
            p.setPhoneNumber(data.getPhoneNumber());
            return repo.save(p);
        }).orElseThrow(() -> new NoSuchElementException("Patient not found"));
    }

    public void delete(String patientId, boolean hardDelete) {
        if (hardDelete) {
            repo.deleteByPatientId(patientId);
        } else {
            repo.findByPatientId(patientId).ifPresent(p -> {
                p.setDeleteCheck(true);
                repo.save(p);
            });
        }
    }
    
    public long countAll() {
        return repo.countByDeleteCheckFalse();
    }

    public long countByMonth(int month, int year) {
        LocalDateTime start = LocalDate.of(year, month, 1).atStartOfDay();
        LocalDateTime end = start.plusMonths(1);
        return repo.findByCreatedAtBetween(start, end).size();
    }

    public List<Patient> searchByName(String name) {
        return repo.findByFullNameContainingIgnoreCaseAndDeleteCheckFalse(name);
    }

    public Optional<Patient> findByPhone(String phone) {
        return repo.findByPhoneNumber(phone);
    }

    public Optional<Patient> findByEmail(String email) {
        return repo.findByEmail(email);
    }
    
    public List<Patient> searchByCriteria(String name, String phone, String email) {
        List<Patient> all = repo.findAll().stream()
            .filter(p -> !p.isDeleteCheck())
            .filter(p -> name == null || name.trim().isEmpty() || isWordMatch(p.getFullName(), name))
            .filter(p -> phone == null || phone.equalsIgnoreCase(p.getPhoneNumber()))
            .filter(p -> email == null || email.equalsIgnoreCase(p.getEmail()))
            .collect(Collectors.toList());

        return all;
    }

    private boolean isWordMatch(String fullName, String searchName) {
        if (fullName == null || searchName == null) return false;
        String[] words = fullName.split("\\s+");
        for (String word : words) {
            if (word.equalsIgnoreCase(searchName)) return true;
        }
        return false;
    }
    
}
