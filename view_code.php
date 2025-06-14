<?php
// Include database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'eds_erp';
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data into the inventory table
if (isset($_POST['submit'])) {
    $store_name = $_POST['store_name'];
    $inventory_name = $_POST['inventory_name'];
    $total_cost = $_POST['total_cost'];
    $total_use = $_POST['total_use'];
    $remaining = $_POST['remaining'];
    $payment = $_POST['payment'];

    $sql = "INSERT INTO inventory (store_name, inventory_name, total_cost, total_use, remaining, payment) 
            VALUES ('$store_name', '$inventory_name', '$total_cost', '$total_use', '$remaining', '$payment')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch data to display in the editable table
$sql = "SELECT * FROM inventory";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editable Inventory Table</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Editable Inventory Table</h2>
    
    <form method="post" action="">
        <table border="1">
            <tr>
                <th>Store Name</th>
                <th>Inventory Name</th>
                <th>Total Cost</th>
                <th>Total Use</th>
                <th>Remaining</th>
                <th>Payment</th>
                <th>Action</th>
            </tr>
            <tr>
                <td><input type="text" name="store_name" required></td>
                <td><input type="text" name="inventory_name" required></td>
                <td><input type="number" name="total_cost" step="0.01" required></td>
                <td><input type="number" name="total_use" step="0.01" value="0.00" required></td>
                <td><input type="number" name="remaining" step="0.01" value="0.00" required></td>
                <td><input type="number" name="payment" step="0.01" value="0.00" required></td>
                <td><input type="submit" name="submit" value="Insert"></td>
            </tr>
        </table>
    </form>
    
    <h3>Inventory Records</h3>
    <table border="1" id="inventoryTable">
        <thead>
            <tr>
                <th>Store Name</th>
                <th>Inventory Name</th>
                <th>Total Cost</th>
                <th>Total Use</th>
                <th>Remaining</th>
                <th>Payment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td contenteditable="true"><?php echo $row['store_name']; ?></td>
                    <td contenteditable="true"><?php echo $row['inventory_name']; ?></td>
                    <td contenteditable="true"><?php echo $row['total_cost']; ?></td>
                    <td contenteditable="true"><?php echo $row['total_use']; ?></td>
                    <td contenteditable="true"><?php echo $row['remaining']; ?></td>
                    <td contenteditable="true"><?php echo $row['payment']; ?></td>
                    <td><button class="updateBtn" data-id="<?php echo $row['id']; ?>">Update</button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        // Update button functionality
        $(".updateBtn").click(function() {
            var row = $(this).closest("tr");
            var id = $(this).data("id");
            var store_name = row.find("td:nth-child(1)").text();
            var inventory_name = row.find("td:nth-child(2)").text();
            var total_cost = row.find("td:nth-child(3)").text();
            var total_use = row.find("td:nth-child(4)").text();
            var remaining = row.find("td:nth-child(5)").text();
            var payment = row.find("td:nth-child(6)").text();

            // AJAX request to update data
            $.ajax({
                url: 'update_inventory.php',
                type: 'POST',
                data: {
                    id: id,
                    store_name: store_name,
                    inventory_name: inventory_name,
                    total_cost: total_cost,
                    total_use: total_use,
                    remaining: remaining,
                    payment: payment
                },
                success: function(response) {
                    alert("Record updated successfully");
                }
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
