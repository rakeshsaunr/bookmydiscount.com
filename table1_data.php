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

// Fetch attendance data for the logged-in user
$sql = "SELECT * FROM `attendance` WHERE `EmployeeID` = ?";

// Use a prepared statement to prevent SQL injection
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$data = [];

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
