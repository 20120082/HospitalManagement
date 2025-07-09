package com.example.demo.model;

import java.time.LocalDate;
import java.time.LocalDateTime;

import org.springframework.data.annotation.Id;
import org.springframework.data.mongodb.core.mapping.Document;

import jakarta.validation.constraints.Email;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import jakarta.validation.constraints.Past;
import jakarta.validation.constraints.Pattern;

@Document(collection = "patients")
public class Patient {
	@Id
	private String id;

	private String patientId;
	@NotBlank(message = "Họ tên không được để trống")
	private String fullName;

	@NotBlank(message = "Giới tính không được để trống")
	@Pattern(regexp = "Nam|Nữ", message = "Giới tính chỉ được là 'Nam' hoặc 'Nữ'")
	private String gender;

	@NotNull(message = "Ngày sinh không được để trống")
	@Past(message = "Ngày sinh phải trước ngày hiện tại")
	private LocalDate dateOfBirth;

	@NotBlank(message = "Số điện thoại không được để trống")
	@Pattern(
			  regexp = "^(03[2-9]|05[6|8|9]|07[0-9]|08[1-5]|09[0-9])\\d{7}$",
			  message = "Số điện thoại không hợp lệ"
			)// Duyet theo sdt vietnam 10 so
	//Viettel (032, 033, ..., 039), Vietnamobile (056, 058), Gmobile (059), Mobifone (070–079), Vinaphone (081–085)
	//@Pattern(regexp = "^\\d{10}$", message = "Số điện thoại không hợp lệ") // Duyet don gian
	private String phoneNumber;

	@NotBlank(message = "Email không được để trống")
	@Email(message = "Email không đúng định dạng")
	private String email;

	@NotBlank(message = "Địa chỉ không được để trống")
	private String address;
	private LocalDateTime createdAt;
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

	public String getFullName() {
		return fullName;
	}

	public void setFullName(String fullName) {
		this.fullName = fullName;
	}

	public String getGender() {
		return gender;
	}

	public void setGender(String gender) {
		this.gender = gender;
	}

	public LocalDate getDateOfBirth() {
		return dateOfBirth;
	}

	public void setDateOfBirth(LocalDate dateOfBirth) {
		this.dateOfBirth = dateOfBirth;
	}

	public String getPhoneNumber() {
		return phoneNumber;
	}

	public void setPhoneNumber(String phoneNumber) {
		this.phoneNumber = phoneNumber;
	}

	public String getEmail() {
		return email;
	}

	public void setEmail(String email) {
		this.email = email;
	}

	public String getAddress() {
		return address;
	}

	public void setAddress(String address) {
		this.address = address;
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

}
