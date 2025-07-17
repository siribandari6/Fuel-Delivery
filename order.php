<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $fuel_type = $_POST['fuel_type'];
    $quantity = $_POST['quantity'];
    $delivery_address = $_POST['delivery_address'];
    $status = 'Pending';  // Initial order status

    $sql = "INSERT INTO orders (user_id, fuel_type, quantity, delivery_address, status) VALUES ('$user_id', '$fuel_type', '$quantity', '$delivery_address', '$status')";

    if (mysqli_query($conn, $sql)) {
        header("Location: user_dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>

            <h1>Place Order</h1>
        
        <nav>
            <ul>
                <li><a href="user_dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form id="orderForm" action="order.php" method="POST">
            <label for="fuel_type">Fuel Type:</label>
            <select id="fuel_type" name="fuel_type" required>
                <option value="Petrol">Petrol</option>
                <option value="Diesel">Diesel</option>
            </select>
            <label for="quantity">Quantity (liters):</label>
            <input type="number" id="quantity" name="quantity" min="1" required>
            <label for="delivery_address">Delivery Address:</label>
            <input type="text" id="delivery_address" name="delivery_address" required>
            <button type="submit" id="orderButton" disabled>Place Order</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Online Fuel Delivery</p>
    </footer>
    <script>
        $(document).ready(function() {
            function validateForm() {
                var quantity = $('#quantity').val();
                var address = $('#delivery_address').val();
                if (quantity > 0 && address.trim() !== '') {
                    $('#orderButton').prop('disabled', false);
                } else {
                    $('#orderButton').prop('disabled', true);
                }
            }

            $('#quantity, #delivery_address').on('input', validateForm);
        });
    </script>
</body>
</html>
