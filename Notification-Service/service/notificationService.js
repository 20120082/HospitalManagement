import Notification from '../model/notification.js';
import nodemailer from 'nodemailer';
import  '../router/notificationRoutes.js';

const transporter = nodemailer.createTransport({
  service: 'gmail',
  auth: {
    user: process.env.EMAIL_USER || `trietcd497@gmail.com`,
    pass: process.env.EMAIL_PASSWORD || `ifxa jgao euws xfxi`
  }
});

export const sendNotification = async ({ to, subject, text, type }) => {
  let status = 'success';
  try {
    await transporter.sendMail({ from: process.env.EMAIL_USER, to, subject, text });
  } catch (error) {
    status = 'failed';
    await Notification.create({ to, subject, text, type, status });
    throw error;
  }
  await Notification.create({ to, subject, text, type, status });
  return { success: true, message: 'Đã gửi thông báo!' };
};
