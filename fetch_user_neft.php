<?php
// fetch_user_neft.php

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eds_erp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {
    $user_id = $_POST["user_id"];

    // Fetch user details based on the user ID
    $sql = "SELECT ef1.*, u.*, ef3.department, ef3.designation, ef3.status 
            FROM employee_form1 ef1
            JOIN user u ON ef1.employee_code = u.id
            JOIN employee_form3 ef3 ON u.id = ef3.user_id
            WHERE u.id = $user_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $userDetails = $result->fetch_assoc();
        echo json_encode($userDetails);
    } else {
        echo json_encode(["error" => "User details not found"]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}

// Close the database connection
$conn->close();
?>