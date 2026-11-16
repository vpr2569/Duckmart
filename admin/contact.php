<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
</head>

<body>

    <ul class="top-bar">
        <img src="assets/duck-logo.png" alt="DuckMart duck" width="120">
        <li>
            <h3 class="accent-text">DuckMart <br>Grocery</h3>
        </li>
        <img src="assets/green_profile.png" alt="account-icon" width="120"
            style="margin-left:auto; margin-right: 15px;">
        <li style=" padding-right: 30px; font-size: 20px; padding-top: 15px;">
            <p class="accent-text">My Account</p>
        </li>
    </ul>

    <nav>
        <li><a href="#Home" class="nav-link">Home</a></li>
        <li><a href="#Deals" class="nav-link">Deals</a></li>
        <li><a href="#Find Store" class="nav-link">Find Store</a></li>
        <li><a href="#Order History" class="nav-link">Order History</a></li>
    </nav>
    <br>
    <hr>

    <style>
        body {
            margin: 0;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .top-bar {
            background-color: #0b4c44;
        }

        .accent-text {
            color: #a2dc90;
            font-family: 'Shrikhand';
            font-weight: 400;
        }

        nav {
            margin-top: 10px;
            padding-top: 10px;
            background-color: white;
            color: #64a668;
            display: flex;
            justify-content: space-around;
            align-items: center;
            list-style: none;
        }

        .nav-link {
            color: #64a668;
            text-decoration: none;
            font-size: clamp(1.5rem, 3vw, 2.5rem);
        }

        hr {
            background-color: #64a668;
            height: 2px
        }

        .contact-info {
            color: #64a668;
            text-align: center;
            font-size: clamp(1.2rem, 2.5vw, 2rem);
        }

        .edit-form {
            max-width: 450px;
            margin: 0 auto;
            padding-bottom: 25px;
            display: grid;
            gap: 12px;
            font-size: 1rem;
            color: #64a668;
        }

        .form-message {
            text-align: center;
        }

        footer {
            background-color: #0b4c44;
            text-align: center;
            padding: 25px;
        }

        footer a {
            color: #a2dc90;
            font-size: 1.5rem;
        }

        @keyframes pulse-size {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.15);
            }
        }

        #success-animation {
            animation: pulse-size 2s ease-in-out infinite alternate;
        }
    </style>

    <div class="contact-info">
        <p>Email Us: DuckMart@gmail.com</p>
        <p>Call Us: 570-767-6767</p>
        <p>Follow us on Facebook!<br>@DuckMart-Groceries-PA</p>
    </div>

    <hr>

    <h2 class="contact-info">Send Us a Message</h2>

    <?php

    // Set these to YOUR OWN MySQL credentials. Never commit real credentials to public GitHub.
    $host = '';
    $dbname = '';
    $dbuser = '';
    $dbpass = '';
    $conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);
    if (!$conn) {
        die('Database connection failed.');
    }

    mysqli_set_charset($conn, 'utf8mb4');

    $submitted = false;
    $inputError = false;

    $name = '';
    $email = '';
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if ($name !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) !== false && $message !== '') {
            $sql_insert = "INSERT INTO Contact_Messages (name, email, message) VALUES (?, ?, ?)";
            $sql_insert_stmt = mysqli_prepare($conn, $sql_insert);

            mysqli_stmt_bind_param($sql_insert_stmt, "sss", $name, $email, $message);
            mysqli_stmt_execute($sql_insert_stmt);
            $insertedRows = mysqli_stmt_affected_rows($sql_insert_stmt);

            if ($insertedRows > 0) {
                $submitted = true;
            } else {
                $inputError = true;
            }
        } else {
            $inputError = true;
        }
    }

    echo '<form method="post" class="edit-form">
                <label>NAME: </label>
                <input type="text" name="name" value="' . htmlspecialchars($submitted ? '' : $name) . '"><br>
                <label>EMAIL: </label>
                <input type="text" name="email" value="' . htmlspecialchars($submitted ? '' : $email) . '"><br>
                <label>MESSAGE: </label>
                <textarea name="message" rows="5">' . htmlspecialchars($submitted ? '' : $message) . '</textarea><br>
                <button type="submit">Submit</button>
                </form>
                ';

    if ($submitted) {
        echo '<p style="color: green;" id="success-animation" class="form-message">Message Sent!</p>';
    } elseif ($inputError) {
        echo '<p style="color: red;" class="form-message">Invalid Input</p>';
    }

    ?>

    <footer>
        <a href="contact.php">Contact Us</a>
    </footer>

</body>

</html>
