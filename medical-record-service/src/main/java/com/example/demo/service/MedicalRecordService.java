package com.example.demo.service;

import com.example.demo.model.MedicalRecord;
import com.example.demo.repository.MedicalRecordRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.data.mongodb.core.MongoTemplate;
import org.springframework.data.mongodb.core.query.Criteria;
import org.springframework.data.mongodb.core.query.Query;
import org.springframework.data.mongodb.core.query.Update;
import org.springframework.stereotype.Service;
import org.springframework.data.mongodb.core.FindAndModifyOptions;
import org.bson.Document;

import java.time.LocalDate;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.List;

@Service
public class MedicalRecordService {

    @Autowired
    private MedicalRecordRepository medicalRecordRepository;

    @Autowired
    private MongoTemplate mongoTemplate;
    
    //------------------------CRUD--------------------------
    public MedicalRecord createMedicalRecord(MedicalRecord record) {
        record.setCreatedAt(LocalDateTime.now());
        record.setDiagnosis(record.getDiagnosis() != null ? record.getDiagnosis() : "Chưa có");
        record.setTreatment(record.getTreatment() != null ? record.getTreatment() : "Chưa có");
        record.setDeleteCheck(false);
        record.setRecordId(generateRecordId());
        return medicalRecordRepository.save(record);
    }

    public MedicalRecord updateMedicalRecord(String recordId, MedicalRecord updated) {
        MedicalRecord existing = medicalRecordRepository.findByRecordIdAndDeleteCheckFalse(recordId).orElse(null);
        if (existing == null) return null;

        existing.setPatientId(updated.getPatientId());
        existing.setRoomId(updated.getRoomId());
        existing.setDoctorId(updated.getDoctorId());
        existing.setDoctorName(updated.getDoctorName());
        existing.setDiagnosis(updated.getDiagnosis());
        existing.setTreatment(updated.getTreatment());
        return medicalRecordRepository.save(existing);
    }

    public boolean softDeleteRecord(String recordId) {
        MedicalRecord record = medicalRecordRepository.findByRecordIdAndDeleteCheckFalse(recordId).orElse(null);
        if (record == null) return false;
        record.setDeleteCheck(true);
        medicalRecordRepository.save(record);
        return true;
    }

    public List<MedicalRecord> getAllRecords() {
        return medicalRecordRepository.findByDeleteCheckFalse();
    }

    public Page<MedicalRecord> getRecordsPaged(int page, int size) {
        Pageable pageable = PageRequest.of(page, size);
        return medicalRecordRepository.findByDeleteCheckFalse(pageable);
    }

    public MedicalRecord getRecordById(String recordId) {
        return medicalRecordRepository.findByRecordIdAndDeleteCheckFalse(recordId).orElse(null);
    }
    
    //------------------------GenerateId--------------------------
    private String generateRecordId() {
        String counterId = "recordId-counter";

        Query counterQuery = new Query(Criteria.where("_id").is(counterId));
        Document counterDoc = mongoTemplate.findOne(counterQuery, Document.class, "counters");

        if (counterDoc == null) {
            long existingCount = mongoTemplate.count(new Query(), "medical_records");
            Document newCounter = new Document("_id", counterId).append("seq", (int) existingCount + 1);
            mongoTemplate.insert(newCounter, "counters");
        }

        Update update = new Update().inc("seq", 1);
        FindAndModifyOptions options = FindAndModifyOptions.options().returnNew(true);
        Document result = mongoTemplate.findAndModify(counterQuery, update, options, Document.class, "counters");

        int seq = result.getInteger("seq");
        return String.format("BA%05d", seq);
    }
    
    //------------------------Advanced Search--------------------------
    public List<MedicalRecord> searchRecords(String recordId, String patientId, String roomId,
                                             String doctorId, String doctorName, String createdAt) {
        Criteria criteria = new Criteria();
        criteria.and("deleteCheck").is(false);

        if (recordId != null && !recordId.isEmpty()) criteria.and("recordId").is(recordId);
        if (patientId != null && !patientId.isEmpty()) criteria.and("patientId").is(patientId);
        if (roomId != null && !roomId.isEmpty()) criteria.and("roomId").is(roomId);
        if (doctorId != null && !doctorId.isEmpty()) criteria.and("doctorId").is(doctorId);
        if (doctorName != null && !doctorName.isEmpty()) criteria.and("doctorName").regex(doctorName, "i");

        if (createdAt != null && !createdAt.isEmpty()) {
            try {
                LocalDate date = LocalDate.parse(createdAt, DateTimeFormatter.ISO_LOCAL_DATE);
                LocalDateTime start = date.atStartOfDay();
                LocalDateTime end = date.plusDays(1).atStartOfDay();
                criteria.and("createdAt").gte(start).lt(end);
            } catch (Exception ignored) {}
        }

        Query query = new Query(criteria);
        return mongoTemplate.find(query, MedicalRecord.class);
    }
}
