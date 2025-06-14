<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eds_erp";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all inventory counts grouped by store
$countQuery = "SELECT inventory_name , inventory_id , created_at ,store_id, store_name, COUNT(inventory_name) as total_inventory FROM add_ivantory_name GROUP BY store_id, store_name";
$countResult = $conn->query($countQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Count</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #ccccff;
        }
    </style>
</head>
<body>
    <h1>Inventory Count by Store</h1>

    <table>
        <tr>
            <th>Store ID</th>
            <th>Store Name</th>
            <!-- <th>Inventory ID</th> -->
            <!-- <th>Inventory Name</th> -->
            <th>Total Stock</th>
            <th>Date & Time</th>

        </tr>
        <?php
        if ($countResult->num_rows > 0) {
            while ($row = $countResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['store_id'] . "</td>";
                echo "<td>" . $row['store_name'] . "</td>";
                // echo "<td>" . $row['inventory_id'] . "</td>";
                // echo "<td>" . $row['inventory_name'] . "</td>";
                echo "<td>" . $row['total_inventory'] . "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
