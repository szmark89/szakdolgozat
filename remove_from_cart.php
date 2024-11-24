<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (isset($_POST['productId'])) {
    $productId = (int)$_POST['productId'];
    unset($_SESSION['cart'][$productId]);

    $totalPrice = 0;
    foreach ($_SESSION['cart'] as $id => $item) {
        $product = getProductById($mysqli, $id);
        if ($product) {
            $totalPrice += $product['price'] * $item['quantity'];
        }
    }

    $response['success'] = true;
    $response['totalPrice'] = number_format($totalPrice, 0, ',', ' ');
} else {
    $response['message'] = 'Product ID missing!';
}

echo json_encode($response);
?>
