$(document).ready(function() {
    function updateCart(itemId, quantity) {
        $.ajax({
            url: 'update_cart.php',
            method: 'POST',
            data: { productId: itemId, quantity: quantity },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('tr[data-id="' + itemId + '"] .total-price').text(response.itemTotal + " Ft");
                    $('#totalPrice').text(response.totalPrice + " Ft");
                    if (quantity === 0) {
                        $('tr[data-id="' + itemId + '"]').remove();
                    }
                    $('#content').load("cart.php");
                    loadCart();
                    updateCartDisplay();
                } else {
                    console.error('Hiba:', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                alert('Hiba történt az AJAX hívás során.');
            }
        });
    }

    $('.increment').on('click', function() {
        var itemId = $(this).data('id');
        var quantityInput = $('.quantity-input[data-id="' + itemId + '"]');
        var quantity = parseInt(quantityInput.val()) + 1;
        quantityInput.val(quantity);
        updateCart(itemId, quantity);
    });

    $('.decrement').on('click', function() {
        var itemId = $(this).data('id');
        var quantityInput = $('.quantity-input[data-id="' + itemId + '"]');
        var quantity = Math.max(0, parseInt(quantityInput.val()) - 1);
        quantityInput.val(quantity);
        updateCart(itemId, quantity);
    });

    $('.remove-btn').on('click', function() {
        var itemId = $(this).data('id');
        updateCart(itemId, 0);
    });
});