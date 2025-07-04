<?php
class Prescription {
    private $apiBaseUrl = 'http://localhost:8083/api/prescriptions';
    private $medicineApiBaseUrl = 'http://localhost:8084/api/medicines';
    private $patientApiBaseUrl = 'http://localhost:8090/api/patients';

    public function getAllMedicines() {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->medicineApiBaseUrl,
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

    public function getAllPatients() {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->patientApiBaseUrl,
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

    public function getAllPrescriptions() {
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

    public function createPrescription($data) {
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
            'message' => $httpCode === 200 ? 'Prescription created successfully!' : 'Error creating prescription: ' . $response
        ];
    }

    public function updatePrescriptionStatus($id, $status) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiBaseUrl . "/$id/status",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_HTTPHEADER => ['Content-Type: text/plain; charset=UTF-8'],
            CURLOPT_POSTFIELDS => $status
        ]);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return [
            'success' => $httpCode === 200,
            'message' => $httpCode === 200 ? 'Status updated successfully!' : 'Error updating status: ' . $response
        ];
    }
    
    public function deletePrescription($id) {
        error_log("Deleting prescription ID: $id");
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiBaseUrl . "/$id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "DELETE",
        ]);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        error_log("Delete response: $response, HTTP Code: $httpCode");
        curl_close($curl);
        if ($httpCode == 204) {
            return ['success' => true, 'message' => 'Prescription deleted successfully!'];
        } else {
            $errorMessage = $response;
            if ($httpCode == 400) {
                $parsed = json_decode($response, true);
                if (is_string($parsed)) {
                    $errorMessage = $parsed;
                } elseif (isset($parsed['message'])) {
                    $errorMessage = $parsed['message'];
                }
            }
            return ['success' => false, 'message' => "Error deleting prescription: $errorMessage"];
        }
    }
}