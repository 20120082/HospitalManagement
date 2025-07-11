package com.example.demo.config;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.CommandLineRunner;
import org.springframework.data.mongodb.core.MongoTemplate;
import org.springframework.stereotype.Component;

@Component
public class DatabaseInitializer implements CommandLineRunner {

    @Autowired
    private MongoTemplate mongoTemplate;

    @Override
    public void run(String... args) throws Exception {
        // Tạo collection nếu chưa có
        createCollectionIfNotExists("patients");
        createCollectionIfNotExists("rooms");
        createCollectionIfNotExists("medical_records");
        createCollectionIfNotExists("counters");

        // (Tuỳ chọn) có thể khởi tạo trước một số counter mặc định
        initCounterIfNotExists("roomId");
        initCounterIfNotExists("patientId-" + java.time.Year.now().getValue());
    }

    private void createCollectionIfNotExists(String name) {
        if (!mongoTemplate.collectionExists(name)) {
            mongoTemplate.createCollection(name);
            System.out.println("Created collection: " + name);
        }
    }

    private void initCounterIfNotExists(String counterId) {
        if (mongoTemplate.findById(counterId, org.bson.Document.class, "counters") == null) {
            org.bson.Document counter = new org.bson.Document("_id", counterId)
                    .append("seq", 0);
            mongoTemplate.insert(counter, "counters");
            System.out.println("Initialized counter: " + counterId);
        }
    }
}
