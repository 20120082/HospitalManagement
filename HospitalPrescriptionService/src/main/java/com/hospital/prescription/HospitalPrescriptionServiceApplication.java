package com.hospital.prescription;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.cloud.client.discovery.EnableDiscoveryClient;

@EnableDiscoveryClient
@SpringBootApplication
public class HospitalPrescriptionServiceApplication {
    public static void main(String[] args) {
        SpringApplication.run(HospitalPrescriptionServiceApplication.class, args);
    }
}