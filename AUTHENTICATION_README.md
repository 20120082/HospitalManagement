# Hospital Management System - Authentication & Authorization

## Tổng quan
Hệ thống quản lý bệnh viện với chức năng đăng nhập và phân quyền (role-based authentication) được tích hợp sẵn.

## Cấu trúc Database
- **users**: Thông tin người dùng
- **roles**: Các vai trò (admin, doctor, nurse, receptionist)
- **permissions**: Các quyền hạn chi tiết
- **role_permissions**: Liên kết quyền với vai trò
- **user_sessions**: Quản lý phiên đăng nhập

## Các tài khoản mặc định
| Username | Password | Role |
|----------|----------|------|
| admin | password123 | Admin |
| doctor1 | password123 | Doctor |
| doctor2 | password123 | Doctor |
| nurse1 | password123 | Nurse |
| receptionist1 | password123 | Receptionist |

## Cấu trúc Code

### Models
- `User.php`: Xử lý đăng nhập, phân quyền, session
- `Doctor.php`, `Medicine.php`, `Prescription.php`: Các model nghiệp vụ

### Controllers
- `AuthController.php`: Xử lý đăng nhập, logout, dashboard
- `DoctorController.php`, `MedicineController.php`, `PrescriptionController.php`: Các controller nghiệp vụ

### Views
- `views/auth/`: Các trang liên quan đến authentication
- `views/auth/login.php`: Trang đăng nhập
- `views/auth/*_dashboard.php`: Dashboard cho từng role

### Middleware
- `AuthMiddleware.php`: Kiểm tra quyền truy cập các controller/action

## Cách sử dụng

### 1. Đăng nhập
```
URL: http://localhost/UDPT_Trinh/HospitalManagement/frontend/index.php?action=login
```

### 2. Truy cập Dashboard
Sau khi đăng nhập thành công, người dùng sẽ được chuyển đến dashboard tương ứng với role:
- Admin: `admin_dashboard`
- Doctor: `doctor_dashboard`
- Nurse: `nurse_dashboard`
- Receptionist: `receptionist_dashboard`

### 3. Phân quyền
Hệ thống tự động kiểm tra quyền truy cập:
- Mỗi controller/action yêu cầu quyền cụ thể
- Middleware tự động chặn truy cập trái phép
- Hiển thị trang "Access Denied" nếu không đủ quyền

## Cấu hình

### Database Connection
File: `frontend/config/database.php`
```php
private $host = "localhost";
private $db_name = "hospital_management";
private $username = "root";
private $password = "";
```

### Session Management
- Session tự động khởi tạo trong `index.php`
- Session được lưu trong database table `user_sessions`
- Auto-logout khi session hết hạn

## Bảo mật
- Password được hash bằng `password_hash()` 
- Session được validate với database
- Kiểm tra quyền truy cập mọi request
- Chống duplicate login sessions

## Development Notes
- Middleware đã được enable
- Tất cả đường dẫn đã được chuẩn hóa với `__DIR__`
- Hệ thống ready cho production

## Troubleshooting
- Kiểm tra XAMPP MySQL service đang chạy
- Đảm bảo database `hospital_management` đã được import
- Kiểm tra file `hospital_auth.sql` đã được execute
- Nếu cần reset password, sử dụng `reset_passwords.sql`
