package com.service.impl;

import java.util.List;
import java.util.Optional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.model.Medicine;
import com.repository.MedicineRepository;
import com.service.MedicineService;

@Service
public class MedicineServiceImpl implements MedicineService {
    @Autowired
    private MedicineRepository medicineRepository;

    @Override
    public List<Medicine> getAllMedicines() {
        return medicineRepository.findAll();
    }

    @Override
    public Medicine getMedicineById(int id) {
        Optional<Medicine> medicine = medicineRepository.findById(id);
        return medicine.orElse(null);
    }

    @Override
    public Medicine addMedicine(Medicine medicine) {
        return medicineRepository.save(medicine);
    }

    @Override
    public Medicine updateMedicine(int id, Medicine medicine) {
        Optional<Medicine> existingOpt = medicineRepository.findById(id);
        if (existingOpt.isPresent()) {
            Medicine existing = existingOpt.get();
            // Cập nhật các trường cần thiết
            existing.setCode(medicine.getCode());
            existing.setName(medicine.getName());
            existing.setCategory(medicine.getCategory());
            existing.setDescription(medicine.getDescription());
            existing.setUnit(medicine.getUnit());
            existing.setPrice(medicine.getPrice());
            existing.setQuantity(medicine.getQuantity());
            existing.setManufacturer(medicine.getManufacturer());
            existing.setExpiryDate(medicine.getExpiryDate());
            existing.setCreatedAt(medicine.getCreatedAt());
            existing.setUpdatedAt(medicine.getUpdatedAt());
            return medicineRepository.save(existing);
        }
        return null;
    }

    @Override
    public void deleteMedicine(int id) {
        medicineRepository.deleteById(id);
    }
    // Tìm kiếm thuốc theo tên, mã hoặc manufacturer (chứa, không phân biệt hoa thường)
    @Override
    public List<Medicine> searchMedicines(String name, String code, String category) {
        boolean hasName = name != null && !name.isBlank();
        boolean hasCode = code != null && !code.isBlank();
        boolean hasCategory = category != null && !category.isBlank();
        if (!hasName && !hasCode && !hasCategory) {
            return medicineRepository.findAll();
        }
        if (hasName && !hasCode && !hasCategory) {
            return medicineRepository.findByNameContainingIgnoreCase(name);
        }
        if (!hasName && hasCode && !hasCategory) {
            return medicineRepository.findByCodeContainingIgnoreCase(code);
        }
        if (!hasName && !hasCode && hasCategory) {
            return medicineRepository.findByCategoryContainingIgnoreCase(category);
        }
        // Kết hợp các trường
        return medicineRepository.findByNameContainingIgnoreCaseOrCodeContainingIgnoreCaseOrCategoryContainingIgnoreCase(
            hasName ? name : "", hasCode ? code : "", hasCategory ? category : ""
        );
    }
}
