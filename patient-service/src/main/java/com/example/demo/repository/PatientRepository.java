package com.example.demo.repository;

import java.time.LocalDateTime;
import java.util.List;
import java.util.Optional;

import org.springframework.data.mongodb.repository.MongoRepository;
import org.springframework.data.mongodb.repository.Query;
import org.springframework.stereotype.Repository;

import com.example.demo.model.Patient;

@Repository
public interface PatientRepository extends MongoRepository<Patient, String> {
    Optional<Patient> findByPhoneNumber(String phoneNumber);
    List<Patient> findByFullNameContainingIgnoreCaseAndDeleteCheckFalse(String fullName);
    Optional<Patient> findByPatientIdAndDeleteCheckFalse(String patientId);
    List<Patient> findAllByDeleteCheckFalse();
    Optional<Patient> findByPatientId(String patientId);
    Optional<Patient> findByEmail(String email);
    boolean existsByPatientId(String patientId);
    void deleteByPatientId(String patientId);
    
    @Query("{ 'createdAt': { $gte: ?0, $lt: ?1 }, 'deleteCheck': false }")
    List<Patient> findByCreatedAtBetween(LocalDateTime start, LocalDateTime end);

    long countByDeleteCheckFalse();
    
    @Query("{ 'fullName': { $regex: ?0, $options: 'i' }, 'deleteCheck': false }")
    List<Patient> searchByFullNameRegex(String regex);
}
