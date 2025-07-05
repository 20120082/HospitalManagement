package com.hospital.doctor;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.cloud.client.discovery.EnableDiscoveryClient;

@EnableDiscoveryClient
@SpringBootApplication
public class HospitalDoctorServiceApplication {

	public static void main(String[] args) {
		SpringApplication.run(HospitalDoctorServiceApplication.class, args);
	}

}
