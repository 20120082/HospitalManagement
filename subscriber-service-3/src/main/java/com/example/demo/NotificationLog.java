package com.example.demo;

import java.time.LocalDateTime;

import org.springframework.data.annotation.Id;
import org.springframework.data.mongodb.core.mapping.Document;

@Document(collection = "notification_logs")
public class NotificationLog {
    @Id
    private String id;
    private String content;
    private LocalDateTime receivedAt;

    public NotificationLog(String content, LocalDateTime receivedAt) {
        this.content = content;
        this.receivedAt = receivedAt;
    }

    // getter + setter
    public String getId() { return id; }
    public String getContent() { return content; }
    public LocalDateTime getReceivedAt() { return receivedAt; }

    public void setId(String id) { this.id = id; }
    public void setContent(String content) { this.content = content; }
    public void setReceivedAt(LocalDateTime receivedAt) { this.receivedAt = receivedAt; }
}
