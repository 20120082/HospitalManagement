import dotenv from 'dotenv';
import nodemailer from 'nodemailer';


// Load biến môi trường từ .env
dotenv.config();

const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
        user: process.env.EMAIL_USER,
        pass: process.env.EMAIL_PASSWORD2
    }
});

const mailOptions = {
    from: process.env.EMAIL_USER,
    to: 'csmbinh2@gmail.com',
    subject: 'Test Email from Node.js 123',
    text: 'Hello this is test 3.'
};

transporter.sendMail(mailOptions, (error, info) => {
    if (error) {
        console.log('❌ Error sending email:', error);
    } else {
        console.log('✅ Email sent:', info.response);
    }
});
