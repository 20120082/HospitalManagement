import requests
import random
from datetime import date, timedelta

# Số lượng bệnh nhân muốn tạo (có thể chỉnh lên đến 10000)
NUMBER_OF_ROOMS = 100

API_URL = "http://localhost:8090/api/patients"

first_names = ['Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng', 'Đặng', 'Bùi', 'Đỗ', 'Hồ', 'Ngô']
middle_names = ['Văn', 'Thị', 'Hữu', 'Thanh', 'Minh', 'Anh', 'Xuân', 'Quốc', 'Thùy', 'Phúc']
last_names = ['An', 'Bình', 'Cường', 'Dũng', 'Hà', 'Hạnh', 'Hưng', 'Lan', 'Mai', 'Nam', 'Tú', 'Trang', 'Vy']
streets = ['Nguyễn Trãi', 'Lý Thường Kiệt', 'Trần Hưng Đạo', 'Lê Lợi', 'Phan Đình Phùng', 'Hai Bà Trưng']
districts = ['Quận 1', 'Quận 3', 'Quận 5', 'Quận 7', 'Bình Thạnh', 'Tân Bình']
cities = ['TP.HCM', 'Hà Nội', 'Đà Nẵng', 'Cần Thơ', 'Huế', 'Biên Hòa']

def generate_full_name():
    return f"{random.choice(first_names)} {random.choice(middle_names)} {random.choice(last_names)}"

def generate_date_of_birth():
    start_date = date.today() - timedelta(days=80*365)
    end_date = date.today() - timedelta(days=18*365)
    return (start_date + timedelta(days=random.randint(0, (end_date - start_date).days))).isoformat()

def generate_phone_number():
    prefix = random.choice(["091", "094", "096", "098", "090", "093", "089", "088"])
    return prefix + str(random.randint(1000000, 9999999))

def generate_email(full_name):
    slug = ''.join(c for c in full_name.lower() if c.isalnum())
    domain = random.choice(["gmail.com", "yahoo.com", "hotmail.com"])
    return f"{slug}{random.randint(1, 999)}@{domain}"

def generate_address():
    return f"{random.randint(1,200)} {random.choice(streets)}, {random.choice(districts)}, {random.choice(cities)}"

def create_patients(num_records):
    for i in range(1, num_records + 1):
        full_name = generate_full_name()
        data = {
            "fullName": full_name,
            "gender": random.choice(["Nam", "Nữ"]),
            "dateOfBirth": generate_date_of_birth(),
            "phoneNumber": generate_phone_number(),
            "email": generate_email(full_name),
            "address": generate_address()
        }
        try:
            response = requests.post(API_URL, json=data)
            print(f"[{i}] {response.status_code} - {response.json() if response.ok else response.text}")
        except Exception as e:
            print(f"[{i}] Lỗi: {e}")

# Gọi với số lượng mong muốn
create_patients(NUMBER_OF_ROOMS)
