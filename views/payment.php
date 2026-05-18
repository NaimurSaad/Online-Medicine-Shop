<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Method</title>
<link rel="stylesheet" href="css/customer.css">
<link rel="stylesheet" href="css/home.css">
<link rel="stylesheet" href="css/profile.css">
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
        <h1>Payment Method</h1>

        <p class="profile-subtitle">
            Select your preferred payment option.
        </p>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post">

            <label class="auth-checkbox">
                <input
                    type="radio"
                    name="payment_method"
                    value="cash_on_delivery"
                    required
                >
                <span>Cash on Delivery</span>
            </label>

            <label class="auth-checkbox">
                <input
                    type="radio"
                    name="payment_method"
                    value="bkash"
                >
                <span>bKash</span>
            </label>

            <label class="auth-checkbox">
                <input
                    type="radio"
                    name="payment_method"
                    value="nagad"
                >
                <span>Nagad</span>
            </label>

            <label class="auth-checkbox">
                <input
                    type="radio"
                    name="payment_method"
                    value="credit_card"
                >
                <span>Credit Card</span>
            </label>

            <label class="auth-checkbox">
                <input
                    type="radio"
                    name="payment_method"
                    value="bank_transfer"
                >
                <span>Bank Transfer</span>
            </label>

            <h3 style="margin-top: 25px;">
                Total Amount:
                ৳ <?= number_format($cartTotal, 2) ?>
            </h3>

            <p style="margin-top: 20px;">
                <a
                    href="index.php?page=checkout&step=invoice"
                    class="btn btn-secondary"
                >
                    Back
                </a>

                <button type="submit" class="btn">
                    Confirm Order
                </button>
            </p>
        </form>
    </div>
</div>

</body>
</html>