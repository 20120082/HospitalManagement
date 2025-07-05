import express from 'express';
import { sendAppointmentNotification, sendPrescriptionNotification } from '../controller/notificationController.js';

const router = express.Router();

// Route gửi thông báo lịch khám
router.post('/appointment', sendAppointmentNotification);

// Route gửi thông báo đơn thuốc
router.post('/prescription', sendPrescriptionNotification);

export default router;