<?php
// Replace these with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "eds_erp";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get user name based on the selected user ID
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $userNameQuery = "SELECT name FROM user WHERE id = $userId";
    $userNameResult = $connection->query($userNameQuery);

    if ($userNameResult->num_rows > 0) {
        $userNameRow = $userNameResult->fetch_assoc();
        echo $userNameRow['name'];
    } else {
        echo "User not found";
    }
}

// Close the connection when done
$connection->close();
?>
