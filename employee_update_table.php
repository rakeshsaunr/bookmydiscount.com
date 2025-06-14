<?php
// Database connection details
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

// Fetch all stores from the database
$sql = "SELECT * FROM add_new_stores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Stores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: white;
        }
        table {
            width: 900px;
            border-collapse: collapse;
            margin: 10px 0;
            text-align: center;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #ccccff;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        h1 {
            text-align: center;
        }
        .filter-container {
            margin-bottom: 20px;
            text-align: center;
        }
        select {
            padding: 2px 2px;
            font-size: 15px;
            border-radius: 5px;
            margin-right: auto;
        }
        label {
            font-size: 20px;
            font-weight: lighter;
            font-weight: basename;
        }
    </style>
    <script>
        function filterStores() {
            const selectedValue = document.getElementById("storeFilter").value;
            const rows = document.querySelectorAll("tbody tr");
            rows.forEach(row => {
                if (selectedValue === "all" || row.dataset.storeId === selectedValue) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
</head>
<body>
    <h1>All Stores</h1>
    <div class="filter-container">
        <label for="storeFilter">Filter by Store:</label>
        <select id="storeFilter" onchange="filterStores()">
            <option value="all">All Stores</option>
            <?php
            // Reset the pointer and fetch data for the dropdown
            $result->data_seek(0); // Reset result pointer
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['store_id'] . "'>" . $row['store_id'] . " - " . $row['store_name'] . "</option>";
                }
            }
            ?>
        </select>
    </div>
    <table>
        <thead>
            <tr>
                <th>S/N</th>
                <th>Store ID</th>
                <th>Store Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Reset the pointer and fetch data for the table
            $result->data_seek(0);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr data-store-id='" . $row['store_id'] . "'>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['store_id'] . "</td>";
                    echo "<td>" . $row['store_name'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No stores available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
