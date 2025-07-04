package com.example.demo.repository;

import com.example.demo.model.Room;
import org.springframework.data.mongodb.repository.MongoRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface RoomRepository extends MongoRepository<Room, String> {

    List<Room> findByDeleteCheckFalse();

    List<Room> findByRoomNameRegexAndDeleteCheckFalse(String regex);

    List<Room> findByDepartmentAndDeleteCheckFalse(String department);

    List<Room> findByActiveAndDeleteCheckFalse(boolean active);

    List<Room> findByDoctorInChargeAndDeleteCheckFalse(String doctorInCharge);

    Room findByRoomCodeAndDeleteCheckFalse(String roomCode);

    long countByDeleteCheckFalse();

    long countByDepartmentAndDeleteCheckFalse(String department);	
}
