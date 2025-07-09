-- Database: hospital_management
-- Tạo database cho hệ thống quản lý bệnh viện với phân quyền user

CREATE DATABASE IF NOT EXISTS hospital_management;
USE hospital_management;

-- Bảng roles (vai trò)
CREATE TABLE roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL UNIQUE,
    role_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng users (người dùng)
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role_id INT NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(role_id) ON DELETE RESTRICT
);

-- Bảng user_sessions (phiên đăng nhập)
CREATE TABLE user_sessions (
    session_id VARCHAR(128) PRIMARY KEY,
    user_id INT NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Bảng permissions (quyền hạn)
CREATE TABLE permissions (
    permission_id INT AUTO_INCREMENT PRIMARY KEY,
    permission_name VARCHAR(100) NOT NULL UNIQUE,
    permission_description TEXT,
    module_name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng role_permissions (quyền của từng vai trò)
CREATE TABLE role_permissions (
    role_id INT,
    permission_id INT,
    granted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(role_id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(permission_id) ON DELETE CASCADE
);

-- Bảng doctors (thông tin bác sĩ - mở rộng từ users)
CREATE TABLE doctors (
    doctor_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    employee_id VARCHAR(20) UNIQUE,
    specialization VARCHAR(100),
    license_number VARCHAR(50),
    department VARCHAR(100),
    consultation_fee DECIMAL(10,2),
    experience_years INT,
    education TEXT,
    available_days VARCHAR(50),
    available_hours VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Bảng patients (thông tin bệnh nhân - mở rộng từ users)
CREATE TABLE patients (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    patient_code VARCHAR(20) UNIQUE,
    date_of_birth DATE,
    gender ENUM('Male', 'Female', 'Other'),
    blood_type VARCHAR(5),
    emergency_contact VARCHAR(100),
    emergency_phone VARCHAR(20),
    insurance_number VARCHAR(50),
    medical_history TEXT,
    allergies TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Bảng login_attempts (theo dõi các lần đăng nhập thất bại)
CREATE TABLE login_attempts (
    attempt_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    ip_address VARCHAR(45),
    attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    success BOOLEAN DEFAULT FALSE,
    failure_reason VARCHAR(100)
);

-- Thêm dữ liệu mẫu cho roles
INSERT INTO roles (role_name, role_description) VALUES 
('admin', 'Quản trị viên hệ thống - có quyền truy cập tất cả'),
('doctor', 'Bác sĩ - quản lý bệnh nhân, đơn thuốc, lịch hẹn'),
('patient', 'Bệnh nhân - xem thông tin cá nhân, lịch hẹn'),
('nurse', 'Y tá - hỗ trợ bác sĩ, quản lý thuốc'),
('receptionist', 'Lễ tân - quản lý lịch hẹn, thông tin bệnh nhân cơ bản');

-- Thêm dữ liệu mẫu cho permissions
INSERT INTO permissions (permission_name, permission_description, module_name) VALUES 
-- Admin permissions
('admin_dashboard', 'Truy cập dashboard quản trị', 'admin'),
('user_management', 'Quản lý người dùng', 'admin'),
('system_settings', 'Cài đặt hệ thống', 'admin'),
('view_reports', 'Xem báo cáo', 'admin'),

-- Doctor permissions
('doctor_dashboard', 'Truy cập dashboard bác sĩ', 'doctor'),
('manage_prescriptions', 'Quản lý đơn thuốc', 'prescription'),
('view_patients', 'Xem thông tin bệnh nhân', 'patient'),
('doctor_manage_appointments', 'Quản lý lịch hẹn bác sĩ', 'appointment'),
('view_medicines', 'Xem danh sách thuốc', 'medicine'),

-- Patient permissions
('patient_dashboard', 'Truy cập dashboard bệnh nhân', 'patient'),
('view_own_appointments', 'Xem lịch hẹn của mình', 'appointment'),
('view_own_prescriptions', 'Xem đơn thuốc của mình', 'prescription'),
('book_appointment', 'Đặt lịch hẹn', 'appointment'),

-- Nurse permissions
('nurse_dashboard', 'Truy cập dashboard y tá', 'nurse'),
('manage_medicines', 'Quản lý thuốc', 'medicine'),
('view_prescriptions', 'Xem đơn thuốc', 'prescription'),
('assist_doctor', 'Hỗ trợ bác sĩ', 'doctor'),

-- Receptionist permissions
('receptionist_dashboard', 'Truy cập dashboard lễ tân', 'receptionist'),
('receptionist_manage_appointments', 'Quản lý lịch hẹn lễ tân', 'appointment'),
('view_patients_basic', 'Xem thông tin cơ bản bệnh nhân', 'patient'),
('manage_notifications', 'Quản lý thông báo', 'notification');

-- Gán quyền cho từng vai trò
-- Admin có tất cả quyền
INSERT INTO role_permissions (role_id, permission_id) 
SELECT 1, permission_id FROM permissions;

-- Doctor permissions
INSERT INTO role_permissions (role_id, permission_id) VALUES 
(2, 5), -- doctor_dashboard
(2, 6), -- manage_prescriptions
(2, 7), -- view_patients
(2, 8), -- doctor_manage_appointments
(2, 9), -- view_medicines
(2, 4); -- view_reports

-- Patient permissions
INSERT INTO role_permissions (role_id, permission_id) VALUES 
(3, 10), -- patient_dashboard
(3, 11), -- view_own_appointments
(3, 12), -- view_own_prescriptions
(3, 13); -- book_appointment

-- Nurse permissions
INSERT INTO role_permissions (role_id, permission_id) VALUES 
(4, 14), -- nurse_dashboard
(4, 15), -- manage_medicines
(4, 16), -- view_prescriptions
(4, 17), -- assist_doctor
(4, 9);  -- view_medicines

-- Receptionist permissions
INSERT INTO role_permissions (role_id, permission_id) VALUES 
(5, 18), -- receptionist_dashboard
(5, 19), -- receptionist_manage_appointments
(5, 20), -- view_patients_basic
(5, 21); -- manage_notifications

-- Tạo users mẫu (mật khẩu đã được hash bằng password_hash())
-- Mật khẩu mặc định: "password123"
INSERT INTO users (username, email, password_hash, full_name, phone, address, role_id) VALUES 
('admin', 'admin@hospital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Quản trị viên hệ thống', '0123456789', 'Hà Nội', 1),
('doctor1', 'doctor1@hospital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bác sĩ Nguyễn Văn A', '0987654321', 'Hà Nội', 2),
('doctor2', 'doctor2@hospital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bác sĩ Trần Thị B', '0987654322', 'TP.HCM', 2),
('patient1', 'patient1@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bệnh nhân Lê Văn C', '0912345678', 'Đà Nẵng', 3),
('nurse1', 'nurse1@hospital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Y tá Phạm Thị D', '0908765432', 'Hà Nội', 4),
('receptionist1', 'receptionist1@hospital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Lễ tân Hoàng Văn E', '0901234567', 'Hà Nội', 5);

-- Thêm thông tin chi tiết cho doctors
INSERT INTO doctors (user_id, employee_id, specialization, license_number, department, consultation_fee, experience_years, education, available_days, available_hours) VALUES 
(2, 'DOC001', 'Nội khoa', 'LIC001', 'Khoa Nội', 300000.00, 10, 'Tiến sĩ Y khoa - Đại học Y Hà Nội', 'Thứ 2-6', '8:00-17:00'),
(3, 'DOC002', 'Ngoại khoa', 'LIC002', 'Khoa Ngoại', 400000.00, 8, 'Thạc sĩ Y khoa - Đại học Y TP.HCM', 'Thứ 2-7', '7:00-16:00');

-- Thêm thông tin chi tiết cho patients
INSERT INTO patients (user_id, patient_code, date_of_birth, gender, blood_type, emergency_contact, emergency_phone, insurance_number, medical_history, allergies) VALUES 
(4, 'PAT001', '1990-05-15', 'Male', 'A+', 'Lê Thị F (Vợ)', '0912345679', 'INS001', 'Không có tiền sử bệnh đặc biệt', 'Không có dị ứng');

-- Tạo indexes để tối ưu hiệu suất
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role_id ON users(role_id);
CREATE INDEX idx_users_is_active ON users(is_active);
CREATE INDEX idx_user_sessions_user_id ON user_sessions(user_id);
CREATE INDEX idx_user_sessions_is_active ON user_sessions(is_active);
CREATE INDEX idx_login_attempts_username ON login_attempts(username);
CREATE INDEX idx_login_attempts_ip_address ON login_attempts(ip_address);
CREATE INDEX idx_login_attempts_attempt_time ON login_attempts(attempt_time);

-- Tạo view để dễ dàng truy vấn thông tin user với role
CREATE VIEW user_info AS
SELECT 
    u.user_id,
    u.username,
    u.email,
    u.full_name,
    u.phone,
    u.address,
    r.role_name,
    r.role_description,
    u.is_active,
    u.last_login,
    u.created_at
FROM users u
JOIN roles r ON u.role_id = r.role_id;

-- Tạo view để xem quyền của user
CREATE VIEW user_permissions AS
SELECT 
    u.user_id,
    u.username,
    u.full_name,
    r.role_name,
    p.permission_name,
    p.permission_description,
    p.module_name
FROM users u
JOIN roles r ON u.role_id = r.role_id
JOIN role_permissions rp ON r.role_id = rp.role_id
JOIN permissions p ON rp.permission_id = p.permission_id
WHERE u.is_active = TRUE;

-- Hiển thị thông tin tài khoản mặc định
SELECT 'Tài khoản mặc định đã được tạo:' as message;
SELECT 
    username,
    full_name,
    r.role_name,
    'password123' as default_password
FROM users u
JOIN roles r ON u.role_id = r.role_id
ORDER BY u.role_id;
