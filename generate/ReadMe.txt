Cần python để chạy và MongoDB để lưu, có thể dùng MongoDB Compass để dễ thao tác
Run As Spring Boot App cho các service tương ứng

port cho api patient-service: 8090
API_URL = "http://localhost:8090/api/patients"

port cho api medical-records-service: 8091
API_URL = "http://localhost:8091/api/medical-records""

port cho api rooms-service: 8092
API_URL = "http://localhost:8092/api/rooms"

Chạy bằng lệnh: python generate_and_post_patients.py

Mặc định là tạo 100 bệnh nhân, thay đổi create_patients(100) thành create_patients(10000) tuỳ ý

Có thể thêm time.sleep(0.05) trong vòng create_patients() để delay