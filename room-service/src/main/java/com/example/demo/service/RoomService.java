<<<<<<< HEAD
package com.example.demo.service;

import com.example.demo.model.Room;
import com.example.demo.repository.RoomRepository;
import com.example.demo.util.RoomIdGenerator;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class RoomService {

    @Autowired
    private RoomRepository roomRepository;

    @Autowired
    private RoomIdGenerator roomIdGenerator;

    public Room createRoom(Room room) {
        room.setRoomId(roomIdGenerator.generateRoomId());
        room.setDeleteCheck(false);
        return roomRepository.save(room);
    }

    public Room updateRoom(String roomId, Room updatedRoom) {
        Room existing = roomRepository.findByRoomIdAndDeleteCheckFalse(roomId).orElse(null);
        if (existing != null) {
            existing.setRoomName(updatedRoom.getRoomName());
            existing.setDepartment(updatedRoom.getDepartment());
            existing.setDoctorId(updatedRoom.getDoctorId());
            existing.setDoctorName(updatedRoom.getDoctorName());
            existing.setRoomActive(updatedRoom.isRoomActive());
            return roomRepository.save(existing);
        }
        return null;
    }

    public List<Room> getAllActiveRooms() {
        return roomRepository.findByDeleteCheckFalse();
    }

    public Page<Room> getAllRoomsPaged(Pageable pageable) {
        return roomRepository.findByDeleteCheckFalse(pageable);
    }

    public Room getRoomByRoomId(String roomId) {
        return roomRepository.findByRoomIdAndDeleteCheckFalse(roomId).orElse(null);
    }

    public void deleteRoom(String roomId) {
        Room room = roomRepository.findByRoomIdAndDeleteCheckFalse(roomId).orElse(null);
        if (room != null) {
            room.setDeleteCheck(true);
            roomRepository.save(room);
        }
    }
}
=======
package com.example.demo.service;

import com.example.demo.model.Room;
import com.example.demo.repository.RoomRepository;
import com.example.demo.util.RoomIdGenerator;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class RoomService {

    @Autowired
    private RoomRepository roomRepository;

    @Autowired
    private RoomIdGenerator roomIdGenerator;

    public Room createRoom(Room room) {
        room.setRoomId(roomIdGenerator.generateRoomId());
        room.setDeleteCheck(false);
        return roomRepository.save(room);
    }

    public Room updateRoom(String roomId, Room updatedRoom) {
        Room existing = roomRepository.findByRoomIdAndDeleteCheckFalse(roomId).orElse(null);
        if (existing != null) {
            existing.setRoomName(updatedRoom.getRoomName());
            existing.setDepartment(updatedRoom.getDepartment());
            existing.setDoctorId(updatedRoom.getDoctorId());
            existing.setDoctorName(updatedRoom.getDoctorName());
            existing.setRoomActive(updatedRoom.isRoomActive());
            return roomRepository.save(existing);
        }
        return null;
    }

    public List<Room> getAllActiveRooms() {
        return roomRepository.findByDeleteCheckFalse();
    }

    public Page<Room> getAllRoomsPaged(Pageable pageable) {
        return roomRepository.findByDeleteCheckFalse(pageable);
    }

    public Room getRoomByRoomId(String roomId) {
        return roomRepository.findByRoomIdAndDeleteCheckFalse(roomId).orElse(null);
    }

    public void deleteRoom(String roomId) {
        Room room = roomRepository.findByRoomIdAndDeleteCheckFalse(roomId).orElse(null);
        if (room != null) {
            room.setDeleteCheck(true);
            roomRepository.save(room);
        }
    }
}
>>>>>>> f86b57d2eee25405e6a4f4f513a633eea3fc0f01
