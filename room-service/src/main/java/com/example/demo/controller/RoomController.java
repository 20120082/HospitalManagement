package com.example.demo.controller;

import com.example.demo.model.Room;
import com.example.demo.service.RoomService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/rooms")
public class RoomController {

    @Autowired
    private RoomService service;

    @GetMapping
    public ResponseEntity<List<Room>> getAll() {
        return ResponseEntity.ok(service.getAll());
    }

    @PostMapping
    public ResponseEntity<Room> create(@RequestBody Room room) {
        return ResponseEntity.ok(service.add(room));
    }

    @PutMapping("/{id}")
    public ResponseEntity<Room> update(@PathVariable String id, @RequestBody Room room) {
        return ResponseEntity.ok(service.update(id, room));
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> delete(@PathVariable String id) {
        service.delete(id);
        return ResponseEntity.noContent().build();
    }

    @GetMapping("/code")
    public ResponseEntity<Room> findByCode(@RequestParam String code) {
        return ResponseEntity.ok(service.findByRoomCode(code));
    }

    @GetMapping("/name")
    public ResponseEntity<List<Room>> findByName(@RequestParam String name) {
        return ResponseEntity.ok(service.findByRoomNameExact(name));
    }

    @GetMapping("/department")
    public ResponseEntity<List<Room>> findByDepartment(@RequestParam String department) {
        return ResponseEntity.ok(service.findByDepartment(department));
    }

    @GetMapping("/status")
    public ResponseEntity<List<Room>> findByStatus(@RequestParam boolean active) {
        return ResponseEntity.ok(service.findByStatus(active));
    }

    @GetMapping("/doctor")
    public ResponseEntity<List<Room>> findByDoctor(@RequestParam String doctor) {
        return ResponseEntity.ok(service.findByDoctor(doctor));
    }

    @GetMapping("/count")
    public ResponseEntity<Long> countAll() {
        return ResponseEntity.ok(service.countAll());
    }

    @GetMapping("/count-by-department")
    public ResponseEntity<Long> countByDepartment(@RequestParam String department) {
        return ResponseEntity.ok(service.countByDepartment(department));
    }
}

