<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers: Content-Type');
include("connection.php");

use Firebase\JWT\JWT;

$user_name = $_POST['user_name'];
$password = $_POST['password'];

$query = $mysqli->prepare('select id_user, user_name, password, id_user_type from users where user_name = ?');
$query->bind_param('s', $user_name);
$query->execute();
$query->store_result();
$num_rows = $query->num_rows;
$query->bind_result($id_user, $user_name, $hashed_password, $id_user_type);
$query->fetch();


$response = [];
if ($num_rows == 0) {
    $response['status'] = 'user not found';
    echo json_encode($response);
} else {
    if (password_verify($password, $hashed_password)) {
        $key = "your_secret_key";
        $payload_array = [];
        $payload_array["user_id"] = $id_user;
        $payload_array["usertype"] = $id_user_type;
        $payload_array["username"] = $user_name;
        $payload_array["exp"] = time() + 3600;
        $payload = $payload_array;
        $response['status'] = 'logged in successfully';
        $jwt = JWT::encode($payload, $key, 'HS256');
        $response['jwt'] = $jwt;
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $response['status'] = 'wrong credentials';
        header('Content-Type: application/json');
        echo json_encode($response);
    }
};