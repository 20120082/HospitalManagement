import requests
import random
import time

# Số lượng phòng muốn tạo (có thể chỉnh lên đến 10000)
NUMBER_OF_ROOMS = 100

# Địa chỉ API room-service
API_URL = "http://localhost:8092/api/rooms"

# Danh sách mẫu chuyên khoa
departments = [
    "Nội tổng quát", "Ngoại thần kinh", "Sản phụ khoa",
    "Tai mũi họng", "Da liễu", "Nhi khoa", "Răng hàm mặt"
]

# Danh sách tên bác sĩ mẫu
doctor_list = [
    {"id": "1", "name": "Nguyễn Văn Hùng"},
    {"id": "2", "name": "Trần Thị Mai"},
    {"id": "3", "name": "Phạm Quốc Anh"},
    {"id": "4", "name": "Lê Thị Hồng Nhung"},
    {"id": "5", "name": "Hoàng Minh Tuấn"}
]

def generate_random_room():
    dept = random.choice(departments)
    doc = random.choice(doctor_list)
    name = f"Phòng {random.randint(100, 999)} - {dept}"
    
    return {
        "roomName": name,
        "department": dept,
        "doctorId": doc["id"],
        "doctorName": doc["name"],
        "roomActive": random.choice([True, False])
    }

def create_room(data):
    try:
        response = requests.post(API_URL, json=data)
        if response.status_code == 200:
            print(f"Đã tạo phòng: {data['roomName']}")
        else:
            print(f"Lỗi tạo phòng: {response.status_code} - {response.text}")
    except Exception as e:
        print(f"Lỗi kết nối: {e}")

def run_batch_create(n=NUMBER_OF_ROOMS):
    for i in range(n):
        room_data = generate_random_room()
        create_room(room_data)
        #time.sleep(0.05)  # Giảm tải hệ thống nếu cần

if __name__ == "__main__":
    run_batch_create()
