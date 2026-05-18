
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="css/admin.css">
</head>
<body>

<div class="admin-container">

    <div class="admin-header">
        <h1>Admin Dashboard</h1>

        <div class="admin-nav">
            <a href="index.php?page=admin&section=dashboard" class="active">Dashboard</a>
            <a href="index.php?page=admin&section=categories">Categories</a>
            <a href="index.php?page=admin&section=medicines">Medicines</a>
            <a href="index.php?page=admin&section=customers">Customers</a>
            <a href="index.php?page=admin&section=orders">Purchase Requests</a>
            <a href="index.php?page=admin&section=history">Purchase History</a>
            <a href="index.php?page=profile">Profile</a>
            <a href="index.php?page=logout">Logout</a>
        </div>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success">
            Operation completed successfully.
        </div>
    <?php endif; ?>

    <div class="dashboard-grid">

        <div class="stat-card">
            <h3>Total Medicines</h3>
            <div class="number">
                <?= $counts['total_medicines'] ?>
            </div>
        </div>

        <div class="stat-card">
            <h3>Total Categories</h3>
            <div class="number">
                <?= $counts['total_categories'] ?>
            </div>
        </div>

        <div class="stat-card">
            <h3>Total Customers</h3>
            <div class="number">
                <?= $counts['total_customers'] ?>
            </div>
        </div>

        <div class="stat-card">
            <h3>Pending Orders</h3>
            <div class="number">
                <?= $counts['pending_orders'] ?>
            </div>
        </div>

    </div>



</div>

</body>
</html>