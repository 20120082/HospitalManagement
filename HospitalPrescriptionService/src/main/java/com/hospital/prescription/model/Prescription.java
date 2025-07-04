package com.hospital.prescription.model;

import jakarta.persistence.*;
import java.time.LocalDate;
import java.util.List;

@Entity
@Table(name = "prescription")
public class Prescription {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @Column(name = "Id_Patient", nullable = false)
    private String idPatient;

    @Column(name = "Created_Date", nullable = false)
    private LocalDate createdDate;

    @Column(name = "Status", nullable = false)
    private String status;
    
    @OneToMany(mappedBy = "prescription", cascade = CascadeType.ALL, fetch = FetchType.LAZY)
    private List<PrescriptionDetail> details;

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getIdPatient() {
        return idPatient;
    }

    public void setIdPatient(String idPatient) {
        this.idPatient = idPatient;
    }

    public LocalDate getCreatedDate() {
        return createdDate;
    }

    public void setCreatedDate(LocalDate createdDate) {
        this.createdDate = createdDate;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }
    
    public List<PrescriptionDetail> getDetails() {
        return details;
    }

    public void setDetails(List<PrescriptionDetail> details) {
        this.details = details;
    }
}