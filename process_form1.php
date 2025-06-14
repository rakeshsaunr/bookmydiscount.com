<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Fetch the next available ID from the user table
    $sql_id = "SELECT MAX(id) + 1 AS next_id FROM user";
    $result_id = $conn->query($sql_id);

    if ($result_id->num_rows > 0) {
        $row_id = $result_id->fetch_assoc();
        $nextId = $row_id["next_id"];
    } else {
        $nextId = 1;
    }

    // Get form data
    $employee_name = $_POST['Employee_name'];
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

    // Prepare and execute SQL query to insert data into the database
    $sql = "INSERT INTO employee_form1 (employee_code, employee_name, email, father_name, date_of_birth, gender, phone1, phone2, local_address, permanent_address, nationality, marital_status, pan_number, aadhar_number) 
            VALUES ('$nextId', '$employee_name', '$email', '$father_name', '$date_of_birth', '$gender', '$phone1', '$phone2', '$local_address', '$permanent_address', '$nationality', '$marital_status', '$pan_number', '$aadhar_number')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}

// Redirect back to the form page after submitting
header("Location: index.html");
exit();
?>
