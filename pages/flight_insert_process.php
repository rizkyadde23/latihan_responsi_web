<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $flight_code = $_POST['flight_code'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $depart_time = $_POST['depart_time'];
    $arrival_time = $_POST['arrival_time'];
    $price = $_POST['price'];
    $seats_total = $_POST['seats_total'];
    $seats_available = $_POST['seats_available'];

    // Insert Query
    $query = "INSERT INTO flights 
        (flight_code, origin, destination, depart_time, arrival_time, price, seats_total, seats_available, created_at)
        VALUES 
        ('$flight_code', '$origin', '$destination', '$depart_time', '$arrival_time', '$price', '$seats_total', '$seats_available', NOW())";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error inserting data: " . mysqli_error($conn);
    }
} else {
    header("Location: flight_insert.php");
    exit;
}