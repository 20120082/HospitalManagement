<?php
class Report {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function generateReport($report_type, $month) {
        $stmt = $this->db->prepare("SELECT value FROM Report_Logs WHERE report_type = :type AND time_period = :month");
        $stmt->execute(['type' => $report_type, 'month' => $month]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return ['count' => $result['value'], 'type' => $report_type];
        }

        $count = $report_type === 'patient_count' ? 150 : 200; // Mock data
        $stmt = $this->db->prepare("INSERT INTO Report_Logs (report_type, time_period, value) VALUES (:type, :month, :count)");
        $stmt->execute(['type' => $report_type, 'month' => $month, 'count' => $count]);

        return ['count' => $count, 'type' => $report_type];
    }

    public function getReportList() { // Đổi tên phương thức
        $stmt = $this->db->query("SELECT * FROM Report_Logs ORDER BY generated_at DESC");
        $rows = '';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows .= "<tr>";
            $rows .= "<td>{$row['report_id']}</td>";
            $rows .= "<td>" . ($row['report_type'] === 'patient_count' ? 'Số bệnh nhân' : 'Số đơn thuốc') . "</td>";
            $rows .= "<td>{$row['time_period']}</td>";
            $rows .= "<td>{$row['value']}</td>";
            $rows .= "<td>{$row['generated_at']}</td>";
            $rows .= "</tr>";
        }
        return $rows;
    }
}
?>