<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home - Online Medicine Shop</title>
<link rel="stylesheet" href="css/customer.css">
<link rel="stylesheet" href="css/home.css">
</head>
<body>

<div class="navbar">
    <div class="container navbar-inner">
        <h2>Online Medicine Shop</h2>

        <div class="nav-links">
            <a href="index.php?page=home" class="active">Home</a>
            <a href="index.php?page=profile">Profile</a>
            <a href="index.php?page=cart">Cart</a>
            <a href="index.php?page=logout">Logout</a>
        </div>
    </div>
</div>

<div class="container">

    <div class="page-header">
        <h1>
            Welcome,
            <?= htmlspecialchars($_SESSION['user']['name'] ?? $_SESSION['user']['email'] ?? 'User') ?>
        </h1>
        <p>Browse medicines and add them to your cart.</p>
    </div>

    <div class="filter-card">
        <input
            type="text"
            id="searchInput"
            class="search-box"
            placeholder="Search medicines..."
        >

        <div class="filter-row">
            <select id="vendorFilter">
                <option value="">All Vendors</option>

                <?php
                $vendors = [];
                foreach ($medicines as $medicine) {
                    if (!empty($medicine['vendor_name']) &&
                        !in_array($medicine['vendor_name'], $vendors)) {
                        $vendors[] = $medicine['vendor_name'];
                    }
                }
                sort($vendors);
                ?>

                <?php foreach ($vendors as $vendor): ?>
                    <option value="<?= htmlspecialchars($vendor) ?>">
                        <?= htmlspecialchars($vendor) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select id="formFilter">
                <option value="">All Forms</option>
                <option value="solid">Solid</option>
                <option value="liquid">Liquid</option>
            </select>
        </div>

        <div class="categories">
            <button class="category-btn active" data-category="">All</button>

            <?php
            $categories = [];
            foreach ($medicines as $medicine) {
                if (!empty($medicine['category_name']) &&
                    !in_array($medicine['category_name'], $categories)) {
                    $categories[] = $medicine['category_name'];
                }
            }
            sort($categories);
            ?>

            <?php foreach ($categories as $category): ?>
                <button
                    type="button"
                    class="category-btn"
                    data-category="<?= htmlspecialchars($category) ?>">
                    <?= htmlspecialchars($category) ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>

    <h2 class="section-title">Available Medicines</h2>

    <div id="medicineContainer" class="medicine-grid">
        <?php if (empty($medicines)): ?>
            <p>No medicines found.</p>
        <?php endif; ?>

        <?php foreach ($medicines as $medicine): ?>
            <div class="medicine-card">
                <?php if (!empty($medicine['image_path'])): ?>
                    <img
                        src="uploads/medicines/<?= htmlspecialchars($medicine['image_path']) ?>"
                        alt="<?= htmlspecialchars($medicine['name']) ?>"
                        class="medicine-image"
                    >
                <?php else: ?>
                    <div class="medicine-image medicine-image-placeholder">
                        No Image
                    </div>
                <?php endif; ?>

                <div class="medicine-content">
                    <h3><?= htmlspecialchars($medicine['name']) ?></h3>

                    <p class="medicine-meta">
                        <strong>Vendor:</strong>
                        <?= htmlspecialchars($medicine['vendor_name']) ?>
                    </p>

                    <p class="medicine-meta">
                        <strong>Category:</strong>
                        <?= htmlspecialchars($medicine['category_name']) ?> 
                    </p>

                    <p class="medicine-meta">
                        <strong>Type:</strong>
                        <?= htmlspecialchars(ucfirst($medicine['category_type'])) ?>
                    </p>

                    <p class="medicine-price">
                        ৳ <?= number_format($medicine['price'], 2) ?>
                    </p>

                    <p class="medicine-stock">
                        <?php if ($medicine['availability'] > 0): ?>
                            In Stock (<?= $medicine['availability'] ?>)
                        <?php else: ?>
                            Out of Stock
                        <?php endif; ?>
                    </p>

                    <details class="medicine-details">
                        <summary>View Description</summary>
                        <p>
                            <?= htmlspecialchars($medicine['description'] ?: 'No description available.') ?>
                        </p>
                    </details>
                </div>

                <button
                    type="button"
                    class="btn add-to-cart"
                    data-medicine-id="<?= $medicine['id'] ?>"
                    <?= $medicine['availability'] <= 0 ? 'disabled' : '' ?>>
                    Add to Cart
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="js/search.js"></script>
<script src="js/cart.js"></script>
</body>
</html>

