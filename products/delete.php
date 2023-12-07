<?php
include_once("./jwt_auth.php");

if ($_POST['action'] == 'delete') {
    if ($decoded->id_user_type != 1) {
        // Return 401 Unauthorized if the user is not a Seller
        http_response_code(401);
        echo json_encode(array("message" => "Unauthorized Access"));
        exit;
    }
    $product_id = $_POST['$id_product'];
    // Delete product from the database if and only if the user is the owner of the product
    $query = $con->prepare('DELETE FROM `products` WHERE `id_product` = ? AND `id_user` = ?');
    $query->bind_param('ii', $id_product, $id_user);
    $query->execute();

    if ($query->error) {
        $response['status'] = false;
        $response['message'] = 'Error updating user: ' . $query->error;
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        if ($query->affected_rows > 0) {
            $response['status'] = true;
            $response['message'] = 'Product deleted successfully';
        } else {
            $response['status'] = false;
            $response['message'] = 'You dont have permission to delete this product';
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
