<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M. Tailor's Weddings</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="shop.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="cart.css">
    <link rel="stylesheet" href="checkout.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div id="navbar">
        <?php include 'navbar.php'; ?>
    </div>

    <main>
        <div id="content">
            <?php include 'home.php'; ?>
        </div>

        <div id="modalContainer" class="modal"></div>

        <div id="errorToast" class="toast"></div>

        <div id="successToast" class="toast"></div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
    <script src="login.js"></script>
</body>

</html>