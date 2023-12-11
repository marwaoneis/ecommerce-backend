<?php
include_once("./jwt_auth.php");

if ($_POST['action'] == 'delete') {
    if ($decoded->id_user_type != 1) {
        http_response_code(401);
        echo json_encode(array("message" => "Unauthorized Access"));
        exit;
    }
    $product_id = $_POST['$id_product'];
    $query = $mysqli->prepare('DELETE FROM `products` WHERE `id_product` = ?');
    $query->bind_param('i', $id_product);
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
