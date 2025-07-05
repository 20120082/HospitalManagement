const mongoose = require('mongoose');

const notificationSchema = new mongoose.Schema({
  to: String,
  subject: String,
  text: String,
  type: String, // 'appointment' hoặc 'prescription'
  status: String, // 'success' hoặc 'failed'
  createdAt: { type: Date, default: Date.now }
});

module.exports = mongoose.model('Notification', notificationSchema);
