<?php
//Asiful

function createOrder($conn, $userId, $shippingAddress, $totalAmount, $paymentMethod) {
    $status = 'pending';
    $stmt = mysqli_prepare($conn, "INSERT INTO orders (user_id, total_amount, shipping_address, payment_method, status) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param( $stmt, "idsss", $userId, $totalAmount, $shippingAddress, $paymentMethod, $status);
    mysqli_stmt_execute($stmt);
    $orderId = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);
    return $orderId;
}

function addOrderItem($conn, $orderId, $medicineId, $quantity, $unitPrice) {
    $stmt = mysqli_prepare($conn, "INSERT INTO order_items (order_id, medicine_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iiid", $orderId, $medicineId, $quantity, $unitPrice);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}

function getOrderDetails($conn, $orderId) {
    $stmt = mysqli_prepare($conn, "SELECT  o.id, o.total_amount, o.status, o.order_date, oi.quantity, oi.unit_price, m.name AS medicine_name FROM orders o
         INNER JOIN order_items oi ON o.id = oi.order_id INNER JOIN medicines m ON oi.medicine_id = m.id WHERE o.id = ?");
    mysqli_stmt_bind_param($stmt, "i", $orderId);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all( mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}


?>
