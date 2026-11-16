<?php
$host = "54.158.145.56";
$username = "groupD";
$password = "tDrkG%SE21U9";
$dbname = "groupD";

$conn = new mysqli (
    $host,
    $username,
    $password,
    $dbname
);

if($conn->connect_error) {
    die("Database connection failed.");
}

$conn->set_charset("utf8mb4");

?>