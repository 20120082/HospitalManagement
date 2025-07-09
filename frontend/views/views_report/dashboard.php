<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Service 4</title>
    <link rel="stylesheet" href="public/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <h2>Chào mừng đến với Service 4</h2>
    <a href="index.php?controller=Report&action=reportPage">Xem danh sách báo cáo</a>
    <form id="reportForm">
        <select name="report_type" required>
            <option value="patient_count">Số bệnh nhân</option>
            <option value="prescription_count">Số đơn thuốc</option>
        </select>
        <input type="text" name="month" placeholder="YYYY-MM" required>
        <button type="submit">Tạo báo cáo</button>
    </form>
    <div id="reportResult"></div>
    <a href="index.php?controller=Auth&action=index">Home</a>
    <script src="public/js/script.js"></script>
</body>
</html>