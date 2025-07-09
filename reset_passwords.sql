-- Kiểm tra tên username thực tế trong database
SELECT user_id, username, full_name, role_id FROM users;

-- Tạo password hash mới cho "password123"
-- Hash này được tạo bằng password_hash("password123", PASSWORD_DEFAULT)

-- Reset password cho từng user cụ thể
UPDATE users SET password_hash = '$2y$10$XmY9GdkjCn5/mjE4zLLC3u2c.dinYlvwFAWNtw2a3ZQ1iMOoX5yhC' WHERE user_id = 1; -- admin
UPDATE users SET password_hash = '$2y$10$XmY9GdkjCn5/mjE4zLLC3u2c.dinYlvwFAWNtw2a3ZQ1iMOoX5yhC' WHERE user_id = 2; -- doctor1
UPDATE users SET password_hash = '$2y$10$XmY9GdkjCn5/mjE4zLLC3u2c.dinYlvwFAWNtw2a3ZQ1iMOoX5yhC' WHERE user_id = 3; -- doctor2
UPDATE users SET password_hash = '$2y$10$XmY9GdkjCn5/mjE4zLLC3u2c.dinYlvwFAWNtw2a3ZQ1iMOoX5yhC' WHERE user_id = 5; -- nurse1
UPDATE users SET password_hash = '$2y$10$XmY9GdkjCn5/mjE4zLLC3u2c.dinYlvwFAWNtw2a3ZQ1iMOoX5yhC' WHERE user_id = 6; -- receptionist1

-- Kiểm tra kết quả sau khi update
SELECT user_id, username, password_hash FROM users;
