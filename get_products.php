<?php
session_start();
include 'db_connect.php';

// Termékek lekérése
$sql = "SELECT * FROM products";
$result = $mysqli->query($sql);

$products = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// JSON visszaküldése
header('Content-Type: application/json');
echo json_encode($products);

$mysqli->close();
?>