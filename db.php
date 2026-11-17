<?php

$host = "54.158.145.56";
$dbname = "groupD";
$dbuser = "groupD";
$dbpass = "V6%kJ1sL8@wB";

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $dbuser,
        $dbpass
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {

    die("Database connection failed.");

}

?>