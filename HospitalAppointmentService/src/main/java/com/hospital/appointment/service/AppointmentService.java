package com.hospital.appointment.service;

import com.hospital.appointment.dto.AppointmentDTO;
import com.hospital.appointment.model.Appointment;
import com.hospital.appointment.repository.AppointmentRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;
import java.util.stream.Collectors;

@Service
public class AppointmentService {
    @Autowired
    private AppointmentRepository appointmentRepository;

    public AppointmentDTO createAppointment(AppointmentDTO dto) {
        Appointment appointment = new Appointment();
        appointment.setIdPatient(dto.getIdPatient());
        appointment.setIdDoctor(dto.getIdDoctor());
        appointment.setIdRoom(dto.getIdRoom());
        appointment.setStartTime(dto.getStartTime());
        appointment.setStatus(dto.getStatus());
        Appointment saved = appointmentRepository.save(appointment);
        return mapToDTO(saved);
    }

    public AppointmentDTO getAppointmentById(Integer id) {
        Optional<Appointment> appointment = appointmentRepository.findById(id);
        return appointment.map(this::mapToDTO).orElse(null);
    }

    public List<AppointmentDTO> getAllAppointments() {
        return appointmentRepository.findAll().stream()
                .map(this::mapToDTO)
                .collect(Collectors.toList());
    }

    public AppointmentDTO updateAppointment(Integer id, AppointmentDTO dto) {
        Optional<Appointment> optionalAppointment = appointmentRepository.findById(id);
        if (optionalAppointment.isPresent()) {
            Appointment appointment = optionalAppointment.get();
            appointment.setIdPatient(dto.getIdPatient());
            appointment.setIdDoctor(dto.getIdDoctor());
            appointment.setIdRoom(dto.getIdRoom());
            appointment.setStartTime(dto.getStartTime());
            appointment.setStatus(dto.getStatus());
            Appointment updatedAppointment = appointmentRepository.save(appointment);
            return mapToDTO(updatedAppointment);
        }
        return null;
    }

    public boolean deleteAppointment(Integer id) {
        if (appointmentRepository.existsById(id)) {
            appointmentRepository.deleteById(id);
            return true;
        }
        return false;
    }

    private AppointmentDTO mapToDTO(Appointment appointment) {
        AppointmentDTO dto = new AppointmentDTO();
        dto.setId(appointment.getId());
        dto.setIdPatient(appointment.getIdPatient());
        dto.setIdDoctor(appointment.getIdDoctor());
        dto.setIdRoom(appointment.getIdRoom());
        dto.setStartTime(appointment.getStartTime());
        dto.setStatus(appointment.getStatus());
        return dto;
    }
}