<?php
session_start();
echo json_encode(isset($_SESSION['cart']) ? $_SESSION['cart'] : []);
?>
