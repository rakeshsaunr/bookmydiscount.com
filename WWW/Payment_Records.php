<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "eds_erp"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch records with error handling
$sql = "SELECT id, inventory_id, store_id, store_name, inventory_name, created_at FROM payments"; // Replace 'payments' with actual table name
$result = $conn->query($sql);

if ($result === false) {
    // If the query fails, display an error message
    echo "Error: " . $conn->error;
    exit; // Stop execution if query fails
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #ccccff;
            font-weight: bold;
            font-size: 16px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .edit-form {
            display: none;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 50%;
            margin: 20px auto;
        }

        .edit-form input {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .edit-form button {
            background-color: green;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .edit-form button:hover {
            background-color: darkgreen;
        }

        .cancel-btn {
            background-color: red;
            color: #fff;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 1rem;
            border-radius: 4px;
            border: none;
        }

        .cancel-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Payment Records</h2>

        <!-- Display Payment Records -->
        <table>
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Inventory ID</th>
                    <th>Store ID</th>
                    <th>Store Name</th>
                    <th>Inventory Name</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if query returned results
                if ($result->num_rows > 0) {
                    // Loop through the records and display them in the table
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['inventory_id']}</td>
                                <td>{$row['store_id']}</td>
                                <td>{$row['store_name']}</td>
                                <td>{$row['inventory_name']}</td>
                                <td>{$row['created_at']}</td>
                                <td><button onclick='editRecord({$row['id']}, \"{$row['inventory_id']}\", \"{$row['store_id']}\", \"{$row['store_name']}\", \"{$row['inventory_name']}\", \"{$row['created_at']}\")'>Edit</button></td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Form Popup -->
    <div class="edit-form" id="editForm">
        <h3>Edit Payment Record</h3>
        <form method="POST">
            <input type="hidden" name="id" id="editId">
            <label for="inventory_id">Inventory ID</label>
            <input type="text" name="inventory_id" id="inventory_id">
            <label for="store_id">Store ID</label>
            <input type="text" name="store_id" id="store_id">
            <label for="store_name">Store Name</label>
            <input type="text" name="store_name" id="store_name">
            <label for="inventory_name">Inventory Name</label>
            <input type="text" name="inventory_name" id="inventory_name">
            <label for="created_at">Created At</label>
            <input type="text" name="created_at" id="created_at">

            <button type="submit" name="update">Update Record</button>
            <button type="button" class="cancel-btn" onclick="closeEditForm()">Cancel</button>
        </form>
    </div>
</body>

<script>
    // Function to open the edit form with existing data
    function editRecord(id, inventory_id, store_id, store_name, inventory_name, created_at) {
        document.getElementById('editId').value = id;
        document.getElementById('inventory_id').value = inventory_id;
        document.getElementById('store_id').value = store_id;
        document.getElementById('store_name').value = store_name;
        document.getElementById('inventory_name').value = inventory_name;
        document.getElementById('created_at').value = created_at;
        
        document.getElementById('editForm').style.display = 'block';
    }

    // Function to close the edit form
    function closeEditForm() {
        document.getElementById('editForm').style.display = 'none';
    }
</script>
</html>

<?php
$conn->close();
?>
