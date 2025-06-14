<?php
session_start();

if (isset($_SESSION['UID'])) {
    include('database.inc.php');

    // Get the current timestamp for logout time
    $logoutTime = date('Y-m-d H:i:s');

    // Update user status to 'Offline' and set logout time
    $updateStatus = mysqli_query($con, "UPDATE user SET status = 'Offline', logout_time = NOW() WHERE id = " . $_SESSION['UID']);

    if (!$updateStatus) {
        die("Update query failed: " . mysqli_error($con));
    }
}

unset($_SESSION['UID']);
header('location:index.php');
die();
?>
