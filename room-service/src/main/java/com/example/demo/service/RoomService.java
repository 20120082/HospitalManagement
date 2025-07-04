package com.example.demo.service;

import com.example.demo.model.Room;
import com.example.demo.repository.RoomRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class RoomService {

    @Autowired
    private RoomRepository repo;

    public List<Room> getAll() {
        return repo.findByDeleteCheckFalse();
    }

    public Room add(Room room) {
        return repo.save(room);
    }

    public Room update(String id, Room room) {
        room.setId(id);
        return repo.save(room);
    }

    public void delete(String id) {
        Room room = repo.findById(id).orElseThrow();
        room.setDeleteCheck(true);
        repo.save(room);
    }

    public Room findByRoomCode(String code) {
        return repo.findByRoomCodeAndDeleteCheckFalse(code);
    }

    public List<Room> findByRoomNameExact(String name) {
        return repo.findByRoomNameRegexAndDeleteCheckFalse("^" + name + "$");
    }

    public List<Room> findByDepartment(String department) {
        return repo.findByDepartmentAndDeleteCheckFalse(department);
    }

    public List<Room> findByStatus(boolean active) {
        return repo.findByActiveAndDeleteCheckFalse(active);
    }

    public List<Room> findByDoctor(String doctor) {
        return repo.findByDoctorInChargeAndDeleteCheckFalse(doctor);
    }

    public long countAll() {
        return repo.countByDeleteCheckFalse();
    }

    public long countByDepartment(String department) {
        return repo.countByDepartmentAndDeleteCheckFalse(department);
    }
}

