<?php

session_start();

if(!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$name = htmlspecialchars($_SESSION["full name"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - DuckMart Grocery</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <div class="logo">
        🦆
        <span>DuckMart<br>Grocery</span>
    </div>
</header>

<main class="account-container">

    <h1>My Account</h1>
    
    <p class="welcome">
        Welcome Back, <?php echo $name; ?>!
    </p>

    <div class="account-grid">

        <div class="account-card">
            <span class="account-icon">♙</span>
            <h3>Personal Information</h3>
            <p>Update your name, email, phone number</p>
        </div>

        <div class="account-card">
            <span class="account-icon">◎</span>
            <h3>My Addresses</h3>
            <p>Manage your delivery addresses</p>
        </div>

        <div class="account-card">
            <span class="account-icon">▱</span>
            <h3>Payment Methods</h3>
            <p>Manage your payment information</p>
        </div>

        <div class="account-card">
            <span class="account-icon">♧</span>
            <h3>Order History</h3>
            <p>View your previous grocery orders</p>
        </div>

        <div class="account-card">
            <span class="account-icon">♡</span>
            <h3>Favorite Products</h3>
            <p>View your saved grocery items</p>
        </div>

        <div class="account-card">
            <span class="account-icon">♔</span>
            <h3>Rewards & Discounts</h3>
            <p>View coupons and loyalty rewards</p>
        </div>
    
    </div>  

    <form action="logout.php" method="POST">
        <button class="sign-out" type="submit">
            Sign Out
        </button>
    </form>

</main>




</body>
</html>