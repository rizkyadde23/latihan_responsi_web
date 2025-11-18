<?php
include '../auth.php';
include '../components/navbar.php';
include '../connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid access");
}

$user_id        = $_SESSION['user_id'];
$flight_id      = $_POST['flight_id'];
$seats_booked   = $_POST['seats_booked'];
$total_price    = $_POST['total_price'];
$passenger_name = mysqli_real_escape_string($conn, $_POST['passenger_name']);
$id_card_number = mysqli_real_escape_string($conn, $_POST['id_card_number']);

$query = "INSERT INTO bookings (user_id, flight_id, seats_booked, total_price, passenger_name, id_card_number, booked_at)
          VALUES ('$user_id', '$flight_id', '$seats_booked', '$total_price', '$passenger_name', '$id_card_number', NOW())";

if (mysqli_query($conn, $query)) {

    // Kurangi seats available
    mysqli_query($conn, "
        UPDATE flights 
        SET seats_available = seats_available - $seats_booked
        WHERE id = '$flight_id'
    ");

    header("Location: index.php");
    exit;

} else {
    die("Error booking: " . mysqli_error($conn));
}
?>