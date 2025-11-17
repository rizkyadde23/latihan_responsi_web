<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Cek apakah flight_id dikirim dari dashboard
if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['flight_id'])) {
    die("Invalid access!");
}

$flight_id = $_POST['flight_id'];
$seats_booked = $_POST['seats_booked'];
$price = $_POST['price'];

$flight = mysqli_query($conn, "SELECT * FROM flights WHERE id = '$flight_id' LIMIT 1");
$f = mysqli_fetch_assoc($flight);

if (!$f) {
    die("Flight not found.");
}

$total_price = $price * $seats_booked;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Confirm Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5" style="max-width: 600px;">

        <div class="card shadow">
            <div class="card-body">
                <h3 class="mb-3 text-center">Confirm Your Booking</h3>

                <div class="mb-3">
                    <strong>Flight:</strong> <?= $f['flight_code'] ?><br>
                    <strong>Route:</strong> <?= $f['origin'] ?> → <?= $f['destination'] ?><br>
                    <strong>Depart:</strong> <?= $f['depart_time'] ?><br>
                    <strong>Seats:</strong> <?= $seats_booked ?><br>
                    <strong>Total Price:</strong> Rp<?= number_format($total_price) ?>
                </div>

                <hr>

                <form action="booking.php" method="POST">

                    <input type="hidden" name="flight_id" value="<?= $flight_id ?>">
                    <input type="hidden" name="seats_booked" value="<?= $seats_booked ?>">
                    <input type="hidden" name="total_price" value="<?= $total_price ?>">

                    <div class="mb-3">
                        <label class="form-label">Passenger Name</label>
                        <input type="text" name="passenger_name" class="form-control" required
                            placeholder="Insert Name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ID Card Number</label>
                        <input type="text" name="id_card_number" class="form-control" required
                            placeholder="Input ID CARD Number">
                    </div>

                    <button class="btn btn-success w-100" type="submit">
                        Confirm Booking
                    </button>
                </form>

            </div>
        </div>

    </div>

</body>

</html>