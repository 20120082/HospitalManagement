import Notification from '../model/notification.js';
import nodemailer from 'nodemailer';

export const sendAppointmentNotification = async (req, res) => {
  const { to, patientName, appointmentTime, appointmentRoom, doctor } = req.body;
  // Lấy tên bác sĩ dù là object hay string
  const doctorName = typeof doctor === 'string' ? doctor : (doctor?.name || '');
  const roomId = appointmentRoom || '';
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
