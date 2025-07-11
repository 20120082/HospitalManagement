package com.hospital.doctor.service;

import com.hospital.doctor.dto.DoctorDTO;
import com.hospital.doctor.model.Doctor;
import com.hospital.doctor.repository.DoctorRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;
import java.util.stream.Collectors;

@Service
public class DoctorService {
    @Autowired
    private DoctorRepository doctorRepository;

    public DoctorDTO createDoctor(DoctorDTO dto) {
        Doctor doctor = new Doctor();
        doctor.setName(dto.getName());
        doctor.setGender(dto.getGender());
        doctor.setPhoneNumber(dto.getPhoneNumber());
        doctor.setPosition(dto.getPosition());
        doctor.setUsername(dto.getUsername());
        Doctor saved = doctorRepository.save(doctor);
        return mapToDTO(saved);
    }

    public DoctorDTO getDoctorById(Integer id) {
        Optional<Doctor> doctor = doctorRepository.findById(id);
        return doctor.map(this::mapToDTO).orElse(null);
    }

    public List<DoctorDTO> getAllDoctors() {
        return doctorRepository.findAll().stream()
                .map(this::mapToDTO)
                .collect(Collectors.toList());
    }

    public DoctorDTO updateDoctor(Integer id, DoctorDTO dto) {
        Optional<Doctor> optionalDoctor = doctorRepository.findById(id);
        if (optionalDoctor.isPresent()) {
            Doctor doctor = optionalDoctor.get();
            doctor.setName(dto.getName());
            doctor.setGender(dto.getGender());
            doctor.setPhoneNumber(dto.getPhoneNumber());
            doctor.setPosition(dto.getPosition());
            doctor.setUsername(dto.getUsername());
            Doctor updatedDoctor = doctorRepository.save(doctor);
            return mapToDTO(updatedDoctor);
        }
        return null;
    }

    public boolean deleteDoctor(Integer id) {
        if (doctorRepository.existsById(id)) {
            doctorRepository.deleteById(id);
            return true;
        }
        return false;
    }

    private DoctorDTO mapToDTO(Doctor doctor) {
        DoctorDTO dto = new DoctorDTO();
        dto.setId(doctor.getId());
        dto.setName(doctor.getName());
        dto.setGender(doctor.getGender());
        dto.setPhoneNumber(doctor.getPhoneNumber());
        dto.setPosition(doctor.getPosition());
        dto.setUsername(doctor.getUsername());
        return dto;
    }
}