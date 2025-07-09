package com.example.demo.publisher;

import java.time.LocalDateTime;
import java.util.NoSuchElementException;
import java.util.Optional;

import org.springframework.amqp.rabbit.core.RabbitTemplate;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Component;

import com.example.demo.log.NotificationLog;
import com.example.demo.repository.NotificationRepository;

@Component
public class NotificationPublisher {

    @Autowired
    private RabbitTemplate rabbitTemplate;

    @Value("${jsa.rabbitmq.exchange}")
    private String exchange;

    @Value("${jsa.rabbitmq.routingkey}")
    private String routingKey;

    @Autowired
    private NotificationRepository repository;

    public void send(String content) {
        NotificationLog log = new NotificationLog(content, LocalDateTime.now());
        rabbitTemplate.convertAndSend(exchange, routingKey, content);
        repository.save(log);
    }

    public Optional<NotificationLog> getById(String id) {
        return repository.findById(id);
    }

    public NotificationLog update(String id, String newContent) {
        Optional<NotificationLog> optionalLog = repository.findById(id);
        if (optionalLog.isPresent()) {
            NotificationLog log = optionalLog.get();
            log.setContent(newContent);
            return repository.save(log);
        } else {
            throw new NoSuchElementException("Log not found");
        }
    }

    public void delete(String id) {
        repository.deleteById(id);
    }
}

