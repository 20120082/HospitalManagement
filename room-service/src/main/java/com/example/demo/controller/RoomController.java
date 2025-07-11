<<<<<<< HEAD
package com.example.demo.controller;

import com.example.demo.model.Room;
import com.example.demo.service.RoomService;

import jakarta.validation.Valid;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/rooms")
public class RoomController {

    @Autowired
    private RoomService roomService;

    @PostMapping
    public ResponseEntity<Room> createRoom(@Valid @RequestBody Room room) {
        return ResponseEntity.ok(roomService.createRoom(room));
    }

    @PutMapping("/{roomId}")
    public ResponseEntity<Room> updateRoom(@PathVariable String roomId, @Valid @RequestBody Room room) {
        Room updated = roomService.updateRoom(roomId, room);
        return updated != null ? ResponseEntity.ok(updated) : ResponseEntity.notFound().build();
    }

    @GetMapping
    public ResponseEntity<List<Room>> getAllRooms() {
        return ResponseEntity.ok(roomService.getAllActiveRooms());
    }

    @GetMapping("/paged")
    public ResponseEntity<Page<Room>> getRoomsPaged(@RequestParam int page, @RequestParam int size) {
        return ResponseEntity.ok(roomService.getAllRoomsPaged(PageRequest.of(page, size)));
    }

    @GetMapping("/{roomId}")
    public ResponseEntity<Room> getRoomByRoomId(@PathVariable String roomId) {
        Room room = roomService.getRoomByRoomId(roomId);
        return room != null ? ResponseEntity.ok(room) : ResponseEntity.notFound().build();
    }

    @DeleteMapping("/{roomId}")
    public ResponseEntity<Void> deleteRoom(@PathVariable String roomId) {
        roomService.deleteRoom(roomId);
        return ResponseEntity.ok().build();
    }
}
=======
package com.example.demo.controller;

import com.example.demo.model.Room;
import com.example.demo.service.RoomService;

import jakarta.validation.Valid;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/rooms")
public class RoomController {

    @Autowired
    private RoomService roomService;

    @PostMapping
    public ResponseEntity<Room> createRoom(@Valid @RequestBody Room room) {
        return ResponseEntity.ok(roomService.createRoom(room));
    }

    @PutMapping("/{roomId}")
    public ResponseEntity<Room> updateRoom(@PathVariable String roomId, @Valid @RequestBody Room room) {
        Room updated = roomService.updateRoom(roomId, room);
        return updated != null ? ResponseEntity.ok(updated) : ResponseEntity.notFound().build();
    }

    @GetMapping
    public ResponseEntity<List<Room>> getAllRooms() {
        return ResponseEntity.ok(roomService.getAllActiveRooms());
    }

    @GetMapping("/paged")
    public ResponseEntity<Page<Room>> getRoomsPaged(@RequestParam int page, @RequestParam int size) {
        return ResponseEntity.ok(roomService.getAllRoomsPaged(PageRequest.of(page, size)));
    }

    @GetMapping("/{roomId}")
    public ResponseEntity<Room> getRoomByRoomId(@PathVariable String roomId) {
        Room room = roomService.getRoomByRoomId(roomId);
        return room != null ? ResponseEntity.ok(room) : ResponseEntity.notFound().build();
    }

    @DeleteMapping("/{roomId}")
    public ResponseEntity<Void> deleteRoom(@PathVariable String roomId) {
        roomService.deleteRoom(roomId);
        return ResponseEntity.ok().build();
    }
}
>>>>>>> f86b57d2eee25405e6a4f4f513a633eea3fc0f01
