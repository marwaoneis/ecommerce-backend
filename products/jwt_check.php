<?php

include('../connection.php');
require_once('../vendor/autoload.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Extract JWT from the request headers
$jwt = null;
$headers = apache_request_headers();
if (isset($headers['Authorization'])) {
    $matches = [];
    if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
        $jwt = $matches[1];
    }
} else {
    // Return 401 Unauthorized if Authorization header is missing
    http_response_code(401);
    echo json_encode(array("message" => "Unauthorized Access"));
    exit;
}

$key = "your_secret_key";

$decoded = JWT::decode($jwt, new key($key, 'HS256'));
$id_user = $decoded->id_user;

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response = [];
    $response['status'] = false;
    $response['message'] = 'Invalid Request';
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
