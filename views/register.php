<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - Online Medicine Shop</title>
<link rel="stylesheet" href="css/customer.css">
<link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="auth-container">
    <h1>Create Account</h1>

    <p class="auth-subtitle">
        Register as a customer to start browsing and purchasing medicines.
    </p>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <form
        method="POST"
        action="index.php?page=register"
        novalidate
    >
        <label for="name">
            Full Name <span class="required">*</span>
        </label>
        <input
            type="text"
            id="name"
            name="name"
            value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
            placeholder="Enter your full name"
            required
        >
        <div class="error"></div>

        <label for="email">
            Email <span class="required">*</span>
        </label>
        <input
            type="text"
            id="email"
            name="email"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            placeholder="Enter your email"
            required
        >
        <div class="error"></div>

        <label for="address">
            Address <span class="required">*</span>
        </label>
        <input
            type="text"
            id="address"
            name="address"
            value="<?= htmlspecialchars($_POST['address'] ?? '') ?>"
            placeholder="Enter your address"
            required
        >
        <div class="error"></div>

        <label for="phone">
            Contact Number <span class="required">*</span>
        </label>
        <input
            type="text"
            id="phone"
            name="phone"
            value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
            placeholder="Enter your phone number"
            required
        >
        <div class="error"></div>

                <label for="role">
            Register As <span class="required">*</span>
        </label>
        <select
            id="role"
            name="role"
            required
        >
            <option value="customer" selected>
                Customer
            </option>
        </select>
        <div class="error"></div>

        <label for="password">
            Password <span class="required">*</span>
        </label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Minimum 8 characters"
            required
        >
        <div class="error"></div>

        <label for="confirm_password">
            Confirm Password <span class="required">*</span>
        </label>
        <input
            type="password"
            id="confirm_password"
            name="confirm_password"
            placeholder="Repeat your password"
            required
        >
        <div class="error"></div>

        <button
            type="submit"
            class="btn auth-btn-full"
        >
            Create Account
        </button>
    </form>

    <p class="auth-footer">
        Already registered?
        <a href="index.php?page=login">Sign In</a>
    </p>
</div>

<script src="js/validation.js"></script>
</body>
</html>