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

    // Fetching inventory data for the selected store where the inventory_status is 'Active'
    $sql = "SELECT * FROM add_ivantory_name WHERE store_id = '$storeId' AND inventory_status = 'Active' AND Stock_use = 'Unused'";
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
                 <td>
                    <select id="stock_use_' . $row['id'] . '" onchange="updateStockUse(' . $row['id'] . ')">
                        <option value="Unused" ' . ($row['Stock_use'] == 'Unused' ? 'selected' : '') . '>Unused</option>
                        <option value="Used" ' . ($row['Stock_use'] == 'Used' ? 'selected' : '') . '>Used</option>
                    </select>
                <td>' . $row['remaining'] . '</td>
                <td>
                     <select id="status_' . $row['id'] . '" onchange="updateStatus(' . $row['id'] . ')">
                        <option value="Active" ' . ($row['inventory_status'] == 'Active' ? 'selected' : '') . '>Active</option>
                        <option value="Inactive" ' . ($row['inventory_status'] == 'Inactive' ? 'selected' : '') . '>Inactive</option>
                    </select>
                </td>
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

<script>
   function updateStockUse(id) {
    var stockUse = document.getElementById('stock_use_' + id).value;
    // Send an AJAX request to update the stock_use in the database
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_inventory_stock_use.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status == 200) {
            alert('Stock Use updated successfully');
        } else {
            alert('Failed to update Stock Use');
        }
    };
    xhr.send('id=' + id + '&stock_use=' + stockUse);
}

function updateStatus(id) {
    var status = document.getElementById('status_' + id).value;
    // Send an AJAX request to update the status in the database
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_inventory_status.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status == 200) {
            alert('Status updated successfully');
        } else {
            alert('Failed to update status');
        }
    };
    xhr.send('id=' + id + '&status=' + status);
}

</script>
