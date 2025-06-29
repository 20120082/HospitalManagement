package com.hospital.prescription.dto;

public class PrescriptionDetailDTO {
    private Integer id;
    private Integer idPrescription;
    private Integer idMedicine;
    private Float quantity;
    private String unit;
    private Float price;

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Integer getIdPrescription() {
        return idPrescription;
    }

    public void setIdPrescription(Integer idPrescription) {
        this.idPrescription = idPrescription;
    }

    public Integer getIdMedicine() {
        return idMedicine;
    }

    public void setIdMedicine(Integer idMedicine) {
        this.idMedicine = idMedicine;
    }

    public Float getQuantity() {
        return quantity;
    }

    public void setQuantity(Float quantity) {
        this.quantity = quantity;
    }

    public String getUnit() {
        return unit;
    }

    public void setUnit(String unit) {
        this.unit = unit;
    }

    public Float getPrice() {
        return price;
    }

    public void setPrice(Float price) {
        this.price = price;
    }
}
