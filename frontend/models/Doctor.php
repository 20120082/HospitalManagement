<?php
session_start();

class Doctor {
    private $apiBaseUrl = 'http://localhost:8081/api/doctors';

    public function getAllDoctors() {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiBaseUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=UTF-8'],
        ]);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode === 200) {
            return json_decode($response, true);
        }
        return [];
    }

    public function createDoctor($data) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiBaseUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=UTF-8'],
            CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return [
            'success' => $httpCode === 200,
            'message' => $httpCode === 200 ? 'Doctor created successfully!' : 'Error creating doctor: ' . $response
        ];
    }

    public function updateDoctor($id, $data) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiBaseUrl . "/$id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=UTF-8'],
            CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return [
            'success' => $httpCode === 200,
            'message' => $httpCode === 200 ? 'Doctor updated successfully!' : 'Error updating doctor: ' . ($httpCode === 404 ? 'Doctor not found' : $response)
        ];
    }

    public function deleteDoctor($id) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiBaseUrl . "/$id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=UTF-8']
        ]);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return [
            'success' => $httpCode === 204,
            'message' => $httpCode === 204 ? 'Doctor deleted successfully!' : 'Error deleting doctor: ' . ($httpCode === 404 ? 'Doctor not found' : $response)
        ];
    }
}