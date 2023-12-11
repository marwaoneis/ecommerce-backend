<?php
include_once("./jwt_auth.php");

if ($_POST['action'] == "create") {
    if ($decoded->id_user_type != 1) {
        http_response_code(401);
        echo json_encode(array("message" => "Unauthorized Access"));
        exit;
    }

    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $query = $mysqli->prepare('INSERT INTO `products` (`product_name`, `price`, `description`) 
                            VALUES (?, ?, ?);');
    $query->bind_param('sis', $product_name, $price, $description);
    $query->execute();

    $response = [];
    if ($query->error) {
        $response['status'] = false;
        $response['message'] = 'Error updating user: ' . $query->error;
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $response['status'] = true;
        $response['message'] = 'Product created successfully';
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
