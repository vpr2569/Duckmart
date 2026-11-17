
<?php

session_start();

if (!isset($_SESSION["customer_id"])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | DuckMart Grocery</title>
    <link rel="stylesheet" href="style.css">
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

    <h2>
        Welcome Back, <?= htmlspecialchars($_SESSION["first_name"]) ?>!
    </h2>

    <div class="dashboard-grid">

        <div class="dashboard-card">
            <h3>♙ Personal Information</h3>
            <p>Update your name, email, and phone number.</p>
        </div>

        <div class="dashboard-card">
            <h3>◎ My Addresses</h3>
            <p>Manage your delivery addresses.</p>
        </div>

        <div class="dashboard-card">
            <h3>▣ Payment Methods</h3>
            <p>Manage your payment information.</p>
        </div>

        <div class="dashboard-card">
            <h3>♧ Order History</h3>
            <p>View your previous grocery orders.</p>
        </div>

        <div class="dashboard-card">
            <h3>♡ Favorite Products</h3>
            <p>View your saved grocery items.</p>
        </div>

        <div class="dashboard-card">
            <h3>🎁 Rewards & Discounts</h3>
            <p>View coupons and loyalty rewards.</p>
        </div>

    </div>

    <p class="signout">
        <a href="logout.php">Sign Out</a>
    </p>

</main>

</body>
</html>
