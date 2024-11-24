<?php
$host = 'localhost';
$dbname = 'wedding_website'; //wedding_webshop
$username = 'root'; //wedding_webshop
$password = ''; //MackoLacko69.

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Kapcsolódási hiba: " . $mysqli->connect_error);
}

?>