<?php
// Replace these with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "eds_erp";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch employee_name and salary details for the specified user ID
    $query = "SELECT e.employee_name, ef.* FROM employee_form1 e 
              LEFT JOIN employee_form4 ef ON e.id = ef.id
              WHERE e.id = $userId";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Set headers for download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="Salary_Slip_User_' . $userId . '.csv"');

        // Create a file handle
        $output = fopen('php://output', 'w');

        // Company logo and name
        $companyLogo = '/eds_erp1/shubham.PNG';  // Change this to the actual path of your company logo
        $companyName = 'EDS';  // Change this to your actual company name

        // Output company logo and name
        fputcsv($output, array('Company Logo', ''));
        fputcsv($output, array('', ''));
        fputcsv($output, array('Company Name', $companyName));
        fputcsv($output, array('', ''));
        fputcsv($output, array('', ''));

        // Write headers to the CSV file
        fputcsv($output, array('Field', 'Value'));

        // Write data to the CSV file
        foreach ($row as $field => $value) {
            fputcsv($output, array($field, $value));
        }

        // Close the file handle
        fclose($output);
    } else {
        echo "Salary details not found for the specified user ID.";
    }
} else {
    echo "Invalid request. User ID not specified.";
}

// Close the connection when done
$connection->close();
?>
