<?php
class Patient
{
    private static $baseUrl = 'http://localhost:8090/api/patients';

    // Gọi API dùng cURL
    private static function makeRequest($url, $method = 'GET', $data = null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($data !== null) {
            $jsonData = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData)
            ]);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['error' => 'Kết nối API thất bại: ' . $error];
        }

        if ($httpCode >= 400) {
            $decoded = json_decode($response, true);
            return ['error' => $decoded['message'] ?? 'Lỗi không xác định từ API.'];
        }

        return json_decode($response, true);
    }

    public static function getAll()
    {
        return self::makeRequest(self::$baseUrl, 'GET');
    }

    public static function getAllPaged($page, $size)
    {
        $url = self::$baseUrl . "/paged?page={$page}&size={$size}";
        return self::makeRequest($url, 'GET');
    }

    public static function countAllPatients()
    {
        $url = self::$baseUrl . "/count";
        return self::makeRequest($url, 'GET');
    }

    public static function countPatientsByMonth($year, $month)
    {
        $url = self::$baseUrl . "/count-by-month?year={$year}&month={$month}";
        return self::makeRequest($url, 'GET');
    }

    public static function getPatientById($id)
    {
        $url = self::$baseUrl . "/{$id}";
        return self::makeRequest($url, 'GET');
    }

    public static function createPatient($data)
    {
        return self::makeRequest(self::$baseUrl, 'POST', $data);
    }

    public static function updatePatient($id, $data)
    {
        $url = self::$baseUrl . "/{$id}";
        return self::makeRequest($url, 'PUT', $data);
    }

    public static function deletePatient($id)
    {
        $url = self::$baseUrl . "/{$id}";
        return self::makeRequest($url, 'DELETE');
    }

    public static function searchPatients($criteria)
    {
        $url = self::$baseUrl . "/search";
        return self::makeRequest($url, 'POST', $criteria);
    }
}
