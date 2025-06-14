<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Approved Attendance Data</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: grey;
        }

        table {
            width: 90%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: 60px;
           box-shadow: 0 100px 100px rgba(2, 3, 4, 5.7);
           background-color: lightgrey;

        }

        th, td {
            border: none;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: blue;
            color: white;
        }

       form {
        width: 90%;
        margin-left: 70px;
  
    background-color: blue;
    align-items: center;
    margin-top: 20px;
    color: white;
    justify-content: space-between ;
}

label {
   
}

input[type='text'] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 40px;
    background-color: lightyellow;
}



input[type='submit']:hover {
    background-color: red;
}


        input[type=submit] {
            padding: 10px;
            background-color:red;
            color: white;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            margin-left: 55px;
        }

        input[type=submit]:hover {
            background-color: gold;
        }
    </style>
</head>
<body>

<!-- Add a form at the top for filtering -->
<form action='' method='post'>
    <label for='user_id'>User ID:</label>
    <input type='text' name='user_id' id='user_id'>
    
    <label for='user_name'>User Name:</label>
    <input type='text' name='user_name' id='user_name'>

    <input type='submit' name='filter' value='Search'>
</form>

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eds_erp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Download button for CSV
echo "<br><br>";
echo "<form action='' method='post'>";
echo "<input type='submit' name='export_csv' value='Export to CSV'>";
echo "</form>";

// Fetch only "Approved" records from the "attendance" table with employee name and id
$fetchQuery = "SELECT a.*, u.name AS user_name, u.id AS user_id
               FROM attendance a 
               JOIN user u ON a.EmployeeID = u.id
               WHERE a.Action = 'Approved'";

// Check if user_id and user_name are set for filtering
if (isset($_POST['filter'])) {
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];

    // Add conditions to the query for filtering
    if (!empty($user_id)) {
        $fetchQuery .= " AND u.id = '$user_id'";
    }

    if (!empty($user_name)) {
        $fetchQuery .= " AND u.name LIKE '%$user_name%'";
    }
}

$result = $conn->query($fetchQuery);

if ($result->num_rows > 0) {
    // Output table header
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>EmployeeID</th><th>User Name</th><th>User ID</th><th>Day</th><th>Status</th><th>Approval</th><th>Reporting</th><th>from_date</th><th>to_date</th><th>Action</th></tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['ID']}</td><td>{$row['EmployeeID']}</td><td>{$row['user_name']}</td><td>{$row['user_id']}</td><td>{$row['Day']}</td><td>{$row['Status']}</td><td>{$row['Approval']}</td><td>{$row['Reporting']}</td><td>{$row['from_date']}</td><td>{$row['to_date']}</td><td>{$row['Action']}</td></tr>";
    }

    echo "</table>";

    // Check if export button is clicked
    if (isset($_POST['export_csv'])) {
        // Output CSV headers
        header('Content-Type: csv');
        header('Content-Disposition: attachment; filename="approved_attendance_data.csv"');

        $output = fopen('php://output', 'w');

        // Output CSV data
        $header = ['ID', 'EmployeeID', 'User Name', 'User ID', 'Day', 'Status', 'Approval', 'Reporting', 'from_date', 'to_date', 'Action'];
        fputcsv($output, $header);

        // Output data
        $result = $conn->query($fetchQuery);
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }

        // Close the database connection
        fclose($output);
        $conn->close();
        exit();
    }
} else {
    echo "No approved records found.";
}

// Close the database connection
$conn->close();
?>

</body>
</html>
