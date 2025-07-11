<?php
session_start();
include('database.inc.php');
$msg = '';

if (isset($_POST['login_submit'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $res = mysqli_query($con, $sql);
    $count = mysqli_num_rows($res);

    if ($count > 0) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['UID'] = $row['id'];

        // Update session start time and idle time on login
        $updateSessionStartTime = mysqli_query($con, "UPDATE user SET session_start_time = CURRENT_TIMESTAMP, idle_time = CURRENT_TIMESTAMP WHERE id = " . $_SESSION['UID']);

        if (!$updateSessionStartTime) {
            die("Update session start time query failed: " . mysqli_error($con));
        }

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
        die();
    } else {
        $msg = "Please enter correct login details";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Signup Form</title>

    <style>
    @import url(https://fonts.googleapis.com/css?family=Roboto:300);
    .login-page {
        width: 360px;
        padding: 8% 0 0;
        margin: auto;
    }
    .form {
        position: relative;
        z-index: 1;
        background: transparent;
        max-width: 360px;
        margin: 0 auto 100px;
        padding: 45px;
        text-align: center;
        box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
    }
    .form input {
        font-family: "Roboto", sans-serif;
        outline: 0;
        background: #f2f2f2;
        width: 100%;
        border: 0;
        margin: 0 0 15px;
        padding: 15px;
        box-sizing: border-box;
        font-size: 14px;
    }
    .form button {
        font-family: "Roboto", sans-serif;
        text-transform: uppercase;
        outline: 0;
        background: #4CAF50;
        width: 100%;
        border: 0;
        padding: 15px;
        color: #FFFFFF;
        font-size: 14px;
        -webkit-transition: all 0.3 ease;
        transition: all 0.3 ease;
        cursor: pointer;
    }
    .form button:hover, .form button:active, .form button:focus {
        background: #43A047;
    }
    .form .message {
        margin: 15px 0 0;
        color: #b3b3b3;
        font-size: 12px;
    }
    .form .message a {
        color: #4CAF50;
        text-decoration: none;
    }
    .form .register-form {
        display: none;
    }
    .container {
        position: relative;
        z-index: 1;
        max-width: 300px;
        margin: 0 auto;
    }
    .container:before, .container:after {
        content: "";
        display: block;
        clear: both;
    }
    .container .info {
        margin: 50px auto;
        text-align: center;
    }
    .container .info h1 {
        margin: 0 0 15px;
        padding: 0;
        font-size: 36px;
        font-weight: 300;
        color: #1a1a1a;
    }
    .container .info span {
        color: #4d4d4d;
        font-size: 12px;
    }
    .container .info span a {
        color: #000000;
        text-decoration: none;
    }
    .container .info span .fa {
        color: #EF3B3A;
    }
   body {
    /* Set background color if the image is not fully covering */
    background-color: #0000ff; /* Choose the color you want */

    /* Set background image */
    background-image: url('/eds_new23/dashboard.PNG');
    background-size: cover; /* Adjust as needed */
    background-repeat: no-repeat;
    background-position: center center;
}

    </style>
</head>
<body>
    <div class="login-page">
        <div class="form">
            <!-- SignUp Form -->
            <form action="" method="post" class="register-form">
                <input type="text" name="username" placeholder="name"/>
                <input type="password" name="password" placeholder="password"/>
                <input type="text" name="email"  placeholder="email address"/>
                <button type="submit" name="register_submit"> create</button>
                <p class="message">Already registered? <a href="#">Sign In</a></p>
            </form>
            
            <!-- Login Form -->
            <form action="" method="post" class="login-form">
                <input type="text" name="username" placeholder="username"/>
                <input type="password" name="password" placeholder="password"/>
                <button type="submit" name="login_submit">login</button>
                <p class="message">Not registered? <a href="#">Create an account</a></p>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>   
    <script>
        $('.message a').click(function(){
            $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
        });
    </script>
</body>
</html>
