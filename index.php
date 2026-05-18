<?php
session_start();
require 'config/config.php';

require 'models/UserModel.php';
require 'models/CustomerManageModel.php';
require 'models/MedicineSearchModel.php';
require 'models/MedicineModel.php';
require 'models/CategoryModel.php';
require 'models/CartModel.php';
require 'models/OrderModel.php';
require 'models/AdminOrderModel.php';
require 'models/PaymentModel.php';

require 'controllers/AuthController.php';
require 'controllers/HomeController.php';
require 'controllers/ProfileController.php';
require 'controllers/AdminController.php';
require 'controllers/CartController.php';
require 'controllers/CheckoutController.php';

$page = $_GET['page'] ?? 'login';


if ($page === 'logout') {
    $_SESSION = [];
    session_destroy();
    setcookie('remember_user', '', time() - 3600, '/');
    header('Location: index.php?page=login');
    exit;
}

if ($page === 'ajax') {
    header('Content-Type: application/json');

    if (!isset($_SESSION['user'])) {
        http_response_code(403);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }

    $type = $_GET['type'] ?? '';
    $q    = trim($_GET['q'] ?? '');

    if ($type === 'search') {
        echo json_encode($q === '' ? getMedicines($conn) : searchMedicines($conn, $q));
    } elseif ($type === 'order_status' &&
            $_SESSION['user']['role'] === 'admin') {
        updateOrderStatusCtrl($conn);
    } elseif ($type === 'cart_add' &&
            $_SESSION['user']['role'] === 'customer') {
        addToCartCtrl($conn);
    } elseif ($type === 'cart_update' &&
            $_SESSION['user']['role'] === 'customer') {
        updateCartCtrl($conn);
    } elseif ($type === 'cart_remove' &&
            $_SESSION['user']['role'] === 'customer') {
        removeFromCartCtrl($conn);

    } else {
        http_response_code(403);
        echo json_encode(['error' => 'Forbidden']);
    }
    exit;
}

$publicPages = ['login', 'register'];

if (in_array($page, $publicPages) && isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'admin') {
        header('Location: index.php?page=admin');
    } else {
        header('Location: index.php?page=home');
    }
    exit;
}

if (!in_array($page, $publicPages) && !isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

if ($page === 'admin' && $_SESSION['user']['role'] !== 'admin') { header('Location: index.php?page=home'); exit; }
if (($page === 'cart' || $page === 'checkout') && $_SESSION['user']['role'] !== 'customer') { header('Location: index.php?page=home'); exit; }

switch ($page) {
    case 'login': loginCtrl($conn); break;
    case 'register': registerCtrl($conn); break;
    case 'home': homeCtrl($conn); break;
    case 'profile': profileCtrl($conn); break;
    case 'admin': adminCtrl($conn); break;
    case 'cart': cartCtrl($conn); break;
    case 'checkout': checkoutCtrl($conn); break;
    default:
        header('Location: index.php?page=login');
        exit;
}

mysqli_close($conn);
?>
