<?php
session_start();

include 'db_connect.php';

// Kijelentkezés kezelése
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    echo "Sikeres kijelentkezés.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = mysqli_real_escape_string($mysqli, $_POST['username']);
    $inputPassword = mysqli_real_escape_string($mysqli, $_POST['password']);

    $sql = "SELECT * FROM users WHERE username = '$inputUsername'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($inputPassword, $row['password'])) {
            $_SESSION['username'] = $inputUsername;
            echo "Sikeres bejelentkezés!";
        } else {
            echo "Hibás jelszó.";
        }
    } else {
        echo "Nem található ilyen felhasználó.";
    }
}

$mysqli->close();
?>
