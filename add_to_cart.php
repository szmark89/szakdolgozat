<?php
session_start();

if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productId) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $productId,
            'quantity' => 1
        ];
    }

    echo json_encode($_SESSION['cart']);
} else {
    echo json_encode(['error' => 'No product ID provided']);
}
?>
