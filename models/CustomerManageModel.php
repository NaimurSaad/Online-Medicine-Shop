<?php

function getCustomers($conn){
    $result = mysqli_query($conn, "SELECT id, name, email, address, phone, created_at FROM users WHERE role = 'customer' ORDER BY id DESC");
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function deleteCustomer($conn, $id){
    $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ? AND role = 'customer'");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}
?>