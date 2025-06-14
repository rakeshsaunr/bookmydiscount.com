<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "eds_erp";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle CSV upload
if (isset($_POST['upload_csv'])) {
    if ($_FILES['csv_file']['name']) {
        // Open the uploaded CSV file
        $csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');
        
        // Skip the first row if it contains headers
        fgetcsv($csvFile);
        
        // Prepare for database insertion
        $success = true;
        while (($row = fgetcsv($csvFile)) !== FALSE) {
            // Prepare values from CSV file
            $store_id = $row[0];
            $store_name = $row[1];
            $inventory_name = $row[2];
            $total_cost = $row[3];
            $total_use = $row[4];
            $remaining = $row[5];
            $payment = $row[6];

            // Insert the data into the database
            $sql = "INSERT INTO add_ivantory_name (store_id, store_name, inventory_name, total_cost, total_use, remaining, payment) 
                    VALUES ('$store_id', '$store_name', '$inventory_name', '$total_cost', '$total_use', '$remaining', '$payment')";

            if ($conn->query($sql) !== TRUE) {
                $success = false;
                echo "Error inserting data: " . $conn->error;
                break;
            }
        }
        fclose($csvFile);
        
        if ($success) {
            echo "CSV data uploaded successfully.";
        }
    } else {
        echo "Please upload a CSV file.";
    }
}

// Handle editing of inventory data
if (isset($_POST['edit_inventory'])) {
    $store_id = $_POST['store_id'];
    $store_name = $_POST['store_name'];
    $inventory_name = $_POST['inventory_name'];
    $total_cost = $_POST['total_cost'];
    $total_use = $_POST['total_use'];
    $remaining = $_POST['remaining'];
    $payment = $_POST['payment'];

    // Update SQL query to save changes
    $sql = "UPDATE add_ivantory_name 
            SET store_name = '$store_name', inventory_name = '$inventory_name', total_cost = '$total_cost', 
                total_use = '$total_use', remaining = '$remaining', payment = '$payment' 
            WHERE store_id = '$store_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Inventory updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch unique store names for dropdown
$storeNamesResult = $conn->query("SELECT DISTINCT store_name FROM add_ivantory_name");

// Filter and fetch data
$selectedStoreName = isset($_GET['store_name']) ? $_GET['store_name'] : '';
$sql = "SELECT * FROM add_ivantory_name"; // Your SQL query

// Add condition for filtering by store name
if ($selectedStoreName) {
    $sql .= " WHERE store_name = '" . $conn->real_escape_string($selectedStoreName) . "'";
}

// Execute the query and store the result
$result = $conn->query($sql);

// Handle CSV download
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    $filename = "inventory_data_" . date('Ymd') . ".csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $output = fopen('php://output', 'w');

    // Output the column headers
    fputcsv($output, ['Store ID', 'Store Name', 'Inventory Name', 'Total Cost', 'Total Use', 'Remaining', 'Payment']);

    // Fetch and output the data
    $sql = "SELECT * FROM add_ivantory_name";
    if ($selectedStoreName) {
        $sql .= " WHERE store_name = '" . $conn->real_escape_string($selectedStoreName) . "'";
    }
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, [
                $row['store_id'],
                $row['store_name'],
                $row['inventory_name'],
                $row['total_cost'],
                $row['total_use'],
                $row['remaining'],
                $row['payment']
            ]);
        }
    }

    fclose($output);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Table</title>
    <style>
        /* General body and table styling */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f7fc;
            color: #333;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5), 0 0 0 2px deepskyblue;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 5px;
            text-align: center;
            border: 1px solid #ddd;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5), 0 0 0 2px deepskyblue;
        }

        th {
            background-color: deepskyblue;
            color: white;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5), 0 0 0 2px deepskyblue;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5), 0 0 0 2px deepskyblue;
            padding: 5px;
        }

        tr:hover {
            background-color: lightblue;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5), 0 0 0 2px deepskyblue;
        }
        
        button {
            padding: 10px 15px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5), 0 0 0 2px deepskyblue;
        }

        button:hover {
            background-color:red;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5), 0 0 0 2px deepskyblue;
        }

        .view-btn {
            background-color: #28a745;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5), 0 0 0 2px deepskyblue;
        }

        .view-btn:hover {
            background-color: #218838;
        }

        form {
            margin-bottom: 20px;
            display: inline-block;
            justify-content: space-between;
            align-items: center;
        }

        select, input[type="file"], button {
            padding: 10px;
            font-size: 1rem;
            margin-right: 10px;
            border-radius: 5px;
        }

        .right-align {
            text-align: right;
            margin: 20px;
            margin-top: -0px;
        }

        /* Modal Styling */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    overflow: auto;
    margin-left: 300px;
    background: lightgray;
    
}

