document.addEventListener('DOMContentLoaded', function () {

    
    document.addEventListener('click', function (e) {
        var button = e.target.closest('.add-to-cart');

        if (!button) {
            return;
        }

        if (button.disabled) {
            return;
        }

        e.preventDefault();

        var medicineId = button.getAttribute('data-medicine-id');

        fetch('index.php?page=ajax&type=cart_add', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body:
                'medicine_id=' +
                encodeURIComponent(medicineId) +
                '&quantity=1'
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (data.success) {
                alert('Added to cart successfully!');
            } else {
                alert(data.message || 'Failed to add to cart.');
            }
        })
        .catch(function (error) {
            console.error(error);
        });
    });

    // Update quantity
    var quantityInputs =
        document.querySelectorAll('.cart-quantity');

    quantityInputs.forEach(function (input) {
        input.addEventListener('change', function () {
            var cartId = this.getAttribute('data-cart-id');
            var quantity = this.value;

            if (quantity < 1) {
                quantity = 1;
                this.value = 1;
            }

            fetch('index.php?page=ajax&type=cart_update', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type':
                        'application/x-www-form-urlencoded'
                },
                body:
                    'cart_id=' +
                    encodeURIComponent(cartId) +
                    '&quantity=' +
                    encodeURIComponent(quantity)
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to update cart.');
                }
            })
            .catch(function (error) {
                console.error(error);
            });
        });
    });

    // Remove items
    var removeButtons =
        document.querySelectorAll('.remove-cart-item');

    removeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            if (!confirm('Remove this item from cart?')) {
                return;
            }

            var cartId =
                this.getAttribute('data-cart-id');

            fetch('index.php?page=ajax&type=cart_remove', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type':
                        'application/x-www-form-urlencoded'
                },
                body:
                    'cart_id=' +
                    encodeURIComponent(cartId)
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to remove item.');
                }
            })
            .catch(function (error) {
                console.error(error);
            });
        });
    });

});