package com.example.demo.repository;

import com.example.demo.model.Patient;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.mongodb.core.MongoTemplate;
import org.springframework.data.mongodb.core.query.Criteria;
import org.springframework.data.mongodb.core.query.Query;
import org.springframework.stereotype.Repository;

import java.time.LocalDate;
import java.util.ArrayList;
import java.util.List;

@Repository
public class PatientRepositoryImpl implements PatientRepositoryCustom {

    @Autowired
    private MongoTemplate mongoTemplate;

    @Override
    public List<Patient> advancedSearch(String fullName, String gender, LocalDate dateOfBirth,
                                        String phoneNumber, String email, String address) {

        List<Criteria> criteriaList = new ArrayList<>();
        criteriaList.add(Criteria.where("deleteCheck").is(false));

        if (fullName != null && !fullName.isBlank()) {
            criteriaList.add(Criteria.where("fullName").regex(fullName, "i"));
        }

        if (gender != null && !gender.isBlank()) {
            criteriaList.add(Criteria.where("gender").is(gender));
        }

        if (dateOfBirth != null) {
            criteriaList.add(Criteria.where("dateOfBirth").is(dateOfBirth));
        }

        if (phoneNumber != null && !phoneNumber.isBlank()) {
            criteriaList.add(Criteria.where("phoneNumber").is(phoneNumber));
        }

        if (email != null && !email.isBlank()) {
            criteriaList.add(Criteria.where("email").is(email));
        }

        if (address != null && !address.isBlank()) {
            criteriaList.add(Criteria.where("address").regex(address, "i"));
        }

        Query query = new Query(new Criteria().andOperator(criteriaList.toArray(new Criteria[0])));
        return mongoTemplate.find(query, Patient.class);
    }
}
