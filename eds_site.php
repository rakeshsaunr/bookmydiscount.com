<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Site Title</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('/eds_erp1/shubham.PNG') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        .maintenance-message {
            text-align: center;

            padding: 20px;
            background-color: rgba(255, 255, 255, 0.7); /* Adjust the background color and transparency as needed */
            color: black;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>

    <?php
        // Check if the site is under maintenance
        $maintenance_mode = true; // Change this to false when the site is not under maintenance

        if ($maintenance_mode) {
            echo '<div class="maintenance-message">';
            echo '<h1>This site is under maintenance</h1>';
            echo '<p>We apologize for any inconvenience. Please check back later.</p>';
            echo '</div>';
            exit; 
        }
    ?>

    <!-- The rest of your HTML content goes here -->

</body>
</html>
