<?php
include("connection.php");


if ($_POST['action'] == "signup") {

    $user_name = $_POST['user_name'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender']; 
    $id_user_type = 2;

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = $mysqli->prepare('insert into users(user_name, first_name, last_name, email, password, gender, id_user_type) values(?,?,?,?,?,?,?)');
    $query->bind_param('ssssssi', $user_name, $first_name, $last_name, $email, $hashed_password, $gender, $id_user_type);
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
}