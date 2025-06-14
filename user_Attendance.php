<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Refresh Table</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
       /* CSS for styling the attendance table */
body {
    font-family: Arial, sans-serif;
    background-color: grey;
    margin: 0;
    padding: 0;
}

#dataTable {
    margin: 20px auto;
    width: 80%;
    background-color: lightgrey;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(1, 2, 3, 4.5);
    padding: 20px;
}

h2 {
    margin-top: 0;
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th,
table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: blue;
    color: white;
}

table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tbody tr:hover {
    background-color: #f0f0f0;
}

/* Hide table initially, show after populating data */
#dataTable {
    display: none;
}

    </style>
</head>

<body>

    <!-- Add this table section after your form -->
    <div id="dataTable" style="display:none;">
        <h2> Daly Attendance </h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Day</th>
                    <th>Status</th>
                    <th>Approval</th>
                    <th>Reporting</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- Table rows will be dynamically added here -->
            </tbody>
        </table>
    </div>

    <script>
        // Function to fetch data from the server and populate the table
        function fetchDataAndPopulateTable() {
            // Using AJAX to fetch data from the server
            $.ajax({
                url: 'table1_data.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    populateTable(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data. Status:', status, 'Error:', error);
                }
            });
        }

        // Function to populate the table with fetched data
        function populateTable(data) {
            // Get the table body element
            var tableBody = $('#tableBody');

            // Clear existing rows
            tableBody.empty();

            // Iterate over the data and create rows
            data.forEach(function(row) {
                var newRow = $('<tr>');
                newRow.append('<td>' + row.ID + '</td>');
                newRow.append('<td>' + row.EmployeeID + '</td>');
                newRow.append('<td>' + row.employee_name + '</td>');
                newRow.append('<td>' + row.Day + '</td>');
                newRow.append('<td>' + row.Status + '</td>');
                newRow.append('<td>' + row.Approval + '</td>');
                newRow.append('<td>' + row.Reporting + '</td>');
                newRow.append('<td>' + row.from_date + '</td>');
                newRow.append('<td>' + row.to_date + '</td>');
                newRow.append('<td>' + row.Action + '</td>');

                // Append the new row to the table body
                tableBody.append(newRow);
            });

            // Show the table after populating data
            $('#dataTable').show();
        }

        // Call the function to fetch and populate data
        fetchDataAndPopulateTable();

        // Refresh the table every 5 seconds
        setInterval(fetchDataAndPopulateTable, 5000);
    </script>

</body>

</html>
