package com.hospital.registerServer;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.cloud.netflix.eureka.server.EnableEurekaServer;

@SpringBootApplication
@EnableEurekaServer
public class HospitalRegisterServerApplication {
    public static void main(String[] args) {
        SpringApplication.run(HospitalRegisterServerApplication.class, args);
    }
}