
<?php
session_start();
require_once "db.php";

$message = "";

if (isset($_SESSION["customer_id"])) {
    header("Location: myaccount.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if (empty($username) || empty($password)) {

        $message = "Please enter your username and password.";

    } else {

        $sql = "SELECT * FROM customers
                WHERE username = ? OR email = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([$username, $username]);

        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if (
            $customer &&
            password_verify($password, $customer["password_hash"])
        ) {

            session_regenerate_id(true);

            $_SESSION["customer_id"] = $customer["id"];
            $_SESSION["first_name"] = $customer["first_name"];
            $_SESSION["last_name"] = $customer["last_name"];
            $_SESSION["email"] = $customer["email"];

            header("Location: myaccount.php");
            exit();

        } else {

            $message = "Incorrect username or password.";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Log In | DuckMart Grocery</title>

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
    <h2>Welcome Back!</h2>

    <p class="welcome">
        Log in to access your DuckMart account.
    </p>

    <?php if ($message !== ""): ?>
        <p class="message">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="login.php"
          onsubmit="return validateLogin()">

        <div class="form-group">
            <label for="username">
                Username or Email Address
            </label>

            <input type="text" id="username"
                   name="username" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>

            <input type="password" id="password"
                   name="password" required>
        </div>

        <button type="submit" class="auth-button">
            Log In
        </button>

    </form>

    <p class="account-link">
        Don't have an account?
        <a href="register.php">Create an Account</a>
    </p>

</main>

</body>
</html>
