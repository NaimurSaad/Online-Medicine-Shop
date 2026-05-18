<?php

/* ============== Show Cart Page ============== */

function cartCtrl($conn){
    // Customer Gate
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
        header('Location: index.php?page=login');
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $cartItems = getCartItems($conn, $userId);
    $cartTotal = getCartTotal($conn, $userId);
    $error = '';
    foreach ($cartItems as $item) {
        if ($item['quantity'] > $item['availability']) {
            $error = 'Insufficient stock for ' . $item['name'] . '.';
            break;
        }
    }
    require 'views/cart.php';
}
//ajax
//add to cart 
function addToCartCtrl($conn){
    $userId = $_SESSION['user']['id'];
    $medicineId = intval($_POST['medicine_id'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 1);
    if ($medicineId <= 0 || $quantity <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid request.']);
        exit;
    }
    $success = addToCart($conn, $userId, $medicineId, $quantity);
    echo json_encode(['success' => $success, 'cart_count' => getCartCount($conn, $userId)]);
    exit;
}

//update cart
function updateCartCtrl($conn){
    $cartId = intval($_POST['cart_id'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 0);
    if ($cartId <= 0 || $quantity <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid quantity.']);
        exit;
    }
    $success = updateCartQuantity($conn, $cartId, $quantity);
    echo json_encode(['success' => $success]);
    exit;
}

///delete cart
function removeFromCartCtrl($conn){
    $cartId = intval($_POST['cart_id'] ?? 0);
    if ($cartId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid item.']);
        exit;
    }
    $success = removeCartItem($conn, $cartId);
    echo json_encode(['success' => $success]);
    exit;
}
?>