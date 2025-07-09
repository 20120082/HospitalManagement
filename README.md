# UDPT Project Nhom 7 - Branch Bình
## Yêu cầu
- Cần Eclipse IDE và các yêu cầu khác để chạy Spring Boot
- Cần MongoDB để lưu dữ liệu
- Ngoài ra có thể dùng MongoDB Compass để dễ dàng truy cập. Postman để kiểm tra các API
- Nếu chưa có Eureka Server thiết lập sẵn có thể dùng trong thư mục HospitalRegisterServer
## Có 3 Service chính:
1. patient-service: port:8090 API_URL = "http://localhost:8090/api/patients"
2. medical-service: port:8091 API_URL = "http://localhost:8091/api/medical-records"
3. room-service: port:8092 API_URL = "http://localhost:8092/api/rooms"
## Lưu ý khi dùng generate
- Cần đảm bảo chạy 1 trong 3 service trước để tạo collection trong MongoDB thì file script mới có thể tạo dữ liệu được.
- Chạy file python bằng console, đường dẫn cần chỉ đúng vào file vd: python generate_and_post_patients.py
* Thư mục other chứa các phần khác có thể không còn liên quan hoặc được dùng cho phần khác 