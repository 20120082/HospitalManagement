package com.example.demo.repository;

import com.example.demo.model.Patient;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.mongodb.repository.MongoRepository;

import java.time.LocalDateTime;
import java.util.List;
import java.util.Optional;

public interface PatientRepository extends MongoRepository<Patient, String>, PatientRepositoryCustom {

    List<Patient> findByDeleteCheckFalse();

    Page<Patient> findByDeleteCheckFalse(Pageable pageable);

    long countByDeleteCheckFalse();

    long countByCreatedAtBetweenAndDeleteCheckFalse(LocalDateTime start, LocalDateTime end);
    
    Optional<Patient> findByPatientIdAndDeleteCheckFalse(String patientId);
    
    boolean existsByPatientId(String patientId);
}
