package com.example.demo.model;

import org.springframework.data.annotation.Id;
import org.springframework.data.mongodb.core.mapping.Document;

@Document(collection = "rooms")
public class Room {

    @Id
    private String id;

    private String roomCode;       // Mã phòng: PK001, PK002,...
    private String roomName;       // Tên phòng: Phòng Nội tổng quát, Phòng Nhi,...
    private String department;     // Khoa / chuyên khoa: Nội, Ngoại, Sản, Tai-Mũi-Họng,...
    private String doctorInCharge; // Bác sĩ phụ trách (tên hoặc mã BS)
    private boolean active = true; // Phòng đang hoạt động hay không
    private boolean deleteCheck = false;
    
	public String getId() {
		return id;
	}
	public void setId(String id) {
		this.id = id;
	}
	
	public String getRoomCode() {
		return roomCode;
	}
	public void setRoomCode(String roomCode) {
		this.roomCode = roomCode;
	}
	
	public String getRoomName() {
		return roomName;
	}
	public void setRoomName(String roomName) {
		this.roomName = roomName;
	}
	
	public String getDepartment() {
		return department;
	}
	public void setDepartment(String department) {
		this.department = department;
	}
	
	public String getDoctorInCharge() {
		return doctorInCharge;
	}
	public void setDoctorInCharge(String doctorInCharge) {
		this.doctorInCharge = doctorInCharge;
	}
	
	public boolean isActive() {
		return active;
	}
	public void setActive(boolean active) {
		this.active = active;
	}
	
	public boolean isDeleteCheck() {
		return deleteCheck;
	}
	public void setDeleteCheck(boolean deleteCheck) {
		this.deleteCheck = deleteCheck;
	}

}

