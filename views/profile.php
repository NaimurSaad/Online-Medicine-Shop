<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile - Online Medicine Shop</title>
<link rel="stylesheet" href="css/customer.css">
<link rel="stylesheet" href="css/home.css">
<link rel="stylesheet" href="css/profile.css">
</head>
<body>


<div class="navbar">
    <div class="container navbar-inner">
        <h2>Online Medicine Shop</h2>

        <div class="nav-links">
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <a href="index.php?page=admin">Dashboard</a>
            <?php else: ?>
                <a href="index.php?page=home">Home</a>
                <a href="index.php?page=profile" class="active">Profile</a>
                <a href="index.php?page=cart">Cart</a>
            <?php endif; ?>


            <a href="index.php?page=logout">Logout</a>
        </div>
    </div>
</div>

<div class="container">
    <div class="profile-container">
        <h1>My Profile</h1>
        <p class="profile-subtitle">
            Update your personal information and password.
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
            action="index.php?page=profile"
            enctype="multipart/form-data"
        >

            <?php if (!empty($user['profile_picture'])): ?>
                <div class="profile-picture-preview">
                    <img
                        src="uploads/profiles/<?= htmlspecialchars($user['profile_picture']) ?>"
                        alt="Profile Picture"
                    >
                </div>
            <?php endif; ?>

            <h2 class="profile-section-title">Profile Information</h2>

            <label for="name">Full Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="<?= htmlspecialchars($user['name']) ?>"
                required
            >

            <label for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?= htmlspecialchars($user['email']) ?>"
                required
            >

            <label for="address">Address</label>
            <input
                type="text"
                id="address"
                name="address"
                value="<?= htmlspecialchars($user['address']) ?>"
                required
            >

            <label for="phone">Phone Number</label>
            <input
                type="text"
                id="phone"
                name="phone"
                value="<?= htmlspecialchars($user['phone']) ?>"
                required
            >

            <label for="profile_picture">Profile Picture</label>
            <input
                type="file"
                id="profile_picture"
                name="profile_picture"
                accept="image/*"
            >

            <h2 class="profile-section-title">
                Change Password (Optional)
            </h2>

            <label for="current_password">Current Password</label>
            <input
                type="password"
                id="current_password"
                name="current_password"
            >

            <label for="new_password">New Password</label>
            <input
                type="password"
                id="new_password"
                name="new_password"
            >

            <label for="confirm_password">Confirm New Password</label>
            <input
                type="password"
                id="confirm_password"
                name="confirm_password"
            >

            <button type="submit" class="btn profile-btn">
                Update Profile
            </button>
        </form>
    </div>
</div>

<script src="js/validation.js"></script>
</body>
</html>