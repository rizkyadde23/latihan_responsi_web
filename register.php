<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm_password"];

    if ($password !== $confirm) {
        $_SESSION['error'] = "Password tidak sama!";
        header("Location: pages/register_form.php");
        exit();
    }

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' LIMIT 1");

    if (mysqli_num_rows($check) > 0) {
        $_SESSION['error'] = "Email sudah terdaftar!";
        header("Location: pages/register_form.php");
        exit();
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, email, password, role) VALUES ('$name', '$email', '$hashed', 'user')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
    } else {
        $_SESSION['error'] = "Gagal registrasi: " . mysqli_error($conn);
    }

    header("Location: pages/login_form.php");
    exit();
}
?>