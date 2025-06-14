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
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['store_id']) && isset($_POST['store_name'])) {
    $store_id = $conn->real_escape_string(trim($_POST['store_id']));
    $store_name = $conn->real_escape_string(trim($_POST['store_name']));

    if (!empty($store_id) && !empty($store_name)) {
        $sql = "INSERT INTO add_new_stores (store_id, store_name) VALUES ('$store_id', '$store_name')";
        if ($conn->query($sql) === TRUE) {
            $message = "<p style='color: green;'>Store added successfully!</p>";
        } else {
            $message = "<p style='color: red;'>Error adding store: " . $conn->error . "</p>";
        }
    } else {
        $message = "<p style='color: red;'>Please enter both Store ID and Store Name.</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background-color: white;
        }
        form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        input[type="text"] {
            width: 100%;
            padding: 5px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: black;
            color: white;
            padding: 4px 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: red;
        }
        p {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Add New Store</h1>
    <form method="POST">
        <label for="store_id">Store ID:</label>
        <input type="text" id="store_id" name="store_id" placeholder="Enter Store ID" required>
        <label for="store_name">Store Name:</label>
        <input type="text" id="store_name" name="store_name" placeholder="Enter Store Name" required>
        <input type="submit" value="Add Store">
    </form>
    <?php if (!empty($message)) echo $message; ?>
</body>
</html>
