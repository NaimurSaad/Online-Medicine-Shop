<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Online Medicine Shop</title>
<link rel="stylesheet" href="css/customer.css">
<link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="auth-container">
    <h1>Login</h1>

    <p class="auth-subtitle">Sign in to access your account.</p>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=login">
        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            value="<?= htmlspecialchars($prefill ?? '') ?>"
            placeholder="Enter your email"
            required
            autofocus
        >

        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Enter your password"
            required
        >

        <label class="auth-checkbox">
            <input
                type="checkbox"
                name="remember"
                <?= !empty($prefill) ? 'checked' : '' ?>
            >
            <span>Remember me</span>
        </label>

        <button type="submit" class="btn auth-btn-full">
            Sign In
        </button>
    </form>

    <p class="auth-footer">
        Don't have an account?
        <a href="index.php?page=register">Register as Customer</a>
    </p>

    <p class="auth-hint">
        <strong>Default Admin:</strong><br>
        admin@medishop.com / admin123
    </p>
</div>

</body>
</html>
