<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eds_erp";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user IDs from the user table
$userIDs = array();
$query = "SELECT id FROM `user`";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $userIDs[] = $row['id'];
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get selected user ID from the form
    $userID = $_POST['userID'];

    // Get leave details from the form
    $Earned_Leave = $_POST['Earned_Leave'];
    $Casual_Leave = $_POST['Casual_Leave'];
    $Medical_Leave = $_POST['Medical_Leave'];
    $Without_Pay = $_POST['Without_Pay'];

    // Construct the update query based on user selection
    if ($userID == 'all') {
        // Update leave details for all users
        $updateQuery = "UPDATE `user` SET `Earned_Leave` = '$Earned_Leave', `Casual_Leave` = '$Casual_Leave', `Medical_Leave` = '$Medical_Leave', `Without_Pay` = '$Without_Pay'";
    } else {
        // Update leave details for a specific user
        $updateQuery = "UPDATE `user` SET `Earned_Leave` = '$Earned_Leave', `Casual_Leave` = '$Casual_Leave', `Medical_Leave` = '$Medical_Leave', `Without_Pay` = '$Without_Pay' WHERE `id` = $userID";
    }

    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo "Leave details updated successfully!";
    } else {
        echo "Error updating leave details: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Leave Details</title>
    <style>
       body {
    font-family: 'Arial', sans-serif;
    background-color: lightgrey;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    width: 80%;
}

form {
    width: 80%;
    box-sizing: border-box;
    float: left;
   
}

h2 {
    text-align: center;
    color: #333;
}

form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: -200px;
}

label {
    margin-top: 5px;
    font-weight: bold;
    display: block;
    color: blue;
    margin-left: 40px;
}

input {
    width: 20%;
    padding: 10px;
    margin-bottom: 15px;
    box-sizing: border-box;
    border: 1px solid blue;
    border-radius: 40px;
    margin-left: 400px;
    margin-top: -10px;
    background-color: lightyellow;
}

select {
    width: 20%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
    border: 1px solid red;
    border-radius: 40px;
    background-color: lightyellow;
}

input[type="submit"] {
    background-color: blue;
    color: white;
    border: none;
    border-radius: 40px;
    cursor: pointer;
    width: 100px;
    margin-left: 00px;
    
}

input[type="submit"]:hover {
    background-color: red;

}


    </style>
</head>
<body>
    <h2></h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="userID">User ID:</label>
        <select name="userID" required>
            <option value="all">All Users</option>
            <?php
            foreach ($userIDs as $id) {
                echo "<option value='$id'>$id</option>";
            }
            ?>
        </select>
        <input type="submit" value="Save">

        <label for="Earned_Leave">Earned_Leave:</label>
        <input type="text" name="Earned_Leave" required>

        <label for="Casual_Leave">Casual_Leave:</label>
        <input type="text" name="Casual_Leave" required>

        <label for="Medical_Leave">Medical_Leave:</label>
        <input type="text" name="Medical_Leave" required>

        <label for="Without_Pay">Without_Pay:</label>
        <input type="text" name="Without_Pay" required>

        
    </form>
</body>
</html>
