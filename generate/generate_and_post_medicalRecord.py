import requests
import random
from datetime import datetime, timedelta

# Số lượng phòng muốn tạo (có thể chỉnh lên đến 10000)
NUMBER_OF_RECORDS = 200

API_URL = "http://localhost:8091/api/medical-records"

doctors = {
    "1": "Nguyễn Văn Hùng",
    "2": "Trần Thị Mai",
    "3": "Phạm Quốc Anh",
    "4": "Lê Thị Hồng Nhung",
    "5": "Hoàng Minh Tuấn"
}

diagnoses = ["Cảm cúm", "Viêm họng", "Tiêu chảy", "Sốt siêu vi", "Đau đầu", "Dị ứng"]
treatments = ["Nghỉ ngơi, uống nước", "Uống thuốc hạ sốt", "Dùng kháng sinh", "Truyền nước", "Ăn kiêng", "Điều trị nội trú"]

def random_date():
    start_date = datetime(2024, 1, 1)
    end_date = datetime.now()
    delta = end_date - start_date
    return (start_date + timedelta(days=random.randint(0, delta.days))).isoformat()

for i in range(NUMBER_OF_RECORDS):
    doctor_id = random.choice(list(doctors.keys()))
    payload = {
        "patientId": f"BN2025-{random.randint(1, 100):05d}",
        "roomId": f"PK{random.randint(1, 25):04d}",
        "doctorId": doctor_id,
        "doctorName": doctors[doctor_id],
        "diagnosis": random.choice(diagnoses),
        "treatment": random.choice(treatments),
        "createdAt": random_date()
    }

    try:
        response = requests.post(API_URL, json=payload)
        if response.status_code == 200:
            print(f"{i+1} Record created")
        else:
            print(f"Failed ({response.status_code}): {response.text}")
    except Exception as e:
        print(f"Error: {e}")
import requests
import random
from datetime import datetime, timedelta

# Số lượng phòng muốn tạo (có thể chỉnh lên đến 10000)
NUMBER_OF_RECORDS = 200

API_URL = "http://localhost:8091/api/medical-records"

doctors = {
    "1": "Nguyễn Văn Hùng",
    "2": "Trần Thị Mai",
    "3": "Phạm Quốc Anh",
    "4": "Lê Thị Hồng Nhung",
    "5": "Hoàng Minh Tuấn"
}

diagnoses = ["Cảm cúm", "Viêm họng", "Tiêu chảy", "Sốt siêu vi", "Đau đầu", "Dị ứng"]
treatments = ["Nghỉ ngơi, uống nước", "Uống thuốc hạ sốt", "Dùng kháng sinh", "Truyền nước", "Ăn kiêng", "Điều trị nội trú"]

def random_date():
    start_date = datetime(2024, 1, 1)
    end_date = datetime.now()
    delta = end_date - start_date
    return (start_date + timedelta(days=random.randint(0, delta.days))).isoformat()

for i in range(NUMBER_OF_RECORDS):
    doctor_id = random.choice(list(doctors.keys()))
    payload = {
        "patientId": f"BN2025-{random.randint(1, 100):05d}",
        "roomId": f"PK{random.randint(1, 25):04d}",
        "doctorId": doctor_id,
        "doctorName": doctors[doctor_id],
        "diagnosis": random.choice(diagnoses),
        "treatment": random.choice(treatments),
        "createdAt": random_date()
    }

    try:
        response = requests.post(API_URL, json=payload)
        if response.status_code == 200:
            print(f"{i+1} Record created")
        else:
            print(f"Failed ({response.status_code}): {response.text}")
    except Exception as e:
        print(f"Error: {e}")
