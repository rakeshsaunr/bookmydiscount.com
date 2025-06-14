<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eds_erp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['UID'])) {
    // Handle the case when the user is not logged in
    die("User not logged in");
}

$userId = $_SESSION['UID'];

// Assuming you have columns like 'employee_name', 'department', 'designation', etc. in your 'employee_form3' table
$sql = "SELECT `employee_name`, `department`, `designation`, `date_of_joining`, `status` FROM `employee_form3` WHERE `user_id` = ?";

// Use a prepared statement to prevent SQL injection
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error in preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$data = [];

if ($result === false) {
    die("Error in fetching results: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($data);

$stmt->close();
$conn->close();
?>
