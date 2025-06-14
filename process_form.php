<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "eds_erp";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $total_costs = $_POST['total_cost'];
    $total_uses = $_POST['total_use'];
    $remainings = $_POST['remaining'];
    $payments = $_POST['payment'];

    // Loop through each row of data and insert/update into database
    foreach ($total_costs as $index => $total_cost) {
        $total_use = $total_uses[$index];
        $remaining = $remainings[$index];
        $payment = $payments[$index];

        // Example query: Insert or Update
        $sql = "INSERT INTO your_table_name (total_cost, total_use, remaining, payment) 
                VALUES ('$total_cost', '$total_use', '$remaining', '$payment')
                ON DUPLICATE KEY UPDATE
                    total_cost='$total_cost',
                    total_use='$total_use',
                    remaining='$remaining',
                    payment='$payment'";

        // Execute the query
        if (!$conn->query($sql)) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    echo "Data successfully submitted!";
}

$conn->close();
?>
