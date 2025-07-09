package com.example.demo.controller;

import java.util.NoSuchElementException;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.example.demo.log.NotificationLog;
import com.example.demo.publisher.NotificationPublisher;

@RestController
@RequestMapping("/notify")
public class NotificationController {

    @Autowired
    private NotificationPublisher publisher;

    @PostMapping("/send")
    public String sendMessage(@RequestBody NotificationRequest request) {
        publisher.send(request.getContent());
        return "Sent: " + request.getContent();
    }

    @GetMapping("/send/{id}")
    public ResponseEntity<NotificationLog> getMessage(@PathVariable String id) {
        return publisher.getById(id)
                .map(ResponseEntity::ok)
                .orElse(ResponseEntity.notFound().build());
    }

    @PutMapping("/send/{id}")
    public ResponseEntity<NotificationLog> updateMessage(@PathVariable String id, @RequestBody NotificationRequest request) {
        try {
            NotificationLog updated = publisher.update(id, request.getContent());
            return ResponseEntity.ok(updated);
        } catch (NoSuchElementException e) {
            return ResponseEntity.notFound().build();
        }
    }

    @DeleteMapping("/send/{id}")
    public ResponseEntity<Void> deleteMessage(@PathVariable String id) {
        publisher.delete(id);
        return ResponseEntity.ok().build();
    }
}
