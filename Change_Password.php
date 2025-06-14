<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Update Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php
// Database connection
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from the form
    $id = $_POST["id"];
    $new_password = $_POST["new_password"];

    // Validate and sanitize the input (you can add more validation as needed)

    // Hash the new password before updating in the database
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Perform the database update using prepared statements
    $sql = "UPDATE `user` SET `password` = ? WHERE `id` = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("si", $hashed_password, $id);

    // Execute the query
    if ($stmt->execute()) {
        echo "Password updated successfully!";
    } else {
        echo "Error updating password: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<h2>Password Update Form</h2>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="id">User ID:</label>
    <input type="text" name="id" required>

    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" required>

    <input type="submit" value="Update Password">
</form>

</body>
</html>