.modal-content {
    background-color: lightblue;
    padding: 6px;
    border-radius: 40px;
    width: 50%; /* Adjusted width for the modal */
    max-width: 700px; /* Max width to avoid it being too wide */
    /* Centering the modal vertically and horizontally */
    overflow-y: auto; /* Ensure content is scrollable if needed */
}

.modal-header, .modal-body {
    margin-bottom: 15px;
}

.modal-header {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
    text-align: center; /* Center the header text */
}

.modal-body table {
    width: 100%; /* Ensure the table takes full width */
    border-spacing: 10px; /* Spacing between cells */
}

.modal-body input {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.modal-footer {
    text-align: center; /* Center the footer content */
    width: 100%;
}

.modal-footer button {
    background-color: #dc3545;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    color: white;
    font-size: 1rem;
}

.modal-footer button:hover {
    background-color: #c82333;
}

        @media (max-width: 768px) {
            table {
                font-size: 0.9rem;
            }

            th, td {
                padding: 8px;
            }

            form {
                display: block;
                text-align: center;
            }

            select, input[type="file"], button {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>

<!-- Upload and Download Buttons -->
<div class="right-align">
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="csv_file" accept=".csv" required>
            <button type="submit" name="upload_csv">Upload</button>
        </form>
        <form method="GET" action="">
            <input type="hidden" name="export" value="csv">
            <button type="submit">Download</button>
        </form>
</div>

<!-- Table -->
<table>
    <thead>
        <tr>
            <th>Store ID</th>
            <th>Store Name</th>
            <th>Inventory Name</th>
            <th>Total Codes</th>
            <th>Used Codes</th>
            <th>Remaining Codes</th>
            <th>Close Payment</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Display rows from the database
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['store_id']}</td>
                    <td>{$row['store_name']}</td>
                    <td>{$row['inventory_name']}</td>
                    <td>{$row['total_cost']}</td>
                    <td>{$row['total_use']}</td>
                    <td>{$row['remaining']}</td>
                    <td>{$row['payment']}</td>
                    <td><button class='view-btn' data-id='{$row['store_id']}' 
                                data-store='{$row['store_name']}' 
                                data-inventory='{$row['inventory_name']}' 
                                data-cost='{$row['total_cost']}' 
                                data-use='{$row['total_use']}' 
                                data-remaining='{$row['remaining']}' 
                                data-payment='{$row['payment']}'>Update</button></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No records found</td></tr>";
        }
        ?>
    </tbody>
</table>

<!-- Modal for View Details -->
<div class="modal" id="viewModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>View Inventory Details</h2>
        </div>
        <div class="modal-body">
            <input type="hidden" id="modal-store-id">
            <table>
                <tr>
                    <td><label for="modal-store-name">Store Name:</label></td>
                    <td><input type="text" id="modal-store-name" readonly></td>
                </tr>
                <tr>
                    <td><label for="modal-inventory-name">Inventory Name:</label></td>
                    <td><input type="text" id="modal-inventory-name" readonly></td>
                </tr>
                <tr>
                    <td><label for="modal-total-cost">Total Codes:</label></td>
                    <td><input type="text" id="modal-total-cost" readonly></td>
                </tr>
                <tr>
                    <td><label for="modal-total-use">Used Codes:</label></td>
                    <td><input type="text" id="modal-total-use" readonly></td>
                </tr>
                <tr>
                    <td><label for="modal-remaining">Remaining Codes:</label></td>
                    <td><input type="text" id="modal-remaining" readonly></td>
                </tr>
                <tr>
                    <td><label for="modal-payment">Close Payment:</label></td>
                    <td><input type="text" id="modal-payment" readonly></td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeModal()">Close</button>
        </div>
    </div>
</div>


<script>
// JavaScript to handle modal view
function closeModal() {
    document.getElementById('viewModal').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.view-btn');
    const viewModal = document.getElementById('viewModal');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get data from button attributes
            const storeId = this.getAttribute('data-id');
            const storeName = this.getAttribute('data-store');
            const inventoryName = this.getAttribute('data-inventory');
            const totalCost = this.getAttribute('data-cost');
            const totalUse = this.getAttribute('data-use');
            const remaining = this.getAttribute('data-remaining');
            const payment = this.getAttribute('data-payment');

            // Populate the modal with the data
            document.getElementById('modal-store-id').value = storeId;
            document.getElementById('modal-store-name').value = storeName;
            document.getElementById('modal-inventory-name').value = inventoryName;
            document.getElementById('modal-total-cost').value = totalCost;
            document.getElementById('modal-total-use').value = totalUse;
            document.getElementById('modal-remaining').value = remaining;
            document.getElementById('modal-payment').value = payment;

            // Show the modal
            viewModal.style.display = 'block';
        });
    });
});
</script>

</body>
</html>

<?php $conn->close(); ?>
