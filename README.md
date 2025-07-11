# UDPT Project Nhom 7
## Yêu cầu:
- nodejs version 24.3.0 hoặc mới hơn, java springboot,wampp hoặc xampp.
- Database: sql server chạy ở port 1433, MySQL chạy ở port 3306, MongoDB.
- Đảm bảo các port từ: 8080->8099 không có ứng dụng khác sử dụng để cho các service sử dụng.

## Hướng dẫn sử dụng: (làm theo đúng trình tự)
1. Bật các database mysql và sql server.
2. Tạo sẵn user có tên là root và password là root ở cả 2 database sql server và MySQL. Tạo database hospital_management trên MySQL.
3. Chạy các file SQL trong folder SQL
4. Tạo file .env cho các folder patient-service,room-service,medical-record-service với nội dung bên trong:
MONGO_USER=hieu123hcm
MONGO_PASSWORD=av83S9D7bZhWbCyU
5. Chạy các folder HospitalRegisterServer tạo eureka server để các service khác đăng ký vào bằng java springboot. 
6. Chạy lần lượt các service bằng java springboot (nhưng không chạy Notification-Service vì service này sử dụng nodejs) (nếu medicine-service không chạy được thì trong properties, port đổi sang 1434)
7. Chạy rabbitMQ. Vào http://localhost:15672/ để đăng nhập rabbitMQ với tài khoản : guest, password: guest
8. Chạy folder Notification-Service bằng nodejs. (cú pháp npm install -> node index.js)
9. Chạy frontend (bằng cách copy folder frontend vào folder www đối với dùng wamp, hoặc htdocs đối với xampp)
10.Truy cập vào http://localhost/frontend.

## Các thành viên:
- Nguyễn Thanh Hiếu – 20120082
- Thái Minh Triết– 20120223
- Phạm Phước Bình – 20120436
- Phạm Thị Kiều Trinh – 21120579