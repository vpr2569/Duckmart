<?php
session_start();
require_once "db.php";

$error ="";
$success ="";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = trim($_POST["first_name"] ?? "");
    $last_name = trim($_POST["last_name"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";


// Check that all fields are completed 
if (
    $first_name === "" ||
    $last_name === "" ||
    $username === "" ||
    $password === "" ||
    $confirm_password === "" 
) {
    $error = "Please complete all fields.";
} elseif (strlen($password) < 8) {
    $error = "Password must be at least 8 characters.";
} elseif ($password !== $confirm_password) {
    $error = "Passwords do not match.";
} else {
    // Check whether the username already exists
    $check = $conn->prepare(
        "SELECT id FROM proj3users WHERE username = ?"
    );

    $check->bind_param("s", $username);
    $check->execute();

    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $error = "That username is already taken.";
    } else {
        // Securely hashing the password
        $password_hash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        // Insert the new customer into MySQL
        $sql = "INSERT INTO proj3users
        (username, password_hash, first_name, last_name)
        VALUES (?,?,?,?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            error_log("Registration error: " . $conn->error);
            $error = "Unable to create your account right now.";
        } else {
            $stmt->bind_param(
                "ssss",
                $username,
                $password_hash,
                $first_name,
                $last_name
            );

            if($stmt->execute()) {
                header("Location: login.html?registered=1");
                exit();
            } else {
                error_log("Registration error: " . $stmt->error);
                $error = "Registration failed. Please try again.";
            }

            $stmt->close();
        }
    }

    $check->close();
}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - DuckMart Grocery</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <div class="logo">
        🦆
        <span>DuckMart<br>Grocery</span>
    </div>
</header>

<main class="login-container">
    <h1>Create Account</h1>

    <p class="welcome">Join DuckMart Grocery!</p>

    <?php if ($error !== ""): ?>
        <p style="color:red;">
            <?php echo htmlspecialchars($error); ?>
        </p>

    <?php endif; ?>
    <form action="register.php" method="POST">
        <label for="first_name">First Name</label>

        <input
            type="text"
            id="first_name"
            name="first_name"
            placeholder="Enter your first name"
            required
        >

        <label for="last_name">Last Name</label>

        <input
            type="text"
            id="last_name"
            name="last_name"
            placeholder="Enter your last name"
            required
        >

        <label for="username">Username</label>

        <input
            type="text"
            id="username"
            name="username"
            placeholder="Create a username"
            required
        >

        <label for="password">Password</label>

        <input
            type="password"
            id="password"
            name="password"
            placeholder="Create a password"
            minlength="8"
            required
        >

        <label for="confirm_password">Confirm Password</label>

        <input
            type="password"
            id="confirm_password"
            name="confirm_password"
            placeholder="Confirm your password"
            minlength="8"
            required
        >

        <button type="submit">
            Create Account
        </button>

    </form>

    <p class="register">
        Already have an account?
        <a href="login.html">Log In</a>
    </p>
    
    </main>


</body>
</html>