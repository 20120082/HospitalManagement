-- Sơ đồ dữ liệu: medicine_service cho MySQL
IF DB_ID('medicine_service') IS NULL
    CREATE DATABASE medicine_service;
GO
USE medicine_service;
GO

-- Cấu trúc bảng cho bảng medicine
IF OBJECT_ID('medicine', 'U') IS NOT NULL
    DROP TABLE medicine;
GO
CREATE TABLE medicine (
    id INT IDENTITY(1,1) PRIMARY KEY,
    code NVARCHAR(50) NOT NULL, -- Mã thuốc
    name NVARCHAR(100) NOT NULL,
    category NVARCHAR(100),     -- Loại thuốc
    description NVARCHAR(MAX),
    unit NVARCHAR(50) NOT NULL,
    price DECIMAL(10,2),
    quantity INT DEFAULT 0, -- Thêm trường số lượng thuốc
    manufacturer NVARCHAR(100),
    expiry_date DATE,
    created_at DATETIME DEFAULT GETDATE(),
    updated_at DATETIME DEFAULT GETDATE()
);
GO


-- Dữ liệu mẫu cho bảng medicine
INSERT INTO medicine (code, name, category, description, unit, price, quantity, manufacturer, expiry_date)
VALUES
  (N'PARA001', N'Paracetamol', N'Hạ sốt giảm đau', N'Pain reliever and fever reducer', N'Tablet', 5000, 100, N'ABC Pharma', '2026-12-31'),
  (N'AMOX002', N'Amoxicillin', N'Kháng sinh', N'Broad-spectrum antibiotic', N'Capsule', 8000, 50, N'XYZ Pharma', '2026-06-30'),
  (N'VITC003', N'Vitamin C', N'Vitamin', N'Immune booster', N'Tablet', 3000, 200, N'HealthPlus', '2027-01-15'),
  (N'VITC004', N'Vitamin B', N'Vitamin', N'B complex for energy', N'Tablet', 3500, 300, N'HealthPlus', '2028-01-15'),
  (N'IBUP005', N'Ibuprofen', N'Hạ sốt giảm đau', N'Anti-inflammatory pain reliever', N'Tablet', 6000, 120, N'ABC Pharma', '2027-10-10'),
  (N'CEFA006', N'Cephalexin', N'Kháng sinh', N'Antibiotic for bacterial infections', N'Capsule', 9000, 80, N'XYZ Pharma', '2026-09-30'),
  (N'ALER007', N'Loratadine', N'Chống dị ứng', N'Allergy relief', N'Tablet', 4000, 60, N'AllergyCare', '2027-05-20'),
  (N'OMEP008', N'Omeprazole', N'Dạ dày', N'Gastric acid reducer', N'Capsule', 7000, 90, N'GastroPharm', '2027-12-01'),
  (N'GLUC009', N'Glucose', N'Bổ sung năng lượng', N'Energy supplement', N'Packet', 2000, 150, N'EnergyPlus', '2028-03-10');
GO
