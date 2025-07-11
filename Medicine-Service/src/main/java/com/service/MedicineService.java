package com.service;

import java.util.List;

import com.model.Medicine;

public interface MedicineService {
    List<Medicine> getAllMedicines();
    Medicine getMedicineById(int id);
    Medicine addMedicine(Medicine medicine);
    Medicine updateMedicine(int id, Medicine medicine);
    void deleteMedicine(int id);

    // Tìm kiếm thuốc theo tên, mã hoặc loại thuốc (category)
    List<Medicine> searchMedicines(String name, String code, String category);
}
