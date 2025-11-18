<?php
include '../auth.php';
include '../connection.php';
include '../components/navbar.php';

// Cek admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Pastikan id dikirim lewat GET
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']); // lebih aman

$query = mysqli_query($conn, "SELECT * FROM flights WHERE id = $id");

if (mysqli_num_rows($query) == 0) {
    header("Location: flight_list.php");
    exit;
}

$flight = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Flight</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Edit Flight: <?= $flight['flight_code'] ?></h4>
            </div>

            <div class="card-body">
                <form action="edit_process.php" method="POST">

                    <input type="hidden" name="id" value="<?= $flight['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Flight Code</label>
                        <input type="text" name="flight_code" value="<?= $flight['flight_code'] ?>" class="form-control"
                            required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Origin</label>
                            <input type="text" name="origin" value="<?= $flight['origin'] ?>" class="form-control"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Destination</label>
                            <input type="text" name="destination" value="<?= $flight['destination'] ?>"
                                class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Departure Time</label>
                            <input type="datetime-local" name="depart_time"
                                value="<?= date('Y-m-d\TH:i', strtotime($flight['depart_time'])) ?>"
                                class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Arrival Time</label>
                            <input type="datetime-local" name="arrival_time"
                                value="<?= date('Y-m-d\TH:i', strtotime($flight['arrival_time'])) ?>"
                                class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" name="price" value="<?= $flight['price'] ?>" class="form-control"
                                required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Seats Total</label>
                            <input type="number" name="seats_total" value="<?= $flight['seats_total'] ?>"
                                class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Seats Available</label>
                            <input type="number" name="seats_available" value="<?= $flight['seats_available'] ?>"
                                class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning">Update Flight</button>
                    <a href="index.php" class="btn btn-secondary">Back</a>

                </form>
            </div>
        </div>
    </div>

</body>

</html>