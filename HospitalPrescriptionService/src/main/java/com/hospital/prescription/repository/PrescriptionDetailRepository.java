package com.hospital.prescription.repository;

import com.hospital.prescription.model.PrescriptionDetail;
import org.springframework.data.jpa.repository.JpaRepository;

public interface PrescriptionDetailRepository extends JpaRepository<PrescriptionDetail, Integer> {
}