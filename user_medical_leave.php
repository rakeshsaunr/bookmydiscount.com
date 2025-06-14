<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Earned Leave</title>
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
            background-color: lightgrey;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
// Start the session
session_start();

// Check if user is logged in
if(isset($_SESSION['UID'])) {
    $employeeID = $_SESSION['UID'];
} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eds_erp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeID = $_POST["employeeID"];
    $fromDate = $_POST["fromDate"];
    $toDate = $_POST["toDate"];
    $reporting = $_POST["reporting"];
    $day = date('l', strtotime($fromDate)); // Get the day name from the date
    $approval = isset($_POST["approval"]) ? 1 : 0; // Check if the leave is approved

    // Check if the record already exists
    $checkQuery = "SELECT * FROM attendance WHERE EmployeeID = '$employeeID' AND from_date BETWEEN '$fromDate' AND '$toDate'";

    $resultCheck = $conn->query($checkQuery);

    if ($resultCheck === FALSE) {
        echo "Error: " . $conn->error;
    } else {
        if ($resultCheck->num_rows > 0) {
            echo "Error: Record already exists for Employee ID $employeeID within the selected date range.";
        } else {
            // Check leave balance
            $leaveBalanceQuery = "SELECT * FROM user WHERE id = '$employeeID'";
            $resultLeaveBalance = $conn->query($leaveBalanceQuery);

            if ($resultLeaveBalance === FALSE) {
                echo "Error: " . $conn->error;
            } else {
                if ($resultLeaveBalance->num_rows > 0) {
                    $leaveBalanceRow = $resultLeaveBalance->fetch_assoc();
                    $earnedLeaveBalance = $leaveBalanceRow["Medical_Leave"]; // Changed to Medical_Leave

                    // Calculate the number of days between fromDate and toDate
                    $fromDateObj = new DateTime($fromDate);
                    $toDateObj = new DateTime($toDate);
                    $dateDiff = $fromDateObj->diff($toDateObj)->days + 1;

                    // Add debugging lines
                    echo "Earned Leave Balance: $earnedLeaveBalance<br>";
                    echo "Requested Leave Duration: $dateDiff days<br>";

                    if ($earnedLeaveBalance >= $dateDiff) {
                        // Insert data into the table with a default status of "Present"
                        $sql = "INSERT INTO attendance (EmployeeID, from_date, to_date, Day, Reporting, Status, Approval) 
        VALUES ('$employeeID', '$fromDate', '$toDate', '$day', '$reporting', 'Medical_Leave', '$approval')";

                        // Update leave balance after leave is granted
                        $updateLeaveBalanceQuery = "UPDATE user 
                                                    SET Medical_Leave = Medical_Leave - $dateDiff 
                                                    WHERE id = '$employeeID'"; // Changed to Medical_Leave

                        if ($conn->query($sql) === TRUE && $conn->query($updateLeaveBalanceQuery) === TRUE) {
                            if ($approval == 1) {
                                echo "Record inserted successfully! Leave is approved.";
                            } else {
                                echo "Record inserted successfully! Leave is pending approval.";
                            }
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    } else {
                        echo "Error: Insufficient earned leave balance for Employee ID $employeeID.";
                    }
                } else {
                    echo "Error: Leave balance not found for Employee ID $employeeID.";
                }
            }
        }
    }
}
?>

<div class="container">
    <h2>Earned Leave</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-row">
            <label for="employeeID">Employee ID:</label>
            <input type="text" id="employeeID" name="employeeID" value="<?php echo $employeeID; ?>" readonly required>
        </div>

        <div class="form-row">
            <label for="fromDate">From Date:</label>
            <input type="date" id="fromDate" name="fromDate" required>
        </div>

        <div class="form-row">
            <label for="toDate">To Date:</label>
            <input type="date" id="toDate" name="toDate" required>
        </div>

        <label for="reporting">Reporting:</label>
        <input type="text" id="reporting" name="reporting" value="Shubham Kotnala" readonly><br>

        <div class="form-row">
            <label for="approval">Leave Approval:</label>
            <input type="checkbox" id="approval" name="approval" value="1">
        </div>

        <input type="submit" value="Submit">
    </form>
</div>

<?php
// Close the database connection
$conn->close();
?>

</body>
</html>
