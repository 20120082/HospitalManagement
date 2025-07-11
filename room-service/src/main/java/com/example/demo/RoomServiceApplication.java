package com.example.demo;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

import io.github.cdimascio.dotenv.Dotenv;

@SpringBootApplication
public class RoomServiceApplication {

	public static void main(String[] args) {
		Dotenv dotenv = Dotenv.load();

        System.setProperty("MONGO_USER", dotenv.get("MONGO_USER"));
        System.setProperty("MONGO_PASSWORD", dotenv.get("MONGO_PASSWORD"));
        
		SpringApplication.run(RoomServiceApplication.class, args);
	}

}
