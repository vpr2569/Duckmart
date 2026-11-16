<?php

session_start();
require_once "db.php";

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.html");
    exit();
}

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

if ($email === "" || $password === "") {
    header("Location: login.html");
    exit();
}

$sql = "SELECT id, full_name, email, password_hash
        FROM users
        WHERE email = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify(
    $password,
    $user["password_hash"]
)) {
    session_regenerate_id(true);

    $_SESSION["user_id"] = $user["id"];
    $_SESSION["full_name"] = $user["full_name"];
    $_SESSION["email"] = $user["email"];

    header("Location: account.php");
    exit();

} else {

    echo "Incorrect email or password.";
    echo "<br><a href='login.html'>Try Again</a>";
}

$stmt->close();
$conn->close();

?>