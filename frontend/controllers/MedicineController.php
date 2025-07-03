<?php
// controllers/MedicineController.php
require_once 'models/Medicine.php';

class MedicineController {
    private $apiBaseUrl = 'http://localhost:8082/api/medicines'; // Sửa lại nếu backend chạy port khác

    private function request($method, $url, $data = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json'
            ]);
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json'
            ]);
        }
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$response, $httpCode];
    }

    public function listPage() {
        // Lấy tham số tìm kiếm từ GET
        $search_name = $_GET['search_name'] ?? '';
        $search_code = $_GET['search_code'] ?? '';
        $search_category = $_GET['search_category'] ?? '';

        // Gọi API với query string nếu có tìm kiếm
        $query = [];
        if ($search_name !== '') $query['name'] = $search_name;
        if ($search_code !== '') $query['code'] = $search_code;
        if ($search_category !== '') $query['category'] = $search_category;
        $url = $this->apiBaseUrl;
        if (!empty($query)) {
            $url .= '/search?' . http_build_query($query); // Sử dụng endpoint /search
        }
        list($response, $code) = $this->request('GET', $url);
        $medicines = [];
        if ($code === 200) {
            $arr = json_decode($response, true);
            foreach ($arr as $item) {
                $medicines[] = new Medicine($item);
            }
        }

        // Lấy tất cả category duy nhất từ danh sách thuốc (để render dropdown động)
        $all_categories = [];
        foreach ($medicines as $med) {
            if (!empty($med->category) && !in_array($med->category, $all_categories)) {
                $all_categories[] = $med->category;
            }
        }

        // Nếu là AJAX request thì chỉ render tbody
        if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
            require 'views/list_medicine_tbody.php';
            return;
        }
        require 'views/list_medicine_page.php';
    }

    public function createPage() {
        require 'views/create_medicine_page.php';
    }

    public function create() {
        $data = $_POST;
        list($response, $code) = $this->request('POST', $this->apiBaseUrl, $data);
        $result = ($code === 200 || $code === 201);
        require 'views/create_medicine_result.php';
    }

    public function updatePage() {
        $id = $_GET['id'] ?? null;
        if (!$id) die('Missing id');
        list($response, $code) = $this->request('GET', $this->apiBaseUrl . "/$id");
        $medicine = null;
        if ($code === 200) {
            $medicine = new Medicine(json_decode($response, true));
        }
        require 'views/update_medicine_page.php';
    }

    public function update() {
        $id = $_POST['id'] ?? null;
        if (!$id) die('Missing id');
        $data = [
            'code' => $_POST['code'] ?? '',
            'name' => $_POST['name'] ?? '',
            'category' => $_POST['category'] ?? '',
            'description' => $_POST['description'] ?? '',
            'unit' => $_POST['unit'] ?? '',
            'price' => isset($_POST['price']) ? floatval($_POST['price']) : 0,
            'quantity' => isset($_POST['quantity']) ? intval($_POST['quantity']) : 0,
            'manufacturer' => $_POST['manufacturer'] ?? '',
            'expiryDate' => $_POST['expiryDate'] ?? null
        ];
        list($response, $code) = $this->request('PUT', $this->apiBaseUrl . "/$id", $data);
        $result = ($code === 200);
        require 'views/update_medicine_result.php';
    }

    public function deletePage() {
        $id = $_GET['id'] ?? null;
        if (!$id) die('Missing id');
        list($response, $code) = $this->request('GET', $this->apiBaseUrl . "/$id");
        $medicine = null;
        if ($code === 200) {
            $medicine = new Medicine(json_decode($response, true));
        }
        require 'views/delete_medicine_page.php';
    }

    public function delete() {
        $id = $_POST['id'] ?? null;
        if (!$id) die('Missing id');
        list($response, $code) = $this->request('DELETE', $this->apiBaseUrl . "/$id");
        $result = ($code === 204);
        require 'views/delete_medicine_result.php';
    }
}
