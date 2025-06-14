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

// Fetching store data for the dropdown with inventory and used stock count
$sql = "SELECT store_id, store_name, 
               COUNT(CASE WHEN Stock_use = 'Unused' THEN 1 END) AS inventory_count,
               COUNT(CASE WHEN Stock_use = 'Used' THEN 1 END) AS used_count
        FROM add_ivantory_name
        GROUP BY store_id, store_name";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your styles here -->
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }

        /* Header styling */
        h1 {
            text-align: center;
            color: #007BFF;
            margin-bottom: 20px;
        }

        /* Dropdown styling */
        label {
            margin-right: 10px;
        }

        select {
            padding: 3px;
            font-size: 14px;
            border: 1px solid red;
            border-radius: 4px;
            outline: none;
        }

        select:focus {
            border-color: #007BFF;
        }

        /* Display counts styling */
        #inventoryCountDisplay, #usedCountDisplay {
            padding: 8px;
            background-color: transparent;
            border-radius: 4px;
            margin-top: 10px;
            display: inline-block;
            width: fit-content;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 2px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color:#ccccff;
            color: black;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9ecef;
            cursor: pointer;
        }

        /* Button styling */
        button {
            padding: 3px 12px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #333;
            color: white;
        }

        button.editBtn {
            background-color: black;
            color: white;
        }

        button.saveBtn {
            background-color: black;
            color: white;
            display: none;
        }

        button.deleteBtn {
            background-color: black;
            color: white;
        }

        button:hover {
            background-color: red;
            opacity: 0.9;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
    <script type="text/javascript">
        // Function to fetch inventory details based on store selection
        function fetchInventoryData() {
            var storeId = document.getElementById('storeDropdown').value;
            $.ajax({
                url: 'fetch_inventory22.php',
                method: 'GET',
                data: { storeId: storeId },
                success: function(data) {
                    document.getElementById('inventoryTable').innerHTML = data;
                }
            });

            // Update inventory and used stock counts outside the dropdown
            var selectedStore = document.getElementById('storeDropdown');
            var inventoryCount = selectedStore.options[selectedStore.selectedIndex].getAttribute('data-inventory-count');
            var usedCount = selectedStore.options[selectedStore.selectedIndex].getAttribute('data-used-count');

            document.getElementById('inventoryCountDisplay').innerText = 'Total Stock ' + inventoryCount;
            document.getElementById('usedCountDisplay').innerText = 'Total Used : ' + usedCount;
        }

        // Function to handle the edit action
        function editInventory(id) {
            var row = document.getElementById('row_' + id);
            var cells = row.getElementsByTagName('td');
            // Enable editing for each cell
            for (var i = 1; i < cells.length; i++) {
                cells[i].contentEditable = true;
            }
            row.getElementsByClassName('editBtn')[0].style.display = 'none';
            row.getElementsByClassName('saveBtn')[0].style.display = 'inline';
        }

        // Function to save the updated data
        function saveInventory(id) {
            var row = document.getElementById('row_' + id);
            var cells = row.getElementsByTagName('td');
            var inventoryData = {
                id: id,
                inventory_id: cells[0].innerText,
                inventory_name: cells[1].innerText,
                total_stock: cells[2].innerText,
                stock_use: cells[3].innerText,
                remaining: cells[4].innerText,
                inventory_status: cells[5].innerText,
                net_payment: cells[6].innerText
            };

            $.ajax({
                url: 'update_inventory22.php',
                method: 'POST',
                data: inventoryData,
                success: function(response) {
                    alert('Inventory updated successfully');
                    // Disable editing after saving
                    for (var i = 1; i < cells.length; i++) {
                        cells[i].contentEditable = false;
                    }
                    row.getElementsByClassName('editBtn')[0].style.display = 'inline';
                    row.getElementsByClassName('saveBtn')[0].style.display = 'none';
                }
            });
        }

        // Function to delete an inventory item
        function deleteInventory(id) {
            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    url: 'delete_inventory.php',
                    method: 'POST',
                    data: { id: id },
                    success: function(response) {
                        alert('Inventory deleted successfully');
                        // Refresh the table after deletion
                        fetchInventoryData();
                    }
                });
            }
        }
    </script>
</head>
<body>
    <h1>Inventory Management</h1>

    <!-- Store Dropdown -->
    <label for="storeDropdown">Select Store:</label>
    <select id="storeDropdown" onchange="fetchInventoryData()">
        <option value="">Select Store</option>
        <?php while($row = $result->fetch_assoc()) { ?>
            <option value="<?php echo $row['store_id']; ?>" 
                    data-inventory-count="<?php echo $row['inventory_count']; ?>" 
                    data-used-count="<?php echo $row['used_count']; ?>">
                <?php echo $row['store_id'] . ' - ' . $row['store_name']; ?>
            </option>
        <?php } ?>
    </select>

    <!-- Display Inventory Counts Outside Dropdown -->
    <div id="inventoryCountDisplay" style="margin-top: 10px; font-weight: bold;"></div>
    <div id="usedCountDisplay" style="margin-top: 10px; font-weight: bold;"></div>

    <!-- Table for Inventory Data -->
    <div id="inventoryTable"></div>

</body>
</html>

<?php $conn->close(); ?>
