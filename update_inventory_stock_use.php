<?php
// Connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eds_erp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id']) && isset($_POST['stock_use'])) {
    $id = $_POST['id'];
    $stock_use = $_POST['stock_use'];

    // Update the stock_use in the database
    $sql = "UPDATE add_ivantory_name SET Stock_use = '$stock_use' WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Stock Use updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
