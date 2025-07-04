package com.example.demo.model;

public class NotificationLog {

    private String id;
    private String content;
    private String sentAt;

    public NotificationLog() {}

    public NotificationLog(String id, String content, String sentAt) {
        this.id = id;
        this.content = content;
        this.sentAt = sentAt;
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content;
    }

    public String getSentAt() {
        return sentAt;
    }

    public void setSentAt(String sentAt) {
        this.sentAt = sentAt;
    }
}
