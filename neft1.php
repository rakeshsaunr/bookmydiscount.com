<?php
// Database connection parameters
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
    // Get bank account details from the form
    $bank_name = $_POST["bank_name"];
    $account_number = $_POST["account_number"];
    $ifsc_code = $_POST["ifsc_code"];
    $bank_branch = $_POST["bank_branch"];

    // Prepare and execute SQL query
    $sql = "INSERT INTO bank_details (bank_name, account_number, ifsc_code, bank_branch)
            VALUES ('$bank_name', '$account_number', '$ifsc_code', '$bank_branch')";

    if ($conn->query($sql) === TRUE) {
        echo "Bank account details added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Fetch user IDs for dropdown
    $userIds = [];
    $sqlUserIds = "SELECT id FROM user";
    $resultUserIds = $conn->query($sqlUserIds);

    if ($resultUserIds->num_rows > 0) {
        while ($rowUserId = $resultUserIds->fetch_assoc()) {
            $userIds[] = $rowUserId['id'];
        }
    } else {
        echo "No user IDs found"; // Add this line for debugging
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Account Details Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: gray;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
$(document).ready(function () {
    $("#user_id").change(function () {
        var userId = $(this).val();

        // Make AJAX request to fetch user details
        $.ajax({
            type: "POST",
            url: "fetch_user_neft.php",
            data: { user_id: userId },
            dataType: "json",
            success: function (response) {
                // Update text boxes with fetched data
                $("#employee_name").val(response.employee_name);
                $("#email").val(response.email);
                $("#father_name").val(response.father_name);
                $("#date_of_birth").val(response.date_of_birth);
                $("#gender").val(response.gender);
                $("#permanent_address").val(response.permanent_address);
                $("#marital_status").val(response.marital_status);
                $("#pan_number").val(response.pan_number);
                $("#aadhar_number").val(response.aadhar_number);
                $("#department").val(response.department);
                $("#designation").val(response.designation);
                $("#status").val(response.status);
                alert('Data fetched successfully!'); // Add this alert for debugging
            },
            error: function (xhr, status, error) {
                console.error("Error fetching user details:", error);
            }
        });
    });

    // Form submission logic
    $("#bankForm").submit(function (event) {
        event.preventDefault();

        // Get form data
        var formData = $(this).serialize();

        // Make AJAX request to submit form data
        $.ajax({
            type: "POST",
            url: "process_form.php",
            data: formData,
            success: function (response) {
                console.log(response);
                // Handle success (e.g., display a success message)
            },
            error: function (xhr, status, error) {
                console.error("Error submitting form:", error);
                // Handle error (e.g., display an error message)
            }
        });
    });
});

    </script>

</head>

<body>

    <form id="bankForm" action="#" method="post">
        <h4>Bank Account Details</h4>

        <label for="bank_name">Bank Name:</label>
        <input type="text" id="bank_name" name="bank_name" required><br>

        <label for="account_number">Account Number:</label>
        <input type="text" id="account_number" name="account_number" required><br>

        <label for="ifsc_code">IFSC Code:</label>
        <input type="text" id="ifsc_code" name="ifsc_code" required><br>

        <label for="bank_branch">Bank Branch:</label>
        <input type="text" id="bank_branch" name="bank_branch" required><br>

        <label for="user_id">User ID:</label>
        <select name="user_id" id="user_id">
            <?php
            foreach ($userIds as $userId) {
                echo '<option value="' . $userId . '">' . $userId . '</option>';
            }
            ?>
        </select><br>

        <!-- Dynamic text boxes for user details -->
        <?php
        $userDetails = [
            "employee_name", "email", "father_name", "date_of_birth", "gender", "permanent_address",
            "marital_status", "pan_number", "aadhar_number", "department", "designation", "status"
        ];

        foreach ($userDetails as $detail) {
            echo '<label for="' . $detail . '">' . ucwords(str_replace("_", " ", $detail)) . ':</label>';
            echo '<input type="text" name="' . $detail . '" id="' . $detail . '" readonly>';
        }
        ?>

        <input type="submit" value="Submit">
    </form>

</body>

</html>
<?php } ?>
