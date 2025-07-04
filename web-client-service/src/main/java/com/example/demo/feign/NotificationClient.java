package com.example.demo.feign;

import org.springframework.cloud.openfeign.FeignClient;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;

import com.example.demo.model.NotificationLog;
import com.example.demo.model.NotificationRequest;

@FeignClient(name = "publisher-service")
public interface NotificationClient {

	@PostMapping("/notify/send")
    String sendNotification(@RequestBody NotificationRequest request);

    @GetMapping("/notify/send/{id}")
    NotificationLog getNotification(@PathVariable("id") String id);

    @PutMapping("/notify/send/{id}")
    NotificationLog updateNotification(@PathVariable("id") String id, @RequestBody NotificationRequest request);

    @DeleteMapping("/notify/send/{id}")
    void deleteNotification(@PathVariable("id") String id);
}

