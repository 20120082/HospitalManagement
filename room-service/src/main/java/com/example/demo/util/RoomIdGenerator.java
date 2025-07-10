package com.example.demo.util;

import org.bson.Document;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.mongodb.core.FindAndModifyOptions;
import org.springframework.data.mongodb.core.MongoTemplate;
import org.springframework.data.mongodb.core.query.Criteria;
import org.springframework.data.mongodb.core.query.Query;
import org.springframework.data.mongodb.core.query.Update;
import org.springframework.stereotype.Component;

@Component
public class RoomIdGenerator {

    @Autowired
    private MongoTemplate mongoTemplate;

    public String generateRoomId() {
        String counterId = "roomId"; // ID cố định cho counter phòng

        // Truy vấn xem counter đã tồn tại chưa
        Query counterQuery = new Query(Criteria.where("_id").is(counterId));
        Document counterDoc = mongoTemplate.findOne(counterQuery, Document.class, "counters");

        if (counterDoc == null) {
            // Nếu chưa có counter, đếm số lượng phòng hiện tại trong collection
            long existingRoomCount = mongoTemplate.count(new Query(), "rooms");

            // Tạo counter mới với seq = số lượng phòng + 1
            Document newCounter = new Document("_id", counterId)
                    .append("seq", (int) existingRoomCount + 1);
            mongoTemplate.insert(newCounter, "counters");
        }

        // Tăng giá trị seq
        Update update = new Update().inc("seq", 1);
        FindAndModifyOptions options = FindAndModifyOptions.options().returnNew(true);
        Document result = mongoTemplate.findAndModify(counterQuery, update, options, Document.class, "counters");

        int seq = result.getInteger("seq");
        return String.format("PK%05d", seq); // ví dụ PK00001, PK00002,...
    }
}
