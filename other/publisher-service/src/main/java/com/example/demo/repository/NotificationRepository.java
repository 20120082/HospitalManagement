package com.example.demo.repository;

import org.springframework.data.mongodb.repository.MongoRepository;

import com.example.demo.log.NotificationLog;

public interface NotificationRepository extends MongoRepository<NotificationLog, String> {
}