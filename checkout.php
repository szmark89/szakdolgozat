<?php
session_start();
include 'db_connect.php';

function getProductById($mysqli, $id) {
    $stmt = $mysqli->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

$totalPrice = 0;
$orderDetails = '';

foreach ($_SESSION['cart'] as $id => $item) {
    $product = getProductById($mysqli, $item['id']);
    if ($product) {
        $lineTotal = $product['price'] * $item['quantity'];
        $totalPrice += $lineTotal;
        $orderDetails .= "{$product['name']} - {$item['quantity']} db - " . number_format($lineTotal, 0, ',', ' ') . " Ft\n";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $subject = "Rendelés visszaigazolás";
    $message = "Kedves $name,\n\nKöszönjük rendelését. Itt vannak a rendelési adatai:\n\n" . $orderDetails . "\nVégösszeg: " . number_format($totalPrice, 0, ',', ' ') . " Ft\n\nKiszállítási cím:\n$address\nTelefon: $phone\n\nÜdvözlettel,\nWebshop csapata";
    $headers = "From: webshop@example.com";

    if (mail($email, $subject, $message, $headers)) {
        unset($_SESSION['cart']);
        echo "<p>Rendelés sikeresen leadva! Visszaigazolás elküldve emailben.</p>";
    } else {
        echo "<p>Hiba történt az e-mail küldése során. Kérjük, próbálja újra később.</p>";
    }
    exit;
}
?>

<div class="checkout-container">
    <h1 class="checkout-title">Pénztár</h1>

    <div class="checkout-content">
        <div class="order-summary-container">
            <h2>Rendelés összegzése</h2>
            <pre class="order-summary"><?php echo nl2br(htmlspecialchars($orderDetails)); ?></pre>
            <p class="total-amount"><strong>Végösszeg: <?php echo number_format($totalPrice, 0, ',', ' ') . " Ft"; ?></strong></p>
        </div>

        <form action="checkout.php" method="post" id="checkout-form" class="checkout-form">
            <h2>Kiszállítási adatok</h2>

            <label for="name">Név:</label>
            <input type="text" id="name" name="name" required>

            <label for="address">Cím:</label>
            <input type="text" id="address" name="address" required>

            <label for="phone">Telefonszám:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="email">Email cím:</label>
            <input type="email" id="email" name="email" required>
        </form>
    </div>

    <div class="terms-container">
        <input type="checkbox" id="terms" name="terms" required>
        <label for="terms">Tudomásul veszem, hogy a rendelés leadása fizetési kötelezettséggel jár.</label>
    </div>

    <button type="submit" form="checkout-form" class="submit-order-btn">Rendelés leadása</button>
</div>