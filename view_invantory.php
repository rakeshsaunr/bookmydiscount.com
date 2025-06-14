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

// Fetch data from Add_ivantory_name table
$sql = "SELECT id, inventory_id, store_id, store_name, inventory_name, created_at FROM Add_ivantory_name";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Table</title>
    <style>
        /* General body styling */
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #eef2f7;
            color: #444;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 1rem;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #ccccff;
            color: #444;
            text-transform: uppercase;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f7ff;
        }

        /* Button styling */
        button {
            padding: 3px 3px;
            background-color: black;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: red;
        }
        /* Flex container for centering buttons */
        .button-container {
            display: flex;
            justify-content: left;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
        }

        /* Popup modal styling */
        .popup-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow: hidden;
        }

        .popup-container.active {
            display: flex;
        }

        .popup-content {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: fadeIn 0.40s ease-in-out;
        }

        .popup-content h2 {
            margin-bottom: 15px;
            font-size: 1.5rem;
            color: #444;
        }

        .popup-content iframe {
            width: 100%;
            height: 400px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .close-btn {
            background-color: #FF0000;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            font-size: 0.9rem;
            cursor: pointer;
            position: absolute;
            top: 15px;
            right: 15px;
            transition: background-color 0.3s;
        }

        /* Close button styling */
        .close-btn {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: absolute; /* Position relative to the popup */
            top: 10px; /* Adjust this value for vertical positioning */
            right: 10px; /* Adjust this value for horizontal positioning */
        }

        /* Centering the close button inside the popup */
        .popup-content {
            position: relative; /* Make sure the popup content is the positioning context */
        }


        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .popup-content iframe {
                height: 300px;
            }

            button {
                padding: 2px;
                font-size: 0.8rem;
            }

            table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Button container -->
    <div class="button-container">
        <button class="open-popup-btn" onclick="openPopup('popup1')">ADD_INV</button>
        <button class="open-popup-btn" onclick="openPopup('popup2')">Payment Records</button>
        <button class="open-popup-btn" onclick="openPopup('popup3')">Open Form 3</button>
    </div>

    <!-- Popup containers -->
    <div id="popup1" class="popup-container">
        <div class="popup-content">
            <button class="close-btn" onclick="closePopup('popup1')">X</button>
            <h2 class="Add-inventory">Add Inventory</h2>
            <iframe src="view_and_add_invantory.php"></iframe>
        </div>
    </div>

    <div id="popup2" class="popup-container">
        <div class="popup-content">
            <button class="close-btn" onclick="closePopup('popup2')">X</button>
            <h2>Form 2</h2>
            <iframe src="WWW/Payment_Records.php"></iframe>
        </div>
    </div>

    <div id="popup3" class="popup-container">
        <div class="popup-content">
            <button class="close-btn" onclick="closePopup('popup3')">X</button>
            <h2>Form 3</h2>
            <iframe src="Leave_Report.php"></iframe>
        </div>
    </div>

    <!-- Inventory table -->
    <table>
        <thead>
            <tr>
                <th>S/N</th>
                <th>Inventory ID</th>
                <th>Store ID</th>
                <th>Store Name</th>
                <th>Inventory Name</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['inventory_id']}</td>
                            <td>{$row['store_id']}</td>
                            <td>{$row['store_name']}</td>
                            <td>{$row['inventory_name']}</td>
                            <td>{$row['created_at']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        // Function to open popup
        function openPopup(popupId) {
            const popup = document.getElementById(popupId);
            popup.classList.add('active');
        }

        // Function to close popup
        function closePopup(popupId) {
            const popup = document.getElementById(popupId);
            popup.classList.remove('active');
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
