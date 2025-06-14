<?php
// Connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eds_erp"; // replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['storeId'])) {
    $storeId = $_GET['storeId'];

    // Fetching inventory data for the selected store where the inventory_status is 'active'
    $sql = "SELECT * FROM add_ivantory_name WHERE store_id = '$storeId' AND inventory_status = 'Active'";
    $result = $conn->query($sql);

    echo '<table border="1">
            <thead>
                <tr>
                    <th>Inventory ID</th>
                    <th>Inventory Name</th>
                    <th>Total Stock</th>
                    <th>Stock Use</th>
                    <th>Remaining</th>
                    <th>Status</th>
                    <th>Net Payment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>';
   
    while($row = $result->fetch_assoc()) {
        echo '<tr id="row_' . $row['id'] . '">
                <td>' . $row['inventory_id'] . '</td>
                <td>' . $row['inventory_name'] . '</td>
                <td>' . $row['Total_stock'] . '</td>
                <td>' . $row['Stock_use'] . '</td>
                <td>' . $row['remaining'] . '</td>
                <td>' . $row['inventory_status'] . '</td>
                <td>' . $row['Net_payment'] . '</td>
                <td>
                    <button class="editBtn" onclick="editInventory(' . $row['id'] . ')">Edit</button>
                    <button class="saveBtn" style="display:none;" onclick="saveInventory(' . $row['id'] . ')">Save</button>
                    <button onclick="deleteInventory(' . $row['id'] . ')">Delete</button>
                </td>
            </tr>';
    }

    echo '</tbody>
        </table>';
}

$conn->close();
?>
