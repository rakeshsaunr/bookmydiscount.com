<?php
session_start();
include('database.inc.php');

if (isset($_SESSION['UID'])) {
    $uid = $_SESSION['UID'];
    $time = time() + 10;

    // Update user status to 'Online'
    $updateStatus = mysqli_query($con, "UPDATE user SET status = 'Online' WHERE id = $uid");

    if (!$updateStatus) {
        die("Update status query failed: " . mysqli_error($con));
    }

    // Update last activity time
    $updateActivity = mysqli_query($con, "UPDATE user SET last_activity = CURRENT_TIMESTAMP WHERE id = $uid");

    if (!$updateActivity) {
        die("Update activity query failed: " . mysqli_error($con));
    }

    echo "Status and activity updated successfully.";
} else {
    echo "User not logged in.";
}
?>
