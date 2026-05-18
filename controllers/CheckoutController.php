<?php

function checkoutCtrl($conn){

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
        header('Location: index.php?page=login');
        exit;
    }
    $userId = $_SESSION['user']['id'];
//load cart data
    $cartItems = getCartItems($conn, $userId);
    $cartTotal = getCartTotal($conn, $userId);

    $step = $_GET['step'] ?? 'shipping';

    if ($step !== 'success' && empty($cartItems)) {
        header('Location: index.php?page=cart');
        exit;
    }
    $error = '';
    $error = '';
    if ($step === 'shipping') {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $shippingAddress = trim($_POST['shipping_address'] ?? '');
            if ($shippingAddress === '') {
                $error = 'Shipping address is required.';
            } else {
                $_SESSION['checkout'] = ['shipping_address' => $shippingAddress];
                header('Location: index.php?page=checkout&step=invoice');
                exit;
            }
        }
        require 'views/checkout.php';
        return;
    }

//invoice
    if ($step === 'invoice') {
        if (empty($_SESSION['checkout']['shipping_address'])) {
            header('Location: index.php?page=checkout&step=shipping');
            exit;
        }
        require 'views/invoice.php';
        return;
    }

//payment
    if ($step === 'payment') {
        if (empty($_SESSION['checkout']['shipping_address'])) {
            header('Location: index.php?page=checkout&step=shipping');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $paymentMethod = trim($_POST['payment_method'] ?? '');
            if ($paymentMethod === '') {
                $error = 'Please select a payment method.';
            } else {

                $orderId = createOrder($conn, $userId, $_SESSION['checkout']['shipping_address'], $cartTotal, $paymentMethod);
                foreach ($cartItems as $item) {
                    addOrderItem($conn, $orderId, $item['medicine_id'], $item['quantity'], $item['price']);
                }
                createPayment($conn, $orderId, $paymentMethod, $cartTotal);
                clearCart($conn, $userId);
                $_SESSION['last_order_id'] = $orderId;
                unset($_SESSION['checkout']);
                header('Location: index.php?page=checkout&step=success');
                exit;
            }
        }
        require 'views/payment.php';
        return;
    }

    if ($step === 'success') {
        if (empty($_SESSION['last_order_id'])) {
        header('Location: index.php?page=home');
            exit;
        }
        $orderId = $_SESSION['last_order_id'];
        $orderDetails = getOrderDetails($conn, $orderId);
        require 'views/order_success.php';
        return;
    }
    header('Location: index.php?page=checkout&step=shipping');
    exit;
}
?>