<?php
// Connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eds_erp"; // replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $inventory_id = $_POST['inventory_id'];
    $inventory_name = $_POST['inventory_name'];
    $total_stock = $_POST['total_stock'];
    $stock_use = $_POST['stock_use'];
    $remaining = $_POST['remaining'];
    $inventory_status = $_POST['inventory_status'];
    $net_payment = $_POST['net_payment'];

    // Logic for updating Total_stock and remaining based on Stock_use
    if ($stock_use == 'Used') {
        // Set Total_stock to 0 if stock_use is "used"
        $total_stock = 0;
        $remaining = 1;  // If Total_stock is 0, remaining is also 0
    } elseif ($stock_use == 'Unused') {
        // Set Total_stock to 1 if stock_use is "unused"
        $total_stock = 1;
        $remaining = 0;  // If Total_stock is 1, remaining is also 1
    }

    // Update query
    $sql = "UPDATE add_ivantory_name
            SET inventory_id = '$inventory_id',
                inventory_name = '$inventory_name',
                Total_stock = '$total_stock',
                Stock_use = '$stock_use',
                remaining = '$remaining',
                inventory_status = '$inventory_status',
                Net_payment = '$net_payment'
            WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
