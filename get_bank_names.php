<?php
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

// Fetch bank names
$bankNames = [];
$sqlBankNames = "SELECT DISTINCT bank_name FROM banks"; // Replace 'banks' with your actual table name
$resultBankNames = $conn->query($sqlBankNames);

if ($resultBankNames->num_rows > 0) {
    while ($rowBankName = $resultBankNames->fetch_assoc()) {
        $bankNames[] = $rowBankName['bank_name'];
    }
}

// Close the database connection
$conn->close();

// Return JSON response
echo json_encode($bankNames);
?>
