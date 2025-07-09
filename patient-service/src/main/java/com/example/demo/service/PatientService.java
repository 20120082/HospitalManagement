package com.example.demo.service;

import com.example.demo.model.Patient;

import com.example.demo.repository.PatientRepository;
import com.example.demo.security.AesEncryptionUtil;
import com.example.demo.util.PatientIdGenerator;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

import java.time.LocalDate;
import java.time.LocalDateTime;
import java.util.List;
import java.util.stream.Collectors;

@Service
public class PatientService {

	@Autowired
	private PatientRepository patientRepository;

	@Autowired
	private AesEncryptionUtil encryptionUtil;

	@Autowired
	private PatientIdGenerator patientIdGenerator;

	// ------------------- Create -------------------
	public Patient createPatient(Patient patient) {
		patient.setPatientId(patientIdGenerator.generatePatientId());
		patient.setCreatedAt(LocalDateTime.now());
		patient.setDeleteCheck(false);
		if (patient.getPhoneNumber() == null) {
			patient.setPhoneNumber("none");
		}
		if (patient.getEmail() == null) {
			patient.setEmail("none");
		}
		patient.setPhoneNumber(encryptionUtil.encrypt(patient.getPhoneNumber()));
		patient.setEmail(encryptionUtil.encrypt(patient.getEmail()));
		return patientRepository.save(patient);
	}

	// ------------------- Read -------------------
	public Patient getPatientById(String patientId) {
		Patient patient = patientRepository.findByPatientIdAndDeleteCheckFalse(patientId).orElse(null);
		return decryptSensitiveFields(patient);
	}

	public List<Patient> getAllActivePatients() {
		return patientRepository.findByDeleteCheckFalse().stream() // Han che dung vi co dung ma hoa nen lay cham
				.map(this::decryptSensitiveFields) // Thay vao do dung getAllPatientsPaged()
				.collect(Collectors.toList());
	}

	public Page<Patient> getAllPatientsPaged(Pageable pageable) {
		return patientRepository.findByDeleteCheckFalse(pageable).map(this::decryptSensitiveFields);
	}

	// ------------------- Update -------------------
	public Patient updatePatient(String patientId, Patient updated) {
		Patient existing = patientRepository.findByPatientIdAndDeleteCheckFalse(patientId).orElse(null);
		if (existing == null || existing.isDeleteCheck()) {
			throw new RuntimeException("Không tìm thấy bệnh nhân với mã " + patientId);
		}
		if (updated.getPhoneNumber() == null) {
			updated.setPhoneNumber("none");
		}
		if (updated.getEmail() == null) {
			updated.setEmail("none");
		}

		existing.setFullName(updated.getFullName());
		existing.setGender(updated.getGender());
		existing.setDateOfBirth(updated.getDateOfBirth());
		existing.setAddress(updated.getAddress());
		existing.setPhoneNumber(encryptionUtil.encrypt(existing.getPhoneNumber()));
		existing.setEmail(encryptionUtil.encrypt(existing.getEmail()));

		return patientRepository.save(existing);
	}

	// ------------------- Delete (soft) -------------------
	public boolean softDeletePatient(String patientId) {
		Patient patient = patientRepository.findByPatientIdAndDeleteCheckFalse(patientId).orElse(null);
		if (patient == null || patient.isDeleteCheck())
			return false;

		patient.setDeleteCheck(true);
		patientRepository.save(patient);
		return true;
	}

	// ------------------- Count -------------------
	public long countAllActivePatients() {
		return patientRepository.countByDeleteCheckFalse();
	}

	public long countPatientsByMonth(int year, int month) {
		List<Patient> patients = patientRepository.findByDeleteCheckFalse();
		return patients.stream().filter(p -> p.getCreatedAt().getMonthValue() == month)
				.filter(p -> p.getCreatedAt().getYear() == year).count();
	}

	// ------------------- Advanced Search -------------------
	public List<Patient> searchPatients(String fullName, String gender, LocalDate dob, String phone, String email,
			String address) {

		// Mã hoá nếu cần tìm theo email hoặc phone
		if (phone != null && !phone.isEmpty()) {
			phone = encryptionUtil.encrypt(phone);
		}
		if (email != null && !email.isEmpty()) {
			email = encryptionUtil.encrypt(email);
		}

		return patientRepository.advancedSearch(fullName, gender, dob, phone, email, address).stream()
				.map(this::decryptSensitiveFields).collect(Collectors.toList());
	}

	// ------------------- Helper -------------------
	private Patient decryptSensitiveFields(Patient patient) {
		if (patient == null)
			return null;
		patient.setPhoneNumber(encryptionUtil.decrypt(patient.getPhoneNumber()));
		patient.setEmail(encryptionUtil.decrypt(patient.getEmail()));
		return patient;
	}
}
