package com.example.demo.repository;

import java.time.LocalDate;
import java.util.List;

import com.example.demo.model.Patient;

public interface PatientRepositoryCustom {
	List<Patient> advancedSearch(String fullName, String gender, LocalDate dateOfBirth, String phoneNumber,
			String email, String address);
}
