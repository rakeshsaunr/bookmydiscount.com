<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eds_erp";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize a variable to hold the success message
$updateMessage = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $id = $_POST['id'];
    $employee_name = $_POST['employee_name'];
    $email = $_POST['email'];
    $father_name = $_POST['father_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $phone1 = $_POST['phone1'];
    $phone2 = $_POST['phone2'];
    $local_address = $_POST['local_address'];
    $permanent_address = $_POST['permanent_address'];
    $nationality = $_POST['nationality'];
    $marital_status = $_POST['marital_status'];
    $pan_number = $_POST['pan_number'];
    $aadhar_number = $_POST['aadhar_number'];
    // Add other fields as needed

    // Prepare and execute SQL query to update data in the database
    $sql = "UPDATE employee_form1 SET
            employee_name = '$employee_name',
            email = '$email',
            father_name = '$father_name',
            date_of_birth = '$date_of_birth',
            gender = '$gender',
            phone1 = '$phone1',
            phone2 = '$phone2',
            local_address = '$local_address',
            permanent_address = '$permanent_address',
            nationality = '$nationality',
            marital_status = '$marital_status',
            pan_number = '$pan_number',
            aadhar_number = '$aadhar_number'
            -- Add other fields as needed
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $updateMessage = "Data updated successfully";
    } else {
        $updateMessage = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee Data</title>
    <!-- Add your CSS link here -->
</head>
<body>

    <h2>Update Employee Data</h2>

    <?php
    // Display the success message if available
    if (!empty($updateMessage)) {
        echo "<p>{$updateMessage}</p>";
    }
    ?>

    <!-- Add your HTML form here -->

</body>
</html>
