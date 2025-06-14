<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "eds_erp"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $inventory_id = $_POST['inventory_id'];
    $payment_method = $_POST['payment_method'];

    // Get the product details
    $product_sql = "SELECT inventory_name, price FROM inventory WHERE id = '$inventory_id'";
    $product_result = $conn->query($product_sql);
    $product = $product_result->fetch_assoc();

    if ($product) {
        // Insert order into database
        $sql = "INSERT INTO orders (name, contact, address, inventory_id, payment_method) 
                VALUES ('$name', '$contact', '$address', '$inventory_id', '$payment_method')";

        if ($conn->query($sql) === TRUE) {
            echo "<h2>Order placed successfully!</h2>";
            echo "<p>Your order for '{$product['inventory_name']}' has been placed. Total: ₹{$product['price']}</p>";
            echo "<p>Payment Method: $payment_method</p>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<p>Product not found!</p>";
    }
}

$conn->close();
?>
