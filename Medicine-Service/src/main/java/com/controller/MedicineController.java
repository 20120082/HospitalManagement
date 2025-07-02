package com.controller;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import com.model.Medicine;
import com.service.MedicineService;

@RestController
@RequestMapping("/api/medicines")
public class MedicineController {

    @Autowired
    private MedicineService medicineService;

    @GetMapping
    public List<Medicine> getAllMedicines() {
        return medicineService.getAllMedicines();
    }

    // API tìm kiếm thuốc theo tên, mã hoặc manufacturer
    @GetMapping("/search")
    public ResponseEntity<List<Medicine>> searchMedicines(@RequestParam(required = false) String name,
                                                         @RequestParam(required = false) String code,
                                                         @RequestParam(required = false) String manufacturer) {
        List<Medicine> result = medicineService.searchMedicines(name, code, manufacturer);
        if (result == null || result.isEmpty()) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.ok(result);
    }

    @GetMapping("/{id}")
    public ResponseEntity<Medicine> getMedicineById(@PathVariable int id) {
        Medicine medicine = medicineService.getMedicineById(id);
        if (medicine != null) {
            return ResponseEntity.ok(medicine);
        } else {
            return ResponseEntity.notFound().build();
        }
    }

    @PostMapping
    public Medicine addMedicine(@RequestBody Medicine medicine) {
        return medicineService.addMedicine(medicine);
    }

    @PutMapping("/{id}")
    public ResponseEntity<Medicine> updateMedicine(@PathVariable int id, @RequestBody Medicine medicine) {
        Medicine updated = medicineService.updateMedicine(id, medicine);
        if (updated != null) {
            return ResponseEntity.ok(updated);
        } else {
            return ResponseEntity.notFound().build();
        }
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deleteMedicine(@PathVariable int id) {
        medicineService.deleteMedicine(id);
        return ResponseEntity.noContent().build();
    }
}
