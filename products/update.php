<?php
include_once("./jwt_auth.php");

if ($_POST['action'] == 'update') {
    if ($decoded->id_user_type != 1) {
        // Return 401 Unauthorized if the user is not a Seller
        http_response_code(401);
        echo json_encode(array("message" => "Unauthorized Access"));
        exit;
    }

    $product_name = $_POST["product_name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $id_product = $_POST["id_product"];

    // Update an existing product in the database if and only if the user is the owner of the product
    $query = $con->prepare('UPDATE `products` SET `product_name` = ?, `price` = ?, `description` = ? WHERE `id_product` = ? AND `id_user` = ?');
    $query->bind_param('sisii', $product_name, $price, $description, $id_product, $id_user);
    $query->execute();

    if ($query->error) {
        $response['status'] = false;
        $response['message'] = 'Error updating user: ' . $query->error;
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        if ($query->affected_rows > 0) {
            $response['status'] = true;
            $response['message'] = 'Product updated successfully';
        } else {
            $response['status'] = false;
            $response['message'] = 'You dont have permission to update this product';
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
