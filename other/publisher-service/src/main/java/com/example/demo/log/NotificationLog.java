package com.example.demo.log;

import java.time.LocalDateTime;

import org.springframework.data.annotation.Id;
import org.springframework.data.mongodb.core.mapping.Document;

@Document(collection = "notifications")
public class NotificationLog {
    @Id
    private String id;
    private String content;
    private LocalDateTime sentAt;
    //Có thể sai
	public NotificationLog(String message, LocalDateTime now) {
		this.content = message;
		this.sentAt = now;
	}
	public String getContent() {
		return content;
	}
	public void setContent(String content) {
		this.content = content;
	}
	public LocalDateTime getSentAt() {
		return sentAt;
	}
	public void setSentAt(LocalDateTime sentAt) {
		this.sentAt = sentAt;
	}
}
