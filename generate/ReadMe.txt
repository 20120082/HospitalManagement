Cần python để chạy

port cho api patient-service: 8090
API_URL = "http://localhost:8090/api/patients"

Chạy bằng lệnh: python generate_and_post_patients.py

Mặc định là tạo 100 bệnh nhân, thay đổi create_patients(100) thành create_patients(10000) tuỳ ý

Có thể thêm time.sleep(0.05) trong vòng create_patients() để delay