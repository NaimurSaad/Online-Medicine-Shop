<?php
function authUser($conn, $email, $password){
    $stmt = mysqli_prepare($conn,
        "SELECT id, name, email, password_hash, role, address, phone FROM users
         WHERE email = ?");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    mysqli_stmt_close($stmt);

    return ($row && password_verify($password, $row['password_hash'])) ? $row : false;
}


function emailExists($conn, $email, $excludeId = null){
    if ($excludeId) {
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ? AND id != ?");
        mysqli_stmt_bind_param($stmt, 'si', $email, $excludeId);
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, 's', $email);
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $exists = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);
    return $exists;
}


function addUser($conn, $name, $email, $password, $role, $address, $phone){
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, 
        "INSERT INTO users (name, email, password_hash, role, address, phone)
         VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssssss', $name, $email, $passwordHash, $role, $address, $phone);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}


function getUser($conn, $id){
    $stmt = mysqli_prepare($conn, "SELECT id, name, email, role, profile_picture, address, phone, password_hash FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row;
}

function updateUser($conn, $id, $name, $email, $address, $phone, $profilePicture = null) {
    if ($profilePicture !== null && $profilePicture !== '') {
        $stmt = mysqli_prepare($conn,
            "UPDATE users SET name = ?, email = ?, address = ?, phone = ?, profile_picture = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt,'sssssi', $name, $email, $address, $phone, $profilePicture, $id);
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE users SET name = ?, email = ?, address = ?, phone = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'ssssi', $name, $email, $address, $phone, $id);
    }
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function updateUserPassword($conn, $id, $newPassword){
    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "UPDATE users SET password_hash = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'si', $passwordHash, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}


?>
