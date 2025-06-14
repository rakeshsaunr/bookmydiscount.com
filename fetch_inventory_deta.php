<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eds_erp";

// Check if the store_id is passed via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['store_id'])) {
    $store_id = $_POST['store_id'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to fetch inventory details based on store_id
    $sql = "SELECT inventory_name, total_stock FROM view_inventory_table WHERE store_id = $store_id LIMIT 1";
    $result = $conn->query($sql);

    // Check if any data is returned
    if ($result->num_rows > 0) {
        // Fetch the row and return the data as JSON
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        // Return an empty response if no data found
        echo json_encode([]);
    }

    // Close the connection
    $conn->close();
} else {
    // If store_id is not set or not a POST request, return an empty response
    echo json_encode([]);
}
?>
