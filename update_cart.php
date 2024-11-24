<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

function getProductById($mysqli, $id) {
    $stmt = $mysqli->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Inicializáljuk az üres kosarat, ha még nincs
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['productId']) && isset($_POST['quantity'])) {
    $productId = (int)$_POST['productId'];
    $quantity = (int)$_POST['quantity'];

    $found = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $productId) {
            if ($quantity > 0) {
                $_SESSION['cart'][$key]['quantity'] = $quantity; // Mennyiség frissítése
                $response['message'] = 'Mennyiség frissítve.';
            } else {
                unset($_SESSION['cart'][$key]); // Termék eltávolítása
                $_SESSION['cart'] = array_values($_SESSION['cart']); // Újraindexelés
                $response['message'] = 'Termék eltávolítva.';
            }
            $found = true;
            break;
        }
    }

    if (!$found && $quantity > 0) {
        $_SESSION['cart'][] = [
            'id' => $productId,
            'quantity' => $quantity
        ];
        $response['message'] = 'Termék hozzáadva.';
    }

    $itemTotal = 0;
    $totalPrice = 0;

    // Kosár frissítése árakkal
    foreach ($_SESSION['cart'] as $item) {
        $product = getProductById($mysqli, $item['id']);
        if ($product) {
            $itemTotal = $product['price'] * $item['quantity'];
            $totalPrice += $itemTotal;

            if ($item['id'] == $productId) {
                $response['itemTotal'] = number_format($itemTotal, 0, ',', ' ');
            }
        }
    }

    $response['success'] = true;
    $response['totalPrice'] = number_format($totalPrice, 0, ',', ' ');
} else {
    $response['message'] = 'Hiányzik az ID vagy a mennyiség!';
}

echo json_encode($response);
