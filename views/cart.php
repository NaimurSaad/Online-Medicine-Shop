<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shopping Cart</title>
<link rel="stylesheet" href="css/customer.css">
<link rel="stylesheet" href="css/home.css">
</head>
<body>

<!-- Navigation -->
<div class="navbar">
    <div class="container navbar-inner">
        <h2>Online Medicine Shop</h2>

        <div class="nav-links">
            <a href="index.php?page=home">Home</a>
            <a href="index.php?page=profile">Profile</a>
            <a href="index.php?page=cart" class="active">Cart</a>
            <a href="index.php?page=logout">Logout</a>
        </div>
    </div>
</div>

<div class="container">
    <h1>Shopping Cart</h1>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>
        <p>Your cart is empty.</p>

        <p>
            <a href="index.php?page=home" class="btn">
                Continue Shopping
            </a>
        </p>
    <?php else: ?>

        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Medicine</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td>
                            <?php if (!empty($item['image_path'])): ?>
                                <img
                                    src="uploads/medicines/<?= htmlspecialchars($item['image_path']) ?>"
                                    alt="<?= htmlspecialchars($item['name']) ?>"
                                    width="60"
                                >
                            <?php endif; ?>
                        </td>

                        <td><?= htmlspecialchars($item['name']) ?></td>

                        <td>
                            ৳ <?= number_format($item['price'], 2) ?>
                        </td>

                        <td>
                            <input
                                type="number"
                                min="1"
                                value="<?= $item['quantity'] ?>"
                                class="cart-quantity"
                                data-cart-id="<?= $item['id'] ?>"
                            >
                        </td>

                        <td>
                            ৳ <?= number_format($item['subtotal'], 2) ?>
                        </td>

                        <td>
                            <button
                                type="button"
                                class="btn btn-danger remove-cart-item"
                                data-cart-id="<?= $item['id'] ?>"
                            >
                                Remove
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>
            Total Amount:
            ৳ <?= number_format($cartTotal, 2) ?>
        </h3>

        <?php if (empty($error)): ?>
            <p>
                <a href="index.php?page=checkout" class="btn">
                    Proceed to Checkout
                </a>
            </p>
        <?php else: ?>
            <p>
                <button type="button" class="btn" disabled>
                    Proceed to Checkout
                </button>
            </p>
        <?php endif; ?>

        <p>
            <a href="index.php?page=home" class="btn btn-secondary">
                Continue Shopping
            </a>
        </p>

    <?php endif; ?>
</div>

<script src="js/cart.js"></script>
</body>
</html>