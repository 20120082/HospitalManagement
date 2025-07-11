package com.example.demo.repository;

import com.example.demo.model.MedicalRecord;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.mongodb.repository.MongoRepository;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public interface MedicalRecordRepository extends MongoRepository<MedicalRecord, String> {

    Optional<MedicalRecord> findByRecordIdAndDeleteCheckFalse(String recordId);

    List<MedicalRecord> findByDeleteCheckFalse();

	Page<MedicalRecord> findByDeleteCheckFalse(Pageable pageable);

}
