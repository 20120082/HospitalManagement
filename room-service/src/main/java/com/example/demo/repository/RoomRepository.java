package com.example.demo.repository;

import com.example.demo.model.Room;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.mongodb.repository.MongoRepository;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public interface RoomRepository extends MongoRepository<Room, String> {

    Optional<Room> findByRoomIdAndDeleteCheckFalse(String roomId);

    boolean existsByRoomIdAndDeleteCheckFalse(String roomId);

    List<Room> findByDeleteCheckFalse();

	Page<Room> findByDeleteCheckFalse(Pageable pageable);

}
