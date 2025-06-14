<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee Data</title>
    
    <script defer src="menu2.js"></script>
    <style>
    body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background-color:grey;
}

form {
    max-width: 1100px;
    margin: 0 auto;
    background-color: lightgrey;
    padding: 30px;
    border-radius: 50px;
    box-shadow: 0 100px 100px rgba(2, 3, 4, 5.6);
    margin-top: 50px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
}

h4 {
    grid-column: span 4;
    text-align: left;
    color: blue;
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
    color:blue;
    font-weight: bold;

}

input, select {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    box-sizing: border-box;
    border-radius: 40px;
    border: solid blue 1px;
}

input[type="submit"] {
    grid-column: span 4;
    background-color: blue;
    color: white;
    padding: 10px 1px;
    border: none;
    border-radius: 40px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: red;
}


    </style>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eds_erp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the ID from the URL
$id = $_GET['id'];

// Fetch data from the database based on the ID
$sql = "SELECT * FROM employee_form1 WHERE id = $id";
$result = $conn->query($sql);

if (!$result) {
    die("Error in SQL query: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Display the form with pre-filled data for editing
    echo "<form action='update_data.php' method='post'>
            <input type='hidden' name='id' value='" . $row['id'] . "'>
            <input type='submit' value='Update'>
            <h4>Edit Employee Data</h4>
            Employee Name: <input type='text' name='employee_name' value='" . $row['employee_name'] . "' required><br>
            Email: <input type='text' name='email' value='" . $row['email'] . "' required><br>
            Father's Name: <input type='text' name='father_name' value='" . $row['father_name'] . "'><br>
            Date of Birth: <input type='date' name='date_of_birth' value='" . $row['date_of_birth'] . "'><br>
            Gender: <input type='text' name='gender' value='" . $row['gender'] . "'><br>
            Phone 1: <input type='tel' name='phone1' value='" . $row['phone1'] . "'><br>
            Phone 2: <input type='tel' name='phone2' value='" . $row['phone2'] . "'><br>
            Local Address: <input type='text' name='local_address' value='" . $row['local_address'] . "'><br>
            Permanent Address: <input type='text' name='permanent_address' value='" . $row['permanent_address'] . "'><br>
            Nationality: <input type='text' name='nationality' value='" . $row['nationality'] . "'><br>
            Marital Status: <select name='marital_status'>
                                <option value='Single' " . ($row['marital_status'] == 'Single' ? 'selected' : '') . ">Single</option>
                                <option value='Married' " . ($row['marital_status'] == 'Married' ? 'selected' : '') . ">Married</option>
                                <option value='Divorced' " . ($row['marital_status'] == 'Divorced' ? 'selected' : '') . ">Divorced</option>
                                <option value='Widowed' " . ($row['marital_status'] == 'Widowed' ? 'selected' : '') . ">Widowed</option>
                             </select><br>
            PAN Number: <input type='text' name='pan_number' value='" . $row['pan_number'] . "'><br>
            Aadhar Number: <input type='text' name='aadhar_number' value='" . $row['aadhar_number'] . "'><br>
            
          </form>";
} else {
    echo "No data found.";
}

$conn->close();
?>

<script>
    function submitAllForms() {
        var forms = document.getElementsByClassName("submit-form");

        for (var i = 0; i < forms.length; i++) {
            forms[i].submit();
        }
    }
</script>

</body>
</html>
