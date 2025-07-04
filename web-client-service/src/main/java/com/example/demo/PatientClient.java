package com.example.demo;

import java.util.List;

import org.springframework.cloud.openfeign.FeignClient;
import org.springframework.web.bind.annotation.GetMapping;

import com.example.demo.model.Patient;

@FeignClient(name = "patient-service")
public interface PatientClient {
    @GetMapping("/patients")
    List<Patient> getAllPatients();
}
