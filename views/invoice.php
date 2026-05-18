<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice Preview</title>
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
            <a href="index.php?page=cart">Cart</a>
            <a href="index.php?page=checkout" class="active">Checkout</a>
            <a href="index.php?page=logout">Logout</a>
        </div>
    </div>
</div>

<div class="container">
    <div class="profile-container">
        <h1>Invoice Preview</h1>

        <p class="profile-subtitle">
            Review your shipping address and order details.
        </p>

        <h2 class="profile-section-title">Shipping Address</h2>
        <p>
            <?= nl2br(htmlspecialchars($_SESSION['checkout']['shipping_address'])) ?>
        </p>

        <h2 class="profile-section-title">Order Items</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>৳ <?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>৳ <?= number_format($item['subtotal'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>
            Total Amount:
            ৳ <?= number_format($cartTotal, 2) ?>
        </h3>

        <p style="margin-top: 20px;">
            <a
                href="index.php?page=checkout&step=shipping"
                class="btn btn-secondary"
            >
                Back
            </a>

            <a
                href="index.php?page=checkout&step=payment"
                class="btn"
            >
                Continue to Payment
            </a>
        </p>
    </div>
</div>

</body>
</html>