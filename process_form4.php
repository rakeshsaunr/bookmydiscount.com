<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Process form data
    $user_id = $_POST["user_id"];
    $user_name = $_POST["user_name"];
    $basicSalary = $_POST["basicSalary"];
    $allowanceType = $_POST["allowanceType"];
    $allowanceAmount = $_POST["allowanceAmount"];
    $pf = $_POST["pf"];
    $pt = $_POST["pt"];
    $incomeTax = $_POST["incomeTax"];
    $totalSalary = $_POST["totalSalary"];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO employee_form4 (user_id, user_name, basic_salary, allowance_type, allowance_amount, pf, pt, income_tax, total_salary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $user_id, $user_name, $basicSalary, $allowanceType, $allowanceAmount, $pf, $pt, $incomeTax, $totalSalary);

    if ($stmt->execute()) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement and the database connection
    $stmt->close();
    $conn->close();
} else {
    // Handle the case where the form is not submitted using POST method
    echo "Form not submitted.";
}
?>
