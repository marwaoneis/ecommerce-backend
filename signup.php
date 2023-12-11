<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

include("connection.php");

$user_name = $_POST['user_name'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$id_user_type = $_POST['id_user_type']; // 1 for seller , 2 for buyer

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$query = $mysqli->prepare('insert into users(user_name, first_name, last_name, email, password, gender, age, id_user_type) values(?,?,?,?,?,?,?,?)');
$query->bind_param('ssssssii', $user_name, $first_name, $last_name, $email, $hashed_password, $gender, $age, $id_user_type);
$query->execute();

$response = [];
if ($query->error) {
    $response['status'] = false;
    $response['message'] = 'Error updating user: ' . $query->error;
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $response['status'] = true;
    $response['message'] = 'User Created successfully';
    header('Content-Type: application/json');
    echo json_encode($response);
}
