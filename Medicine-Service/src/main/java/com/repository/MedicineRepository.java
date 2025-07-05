package com.repository;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;

import com.model.Medicine;

public interface MedicineRepository extends JpaRepository<Medicine, Integer> {
    // JpaRepository đã cung cấp các phương thức CRUD cơ bản

    // Tìm kiếm theo tên, mã hoặc loại thuốc (category) (chứa, không phân biệt hoa thường)
    List<Medicine> findByNameContainingIgnoreCase(String name);
    List<Medicine> findByCodeContainingIgnoreCase(String code);
    List<Medicine> findByCategoryContainingIgnoreCase(String category);
    List<Medicine> findByNameContainingIgnoreCaseOrCodeContainingIgnoreCaseOrCategoryContainingIgnoreCase(String name, String code, String category);
}
