package com.hospital.prescription.repository;

import com.hospital.prescription.model.Prescription;
import org.springframework.data.jpa.repository.JpaRepository;
import java.time.LocalDate;

public interface PrescriptionRepository extends JpaRepository<Prescription, Integer> {
    Long countByCreatedDateBetween(LocalDate startDate, LocalDate endDate);
}