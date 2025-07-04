package com.example.demo;

import java.time.LocalDateTime;

import org.springframework.amqp.rabbit.annotation.RabbitListener;
import org.springframework.stereotype.Component;

@Component
public class Subscriber {
	
	private final NotificationRepository repo;

    public Subscriber(NotificationRepository repo) {
        this.repo = repo;
    }
	
	@RabbitListener(queues="${jsa.rabbitmq.queue}")
	public void recievedMessage(String msg) {
		System.out.println("Received Message: " + msg);
		NotificationLog log = new NotificationLog(msg, LocalDateTime.now());
        repo.save(log);
	}

	public NotificationRepository getRepo() {
		return repo;
	}
}