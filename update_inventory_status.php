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

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Update the inventory_status in the database
    $sql = "UPDATE add_ivantory_name SET inventory_status = '$status' WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Status updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
