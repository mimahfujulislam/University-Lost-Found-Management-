<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "university_lost_found";

$conn = mysqli_connect(
    $servername,
    $username,
    $password,
    $dbname
);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

?>

