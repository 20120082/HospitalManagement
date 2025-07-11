package com.example.demo.model;

import org.springframework.data.annotation.Id;
import org.springframework.data.mongodb.core.mapping.Document;

import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.Size;

@Document(collection = "rooms")
public class Room {

    @Id
    private String id; // MongoDB ID

    private String roomId; // VD: PK0001, PK0002...

    @NotBlank(message = "Tên phòng không được để trống")
    @Size(max = 100, message = "Tên phòng không được vượt quá 100 ký tự")
    private String roomName;

    @NotBlank(message = "Chuyên khoa không được để trống")
    @Size(max = 100, message = "Chuyên khoa không được vượt quá 100 ký tự")
    private String department;

    private String doctorId;
    private String doctorName;

    private boolean roomActive = true;
    private boolean deleteCheck = false;

    // Getters & Setters
    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getRoomId() {
        return roomId;
    }

    public void setRoomId(String roomId) {
        this.roomId = roomId;
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

    public boolean isRoomActive() {
        return roomActive;
    }

    public void setRoomActive(boolean roomActive) {
        this.roomActive = roomActive;
    }

    public boolean isDeleteCheck() {
        return deleteCheck;
    }

    public void setDeleteCheck(boolean deleteCheck) {
        this.deleteCheck = deleteCheck;
    }
}
