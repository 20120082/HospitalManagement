<?php

class ReportController {
    private $patientApiUrl = 'http://localhost:8090/api/patients';
    private $prescriptionApiUrl = 'http://localhost:8083/api/prescriptions';
    
    public function index() {
        include 'views/report_statistics.php';
    }
    
    public function test() {
        echo "ReportController is working!<br>";
        echo "Patient API: " . $this->patientApiUrl . "<br>";
        echo "Prescription API: " . $this->prescriptionApiUrl . "<br>";
        
        $result = $this->callApi($this->patientApiUrl . '/count');
        echo "Patient count result: " . json_encode($result) . "<br>";
        
        $result2 = $this->callApi($this->prescriptionApiUrl . '/count');
        echo "Prescription count result: " . json_encode($result2) . "<br>";
    }
    
    public function getPatientStats() {
        try {
            // Clean any previous output
            ob_clean();
            
            $year = $_GET['year'] ?? date('Y');
            $month = $_GET['month'] ?? date('m');
            
            // Gọi API để lấy thống kê bệnh nhân
            $totalPatients = $this->callApi($this->patientApiUrl . '/count');
            $monthlyPatients = $this->callApi($this->patientApiUrl . '/count-by-month?year=' . $year . '&month=' . $month);
            
            // Đảm bảo trả về header JSON
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type');
            
            $result = [
                'total' => $totalPatients,
                'monthly' => $monthlyPatients
            ];
            
            echo json_encode($result);
            exit; // Quan trọng: dừng execution
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }
    
    public function getPrescriptionStats() {
        try {
            // Clean any previous output
            ob_clean();
            
            $year = $_GET['year'] ?? date('Y');
            $month = $_GET['month'] ?? date('m');
            
            // Gọi API để lấy thống kê đơn thuốc
            $totalPrescriptions = $this->callApi($this->prescriptionApiUrl . '/count');
            $monthlyPrescriptions = $this->callApi($this->prescriptionApiUrl . '/count-by-month?year=' . $year . '&month=' . $month);
            $statusStats = $this->callApi($this->prescriptionApiUrl . '/count-by-status');
            
            // Đảm bảo trả về header JSON
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type');
            
            $result = [
                'total' => $totalPrescriptions,
                'monthly' => $monthlyPrescriptions,
                'status' => $statusStats
            ];
            
            echo json_encode($result);
            exit; // Quan trọng: dừng execution
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }
    
    public function getMonthlyReport() {
        try {
            // Clean any previous output
            ob_clean();
            
            $year = $_GET['year'] ?? date('Y');
            $report = [];
            
            for ($month = 1; $month <= 12; $month++) {
                $patientCount = $this->callApi($this->patientApiUrl . '/count-by-month?year=' . $year . '&month=' . $month);
                $prescriptionCount = $this->callApi($this->prescriptionApiUrl . '/count-by-month?year=' . $year . '&month=' . $month);
                
                $report[] = [
                    'month' => $month,
                    'patients' => $patientCount,
                    'prescriptions' => $prescriptionCount
                ];
            }
            
            // Đảm bảo trả về header JSON
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type');
            
            echo json_encode($report);
            exit; // Quan trọng: dừng execution
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }
    
    private function callApi($url) {
        // Debug: Log URL được gọi
        error_log("Calling API: " . $url);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        // Debug: Log response
        error_log("API Response - URL: $url, HTTP Code: $httpCode, Response: $response, Error: $error");
        
        if ($httpCode === 200 && $response !== false) {
            $decoded = json_decode($response, true);
            return $decoded !== null ? $decoded : 0;
        }
        
        return 0; // Trả về 0 nếu API không thành công
    }
}
?>
