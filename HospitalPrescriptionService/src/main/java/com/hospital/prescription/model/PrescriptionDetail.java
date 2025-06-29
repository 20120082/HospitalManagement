package com.hospital.prescription.model;

import jakarta.persistence.*;

@Entity
@Table(name = "prescriptiondetail")
public class PrescriptionDetail {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "Id")
    private Integer id;

    @Column(name = "Id_Prescription", nullable = false)
    private Integer idPrescription;

    @Column(name = "Id_Medicine", nullable = false)
    private Integer idMedicine;

    @Column(name = "Quantity", nullable = false)
    private Float quantity;

    @Column(name = "Unit", nullable = false)
    private String unit;

    @Column(name = "Price", nullable = false)
    private Float price;

    @ManyToOne
    @JoinColumn(name = "Id_Prescription", insertable = false, updatable = false)
    private Prescription prescription;

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

    public Prescription getPrescription() {
        return prescription;
    }

    public void setPrescription(Prescription prescription) {
        this.prescription = prescription;
    }
}