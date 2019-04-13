<?php
session_start();
require_once 'database/connection.php';

if (isset($_POST['register'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = strtolower(trim($_POST['email']));
    $password = trim($_POST['password']);
    $password = password_hash($password, PASSWORD_BCRYPT);
    $email_verification_token = sha1(time().$email.$username);

    if (!empty($_FILES['photo']['tmp_name'])) {
        $name = $_FILES['photo']['name'];
        $filename_parts = explode('.', $name);
        $extension = end($filename_parts);
        $new_filename = uniqid('pp_', true) . time() . '.' . $extension;
        move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/profile_photo/' . $new_filename);
    }
    $photo = $new_filename;
    $query = 'INSERT INTO users (`first_name`, `last_name`, `username`, `email`, `password`, `photo`, `email_verification_token`, `active`) VALUES (:first_name, :last_name, :username, :email, :password, :photo, :email_verification_token, :active)';
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':photo', $photo);
    $stmt->bindValue(':email_verification_token', $email_verification_token);
    $stmt->bindValue(':active', 1);
    $response = $stmt->execute();

    if ($response) {
        $_SESSION['type'] = 'success';
        $_SESSION['message'] = 'Registration successful.';
    } else {
        $_SESSION['type'] = 'danger';
        $_SESSION['message'] = 'Registration unsuccessful.';
    }
    header('Location: register.php');
    exit();
}