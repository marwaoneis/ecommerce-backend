<?php
include_once("./jwt_auth.php");


if ($_POST['action'] == 'getproducts') {
    if ($decoded->id_user_type != 2) {
        http_response_code(401);
        echo json_encode(array("message" => "Unauthorized Access"));
        exit;
    }
    $query = $mysqli->prepare('SELECT * FROM `products`');
    $query->execute();

    if ($query->error) {
        $response['status'] = false;
        $response['message'] = 'Error updating user: ' . $query->error;
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $result = $query->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $response['status'] = true;
        $response['message'] = 'Products fetched successfully';
        $response['products'] = $products;
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
