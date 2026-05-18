<?php

function loginCtrl($conn)
{
    $error = '';
    $prefill = $_COOKIE['remember_user'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        if ($email === '' || $password === '') {
            $error = 'Please fill in both fields.';
        } else {
  
            $user = authUser($conn, $email, $password);

            if ($user) {
                $_SESSION['user'] = [
                    'id' => $user['id'], 'name' => $user['name'],
                    'email' => $user['email'], 'role' => $user['role'],
                    'address' => $user['address'], 'phone' => $user['phone']
                ];


                if ($remember) {
                    setcookie('remember_user', $email, time() + 86400 * 30, '/');
                } else {
                    setcookie('remember_user', '', time() - 3600, '/');
                }


                if ($user['role'] === 'admin') {
                    header('Location: index.php?page=admin');
                } else {
                    header('Location: index.php?page=home');
                }
                exit;
            } else {
                $error = 'Invalid email or password.';
            }
        }
    }

    require 'views/login.php';
}


function registerCtrl($conn){
    $error = $success = '';
    if (isset($_GET['success'])) {
    $success = 'Account created successfully.';
}
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $role = $_POST['role'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if ($name === '' || $email === '' || $address === '' ||
            $phone === '' || $role === '' || $password === '' || $confirm === '') {
            $error = 'All fields are required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
            $error = 'Invalid email address.';
        } elseif (strlen($password) < 8) {
            $error = 'Password must be at least 8 characters.';
        } elseif ($password !== $confirm) {
            $error = 'Passwords do not match.';
        } elseif (emailExists($conn, $email)) {
            $error = 'Email is already registered.';
        } else {

            if (addUser($conn, $name, $email, $password, $role, $address, $phone)) {
                header('Location: index.php?page=register&success=1');
                exit;
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }

    require 'views/register.php';
}


function logoutCtrl()
{
    $_SESSION = [];


    setcookie('remember_user', '', time() - 3600, '/');

    session_destroy();

    header('Location: index.php?page=login');
    exit;
}
?>