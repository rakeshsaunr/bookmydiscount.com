<?php
session_start();
include('database.inc.php');

$msg = '';

if (isset($_POST['login_submit'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $sql = "SELECT id, username FROM user WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    $count = mysqli_num_rows($result);

    if ($count > 0) {
        // Fetch the user data
        $row = mysqli_fetch_assoc($result);

        // Store user_id and username in the session
        $_SESSION['UID'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        // Check if the user status is already 'Online'
        if ($row['status'] != 'Online') {
            // Update user status to 'Online' and last login time
            $time = time() + 10;
            $updateResult = mysqli_query($con, "UPDATE user SET status = 'Online', last_login = $time WHERE id = " . $_SESSION['UID']);

            if (!$updateResult) {
                die("Update query failed: " . mysqli_error($con));
            }
        }

        header('location:dashboard.php');
        exit();
    } else {
        $msg = "Please enter correct login details";
    }
}
?>
