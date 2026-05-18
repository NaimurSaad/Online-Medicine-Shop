<?php

function profileCtrl($conn){
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?page=login');
        exit;
    }
    $userId = $_SESSION['user']['id'];
    $success = '';
    $error = '';

    $user = getUser($conn, $userId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($name === '' || $email === '' || $address === '' || $phone === '') {
            $error = 'All profile fields are required.';
        } elseif (emailExists($conn, $email) && $email !== $user['email']) {
            $error = 'Email already exists.';
        } else {
            $profilePicture = $user['profile_picture'];

            if (!empty($_FILES['profile_picture']['name'])) {
                if (!is_dir('uploads/profiles')) {
                    mkdir('uploads/profiles', 0777, true);
                }
                $fileName = time() . '_' . basename($_FILES['profile_picture']['name']);
                $target = 'uploads/profiles/' . $fileName;

                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target)) {
                    $profilePicture = $fileName;
                }
            }

            if (updateUser($conn, $userId, $name, $email, $address, $phone, $profilePicture)) {

                if ($currentPassword !== '' || $newPassword !== '' || $confirmPassword !== '') {
                    if ($currentPassword === '' || $newPassword === '' || $confirmPassword === '') {
                         $error = 'Fill in all password fields to change your password.';
                    } elseif (!password_verify($currentPassword, getUser($conn, $userId)['password_hash'])) {
                        $error = 'Current password is incorrect.';
                    } elseif ($newPassword !== $confirmPassword) {
                        $error = 'New password and confirm password do not match.';
                    } elseif (strlen($newPassword) < 8) {
                        $error = 'New password must be at least 8 characters.';
                    } elseif (updateUserPassword($conn, $userId, $newPassword)) {
                        $success = 'Profile and password updated successfully.';
                    } else {
                        $error = 'Profile updated, but password could not be changed.';
                    }
                } else {
                    $success = 'Profile updated successfully.';
                }

                $_SESSION['user']['name'] = $name;
                $_SESSION['user']['email'] = $email;

                $user = getUser($conn, $userId);
            } else {
                $error = 'Failed to update profile.';
            }
        }
    }

    require 'views/profile.php';
}
?>