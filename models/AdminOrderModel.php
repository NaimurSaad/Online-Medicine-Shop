<?php

function getDashboardCounts($conn)
{
    $counts = [
        'total_medicines'  => 0,
        'total_categories' => 0,
        'total_customers'  => 0,
        'pending_orders'   => 0
    ];

    // Total medicines
    $result = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM medicines"
    );
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $counts['total_medicines'] = (int)$row['total'];
    }

    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM categories");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $counts['total_categories'] = (int)$row['total'];
    }

    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'customer'");
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    $counts['total_customers'] = (int)$row['total'];
    mysqli_stmt_close($stmt);
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS total FROM orders WHERE status = 'pending'");
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    $counts['pending_orders'] = (int)$row['total'];
    mysqli_stmt_close($stmt);
    return $counts;
}


function getAllOrders($conn){
    $result = mysqli_query(
        $conn,
        "SELECT o.id, o.user_id, u.name AS customer_name, u.email, u.phone, u.address, o.total_amount, o.shipping_address, o.status, o.order_date
         FROM orders o INNER JOIN users u ON o.user_id = u.id ORDER BY o.order_date DESC");

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


function reduceStockForOrder($conn, $orderId){
    $stmt = mysqli_prepare(
        $conn,
        "SELECT medicine_id, quantity
         FROM order_items
         WHERE order_id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $orderId);
    mysqli_stmt_execute($stmt);

    $items = mysqli_fetch_all(
        mysqli_stmt_get_result($stmt),
        MYSQLI_ASSOC
    );

    mysqli_stmt_close($stmt);

    foreach ($items as $item) {
        $update = mysqli_prepare(
            $conn,
            "UPDATE medicines SET availability = availability - ? WHERE id = ?");

        mysqli_stmt_bind_param($update, "ii", $item['quantity'], $item['medicine_id']);
        mysqli_stmt_execute($update);
        mysqli_stmt_close($update);
    }
}

//accept/reject status
function updateOrderStatus($conn, $orderId, $status){
    $stmt = mysqli_prepare(
        $conn,
        "UPDATE orders SET status = ? WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, 'si', $status, $orderId);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($ok && $status === 'accepted') {
        reduceStockForOrder($conn, $orderId);
    }

    return $ok;
}

function getPurchaseHistory($conn){
    $result = mysqli_query($conn, "SELECT  o.id, o.user_id, u.name AS customer_name, u.email, u.phone, u.address, o.total_amount, o.shipping_address,
            o.status, o.order_date, m.name AS medicine_name, oi.quantity, oi.unit_price FROM orders o INNER JOIN users u ON o.user_id = u.id INNER JOIN order_items oi ON o.id = oi.order_id
         INNER JOIN medicines m ON oi.medicine_id = m.id WHERE o.status = 'accepted' ORDER BY o.order_date DESC");
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>