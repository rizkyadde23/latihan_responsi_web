<?php
include '../auth.php';
include '../connection.php';
include '../components/navbar.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?error=forbidden");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Flight</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Add New Flight</h4>
            </div>

            <div class="card-body">
                <form action="flight_insert_process.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Flight Code</label>
                        <input type="text" name="flight_code" class="form-control" required placeholder="EX: GA123">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Origin</label>
                            <input type="text" name="origin" class="form-control" required placeholder="Insert Place">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Destination</label>
                            <input type="text" name="destination" class="form-control" required
                                placeholder="Insert Place">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Departure Time</label>
                            <input type="datetime-local" name="depart_time" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Arrival Time</label>
                            <input type="datetime-local" name="arrival_time" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" required placeholder="Insert Price">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Seats Total</label>
                            <input type="number" name="seats_total" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Seats Available</label>
                            <input type="number" name="seats_available" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Add Flight</button>
                    <a href="index.php" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>

</body>

</html>