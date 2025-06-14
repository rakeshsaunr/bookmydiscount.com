<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Replace these variables with your actual database credentials
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

    // Retrieve form data
    $user_id = $conn->real_escape_string($_POST["user_id"]);
    $employee_name = $conn->real_escape_string($_POST["employee_name"]);
    $department = $conn->real_escape_string($_POST["department"]);
    $designation = $conn->real_escape_string($_POST["designation"]);
    $date_of_joining = $conn->real_escape_string($_POST["date_of_joining"]);
    $date_of_leaving = $conn->real_escape_string($_POST["date_of_leaving"]);
    $status = $conn->real_escape_string($_POST["status"]);

    // Retrieve bank details
    $bank_holder_name = $conn->real_escape_string($_POST["bank_holder_name"]);
    $bank_name = $conn->real_escape_string($_POST["bank_name"]);
    $bank_account_no = $conn->real_escape_string($_POST["bank_account_no"]);
    $bank_ifsc_code = $conn->real_escape_string($_POST["bank_ifsc_code"]);
    $bank_branch = $conn->real_escape_string($_POST["bank_branch"]);

    try {
        // Start a transaction
        $conn->begin_transaction();

        // Insert data into the 'employee_form3' table
        $sql_employee_form3 = "INSERT INTO employee_form3 (user_id, employee_name, department, designation, date_of_joining, date_of_leaving, status)
            VALUES ('$user_id', '$employee_name', '$department', '$designation', '$date_of_joining', '$date_of_leaving', '$status')";

        if ($conn->query($sql_employee_form3) !== TRUE) {
            throw new Exception("Error inserting employee_form3 data: " . $conn->error);
        }

        // Retrieve the last inserted employee_form3 ID
        $employee_form3_id = $conn->insert_id;

        // Insert data into the 'bank_details' table
        $sql_bank_details = "INSERT INTO bank_details (employee_form3_id, bank_holder_name, bank_name, bank_account_no, bank_ifsc_code, bank_branch)
            VALUES ('$employee_form3_id', '$bank_holder_name', '$bank_name', '$bank_account_no', '$bank_ifsc_code', '$bank_branch')";

        if ($conn->query($sql_bank_details) !== TRUE) {
            throw new Exception("Error inserting bank details: " . $conn->error);
        }

        // Commit the transaction
        $conn->commit();

        echo "Data inserted successfully.";
    } catch (Exception $e) {
        // Rollback the transaction in case of any errors
        $conn->rollback();

        echo "Transaction failed: " . $e->getMessage();
    }

    // Close the database connection
    $conn->close();
} else {
    header("Location: your_form_page.php");
    exit();
}
?>
