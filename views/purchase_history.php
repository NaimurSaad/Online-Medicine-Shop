
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Purchase History</title>
<link rel="stylesheet" href="css/admin.css">
</head>
<body>

<div class="admin-container">

    <div class="admin-header">
        <h1>Purchase History</h1>

        <div class="admin-nav">
            <a href="index.php?page=admin&section=dashboard">Dashboard</a>
            <a href="index.php?page=admin&section=categories">Categories</a>
            <a href="index.php?page=admin&section=medicines">Medicines</a>
            <a href="index.php?page=admin&section=customers">Customers</a>
            <a href="index.php?page=admin&section=orders">Purchase Requests</a>
            <a href="index.php?page=admin&section=history" class="active">Purchase History</a>
            <a href="index.php?page=profile">Profile</a>
            <a href="index.php?page=logout">Logout</a>
        </div>
    </div>

    <div class="admin-card">
        <h2>Accepted Orders</h2>

        <?php if (empty($history)): ?>
            <p>No accepted orders found.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Serial</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Shipping Address</th>
                        <th>Order Date</th>
                        <th>Medicine</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history as $index => $order): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>

                            <td>
                                <strong><?= htmlspecialchars($order['customer_name']) ?></strong><br>
                                <?= htmlspecialchars($order['email']) ?>
                            </td>

                            <td><?= htmlspecialchars($order['phone']) ?></td>
                            <td><?= htmlspecialchars($order['shipping_address']) ?></td>
                            <td><?= htmlspecialchars($order['order_date']) ?></td>
                            <td><?= htmlspecialchars($order['medicine_name']) ?></td>
                            <td><?= htmlspecialchars($order['quantity']) ?></td>
                            <td>৳ <?= number_format($order['unit_price'], 2) ?></td>
                            <td>৳ <?= number_format($order['total_amount'], 2) ?></td>
                            <td><?= ucfirst(htmlspecialchars($order['status'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</div>

</body>
</html>