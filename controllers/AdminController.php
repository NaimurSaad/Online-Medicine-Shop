<?php

function adminCtrl($conn){
    if (
        !isset($_SESSION['user']) ||
        $_SESSION['user']['role'] !== 'admin'
    ) {
        header('Location: index.php?page=login');
        exit;
    }
    $action = $_GET['action'] ?? 'dashboard';
    $section = $_GET['section'] ?? 'dashboard';
    $error = '';
    $success = '';
    $editing = null;

//category management

//add category
    if ($section === 'categories' && $action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $categoryType = trim($_POST['category_type'] ?? '');

        if ($name === '' || $categoryType === '') {
            $error = 'All fields are required.';
        } else {
            if (addCategory($conn, $name, $categoryType)) {
                header('Location: index.php?page=admin&section=categories&msg=added');
                exit;
            }
            $error = 'Failed to add category.';
        }
    }

//edit category
    if ($section === 'categories' && $action === 'edit' && !$editing) {
        $id = intval($_GET['id'] ?? 0);
        $editing = getCategory($conn, $id);
    }

//update category
    if ($section === 'categories' && $action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = intval($_GET['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $categoryType = trim($_POST['category_type'] ?? '');

        if ($name === '' || $categoryType === '') {
            $error = 'All fields are required.';
            $editing = ['id' => $id, 'name' => $name, 'category_type' => $categoryType];
        } else {
            if (updateCategory($conn, $id, $name, $categoryType)) {
                header('Location: index.php?page=admin&section=categories&msg=updated');
                exit;
            }
            $error = 'Failed to update category.';
            $editing = ['id' => $id, 'name' => $name, 'category_type' => $categoryType];
        }
    }

//delete category
    if ($section === 'categories' && $action === 'delete') {
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) {
            if (categoryHasMedicines($conn, $id)) {
                $error = 'Cannot delete category because medicines exist in it.';
            } else {
                deleteCategory($conn, $id);
                header('Location: index.php?page=admin&section=categories&msg=deleted');
                exit;
            }
        }
    }

//medicine management

//add medicine
    if ($section === 'medicines' && $action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $categoryId = intval($_POST['category_id'] ?? 0);
        $vendorName = trim($_POST['vendor_name'] ?? '');
        $price = floatval($_POST['price'] ?? 0);
        $availability = intval($_POST['availability'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $imagePath = '';
        if ($name === '' || $categoryId <= 0 || $vendorName === '' || $price <= 0 || $availability < 0) {
            $error = 'Please fill all required fields correctly.';
        } else {
            if (!empty($_FILES['image']['name'])) {
                $imagePath = uploadMedicineImage($_FILES['image']);
                if ($imagePath === false) {
                    $error = 'Image upload failed. Only JPG/PNG up to 2MB are allowed.';
                }
            }
            if ($error === '') {
                if (addMedicine($conn, $name, $categoryId, $vendorName, $price, $availability, $description, $imagePath)) {
                    header('Location: index.php?page=admin&section=medicines&msg=added');
                    exit;
                }
                $error = 'Failed to add medicine.';
            }
        }
    }


//edit medicine
    if ($section === 'medicines' && $action === 'edit' && !$editing) {
        $id = intval($_GET['id'] ?? 0);
        $editing = getMedicine($conn, $id);
    }

//update medicine
    if ($section === 'medicines' && $action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = intval($_GET['id'] ?? 0);
        $existing = getMedicine($conn, $id);

        $name = trim($_POST['name'] ?? '');
        $categoryId = intval($_POST['category_id'] ?? 0);
        $vendorName = trim($_POST['vendor_name'] ?? '');
        $price = floatval($_POST['price'] ?? 0);
        $availability = intval($_POST['availability'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $imagePath = $existing['image_path'] ?? '';
        if ($name === '' || $categoryId <= 0 || $vendorName === '' || $price <= 0 || $availability < 0
        ) {
            $error = 'Please fill all required fields correctly.';
        } else {
            if (!empty($_FILES['image']['name'])) {
                $newImage = uploadMedicineImage($_FILES['image']);

                if ($newImage === false) {
                    $error = 'Image upload failed. Only JPG/PNG up to 2MB are allowed.';
                } else {
                    if ($imagePath !== '' && file_exists('uploads/medicines/' . $imagePath)) {
                        unlink('uploads/medicines/' . $imagePath);
                    }
                    $imagePath = $newImage;
                }
            }
            if ($error === '') {
                if (updateMedicine($conn, $id, $name, $categoryId, $vendorName, $price, $availability, $description, $imagePath)) {
                    header('Location: index.php?page=admin&section=medicines&msg=updated');
                    exit;
                }
                $error = 'Failed to update medicine.';
            }
        }
        if ($error !== '') { $editing = [ 'id' => $id, 'name' => $name, 'category_id' => $categoryId, 'vendor_name' => $vendorName, 'price' => $price, 'availability' => $availability,
                'description' => $description, 'image_path' => $imagePath];
        }
    }



//delete medicine
    if ( $section === 'medicines' && $action === 'delete') {
        $id = intval($_GET['id'] ?? 0);

        if ($id > 0) {
            if (medicineInPendingOrders($conn, $id)) {
                $error = 'Cannot delete a medicine that exists in pending orders.';
            } else {
                $medicine = getMedicine($conn, $id);
                if ($medicine && !empty($medicine['image_path']) && file_exists('uploads/medicines/' . $medicine['image_path'])) {
                    unlink('uploads/medicines/' . $medicine['image_path']);
                }
                deleteMedicine($conn, $id);
                header('Location: index.php?page=admin&section=medicines&msg=deleted');
                exit;
            }
        }
    }

//delete customer

    if ($section === 'customers' && $action === 'delete') {
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) {
            deleteCustomer($conn, $id);
        }
        header('Location: index.php?page=admin&section=customers&msg=deleted');
        exit;
    }

//accept/reject orders

    if ($section === 'orders' && $action === 'status' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');
        $orderId = intval($_POST['order_id'] ?? 0);
        $status = trim($_POST['status'] ?? '');
        if ($orderId <= 0 || !in_array($status, ['accepted', 'rejected'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid request.']);
            exit;
        }
        $ok = updateOrderStatus($conn, $orderId, $status);
        echo json_encode(['success' => $ok, 'status' => $status]);
        exit;
    }

    if ($section === 'orders' && $action === 'status') {
    $orderId = (int) ($_GET['id'] ?? 0);
    $status  = $_GET['status'] ?? '';

    if (
        $orderId > 0 &&
        in_array($status, ['accepted', 'rejected'])
    ) {
        updateOrderStatus($conn, $orderId, $status);
        echo 'OK';
    } else {
        echo 'ERROR';
    }

    exit;
}

//dashboard

    if ($section === 'dashboard') {
        $counts = getDashboardCounts($conn);
        require 'views/admin_dashboard.php';
        return;
    }

//category view

    if ($section === 'categories') {
        $categories = getCategories($conn);
        require 'views/category_form.php';
        return;
    }

//medicine view

    if ($section === 'medicines') {
        $categories = getCategories($conn);
        $medicines = getMedicines($conn);
        require 'views/medicine_form.php';
        return;
    }

//customer view

    if ($section === 'customers') {
        $customers = getCustomers($conn);
        require 'views/customers.php';
        return;
    }

//purchase req view
    if ($section === 'orders') {
        $orders = getAllOrders($conn);
        require 'views/purchase_requests.php';
        return;
    }

//purchase history view

    if ($section === 'history') {
        $history = getPurchaseHistory($conn);
        require 'views/purchase_history.php';
        return;
    }

    $counts = getDashboardCounts($conn);
    require 'views/admin_dashboard.php';
}

//medicine image upload

function uploadMedicineImage($file)
{
    if (!isset($file['tmp_name']) || $file['tmp_name'] === '') {
        return '';
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        return false;
    }

    $allowed = ['image/jpeg', 'image/png'];
    $mime = mime_content_type($file['tmp_name']);

    if (!in_array($mime, $allowed)) {
        return false;
    }

    if (!is_dir('uploads/medicines')) {
        mkdir('uploads/medicines', 0777, true);
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = time() . '_' . mt_rand(1000, 9999) . '.' . $extension;

    if (move_uploaded_file(
        $file['tmp_name'],
        'uploads/medicines/' . $fileName
    )) {
        return $fileName;
    }

    return false;
}
?>
