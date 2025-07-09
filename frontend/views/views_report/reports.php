<!DOCTYPE html>
<html>
<head>
    <title>Báo cáo - Service 4</title>
    <link rel="stylesheet" href="public/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <h2>Báo cáo thống kê</h2>
    <a href="index.php?controller=Report&action=dashboard">Quay lại Dashboard</a>
    <h3>Tạo báo cáo mới</h3>
    <form id="reportForm">
        <select name="report_type" required>
            <option value="patient_count">Số bệnh nhân</option>
            <option value="prescription_count">Số đơn thuốc</option>
        </select>
        <input type="text" name="month" placeholder="YYYY-MM" required>
        <button type="submit">Tạo báo cáo</button>
    </form>
    <div id="reportResult"></div>

    <h3>Danh sách báo cáo</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Loại báo cáo</th>
                <th>Thời gian</th>
                <th>Giá trị</th>
                <th>Ngày tạo</th>
            </tr>
        </thead>
        <tbody id="reportTable">
            <?php
            // Không cần session_start() vì đã gọi trong index.php
            if (!isset($_SESSION['permissions']) || strpos($_SESSION['permissions'], 'view_reports') === false) {
                echo "<tr><td colspan='5'>Bạn không có quyền xem báo cáo.</td></tr>";
            } else {
                require_once 'config/database.php';
                $db = new Database();
                $conn = $db->getConnection();
                $stmt = $conn->query("SELECT * FROM Report_Logs ORDER BY generated_at DESC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$row['report_id']}</td>";
                    echo "<td>" . ($row['report_type'] === 'patient_count' ? 'Số bệnh nhân' : 'Số đơn thuốc') . "</td>";
                    echo "<td>{$row['time_period']}</td>";
                    echo "<td>{$row['value']}</td>";
                    echo "<td>{$row['generated_at']}</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <script src="public/js/script.js"></script>
</body>
</html>