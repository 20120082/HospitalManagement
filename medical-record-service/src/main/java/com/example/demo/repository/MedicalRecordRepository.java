package com.example.demo.repository;

import com.example.demo.model.MedicalRecord;
import org.springframework.data.mongodb.repository.MongoRepository;

import java.time.LocalDateTime;
import java.util.List;

public interface MedicalRecordRepository extends MongoRepository<MedicalRecord, String> {

    List<MedicalRecord> findByDeleteCheckFalse();

    List<MedicalRecord> findByPatientIdAndDeleteCheckFalse(String patientId);

    List<MedicalRecord> findByRoomIdAndDeleteCheckFalse(String roomId);

    List<MedicalRecord> findByDoctorAndDeleteCheckFalse(String doctorId);

    List<MedicalRecord> findByVisitDateBetweenAndDeleteCheckFalse(LocalDateTime start, LocalDateTime end);
}

