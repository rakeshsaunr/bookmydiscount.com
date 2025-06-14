<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "eds_erp";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $reporting_tl = $_POST['reporting_tl']; // TL ka naam

    // Prepare and execute SQL query to insert data into the database
    $sql = "INSERT INTO user (name, username, password, team_leader_name) 
            VALUES ('$name', '$username', '$password', '$reporting_tl')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
