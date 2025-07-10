package com.example.demo.util;

import org.bson.Document;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.mongodb.core.FindAndModifyOptions;
import org.springframework.data.mongodb.core.MongoTemplate;
import org.springframework.data.mongodb.core.query.Criteria;
import org.springframework.data.mongodb.core.query.Query;
import org.springframework.data.mongodb.core.query.Update;
import org.springframework.stereotype.Component;

import java.time.Year;

@Component
public class PatientIdGenerator {

    @Autowired
    private MongoTemplate mongoTemplate;

    public String generatePatientId() {
    	// Truy vấn counter trên MongoDB
        String currentYear = String.valueOf(Year.now().getValue());
        String counterId = "patientId-" + currentYear;

        // Truy vấn xem counter có tồn tại không
        Query counterQuery = new Query(Criteria.where("_id").is(counterId));
        Document counterDoc = mongoTemplate.findOne(counterQuery, Document.class, "counters");

        if (counterDoc == null) {
            // Nếu chưa có counter, tính số lượng bệnh nhân đã có trong năm hiện tại
            String yearPrefix = "BN" + currentYear + "-";

            Query countQuery = new Query(Criteria.where("patientId").regex("^" + yearPrefix));
            long existingCount = mongoTemplate.count(countQuery, "patients");

            // Tạo counter với giá trị ban đầu là existingCount + 1
            Document newCounter = new Document("_id", counterId).append("seq", (int) existingCount + 1);
            mongoTemplate.insert(newCounter, "counters");
        }

        // Bây giờ tăng giá trị seq như bình thường
        Update update = new Update().inc("seq", 1);
        FindAndModifyOptions options = FindAndModifyOptions.options().returnNew(true);
        Document result = mongoTemplate.findAndModify(counterQuery, update, options, Document.class, "counters");

        int seq = result.getInteger("seq");
        return String.format("BN%s-%05d", currentYear, seq);
    }

}
