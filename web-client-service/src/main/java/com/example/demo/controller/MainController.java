package com.example.demo.controller;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;

import com.example.demo.PatientClient;
import com.example.demo.feign.NotificationClient;
import com.example.demo.model.NotificationLog;
import com.example.demo.model.NotificationRequest;
import com.example.demo.model.Patient;

@Controller
public class MainController {

    @Autowired
    private PatientClient patientClient;
    
    @Autowired
    private NotificationClient notificationClient;

    @GetMapping("/patients")
    public String viewPatients(Model model) {
        List<Patient> patients = patientClient.getAllPatients();
        model.addAttribute("patients", patients);
        return "patients"; // templates/patients.html
    }
    

	@GetMapping("/send-notification")
	public String showForm(Model model) {
	    model.addAttribute("notificationRequest", new NotificationRequest());
	    return "send_notification"; // form nhập nội dung
	}
	
	@PostMapping("/send-notification")
	public String sendNotification(@ModelAttribute NotificationRequest notificationRequest, Model model) {
	    String response = notificationClient.sendNotification(notificationRequest);
	    model.addAttribute("message", "Đã gửi thành công!");
	    return "send_notification";
	}
	
	@GetMapping("/notify/get")
	public String getNotification(@RequestParam("id") String id, Model model) {
	    try {
	        NotificationLog log = notificationClient.getNotification(id);
	        model.addAttribute("log", log);
	    } catch (Exception e) {
	        model.addAttribute("error", "Không tìm thấy thông báo với ID: " + id);
	    }
	    return "result"; // Trỏ tới result.html
	}
	
	@GetMapping("/notify/update")
	public String updateNotification(@RequestParam("id") String id,
	                                 @RequestParam("content") String content,
	                                 Model model) {
	    NotificationRequest req = new NotificationRequest(content);
	    try {
	        NotificationLog log = notificationClient.updateNotification(id, req);
	        model.addAttribute("log", log);
	    } catch (Exception e) {
	        model.addAttribute("error", "Không thể cập nhật thông báo: " + e.getMessage());
	    }
	    return "result";
	}

}
