<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Refresh Table</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        form{
            width: 70%;
            background-color: grey;
            padding: 180px;
            margin-top: 50px;
             box-shadow: 0 100px 100px rgba(2, 3, 4, 5.6);
            
             margin-left: 50px;
        }
        h5{
            color: white;
          
        }
        body {
            background-color: white;
            font-family: Arial, sans-serif;
        }


        /* Styling for the user icon box */
        #userIconBox {
            width: 200px;
            height: 200px;
            border: 2px solid #ccc;
            border-radius: 5px;
            margin-top: -180px;
            margin-left: -85px;

            display: flex;
            justify-content: center;
            align-items: center;
            background-color:lightgrey;
            overflow: hidden;
        }

        img {
           width: 350px;
            padding: 150px;
            margin-left: -5px;
        }

        /* Styling for the first table */
        #dataTable
         {
            border: 2px solid #ccc;
            padding: 25px;
            width: 25%;
            margin-left: 865px;
            background-color: lightgrey;
            border-radius: 10px;
            margin-top: -210px;
        }


#dataTable2{
    border: 2px solid #ccc;
            
            margin-bottom: 20px;
            width: 1269px;
            
            background-color: lightgrey;
            border-radius: 5px;
            margin-top: 50px;
            margin-left: -90px;

}
        table{
            
            border-collapse: collapse;
            background-color: lightgrey;
        }
       
#dataTable3{
    border: 2px solid #ccc;
            
            margin-bottom: 20px;
            width: 500px;
            padding: 35px;
            
            background-color:lightgrey;
            border-radius: 10px;
            margin-top: -200px;
            margin-left: 190px;

}
        table{
            
            padding: 10px;
            margin-top: -20px;
            background-color: white;
            color: black;
            font-weight: bold;
        }
       




        #dataTable th,
        #dataTable td,
        
        #dataTable2 th,
        #dataTable2 td,
        #dataTable3 td,
        #dataTable3 th {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        #dataTable th,
        #dataTable2 th,
        #dataTable3 th {
            background-color: blue;
            color: white;
        }
    </style>
</head>

<body>
<form>
    <!-- User icon box with picture -->
    <div id="userIconBox">
        <img src="/eds_erp1/user2.PNG" alt="User Picture">
        
    </div>

     <div id="dataTable3">
        <h5>Professional Details</h5>
        <table border="1">
            <thead>
                <tr>
                    <th>employee_name</th>
                    <th>department</th>
                    <th>designation</th>
                    <th>date_of_joining</th>
                    <th>status</th>
                </tr>
            </thead>
            <tbody id="tableBody3">
                <!-- Table rows will be dynamically added here -->
            </tbody>
        </table>
    </div>

    <!-- Add this table section after your form -->
    <div id="dataTable">
        <h5> Balance Leave Details</h5>
        <table border="1">
            <thead>
                <tr>
                    <th>EMP Name</th>
                    <th>EL</th>
                    <th>CL</th>
                    <th>ML</th>
                    <th>WO</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- Table rows will be dynamically added here -->
            </tbody>
        </table>
    </div>

    <!-- Add the new table for employee_data1 -->
    <div id="dataTable2">
        <h5> Personal Details</h5>
        <table border="1">
            <thead>
                <tr>
                    <th>EMP_Name</th>
                    <th>Email</th>
                    <th>Father's_Name</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Local_Adss</th>
                    <th>Permanent_Adss</th>
                    <th>Nationality</th>
                    <th>Marital</th>
                </tr>
            </thead>
            <tbody id="tableBody2">
                <!-- Table rows will be dynamically added here -->
            </tbody>
        </table>
    </div>


     
</form>
    <script>
        // Function to fetch data from the server and populate the first table
        function fetchDataAndPopulateTable() {
            $.ajax({
                url: 'table3_data.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    populateTable1(data);
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        // Function to populate the first table with fetched data
        function populateTable1(data) {
            var tableBody = $('#tableBody');
            tableBody.empty(); // Clear existing rows

            // Iterate over the data and create rows
            $.each(data, function (index, row) {
                var newRow = $('<tr>');
                newRow.append('<td>' + row.name + '</td>');
                newRow.append('<td>' + row.Earned_Leave + '</td>');
                newRow.append('<td>' + row.Casual_Leave + '</td>');
                newRow.append('<td>' + row.Medical_Leave + '</td>');
                newRow.append('<td>' + row.Without_Pay + '</td>');
                tableBody.append(newRow);
            });

            // Show the table after populating data
            $('#dataTable').show();
        }

        // Function to fetch data from the server and populate the second table
        function fetchDataAndPopulateTable2() {
            $.ajax({
                url: 'table2_data.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    populateTable2(data);
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        // Function to populate the second table with fetched data
        function populateTable2(data) {
            var tableBody = $('#tableBody2');
            tableBody.empty(); // Clear existing rows

            // Iterate over the data and create rows
            $.each(data, function (index, row) {
                var newRow = $('<tr>');
                newRow.append('<td>' + row.employee_name + '</td>');
                newRow.append('<td>' + row.email + '</td>');
                newRow.append('<td>' + row.father_name + '</td>');
                newRow.append('<td>' + row.date_of_birth + '</td>');
                newRow.append('<td>' + row.gender + '</td>');
                newRow.append('<td>' + row.phone1 + '</td>');
                newRow.append('<td>' + row.local_address + '</td>');
                newRow.append('<td>' + row.permanent_address + '</td>');
                newRow.append('<td>' + row.nationality + '</td>');
                newRow.append('<td>' + row.marital_status + '</td>');
                tableBody.append(newRow);
            });

            // Show the table after populating data
            $('#dataTable2').show();
        }

 // Function to fetch data from the server and populate the third table
        function fetchDataAndPopulateTable3() {
            $.ajax({
                url: 'table4_data.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    populateTable3(data);
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        // Function to populate the third table with fetched data
        function populateTable3(data) {
            var tableBody = $('#tableBody3');
            tableBody.empty(); // Clear existing rows

            // Iterate over the data and create rows
            $.each(data, function (index, row) {
                var newRow = $('<tr>');
                newRow.append('<td>' + row.employee_name + '</td>');
                newRow.append('<td>' + row.department + '</td>');
                newRow.append('<td>' + row.designation + '</td>');
                newRow.append('<td>' + row.date_of_joining + '</td>');
                newRow.append('<td>' + row.status + '</td>');
                tableBody.append(newRow);
            });

            // Show the table after populating data
            $('#dataTable3').show();
        }

        // Call the function to fetch and populate data for the third table
        fetchDataAndPopulateTable3();

        // Set a timer to refresh the third table every 1 minute
        setInterval(fetchDataAndPopulateTable3, 60000); // 60000 milliseconds = 1 minute


        // Call the function to fetch and populate data for both tables
        fetchDataAndPopulateTable();
        fetchDataAndPopulateTable2();

        // Set a timer to refresh the tables every 1 minute
        setInterval(fetchDataAndPopulateTable, 60000); // 60000 milliseconds = 1 minute
        setInterval(fetchDataAndPopulateTable2, 60000); // 60000 milliseconds = 1 minute
    </script>

</body>

</html>
