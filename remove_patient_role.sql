-- Script để xóa role patient khỏi hệ thống

-- 1. Xóa user có role patient
DELETE FROM users WHERE role_id = (SELECT role_id FROM roles WHERE role_name = 'patient');

-- 2. Xóa permissions của role patient
DELETE FROM role_permissions WHERE role_id = (SELECT role_id FROM roles WHERE role_name = 'patient');

-- 3. Xóa role patient
DELETE FROM roles WHERE role_name = 'patient';

-- 4. Kiểm tra kết quả
SELECT * FROM roles;
SELECT * FROM users;
SELECT COUNT(*) as total_role_permissions FROM role_permissions;
