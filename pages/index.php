<?php
include '../auth.php';
include '../components/navbar.php';
include '../connection.php';
// Redirect kalau belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$role = $_SESSION['role'];
$userId = $_SESSION['user_id'];

$flightsQuery = mysqli_query($conn, "
    SELECT *
    FROM flights
    ORDER BY created_at DESC
");

$userBookingsQuery = mysqli_query($conn, "
    SELECT b.id, b.seats_booked, b.total_price, b.booked_at,
           f.flight_code, f.origin, f.destination
    FROM bookings b
    JOIN flights f ON b.flight_id = f.id
    WHERE b.user_id = '$userId'
    ORDER BY b.id DESC
");

$allBookingsQuery = mysqli_query($conn, "
    SELECT 
        b.id AS booking_id,
        u.username,
        f.flight_code,
        b.passenger_name,
        f.origin,
        f.destination,
        f.depart_time,
        b.seats_booked,
        b.total_price,
        b.booked_at
    FROM bookings b
    JOIN users u ON u.id = b.user_id
    JOIN flights f ON f.id = b.flight_id
    ORDER BY b.booked_at DESC
");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-4">

        <!-- USER DASHBOARD -->
        <?php if ($role === 'user'): ?>

        <h3 class="mb-3">Available Flights</h3>

        <div class="row">
            <?php while ($f = mysqli_fetch_assoc($flightsQuery)): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?= $f['flight_code'] ?> ✈️
                        </h5>

                        <p class="card-text mb-2">
                            <strong><?= $f['origin'] ?> → <?= $f['destination'] ?></strong> <br>
                            Depart: <?= $f['depart_time'] ?> <br>
                            Arrive: <?= $f['arrival_time'] ?> <br>
                            Price: <strong>Rp<?= number_format($f['price']) ?></strong> <br>
                            Seats Left: <strong><?= $f['seats_available'] ?></strong>
                        </p>

                        <form action="confirm_booking.php" method="POST">
                            <input type="hidden" name="flight_id" value="<?= $f['id'] ?>">
                            <input type="hidden" name="price" value="<?= $f['price'] ?>">

                            <label class="form-label">Seats</label>
                            <input type="number" class="form-control mb-3" name="seats_booked" min="1"
                                max="<?= $f['seats_available'] ?>" required>

                            <button class="btn btn-primary w-100">Book Now</button>
                        </form>


                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <hr>

        <h3>Your Bookings</h3>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Flight Code</th>
                        <th>Route</th>
                        <th>Seats</th>
                        <th>Total Price</th>
                        <th>Booked At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
        $no = 1;
        while ($b = mysqli_fetch_assoc($userBookingsQuery)): 
        ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $b['flight_code'] ?></td>
                        <td><?= $b['origin'] ?> → <?= $b['destination'] ?></td>
                        <td><?= $b['seats_booked'] ?></td>
                        <td>Rp<?= number_format($b['total_price']) ?></td>
                        <td><?= $b['booked_at'] ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <?php endif; ?>

        <!-- ADMIN DASHBOARD -->
        <?php if ($role === 'admin'): ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-3">Flight List</h3>
            <a href="flight_insert.php" class="btn btn-success">
                + Add New Flight
            </a>
        </div>
        <div class="row">
            <?php while ($f = mysqli_fetch_assoc($flightsQuery)): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= $f['flight_code'] ?> ✈️</h5>
                        <p class="card-text">
                            <strong><?= $f['origin'] ?> → <?= $f['destination'] ?></strong><br>
                            Depart: <?= $f['depart_time'] ?><br>
                            Seats: <?= $f['seats_available'] ?>/<?= $f['seats_total'] ?><br>
                            Price: <strong>Rp<?= number_format($f['price']) ?></strong>
                        </p>
                        <a href="flight_edit.php?id=<?= $f['id'] ?>" class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <a href="delete_flight.php?id=<?= $f['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure want to delete this flight?')">
                            Delete
                        </a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <hr>

        <h3 class="mt-4">All Bookings</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Flight</th>
                        <th>Passenger Name</th>
                        <th>Route</th>
                        <th>Departure</th>
                        <th>Seats</th>
                        <th>Total Price</th>
                        <th>Booked At</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($allBookingsQuery)): ?>
                    <tr>
                        <td><?= $row['booking_id'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['flight_code'] ?></td>
                        <td><?= $row['passenger_name'] ?></td>
                        <td><?= $row['origin'] ?> → <?= $row['destination'] ?></td>
                        <td><?= date('H:i', strtotime($row['depart_time'])) ?></td>
                        <td><?= $row['seats_booked'] ?></td>
                        <td>Rp<?= number_format($row['total_price']) ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($row['booked_at'])) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <?php endif; ?>

    </div>

</body>

</html>