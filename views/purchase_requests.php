
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Purchase Requests</title>
<link rel="stylesheet" href="css/admin.css">
</head>
<body>

<div class="admin-container">

    <div class="admin-header">
        <h1>Purchase Requests</h1>

        <div class="admin-nav">
            <a href="index.php?page=admin&section=dashboard">Dashboard</a>
            <a href="index.php?page=admin&section=categories">Categories</a>
            <a href="index.php?page=admin&section=medicines">Medicines</a>
            <a href="index.php?page=admin&section=customers">Customers</a>
            <a href="index.php?page=admin&section=orders" class="active">Purchase Requests</a>
            <a href="index.php?page=admin&section=history">Purchase History</a>
            <a href="index.php?page=profile">Profile</a>
            <a href="index.php?page=logout">Logout</a>
        </div>
    </div>

    <div class="admin-card">
        <h2>All Purchase Requests</h2>

        <?php if (empty($orders)): ?>
            <p>No purchase requests found.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Serial</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Shipping Address</th>
                        <th>Total Amount</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $index => $order): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <strong><?= htmlspecialchars($order['customer_name']) ?></strong><br>
                                <?= htmlspecialchars($order['email']) ?>
                            </td>
                            <td><?= htmlspecialchars($order['phone']) ?></td>
                            <td><?= htmlspecialchars($order['shipping_address']) ?></td>
                            <td>৳ <?= number_format($order['total_amount'], 2) ?></td>
                            <td><?= htmlspecialchars($order['order_date']) ?></td>
                            <td id="status-<?= $order['id'] ?>">
                                <?= ucfirst(htmlspecialchars($order['status'])) ?>
                            </td>
                            <td>
                                <?php if ($order['status'] === 'pending'): ?>
                                    <button type="button"
                                            class="btn-sm btn-primary"
                                            onclick="updateOrderStatus(<?= $order['id'] ?>, 'accepted')">
                                        Accept
                                    </button>

                                    <button type="button"
                                            class="btn-sm btn-delete"
                                            onclick="updateOrderStatus(<?= $order['id'] ?>, 'rejected')">
                                        Reject
                                    </button>
                                <?php else: ?>
                                    <span>No Action</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</div>

<script src="js/order_status.js"></script>
</body>
</html>