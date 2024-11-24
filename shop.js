function loadProducts() {
    $.ajax({
        url: 'get_products.php',
        method: 'GET',
        dataType: 'json',
        success: function(products) {
            $('#productGrid').empty();
            products.forEach(function(product) {
                const productCard = `
                    <div class="col-md-4 mb-4 product" data-category="${product.category}" data-id="${product.id}">
                        <div class="card">
                            <img src="img/products/${product.image}" class="card-img-top" alt="${product.name}">
                            <div class="card-body text-center">
                                <h5 class="card-title">${product.name}</h5>
                                <p class="card-text">Ár: ${product.price} Ft</p>
                                <p class="card-description">${product.description}</p>
                                <button class="btn btn-add-to-cart" data-id="${product.id}">Kosárba</button>
                            </div>
                        </div>
                    </div>`;
                $('#productGrid').append(productCard);
            });

            $('.product').show();
            setCategoryFilter();
        },
        error: function(xhr, status, error) {
            console.error("Hiba a termékek betöltésekor:", error);
        }
    });
}


function addToCart(productId) {
    $.ajax({
        url: 'add_to_cart.php',
        method: 'POST',
        data: { productId: productId },
        dataType: 'json',
        success: function(cartData) {
            cart = cartData;
            updateCartDisplay();
            showSuccessToast("Termék hozzáadva a kosárhoz!");
        },
        error: function(xhr, status, error) {
            console.error("Hiba a kosárhoz adáskor:", error);
        }
    });
}

$(document).off('click', '.btn-add-to-cart').on('click', '.btn-add-to-cart', function() {
    const productId = $(this).data('id');
    addToCart(productId);
});

$('#searchInput').on('input', function() {
    const searchTerm = $(this).val().toLowerCase();
    $('.product').each(function() {
        const productName = $(this).find('.card-title').text().toLowerCase();
        if (productName.includes(searchTerm)) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
});

function setCategoryFilter() {
    $('.filter-bar .btn').off('click').on('click', function() {
        const selectedCategory = $(this).find('input').attr('id');
        
        $('.filter-bar .btn').removeClass('active');
        $(this).addClass('active');

        if (selectedCategory === 'all') {
            $('.product').show();
        } else {
            $('.product').each(function() {
                const productCategory = $(this).data('category');
                if (productCategory === selectedCategory) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    });
}

$(document).ready(function() {
    loadProducts();
    loadCart();
});
