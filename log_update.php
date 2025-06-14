<?php
// Assuming you have a database connection established
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_eds";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user ID from the AJAX request
$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['userId'];

// Your SQL query to update the user's data in the database
// Replace 'your_table', 'column_name', and 'new_value' with your actual values
$query = "UPDATE user SET status = 'Offline' WHERE user_id = $userId";

// Execute the query
$result = $conn->query($query);

// Send a response back to the JavaScript
if ($result) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $conn->error]);
}

// Close the database connection
$conn->close();
?>
