package com.hospital.appointment;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.cloud.client.discovery.EnableDiscoveryClient;

@SpringBootApplication
@EnableDiscoveryClient
public class HospitalAppointmentServiceApplication {

	public static void main(String[] args) {
		SpringApplication.run(HospitalAppointmentServiceApplication.class, args);
	}

}
