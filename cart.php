<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<div class='cart-empty-message'>";
    echo "<h2>A kosár üres</h2>";
    echo "<p>Adjon hozzá termékeket a kosárhoz!</p>";
    echo "<a href='shop.php' data-page='shop' class='shop-link'>Vásárlás folytatása</a>";
    echo "</div>";
    exit;
}

function getProductById($mysqli, $id) {
    $stmt = $mysqli->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

$totalPrice = 0;
$cartItems = [];

foreach ($_SESSION['cart'] as $id => $item) {
    $product = getProductById($mysqli, $item['id']);
    if ($product) {
        $product['quantity'] = $item['quantity'];
        $product['total'] = $product['price'] * $item['quantity'];
        $totalPrice += $product['total'];
        $cartItems[] = $product;
    }
}

$mysqli->close();
?>

<div id="cart">
    <h1 class="cart-title">Kosár</h1>

    <?php if (!empty($cartItems)): ?>
    <table class="cart-table">
        <tr>
            <th>Termék</th>
            <th>Ár</th>
            <th>Mennyiség</th>
            <th>Összesen</th>
            <th>Műveletek</th>
        </tr>
        <?php foreach ($cartItems as $item): ?>
        <tr data-id="<?php echo $item['id']; ?>">
            <td><?php echo htmlspecialchars($item['name']); ?></td>
            <td><?php echo number_format($item['price'], 0, ',', ' ') . " Ft"; ?></td>
            <td>
                <button class="quantity-btn decrement" data-id="<?php echo $item['id']; ?>">-</button>
                <input type="text" class="quantity-input" data-id="<?php echo $item['id']; ?>" value="<?php echo $item['quantity']; ?>" min="0" readonly>
                <button class="quantity-btn increment" data-id="<?php echo $item['id']; ?>">+</button>
            </td>
            <td class="total-price"><?php echo number_format($item['total'], 0, ',', ' ') . " Ft"; ?></td>
            <td>
                <button class="remove-btn" data-id="<?php echo $item['id']; ?>">Eltávolítás</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2 class="total-amount">Végösszeg: <span id="totalPrice"><?php echo number_format($totalPrice, 0, ',', ' ') . " Ft"; ?></span></h2>

    <a href="checkout.php" data-page="checkout"><button class="checkout-btn">Pénztárhoz</button></a>
    <?php else: ?>
    <p>A kosár üres. Adjon hozzá termékeket a kosárhoz!</p>
    <?php endif; ?>

</div>
<script src="cart.js"></script>
