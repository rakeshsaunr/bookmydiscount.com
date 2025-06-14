<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Tracker</title>
     <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:gray;
        }

        .notification {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            position: fixed;
            top: 50px;
            left: 0;
            width: 150%;
            transition: top 0.5s ease-in-out;
            border-radius:px;
        }

        .notification.show {
            top: 100%;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            background-color: #fff;
            padding: 40px;
            box-shadow: 0 10px 10px rgba(2, 3, 4, 5.7);
            border: lightgray;
            border-radius: 50px;
        }

        .form-row {
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="date"] {
            width: 50%;
            color: blue;
            padding: 4px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid blue;
            border-radius: 5px;
            font-size: 16px;
            background: skyblue;

        }

        input[type="submit"] {
            background-color: red;
            color: white;
            margin-top: 40px;
            padding: 10px 15px;
            border-radius: 40px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: blue;
        }
    </style>
</head>
<body>

<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eds_erp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch ID values from the "user" table
$result = $conn->query("SELECT id FROM user");

$ids = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $ids[] = $row["id"];
    }
}

// Set default value of $employeeID to session UID
$employeeID = isset($_SESSION['UID']) ? $_SESSION['UID'] : '';

?>

<div class="notification">
    <?php
    // Check if the form is submitted and display error message if needed
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // You need to check if $resultCheck exists before using it
        if (isset($resultCheck) && $resultCheck->num_rows > 0) {
            echo 'Error: Record already exists for Employee ID ' . $employeeID . ' on ' . $date . '.';
        }
    }
    ?>
</div>

<div class="container">
    <h2>Attendance Form</h2>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-row">
            <label for="employeeID">Employee ID:</label>
            <input type="text" id="employeeID" name="employeeID" value="<?php echo $employeeID; ?>" readonly required>
        </div>

        <div class="form-row">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
        </div>

        <label for="reporting">Reporting:</label>
        <input type="text" id="reporting" name="reporting" value="Shubham Kotnala" readonly><br>

        <input type="submit" value="Submit">
    </form>
</div>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeID = $_POST["employeeID"];
    $date = $_POST["date"];
    $reporting = $_POST["reporting"];
    $day = date('l', strtotime($date)); // Get the day name from the date

    // Check if the record already exists
    $checkQuery = "SELECT * FROM attendance WHERE EmployeeID = '$employeeID' AND from_date = '$date'";
    $resultCheck = $conn->query($checkQuery);

    if ($resultCheck->num_rows > 0) {
        echo "Error: Record already exists for Employee ID $employeeID on $date.";
    } else {
        // Insert data into the table with a default status of "Present"
        $sql = "INSERT INTO attendance (EmployeeID, Day, Reporting, from_date, to_date, Action , Status) 
                VALUES ('$employeeID', '$day', '$reporting', '$date', '$date','Pending', 'Present')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Present Submit successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>


</body>
</html>
