<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Successful</title>
<link rel="stylesheet" href="css/customer.css?v=<?= time() ?>">
</head>
<body>

<div class="container">
    <div class="center-summary">
        <h1>Order Placed Successfully!</h1>

        <p>
            Your order has been confirmed.
        </p>

        <p>
            <strong>Order ID:</strong>
            #<?= htmlspecialchars($orderId) ?>
        </p>
<?php if (!empty($orderDetails)): ?>
    <p>
        <strong>Status:</strong>
        Pending admin approval
    </p>

    <table class="table">
        <thead>
            <tr>
                <th>Medicine</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderDetails as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['medicine_name']) ?></td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td>৳ <?= number_format($item['unit_price'], 2) ?></td>
                    <td>৳ <?= number_format($item['quantity'] * $item['unit_price'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p>
        <strong>Total:</strong>
        ৳ <?= number_format($orderDetails[0]['total_amount'], 2) ?>
    </p>
<?php endif; ?>
        <div class="center-actions">
            <a href="index.php?page=home" class="btn">
                Continue Shopping
            </a>
        </div>
    </div>
</div>

</body>
</html>