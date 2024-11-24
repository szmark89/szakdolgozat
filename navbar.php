<!-- Navigációs sáv -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#" data-page="home">
        <img src="img/logo.png" alt="M. Tailor's Weddings Logo" class="logo">
        M. Tailor's Weddings
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="#" data-page="home">Kezdőlap</a></li>
            <li class="nav-item"><a class="nav-link" href="#" data-page="shop">Webshop</a></li>
            <li class="nav-item"><a class="nav-link" data-page="home" href="#services">Szolgáltatások</a></li>
            <li class="nav-item"><a class="nav-link" data-page="home" href="#contact">Kapcsolat</a></li>
            <li class="nav-item">
                <button id="cartBtn" class="nav-link cart-button" data-page="cart">
                    <i class="fas fa-shopping-cart"></i> Kosár (<span id="cartCount"> 0</span>)
                </button>
            </li>
            <?php session_start(); ?>
            <?php if (isset($_SESSION['username'])): ?>
                <li class="nav-item">
                    <button id="adminBtn" class="nav-link btn btn-login" data-page="admin_panel">
                        <i class="fas fa-user-shield"></i> Vezérlőpult
                    </button>
                </li>
                <li class="nav-item">
                    <button id="logoutBtn" class="nav-link btn btn-login">Kijelentkezés</button>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <button id="loginBtn" class="nav-link btn btn-login">Bejelentkezés</button>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<script src="login.js"></script>
