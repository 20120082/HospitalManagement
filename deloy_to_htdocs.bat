@echo off
echo Đang copy code sang thư mục XAMPP htdocs...
xcopy /E /I /Y Service4 "C:\xampp\htdocs\Service4"
echo ✅ Deploy hoàn tất! Bạn có thể chạy http://localhost/Service4
pause
