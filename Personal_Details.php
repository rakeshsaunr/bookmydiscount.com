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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $store_id = $_POST['store'];
    $inventory_id = $_POST['inventory_id'];
    $inventory_name = $_POST['inventory_name'];

    // Fetch store details based on selected store_id
    $store_sql = "SELECT store_id, store_name FROM add_new_stores WHERE id = ?";
    $stmt = $conn->prepare($store_sql);
    $stmt->bind_param("i", $store_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $store_row = $result->fetch_assoc();
    $store_id_manual = $store_row['store_id'];
    $store_name = $store_row['store_name'];
    $stmt->close();

    // Insert inventory into Add_ivantory_name table
    $sql = "INSERT INTO Add_ivantory_name (store_id, store_name, inventory_id, inventory_name) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $store_id_manual, $store_name, $inventory_id, $inventory_name);

    if ($stmt->execute()) {
        $message = "Inventory added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
    $stmt->close();
}

// Fetch stores for dropdown
$sql = "SELECT id, store_id, store_name FROM add_new_stores";
$stores = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Inventory Name</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background-color: white;
        }
        form {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .form-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        label {
            flex: 1;
            margin-right: 10px;
            font-weight: bold;
        }
        select, input[type="text"] {
            flex: 2;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Add Inventory Name</h1>
    <form method="POST" action="">
        <div class="form-group">
            <label for="store">Select Store:</label>
            <select id="store" name="store" required>
                <option value="">-- Select a Store --</option>
                <?php
                if ($stores->num_rows > 0) {
                    while ($row = $stores->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['store_id'] . " - " . $row['store_name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No stores available</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="inventory_id">Inventory ID:</label>
            <input type="text" id="inventory_id" name="inventory_id" placeholder="Enter inventory ID" required>
        </div>

        <div class="form-group">
            <label for="inventory_name">Inventory Name:</label>
            <input type="text" id="inventory_name" name="inventory_name" placeholder="Enter inventory name" required>
        </div>

        <input type="submit" value="Add Inventory">
    </form>

    <?php
    if (!empty($message)) {
        echo "<p class='message'>$message</p>";
    }
    ?>
</body>
</html>

<?php
$conn->close();
?>
