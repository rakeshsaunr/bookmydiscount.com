<?php
// fetch_user_details.php

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eds_erp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the selected user_id
$user_id = $_POST['user_id'];

// Fetch id and name from user table
$sql = "SELECT id, name FROM user WHERE id = $user_id";
$result = $conn->query($sql);

$response = array();

if ($result->num_rows > 0) {
    // Fetch the data
    $row = $result->fetch_assoc();
    $response['id'] = $row['id'];
    $response['employee_name'] = $row['name'];
} else {
    $response['id'] = '';
    $response['employee_name'] = '';
}

// Close the database connection
$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
