<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    echo json_encode(['error' => 'Hozzáférés megtagadva. Kérjük, jelentkezzen be!']);
    exit;
}

// AJAX kérések kezelése
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response = ['success' => false];

    // Új termék hozzáadása
    if ($_POST['action'] === 'add') {
        $name = $_POST['name'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $image = $_FILES['image'];

        $imagePath = 'img/products/' . basename($image['name']);
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            $stmt = $mysqli->prepare("INSERT INTO products (name, category, price, description, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdss", $name, $category, $price, $description, $image['name']);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response['success'] = true;
            } else {
                $response['error'] = 'Nem sikerült hozzáadni a terméket.';
            }
        } else {
            $response['error'] = 'Kép feltöltése sikertelen.';
        }
    }

    // Inline szerkesztés
    elseif ($_POST['action'] === 'update-inline') {
        $id = $_POST['id'];
        $field = $_POST['field'];
        $value = $_POST['value'];

        $validFields = ['name', 'category', 'price', 'description'];
        if (in_array($field, $validFields)) {
            $stmt = $mysqli->prepare("UPDATE products SET $field = ? WHERE id = ?");
            $stmt->bind_param("si", $value, $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response['success'] = true;
            } else {
                $response['error'] = 'Nem sikerült frissíteni a terméket.';
            }
        } else {
            $response['error'] = 'Érvénytelen mező: ' . $field;
        }
    }

    // Kép cseréje
    elseif ($_POST['action'] === 'update-image') {
        $id = $_POST['id'];
        $image = $_FILES['image'];

        $stmt = $mysqli->prepare("SELECT image FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product) {
            $oldImagePath = 'img/products/' . $product['image'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Régi kép törlése
            }

            $newImagePath = 'img/products/' . basename($image['name']);
            if (move_uploaded_file($image['tmp_name'], $newImagePath)) {
                $stmt = $mysqli->prepare("UPDATE products SET image = ? WHERE id = ?");
                $stmt->bind_param("si", $image['name'], $id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                } else {
                    $response['error'] = 'Nem sikerült frissíteni a képet az adatbázisban.';
                }
            } else {
                $response['error'] = 'Nem sikerült feltölteni az új képet.';
            }
        } else {
            $response['error'] = 'A termék nem található.';
        }
    }

    // Termék törlése
    elseif ($_POST['action'] === 'delete') {
        $id = $_POST['id'];

        $stmt = $mysqli->prepare("SELECT image FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product && file_exists('img/products/' . $product['image'])) {
            unlink('img/products/' . $product['image']); // Kép törlése
        }

        $stmt = $mysqli->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $response['success'] = true;
    }

    // Válasz visszaküldése AJAX-nak
    echo json_encode($response);
    exit;
}

// Termékek lekérése az adatbázisból
$result = $mysqli->query("SELECT * FROM products");
$products = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_panel.css">
    <title>Admin Panel</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Vezérlőpult</h1>
        <br>
        <div class="products-management">
            <h2>Termékek kezelése</h2>
            <table class="table" id="productsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Név</th>
                        <th>Kategória</th>
                        <th>Ár</th>
                        <th>Kép</th>
                        <th>Leírás</th>
                        <th>Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td contenteditable="true" data-id="<?php echo $product['id']; ?>" data-field="name"><?php echo htmlspecialchars($product['name']); ?></td>
                        <td contenteditable="true" data-id="<?php echo $product['id']; ?>" data-field="category"><?php echo htmlspecialchars($product['category']); ?></td>
                        <td contenteditable="true" data-id="<?php echo $product['id']; ?>" data-field="price"><?php echo htmlspecialchars($product['price']); ?> Ft</td>
                        <td>
                            <img src="img/products/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image clickable-image" data-id="<?php echo $product['id']; ?>" />
                        </td>
                        <td contenteditable="true" data-id="<?php echo $product['id']; ?>" data-field="description"><?php echo htmlspecialchars($product['description']); ?></td>
                        <td>
                            <button class="btn btn-danger delete-product" data-id="<?php echo $product['id']; ?>">Törlés</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="add-product">
            <h2>Új termék hozzáadása</h2>
            <form id="addProductForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Név:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="category">Kategória:</label>
                    <input type="text" id="category" name="category" required>
                </div>
                <div class="form-group">
                    <label for="price">Ár:</label>
                    <input type="number" id="price" step="0.01" name="price" required>
                </div>
                <div class="form-group">
                    <label for="image">Kép:</label>
                    <input type="file" id="image" name="image" required>
                </div>
                <div class="form-group">
                    <label for="description">Leírás:</label>
                    <textarea id="description" name="description" rows="4"></textarea>
                </div>
                <button type="submit">Hozzáadás</button>
            </form>
        </div>



    </div>
    <script src="admin_panel.js"></script>
</body>

</html>
