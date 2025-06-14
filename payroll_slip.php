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

// Fetch user data along with salary details
$query = "SELECT id, user_id, user_name, basic_salary, allowance_type, allowance_amount, pf, pt, income_tax, total_salary
          FROM employee_form4";
$result = $connection->query($query);

// Check if the query was successful
if ($result === false) {
    die("Error executing query: " . $connection->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Salary Details</title>
    <style>
        body {
            background-color: grey;
        }

        table {
            margin-top: 70px;
            margin-left: 50px;
            width: 90%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 100px 100px rgba(2, 3, 4, 5.6);
            background-color: lightgrey;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: blue;
            color: white;
        }

        .download-btn {
            padding: 8px 12px;
            cursor: pointer;
            background-color: blue;
            color: white;
            border-radius: 40px;
        }
    </style>
</head>
<body>

    <table>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>User Name</th>
            <th>Basic Salary</th>
            <th>Allowance Type</th>
            <th>Allowance Amount</th>
            <th>PF</th>
            <th>PT</th>
            <th>Income Tax</th>
            <th>Total Salary</th>
            <th>Action</th>
        </tr>

        <?php
        while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['user_id']; ?></td>
            <td><?= $row['user_name']; ?></td>
            <td><?= $row['basic_salary']; ?></td>
            <td><?= $row['allowance_type']; ?></td>
            <td><?= $row['allowance_amount']; ?></td>
            <td><?= $row['pf']; ?></td>
            <td><?= $row['pt']; ?></td>
            <td><?= $row['income_tax']; ?></td>
            <td><?= $row['total_salary']; ?></td>
            <td><button class="download-btn" onclick="downloadCSV(<?= $row['id']; ?>)">Download</button></td>
        </tr>
        <?php
        }
        ?>
    </table>

    <script>
        function downloadCSV(userId) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "download.php?id=" + userId, true);
            xhr.responseType = "blob"; // Expecting a binary response
            xhr.onload = function() {
                var blob = new Blob([xhr.response], { type: "application/octet-stream" });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "Salary_Slip_User_" + userId + ".csv";
                link.click();
            };
            xhr.send();
        }
    </script>

</body>
</html>

<?php
// Close the connection when done
$connection->close();
?>
