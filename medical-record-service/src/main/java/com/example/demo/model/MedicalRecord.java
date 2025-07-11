package com.example.demo.model;

import org.springframework.data.annotation.Id;
import org.springframework.data.mongodb.core.mapping.Document;

import jakarta.validation.constraints.NotBlank;

import java.time.LocalDateTime;

@Document(collection = "medical_records")
public class MedicalRecord {

	@Id
	private String id; // MongoDB ObjectId

	private String recordId; // Mã bệnh án tự động tăng (VD: BA00001)
	
	@NotBlank(message = "patientId không được để trống")
	private String patientId; // Mã bệnh nhân (từ patient-service)
	
	@NotBlank(message = "roomId không được để trống")
	private String roomId; // Mã phòng (từ room-service)

	private String doctorId; // Mã bác sĩ (có thể từ service riêng)
	private String doctorName; // Tên bác sĩ
	private String diagnosis = "Chưa có"; // Mặc định
	private String treatment = "Chưa có"; // Mặc định

	private LocalDateTime createdAt = LocalDateTime.now(); // Thời gian tạo

	private boolean deleteCheck = false;

	// Getter & Setter
	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	public String getRecordId() {
		return recordId;
	}

	public void setRecordId(String recordId) {
		this.recordId = recordId;
	}

	public String getPatientId() {
		return patientId;
	}

	public void setPatientId(String patientId) {
		this.patientId = patientId;
	}

	public String getRoomId() {
		return roomId;
	}

	public void setRoomId(String roomId) {
		this.roomId = roomId;
	}

	public String getDoctorId() {
		return doctorId;
	}

	public void setDoctorId(String doctorId) {
		this.doctorId = doctorId;
	}

	public String getDoctorName() {
		return doctorName;
	}

	public void setDoctorName(String doctorName) {
		this.doctorName = doctorName;
	}

	public String getDiagnosis() {
		return diagnosis;
	}

	public void setDiagnosis(String diagnosis) {
		this.diagnosis = diagnosis;
	}

	public String getTreatment() {
		return treatment;
	}

	public void setTreatment(String treatment) {
		this.treatment = treatment;
	}

	public LocalDateTime getCreatedAt() {
		return createdAt;
	}

	public void setCreatedAt(LocalDateTime createdAt) {
		this.createdAt = createdAt;
	}

	public boolean isDeleteCheck() {
		return deleteCheck;
	}

	public void setDeleteCheck(boolean deleteCheck) {
		this.deleteCheck = deleteCheck;
	}
	// Lưu ý không thêm hàm logic tại đây
}
