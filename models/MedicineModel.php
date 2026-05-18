<?php

function getMedicine($conn, $id) {
    $stmt = mysqli_prepare($conn, "SELECT id, name, category_id, vendor_name, price, availability, description, image_path, created_at
         FROM medicines WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row;
}


function addMedicine($conn, $name, $categoryId, $vendorName, $price, $availability, $description, $imagePath) {
    $stmt = mysqli_prepare($conn, "INSERT INTO medicines (name, category_id, vendor_name, price, availability, description, image_path)
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    mysqli_stmt_bind_param($stmt, 'sisdiss', $name, $categoryId, $vendorName, $price, $availability, $description, $imagePath);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function updateMedicine($conn, $id, $name, $categoryId, $vendorName, $price, $availability, $description, $imagePath) {
    $stmt = mysqli_prepare($conn, "UPDATE medicines SET name = ?, category_id = ?, vendor_name = ?, price = ?, availability = ?, description = ?, image_path = ?
         WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'sisdissi', $name, $categoryId, $vendorName, $price, $availability, $description, $imagePath, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function deleteMedicine($conn, $id){


    $stmt = mysqli_prepare(
        $conn,
        "DELETE oi FROM order_items oi INNER JOIN orders o ON oi.order_id = o.id WHERE oi.medicine_id = ? AND o.status != 'pending'");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($conn, "DELETE FROM medicines WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}


function medicineInPendingOrders($conn, $medicineId) {
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS total FROM order_items oi INNER JOIN orders o ON oi.order_id = o.id WHERE oi.medicine_id = ?
           AND o.status = 'pending'");
    mysqli_stmt_bind_param($stmt, 'i', $medicineId);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row['total'] > 0;
}
?>