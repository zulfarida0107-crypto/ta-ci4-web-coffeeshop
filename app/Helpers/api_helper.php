<?php
// app/Helpers/api_helper.php

// Pastikan mendefinisikan Base URL API Spring Boot
define('API_BASE_URL', 'http://127.0.0.1:8083/api');

// Fungsi untuk request GET (mengambil data)
function api_get($endpoint, $token = null) {
    $client = \Config\Services::curlrequest();
    $headers = ['Accept' => 'application/json'];
    
    if ($token) {
        $headers['Authorization'] = 'Bearer ' . $token;
    }
    
    try {
        $response = $client->get(API_BASE_URL . $endpoint, ['headers' => $headers, 'http_errors' => false]);
        return json_decode($response->getBody(), true);
    } catch (\Exception $e) {
        return ['success' => false, 'message' => 'Gagal menghubungi server API'];
    }
}

// Fungsi untuk request POST (mengirim data)
function api_post($endpoint, $data, $token = null) {
    $client = \Config\Services::curlrequest();
    $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];
    
    if ($token) {
        $headers['Authorization'] = 'Bearer ' . $token;
    }
    
    try {
        $response = $client->post(API_BASE_URL . $endpoint, [
            'headers' => $headers,
            'json' => $data,
            'http_errors' => false
        ]);
        return json_decode($response->getBody(), true);
    } catch (\Exception $e) {
        return ['success' => false, 'message' => 'Gagal menghubungi server API'];
    }
}
