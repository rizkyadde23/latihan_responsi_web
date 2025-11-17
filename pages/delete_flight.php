<?php
include '../connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM flights WHERE id='$id'";
    mysqli_query($conn, $query);
}

header("Location: index.php");
exit;