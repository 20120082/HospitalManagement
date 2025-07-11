<?php
class Room
{
    private static $baseUrl = "http://localhost:8092/api/rooms";

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
        return self::makeRequest(self::$baseUrl, "GET");
    }

    public static function getAllPaged($page, $size)
    {
        $url = self::$baseUrl . "/paged?page={$page}&size={$size}";
        return self::makeRequest($url, 'GET');
    }

    public static function getRoomById($id)
    {
        return self::makeRequest(self::$baseUrl . "/$id", "GET");
    }

    public static function createRoom($data)
    {
        return self::makeRequest(self::$baseUrl, "POST", $data);
    }

    public static function updateRoom($id, $data)
    {
        return self::makeRequest(self::$baseUrl . "/$id", "PUT", $data);
    }

    public static function deleteRoom($id)
    {
        return self::makeRequest(self::$baseUrl . "/$id", "DELETE");
    }
    public static function getAllDoctors()
    {
        $url = "http://localhost:8081/api/doctors";
        return self::makeRequest($url, 'GET');
    }
}
?>
