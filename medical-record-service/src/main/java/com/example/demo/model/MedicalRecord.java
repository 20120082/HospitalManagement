package com.example.demo.model;

import org.springframework.data.annotation.Id;
import org.springframework.data.mongodb.core.mapping.Document;

import java.time.LocalDateTime;

@Document(collection = "medical_records")
public class MedicalRecord {

    @Id
    private String id;

    private String patientId;     // Tham chiếu bệnh nhân
    private String roomId;        // Tham chiếu phòng khám
    private String doctorId;      // Tham chiếu bác sĩ
    private String doctorName;    // Tên bác sĩ điều trị
    private String diagnosis;     // Chẩn đoán
    private String treatment;     // Phác đồ điều trị
    private LocalDateTime visitDate = LocalDateTime.now();

    private boolean deleteCheck = false;

	public String getId() {
		return id;
	}
	public void setId(String id) {
		this.id = id;
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

	public String getDoctor() {
		return doctorName;
	}
	public void setDoctor(String doctor) {
		this.doctorName = doctor;
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

	public LocalDateTime getVisitDate() {
		return visitDate;
	}
	public void setVisitDate(LocalDateTime visitDate) {
		this.visitDate = visitDate;
	}

	public boolean isDeleteCheck() {
		return deleteCheck;
	}
	public void setDeleteCheck(boolean deleteCheck) {
		this.deleteCheck = deleteCheck;
	}
}
