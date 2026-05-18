
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customers</title>
<link rel="stylesheet" href="css/admin.css">
</head>
<body>

<div class="admin-container">


    <div class="admin-header">
        <h1>Customer Management</h1>

        <div class="admin-nav">
            <a href="index.php?page=admin&section=dashboard">Dashboard</a>
            <a href="index.php?page=admin&section=categories">Categories</a>
            <a href="index.php?page=admin&section=medicines">Medicines</a>
            <a href="index.php?page=admin&section=customers" class="active">Customers</a>
            <a href="index.php?page=admin&section=orders">Purchase Requests</a>
            <a href="index.php?page=admin&section=history">Purchase History</a>
            <a href="index.php?page=profile">Profile</a>
            <a href="index.php?page=logout">Logout</a>
        </div>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success">
            Customer deleted successfully.
        </div>
    <?php endif; ?>

    <div class="admin-card">
        <h2>All Customers</h2>

        <?php if (empty($customers)): ?>
            <p>No customers found.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Serial</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Joined At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $index => $customer): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($customer['name']) ?></td>
                            <td><?= htmlspecialchars($customer['email']) ?></td>
                            <td><?= htmlspecialchars($customer['phone']) ?></td>
                            <td><?= htmlspecialchars($customer['address']) ?></td>
                            <td><?= htmlspecialchars($customer['created_at']) ?></td>
                            <td>
                                <a href="index.php?page=admin&section=customers&action=delete&id=<?= $customer['id'] ?>"
                                   class="btn-sm btn-delete"
                                   onclick="return confirm('Delete this customer?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</div>

</body>
</html>