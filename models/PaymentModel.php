<?php
function createPayment($conn, $orderId, $paymentMethod, $amount){
    if ($paymentMethod === 'cash_on_delivery') {
        $transactionId = 'COD';
        $stmt = mysqli_prepare($conn, "INSERT INTO payments (order_id, payment_method, transaction_id, amount) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "issd", $orderId, $paymentMethod, $transactionId, $amount);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $success;
    }
    $tempTransactionId = '';
    $stmt = mysqli_prepare($conn, "INSERT INTO payments (order_id, payment_method, transaction_id, amount) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "issd", $orderId, $paymentMethod, $tempTransactionId, $amount);
    mysqli_stmt_execute($stmt);
    $paymentId = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    $transactionId = 'TXN-' . $paymentId;

    $stmt = mysqli_prepare($conn, "UPDATE payments SET transaction_id = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $transactionId, $paymentId);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}

?>