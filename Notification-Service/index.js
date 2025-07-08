import dotenv from 'dotenv';
dotenv.config();
import express from 'express';
import { Eureka } from 'eureka-js-client';
import mongoose from 'mongoose';
import notificationRoutes from './router/notificationRoutes.js';
import { startConsumer } from './service/notificationConsumer.js';

const app = express();
app.use(express.json());



// Kết nối MongoDB
const mongoUri = process.env.MONGODB_URI || `mongodb+srv://triet4work:PuTHRiqnZq0Iboej@minhtriet.cdqhrdy.mongodb.net/HospitalManagement?retryWrites=true&w=majority`;
mongoose.connect(mongoUri, {
  useNewUrlParser: true,
  useUnifiedTopology: true
})
  .then(() => console.log('Connected to MongoDB'))
  .catch(err => console.error('MongoDB connection error:', err));

// Đăng ký với Eureka Server
const client = new Eureka({
  instance: {
    app: 'notification-service',
    instanceId: 'localhost:notification-service:8085',
    hostName: 'localhost',
    ipAddr: '127.0.0.1',
    port: { '$': 8085, '@enabled': true },
    vipAddress: 'notification-service',
    dataCenterInfo: { '@class': 'com.netflix.appinfo.InstanceInfo$DefaultDataCenterInfo', name: 'MyOwn' }
  },
  eureka: {
    host: 'localhost',
    port: 8761,
    servicePath: '/eureka/apps/'
  }
});

// Sử dụng router cho các endpoint thông báo
app.use('/api/notify', notificationRoutes);

// Start RabbitMQ consumer
startConsumer();

client.start();

app.listen(8085, () => console.log('Notification service running on port 8085'));