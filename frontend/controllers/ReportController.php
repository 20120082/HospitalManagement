<?php
require_once 'config/database.php';
require_once 'models/Report.php';

class ReportController {
    private $report;

    public function __construct() {
        $db = new Database();
        $this->report = new Report($db->getConnection());
    }

    public function generate($report_type, $month) {
        session_start();
        if (!isset($_SESSION['permissions']) || strpos($_SESSION['permissions'], 'view_reports') === false) {
            http_response_code(403);
            echo json_encode(['error' => 'Không có quyền xem báo cáo']);
            return;
        }

        $result = $this->report->generateReport($report_type, $month);
        echo json_encode($result);
    }

    public function getReportList() { // Đổi tên phương thức
        session_start();
        if (!isset($_SESSION['permissions']) || strpos($_SESSION['permissions'], 'view_reports') === false) {
            echo "<tr><td colspan='5'>Bạn không có quyền xem báo cáo.</td></tr>";
            return;
        }

        echo $this->report->getReportList();
    }

    public function dashboard()
    {
        require_once 'views/views_report/dashboard.php';
    }

    public function reportPage()
    {
        require_once 'views/views_report/reports.php';
    }
}
?>