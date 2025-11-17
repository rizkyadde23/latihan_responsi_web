<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];

            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Password salah";
        }

    } else {
        $_SESSION['error'] = "Email tidak ditemukan";
    }

    header("Location: pages/login_form.php");
    exit();
}
?>