var cart = [];

function updateCartDisplay() {
    const totalItems = cart.reduce((total, item) => total + (item.quantity || 0), 0);
    $('#cartCount').text(totalItems);
}

function loadCart() {
    $.ajax({
        url: 'get_cart.php',
        method: 'GET',
        dataType: 'json',
        success: function (cartData) {
            cart = cartData;
            console.log(cart);
            updateCartDisplay();
        },
        error: function (xhr, status, error) {
            console.error("Hiba a kosár betöltésekor:", error);
        }
    });
}

$(document).ready(function () {
    // Az oldal betöltésekor alapértelmezésben a home.php betöltése
    $('#content').load('home.php');

    // Linkek és gombok kezelése az összes data-page attribútum esetén
    $('body').on('click', '[data-page]', function (e) {
        e.preventDefault(); // Alapértelmezett viselkedés megakadályozása

        // Lekérjük az oldalt a data-page attribútumból
        const page = $(this).data('page') + '.php'; // Példa: 'shop.php'

        // Ellenőrizzük, hogy valóban egy oldal betöltéséről van-e szó
        if (!$(this).hasClass('ajax-ignore')) {
            // Tartalom betöltése AJAX-szal az #content div-be
            $('#content').load(page, function (response, status) {
                if (status === "error") {
                    $('#content').html("<p>Hiba történt a tartalom betöltésekor. Próbáld újra!</p>");
                }
            });
        }
    });



    // Smooth scroll minden horgonyhoz
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    loadCart();
});
