<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Products</title>
</head>

<body>


    <ul class="top-bar">
        <img src="../assets/duck-logo.png" alt="DuckMart duck" width="120">
        <li>
            <h3 class="accent-text">DuckMart <br>Grocery</h3>
        </li>
        <img src="../assets/green_profile.png" alt="account-icon" width="120"
            style="margin-left:auto; margin-right: 15px;">
        <li style=" padding-right: 30px; font-size: 20px; padding-top: 15px;">
            <p class="accent-text">My Account</p>
        </li>

    </ul>

    <nav>


        <li><a href="#Dashboard" class="nav-link">Dashboard</a></li>
        <li><a href="/admin/edit_products.php"class="nav-link">Edit Products</a></li>
        <li><a href="#Manage Orders" class="nav-link">Manage Orders</a></li>
        <li><a href="#Customers" class="nav-link">Manage Customers</a></li>
    </nav>
    <br>
    <hr>

    <p id="if-not-started">Select a product to begin editing...</p>




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

        #if-not-started {
            color: #64a668;
            font-size: clamp(1.5rem, 3vw, 2.5rem);
            padding-left: 25px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 30px;
            padding: 25px;

        }

        .product-card {
            border: 2px solid #64a668;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            color: #64a668;
        }

        .product-card img {
            width: 100%;
            height: 220px;
            object-fit: contain;


        }

        .product-card h3 {
            font-size: 1.5rem;
        }



        .product-card :hover img {
            transform: scale(1.05);
        }

        .edit-form {
            max-width: 450px;
            margin-left: 90px;
            margin-bottom: 0px;
            padding-bottom: 25px;
            border-radius: 20px;
            display: grid;
            gap: 12px;
            font-size: 1rem;

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
            margin: 0 0 0 90px;
            animation: pulse-size 2s ease-in-out infinite alternate;
        }
    </style>


    <?php

    // Elijah Goglin
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
    $noEffect = false;
    $inputError = false;


    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        if (filter_var($_GET['product_id'], FILTER_VALIDATE_INT) !== false) {
            if ($_GET['product_id'] > 0) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $name = trim($_POST['name'] ?? '');
                    $price = $_POST['price'] ?? '';
                    $stock = $_POST['stock'] ?? '';




                    if ($name !== '' && is_numeric($price) && $price >= 0 && filter_var($stock, FILTER_VALIDATE_INT) !== false && $stock >= 0) {
                        $sql_update = "UPDATE Products SET name = ?, price = ?, stock= ? WHERE product_id=?";
                        $sql_update_stmt = mysqli_prepare($conn, $sql_update);

                        mysqli_stmt_bind_param($sql_update_stmt, "sdii", $name, $price, $stock, $product_id);
                        mysqli_stmt_execute($sql_update_stmt);
                        $changedRows = mysqli_stmt_affected_rows($sql_update_stmt);
                    



                        if ($changedRows == 0) {
                            $noEffect = true;
                        } elseif ($changedRows > 0) {
                            $submitted = true;
                        }
                    }

                    else {
                        $inputError = true;
                    }

                }

                $sql_id = "SELECT product_id, name, image, price, stock FROM Products WHERE product_id=?";
                
                $id_result = mysqli_prepare($conn, $sql_id);
                $stmt_bind = mysqli_stmt_bind_param($id_result, "i", $product_id);
                mysqli_stmt_execute($id_result);
                $stmt_result = mysqli_stmt_get_result($id_result);
                $row = mysqli_fetch_assoc($stmt_result);

               









    if ($row) {
        


        echo '<form method="post" class="edit-form">
                    <label>NAME: </label> 
                    <input type="text" name="name" value="' . htmlspecialchars($row['name']) . '"><br>
                    <label>PRICE: </label> <input type="text" name="price" value="' . htmlspecialchars($row['price']) . '"><br>
                    <label>STOCK: </label><input type="number" name="stock" value="' . htmlspecialchars($row['stock']) . '"><br>
                    <button type="submit" value="' . htmlspecialchars($row['product_id']) . '">Submit</button>
                    </form>
                    ';
        if ($submitted) {
            echo '<p style="color: green;" id="success-animation">Changes Saved!</p>';
        } elseif ($noEffect == true) {
            echo '<p style="color: gray; margin: 0 0 0 90px;">No changes made.</p>';
        } else if ($inputError) {
            echo '<p style="color: red; margin: 0 0 0 90px;">Invalid Input</p>';
        }
    }

    else {
        echo '<p style="color: red;">Product not found.</p>';
    }
        

            }

            else {
                echo '<p style="color: red;">Invalid Product</p>';
            }
        }

        else {
            echo '<p style="color: red;">Invalid Product</p>';
        }
    }

    $sql = "SELECT product_id, name, image, price, stock FROM Products";
    $result = mysqli_query($conn, $sql);

    echo '<div class="product-grid">';

    foreach ($result as $product) {

        echo '<div class="product-card";>';
        echo '<h3>' . htmlspecialchars($product['name']) . '<h3>';
        echo '<a href="edit_products.php?product_id=' . (int) $product['product_id'] . '">';
        echo '<img src="' . htmlspecialchars($product['image']  ?? '') . '" width="150" style="display: block; margin 0 auto;">';
        echo '</a>';
        echo '<p>Price: $' .  number_format($product['price'], 2) . '</p>';
        echo '<p style="color: green;">Quantity: ' . (int) $product['stock'] . '</p>';
        echo '</div>';

    }

    echo '</div>';

    ?>



</body>

</html>
