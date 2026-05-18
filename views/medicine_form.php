
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Medicine Management</title>
<link rel="stylesheet" href="css/admin.css">
</head>
<body>

<div class="admin-container">

    <div class="admin-header">
        <h1>Medicine Management</h1>

        <div class="admin-nav">
            <a href="index.php?page=admin&section=dashboard">Dashboard</a>
            <a href="index.php?page=admin&section=categories">Categories</a>
            <a href="index.php?page=admin&section=medicines" class="active">Medicines</a>
            <a href="index.php?page=admin&section=customers">Customers</a>
            <a href="index.php?page=admin&section=orders">Purchase Requests</a>
            <a href="index.php?page=admin&section=history">Purchase History</a>
            <a href="index.php?page=profile">Profile</a>
            <a href="index.php?page=logout">Logout</a>
        </div>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success">
            <?php
            if ($_GET['msg'] === 'added') {
                echo 'Medicine added successfully.';
            } elseif ($_GET['msg'] === 'updated') {
                echo 'Medicine updated successfully.';
            } elseif ($_GET['msg'] === 'deleted') {
                echo 'Medicine deleted successfully.';
            }
            ?>
        </div>
    <?php endif; ?>

    <div class="admin-card">
        <h2><?= $editing ? 'Edit Medicine' : 'Add New Medicine' ?></h2>

        <form method="POST"
              enctype="multipart/form-data"
              action="index.php?page=admin&section=medicines&action=<?= $editing ? 'update&id=' . $editing['id'] : 'add' ?>"
              class="form"
              novalidate>

            <div class="field">
                <label for="name">
                    Medicine Name <span class="required">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="<?= htmlspecialchars($editing['name'] ?? '') ?>"
                       placeholder="e.g. Napa">
                <div class="error"></div>
            </div>

            <div class="field">
                <label for="category_id">
                    Category <span class="required">*</span>
                </label>
                <select id="category_id" name="category_id">
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"
                            <?= (($editing['category_id'] ?? '') == $category['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                            (<?= ucfirst($category['category_type']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="error"></div>
            </div>


            <div class="field">
                <label for="vendor_name">
                    Vendor Name <span class="required">*</span>
                </label>
                <input type="text"
                       id="vendor_name"
                       name="vendor_name"
                       value="<?= htmlspecialchars($editing['vendor_name'] ?? '') ?>"
                       placeholder="e.g. Beximco">
                <div class="error"></div>
            </div>

            <div class="field">
                <label for="price">
                    Price <span class="required">*</span>
                </label>
                <input type="number"
                       step="0.01"
                       min="0.01"
                       id="price"
                       name="price"
                       value="<?= htmlspecialchars($editing['price'] ?? '') ?>"
                       placeholder="e.g. 10.50">
                <div class="error"></div>
            </div>

            <div class="field">
                <label for="availability">
                    Stock Quantity <span class="required">*</span>
                </label>
                <input type="number"
                       min="0"
                       id="availability"
                       name="availability"
                       value="<?= htmlspecialchars($editing['availability'] ?? '') ?>"
                       placeholder="e.g. 100">
                <div class="error"></div>
            </div>

            <div class="field">
                <label for="description">
                    Description
                </label>
                <textarea id="description"
                          name="description"
                          placeholder="Optional description"><?= htmlspecialchars($editing['description'] ?? '') ?></textarea>
                <div class="error"></div>
            </div>

            <?php if (!empty($editing['image_path'])): ?>
                <div class="field">
                    <label>Current Image</label>
                    <img src="uploads/medicines/<?= htmlspecialchars($editing['image_path']) ?>"
                         alt="Medicine Image"
                         class="preview-image">
                </div>
            <?php endif; ?>

            <div class="field">
                <label for="image">
                    Image <?= $editing ? '(Optional)' : '' ?>
                </label>
                <input type="file"
                       id="image"
                       name="image"
                       accept=".jpg,.jpeg,.png">
                <div class="error"></div>
            </div>

            <button type="submit" class="btn btn-primary">
                <?= $editing ? 'Update Medicine' : 'Add Medicine' ?>
            </button>

            <?php if ($editing): ?>
                <a href="index.php?page=admin&section=medicines"
                   class="btn btn-secondary">
                    Cancel
                </a>
            <?php endif; ?>
        </form>
    </div>

    <div class="admin-card">
        <h2>All Medicines</h2>

        <?php if (empty($medicines)): ?>
            <p>No medicines found.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Serial</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Vendor</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medicines as $index => $medicine): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>

                            <td>
                                <?php if (!empty($medicine['image_path'])): ?>
                                    <img src="uploads/medicines/<?= htmlspecialchars($medicine['image_path']) ?>"
                                         alt="Medicine"
                                         class="medicine-thumb">
                                <?php else: ?>
                                    No Image
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($medicine['name']) ?></td>
                            <td><?= htmlspecialchars($medicine['category_name']) ?></td>
                            <td><?= ucfirst(htmlspecialchars($medicine['category_type'])) ?></td>
                            <td><?= htmlspecialchars($medicine['vendor_name']) ?></td>
                            <td>৳ <?= number_format($medicine['price'], 2) ?></td>
                            <td><?= htmlspecialchars($medicine['availability']) ?></td>

                            <td>
                                <a href="index.php?page=admin&section=medicines&action=edit&id=<?= $medicine['id'] ?>"
                                   class="btn-sm btn-edit">
                                    Edit
                                </a>

                                <a href="index.php?page=admin&section=medicines&action=delete&id=<?= $medicine['id'] ?>"
                                   class="btn-sm btn-delete"
                                   onclick="return confirm('Delete this medicine?')">
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

<script src="js/admin_validation.js"></script>
</body>
</html>