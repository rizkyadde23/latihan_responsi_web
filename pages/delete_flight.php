<?php
include '../auth.php';
include '../connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

$delete = mysqli_query($conn, "DELETE FROM flights WHERE id = $id");

if ($delete) {
    header("Location: index.php");
    exit;
} else {
    echo "Failed to delete flight.";
}