
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Category Management</title>
<link rel="stylesheet" href="css/admin.css">
</head>
<body>

<div class="admin-container">

    <div class="admin-header">
        <h1>Category Management</h1>

        <div class="admin-nav">
            <a href="index.php?page=admin&section=dashboard">Dashboard</a>
            <a href="index.php?page=admin&section=categories">Categories</a>
            <a href="index.php?page=admin&section=medicines">Medicines</a>
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
                echo 'Category added successfully.';
            } elseif ($_GET['msg'] === 'updated') {
                echo 'Category updated successfully.';
            } elseif ($_GET['msg'] === 'deleted') {
                echo 'Category deleted successfully.';
            }
            ?>
        </div>
    <?php endif; ?>


    <div class="admin-card">
        <h2>
            <?= $editing ? 'Edit Category' : 'Add New Category' ?>
        </h2>

        <form method="POST"
              action="index.php?page=admin&section=categories&action=<?= $editing ? 'update&id=' . $editing['id'] : 'add' ?>"
              class="form"
              novalidate>

            <div class="field">
                <label for="name">
                    Category Name <span class="required">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="<?= htmlspecialchars($editing['name'] ?? '') ?>"
                       placeholder="e.g. Tablets">
                <div class="error"></div>
            </div>


            <div class="field">
                <label for="category_type">
                    Category Type <span class="required">*</span>
                </label>

                <select id="category_type"
                        name="category_type">
                    <option value="">Select Type</option>
                    <option value="solid"
                        <?= (($editing['category_type'] ?? '') === 'solid') ? 'selected' : '' ?>>
                        Solid
                    </option>
                    <option value="liquid"
                        <?= (($editing['category_type'] ?? '') === 'liquid') ? 'selected' : '' ?>>
                        Liquid
                    </option>
                </select>

                <div class="error"></div>
            </div>

            <button type="submit" class="btn btn-primary">
                <?= $editing ? 'Update Category' : 'Add Category' ?>
            </button>

            <?php if ($editing): ?>
                <a href="index.php?page=admin&section=categories"
                   class="btn btn-secondary">
                    Cancel
                </a>
            <?php endif; ?>
        </form>
    </div>

    <div class="admin-card">
        <h2>All Categories</h2>

        <?php if (empty($categories)): ?>
            <p>No categories found.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Serial</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $index => $category): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($category['name']) ?></td>
                            <td>
                                <?= ucfirst(htmlspecialchars($category['category_type'])) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($category['created_at']) ?>
                            </td>
                            <td>
                                <a href="index.php?page=admin&section=categories&action=edit&id=<?= $category['id'] ?>"
                                   class="btn-sm btn-edit">
                                    Edit
                                </a>

                                <a href="index.php?page=admin&section=categories&action=delete&id=<?= $category['id'] ?>"
                                   class="btn-sm btn-delete"
                                   onclick="return confirm('Delete this category?')">
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