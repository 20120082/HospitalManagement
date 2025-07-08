import amqp from 'amqplib';
import { sendNotification } from './notificationService.js';

const RABBITMQ_HOST = 'amqp://localhost';
const QUEUE_NAME = 'prescription_notifications';

export async function startConsumer() {
  try {
    const connection = await amqp.connect(RABBITMQ_HOST);
    const channel = await connection.createChannel();
    await channel.assertQueue(QUEUE_NAME, { durable: true });
    
    console.log('Waiting for messages in queue:', QUEUE_NAME);
    
    channel.consume(QUEUE_NAME, async (msg) => {
      if (msg !== null) {
        const message = JSON.parse(msg.content.toString());
        try {
          await sendNotification({
            to: message.to,
            subject: 'Thông báo đơn thuốc',
            text: `Xin chào ${message.patientName},\nĐơn thuốc của bạn: ${message.prescriptionDetail}. \nĐơn thuốc được tạo lúc: ${message.prescriptionTime},\nBạn có thể đến bệnh viện của chúng tôi vào những ngày bệnh viện làm việc`,
            type: 'prescription'
          });
          channel.ack(msg);
        } catch (error) {
          console.error('Error processing message:', error);
          // Optionally, move to a dead-letter queue or retry
          channel.nack(msg, false, false);
        }
      }
    }, { noAck: false });
  } catch (error) {
    console.error('Error connecting to RabbitMQ:', error);
    setTimeout(startConsumer, 5000); // Retry after 5 seconds
  }
}

startConsumer();