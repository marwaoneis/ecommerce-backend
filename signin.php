<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers: Content-Type');
include("connection.php");
require __DIR__ . '/vendor/autoload.php';

use Firebase\JWT\JWT;

$email = $_POST['email'];
$password = $_POST['password'];
$query = $mysqli->prepare('select id_user,id_user_type,password from users where email=?');
$query->bind_param('s', $email);
$query->execute();
$query->store_result();
$num_rows = $query->num_rows;
$query->bind_result($id_user, $id_user_type, $hashed_password);
$query->fetch();


$response = [];
if ($num_rows == 0) {
    $response['status'] = 'user not found';
    echo json_encode($response);
} else {
    if (password_verify($password, $hashed_password)) {
        $key = "your_secret_key";
        $payload_array = [];
        $payload_array["id_user"] = $id_user;
        $payload_array["id_user_type"] = $id_user_type;
        $payload_array["exp"] = time() + 3600;
        $payload = $payload_array;
        $response['status'] = 'logged in successfully';
        $jwt = JWT::encode($payload, $key, 'HS256');
        $response['jwt'] = $jwt;
        $response['id_user_type'] = $id_user_type;
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $response['status'] = 'wrong credentials';
        header('Content-Type: application/json');
        echo json_encode($response);
    }
};