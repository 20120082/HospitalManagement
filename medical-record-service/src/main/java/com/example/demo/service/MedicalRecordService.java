package com.example.demo.service;

import com.example.demo.model.MedicalRecord;
import com.example.demo.repository.MedicalRecordRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;
import java.util.List;

@Service
public class MedicalRecordService {

    @Autowired
    private MedicalRecordRepository repo;

    public List<MedicalRecord> getAll() {
        return repo.findByDeleteCheckFalse();
    }

    public MedicalRecord create(MedicalRecord record) {
        return repo.save(record);
    }

    public MedicalRecord update(String id, MedicalRecord updated) {
        updated.setId(id);
        return repo.save(updated);
    }

    public void delete(String id) {
        MedicalRecord record = repo.findById(id).orElseThrow();
        record.setDeleteCheck(true);
        repo.save(record);
    }

    public List<MedicalRecord> findByPatient(String patientId) {
        return repo.findByPatientIdAndDeleteCheckFalse(patientId);
    }

    public List<MedicalRecord> findByRoom(String roomId) {
        return repo.findByRoomIdAndDeleteCheckFalse(roomId);
    }

    public List<MedicalRecord> findByDoctor(String doctorId) {
        return repo.findByDoctorAndDeleteCheckFalse(doctorId);
    }

    public List<MedicalRecord> findByVisitDateRange(LocalDateTime start, LocalDateTime end) {
        return repo.findByVisitDateBetweenAndDeleteCheckFalse(start, end);
    }
}

