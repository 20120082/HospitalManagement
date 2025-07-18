import Notification from '../model/notification.js';
import nodemailer from 'nodemailer';

export const sendAppointmentNotification = async (req, res) => {
  const { to, patientName, appointmentTime, appointmentRoom, doctor } = req.body;
  
  // Xử lý tên bác sĩ: có thể là object hoặc string
  let doctorName = 'Bác sĩ';
  if (typeof doctor === 'string' && doctor.trim()) {
    doctorName = doctor.trim();
  } else if (typeof doctor === 'object' && doctor) {
    doctorName = doctor.name || doctor.fullName || doctor.doctorName || 'Bác sĩ';
  }
  
  const roomId = appointmentRoom || 'Phòng khám';
  
  const subject = 'Thông báo lịch khám bệnh';
  const text = `Xin chào ${patientName},\nBạn có lịch khám với bác sĩ ${doctorName} tại phòng ${roomId} vào lúc ${appointmentTime}. Vui lòng đến đúng giờ.`;
  let status = 'success';
  const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
      user: process.env.EMAIL_USER,
      pass: process.env.EMAIL_PASSWORD
    }
  });
  try {
    await transporter.sendMail({ from: process.env.EMAIL_USER, to, subject, text });
  } catch (error) {
    status = 'failed';
    await Notification.create({ to, subject, text, type: 'appointment', status });
    return res.status(500).json({ success: false, error: error.message });
  }
  await Notification.create({ to, subject, text, type: 'appointment', status });
  res.json({ success: true, message: 'Đã gửi thông báo lịch khám!' });
};


export const sendPrescriptionNotification = async (req, res) => {
  const { to, patientName, prescriptionDetail, prescriptionTime } = req.body;
  const subject = 'Thông báo đơn thuốc';
  const text = `Xin chào ${patientName},\nĐơn thuốc của bạn: ${prescriptionDetail}. \nVui lòng đến lấy thuốc tại quầy lúc ${prescriptionTime}`;
  let status = 'success';
  const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
      user: process.env.EMAIL_USER,
      pass: process.env.EMAIL_PASSWORD
    }
  });
  try {
    await transporter.sendMail({ from: process.env.EMAIL_USER, to, subject, text });
  } catch (error) {
    status = 'failed';
    await Notification.create({ to, subject, text, type: 'prescription', status });
    return res.status(500).json({ success: false, error: error.message });
  }
  await Notification.create({ to, subject, text, type: 'prescription', status });
  res.json({ success: true, message: 'Đã gửi thông báo đơn thuốc!' });
};

// Lấy danh sách tất cả thông báo
export const getAllNotifications = async (req, res) => {
  try {
    const notifications = await Notification.find().sort({ createdAt: -1 });
    res.json({ success: true, data: notifications });
  } catch (error) {
    res.status(500).json({ success: false, error: error.message });
  }
};

// Xóa thông báo theo ID
export const deleteNotification = async (req, res) => {
  try {
    const { id } = req.params;
    const deletedNotification = await Notification.findByIdAndDelete(id);
    if (!deletedNotification) {
      return res.status(404).json({ success: false, message: 'Không tìm thấy thông báo' });
    }
    res.json({ success: true, message: 'Đã xóa thông báo thành công' });
  } catch (error) {
    res.status(500).json({ success: false, error: error.message });
  }
};

// Xóa tất cả thông báo
export const deleteAllNotifications = async (req, res) => {
  try {
    await Notification.deleteMany({});
    res.json({ success: true, message: 'Đã xóa tất cả thông báo thành công' });
  } catch (error) {
    res.status(500).json({ success: false, error: error.message });
  }
};
