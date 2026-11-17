<?php
session_start();
require_once "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $first_name = trim($_POST["first_name"] ?? "");
    $last_name = trim($_POST["last_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    if (
        empty($first_name) ||
        empty($last_name) ||
        empty($email) ||
        empty($username) ||
        empty($password)
    ) {
        $message = "Please complete all fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";

    } elseif (strlen($password) < 8) {
        $message = "Password must be at least 8 characters.";

    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";

    } else {

        try {

            $check = $pdo->prepare(
                "SELECT id FROM customers
                 WHERE email = ? OR username = ?"
            );

            $check->execute([$email, $username]);

            if ($check->fetch()) {

                $message = "Email or username already exists.";

            } else {

                $password_hash = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                $sql = "INSERT INTO customers
                    (first_name, last_name, email,
                     username, password_hash)
                    VALUES (?, ?, ?, ?, ?)";

                $stmt = $pdo->prepare($sql);

                $stmt->execute([
                    $first_name,
                    $last_name,
                    $email,
                    $username,
                    $password_hash
                ]);

                $message = "Account created successfully! You can now log in.";

            }

        } catch (PDOException $e) {

    $message = "Database Error: " . $e->getMessage();

}
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Account | DuckMart Grocery</title>

    <link rel="stylesheet" href="style.css">
    <script src="auth.js" defer></script>
</head>

<body>

<header class="header">
    <div class="logo">
        🦆
        <span>DuckMart<br>Grocery</span>
    </div>
</header>

<main class="auth-container">

    <h1>My Account</h1>
    <h2>Create Your Account</h2>

    <p class="welcome">
        Join DuckMart Grocery today!
    </p>

    <?php if ($message !== ""): ?>
        <p class="message">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="register.php"
          onsubmit="return validateRegister()">

        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name"
                   name="first_name" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name"
                   name="last_name" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email"
                   name="email" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username"
                   name="username" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password"
                   name="password" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">
                Confirm Password
            </label>

            <input type="password" id="confirm_password"
                   name="confirm_password" required>
        </div>

        <button type="submit" class="auth-button">
            Create Account
        </button>

    </form>

    <p class="account-link">
        Already have an account?
        <a href="login.php">Log In</a>
    </p>

</main>

</body>
</html>
