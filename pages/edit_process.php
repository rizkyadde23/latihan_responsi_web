<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $flight_code = $_POST['flight_code'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $depart_time = $_POST['depart_time'];
    $arrival_time = $_POST['arrival_time'];
    $price = $_POST['price'];
    $seats_total = $_POST['seats_total'];
    $seats_available = $_POST['seats_available'];

    $query = "UPDATE flights SET
                flight_code = '$flight_code',
                origin = '$origin',
                destination = '$destination',
                depart_time = '$depart_time',
                arrival_time = '$arrival_time',
                price = '$price',
                seats_total = '$seats_total',
                seats_available = '$seats_available'
              WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error updating data: " . mysqli_error($conn);
    }

} else {
    header("Location: flight_list.php");
    exit;
}