<?php

function addToCart($conn, $userId, $medicineId, $quantity = 1){

    $stmt = mysqli_prepare($conn, "SELECT id, quantity FROM cart WHERE user_id = ? AND medicine_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $userId, $medicineId);
    mysqli_stmt_execute($stmt);
    $existing = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    if ($existing) {
        $newQuantity = $existing['quantity'] + $quantity;
        $stmt = mysqli_prepare($conn, "UPDATE cart SET quantity = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ii", $newQuantity, $existing['id']);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $success;
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO cart (user_id, medicine_id, quantity) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iii", $userId, $medicineId, $quantity);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}


function getCartItems($conn, $userId){
    $stmt = mysqli_prepare($conn, "SELECT c.id, c.quantity, m.id AS medicine_id, m.name, m.price, m.image_path, m.availability, (c.quantity * m.price) AS subtotal
         FROM cart c INNER JOIN medicines m ON c.medicine_id = m.id WHERE c.user_id = ? ORDER BY c.id DESC");
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $items = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    return $items;
}  


function getCartTotal($conn, $userId){
    $stmt = mysqli_prepare($conn, "SELECT SUM(c.quantity * m.price) AS total FROM cart c INNER JOIN medicines m ON c.medicine_id = m.id
         WHERE c.user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    return (float) ($row['total'] ?? 0);
}


function updateCartQuantity($conn, $cartId, $quantity){
    $stmt = mysqli_prepare($conn, "UPDATE cart SET quantity = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $quantity, $cartId);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}


function removeCartItem($conn, $cartId){
    $stmt = mysqli_prepare($conn, "DELETE FROM cart WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $cartId);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}


function clearCart($conn, $userId){
    $stmt = mysqli_prepare($conn, "DELETE FROM cart WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $userId);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}


function getCartCount($conn, $userId){
    $stmt = mysqli_prepare($conn, "SELECT SUM(quantity) AS total_items FROM cart WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return (int) ($row['total_items'] ?? 0);
}
?>