<?php

function getCategories($conn) {
    $result = mysqli_query($conn, "SELECT id, name, category_type, created_at FROM categories ORDER BY id DESC");
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


function getCategory($conn, $id){
    $stmt = mysqli_prepare($conn, "SELECT id, name, category_type, created_at FROM categories WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row;
}

function addCategory($conn, $name, $categoryType){
    $stmt = mysqli_prepare($conn, "INSERT INTO categories (name, category_type) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, 'ss', $name, $categoryType);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}


function updateCategory($conn, $id, $name, $categoryType){
    $stmt = mysqli_prepare($conn, "UPDATE categories SET name = ?, category_type = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'ssi', $name, $categoryType, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}


function deleteCategory($conn, $id){
    $stmt = mysqli_prepare($conn, "DELETE FROM categories WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}


function categoryHasMedicines($conn, $categoryId){
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS total FROM medicines WHERE category_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $categoryId);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return ((int)$row['total']) > 0;
}
?>