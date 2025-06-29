package com.hospital.prescription.dto;


import java.time.LocalDate;
import java.util.List;

public class PrescriptionDTO {
    private Integer id;
    private Integer idPatient;
    private LocalDate createdDate;
    private String status;
    
    private List<PrescriptionDetailDTO> details;

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Integer getIdPatient() {
        return idPatient;
    }

    public void setIdPatient(Integer idPatient) {
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
    

    public List<PrescriptionDetailDTO> getDetails() {
        return details;
    }

    public void setDetails(List<PrescriptionDetailDTO> details) {
        this.details = details;
    }
}
