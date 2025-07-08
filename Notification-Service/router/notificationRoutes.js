import express from 'express';
import { 
  sendAppointmentNotification, 
  sendPrescriptionNotification,
  getAllNotifications,
  deleteNotification,
  deleteAllNotifications
} from '../controller/notificationController.js';

const router = express.Router();

// Route gửi thông báo lịch khám
router.post('/appointment', sendAppointmentNotification);

// Route gửi thông báo đơn thuốc
router.post('/prescription', sendPrescriptionNotification);

// Route lấy danh sách tất cả thông báo
router.get('/list', getAllNotifications);

// Route xóa thông báo theo ID
router.delete('/:id', deleteNotification);

// Route xóa tất cả thông báo
router.delete('/all/clear', deleteAllNotifications);

export default router;