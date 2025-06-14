<?php
session_start();
include('database.inc.php');

// Initialize the $userRole variable
$userRole = '';

if (isset($_SESSION['UID'])) {
    $userId = $_SESSION['UID'];
    $getUserDetails = mysqli_query($con, "SELECT * FROM user WHERE id = $userId");

    if ($getUserDetails) {
        $userDetails = mysqli_fetch_assoc($getUserDetails);
        $userRole = $userDetails['role'];

        $dashboardPage = '';
        if ($userRole == 'admin') {
            $dashboardPage = 'menu1.php';
        } elseif ($userRole == 'user') {
            $dashboardPage = 'employee_dashboard.php';
        } else {
            $managerRoles = ['Sandeep', 'RakeshChandra', 'AshuTyagi', 'DevenderRandhava', 'AjaySaini', 'Jitin', 'Ranisingh', 'Mukulkotnala', 'RajeshNegi', 'Shehazad', 'VikasKumar', 'AbdulRub'];
            if (in_array($userRole, $managerRoles)) {
                $dashboardPage = 'employee_dashboard_maneger.php';
            }
        }

        if (!empty($dashboardPage)) {
            $initialIframeSrc = $dashboardPage;
        } else {
            echo "Error: Dashboard page not found for user role.";
            exit();
        }
    } else {
        echo "Error fetching user details.";
        exit();
    }
} else {
    header('location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookMyDiscount</title>
    <link rel="stylesheet" type="text/css" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #dashboard {
            display: flex;
            height: 100vh;
            position: relative;
            width: 100%;
        }

        #menu {
            width: 250px;
            background-color: #1a237e; /* Changed from red to a deep blue */
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            transition: all 0.3s ease;
            overflow-y: auto;
            z-index: 1000;
        }

        #menu.active {
            left: 0;
        }

        #menu ul {
            list-style-type: none;
        }

        #menu ul li {
            padding: 12px 20px;
            position: relative;
            cursor: pointer;
            border-bottom: 1px solid #444;
        }

        #menu ul li a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 14px;
        }

        #menu ul li a i {
            margin-right: 10px;
            width: 20px;
        }

        #menu ul li:hover {
            background-color: #283593; /* Changed from #444 to a lighter blue */
        }

        #logo {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #444;
        }

        #logo img {
            max-width: 120px;
            height: auto;
        }

        #hamburgerMenu {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            background: none;
            border: none;
            color: #333;
            font-size: 24px;
            z-index: 1100;
            cursor: pointer;
        }

        iframe {
            flex: 1;
            margin-left: 250px;
            width: calc(100% - 250px);
            height: 100%;
            border: none;
            transition: all 0.3s ease;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            #hamburgerMenu {
                display: block;
            }

            #menu {
                left: -250px;
                width: 250px;
            }

            #menu.active {
                left: 0;
            }

            iframe {
                margin-left: 0;
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            #menu {
                width: 100%;
                left: -100%;
            }

            #logo img {
                max-width: 100px;
            }

            #menu ul li {
                padding: 10px 15px;
            }

            #menu ul li a {
                font-size: 13px;
            }
        }

        /* Tablet Optimization */
        @media (min-width: 769px) and (max-width: 1024px) {
            #menu {
                width: 220px;
            }

            iframe {
                margin-left: 220px;
                width: calc(100% - 220px);
            }
        }

        /* Large Screen Optimization */
        @media (min-width: 1025px) {
            #menu {
                width: 250px;
            }

            iframe {
                margin-left: 250px;
                width: calc(100% - 250px);
            }
        }
    </style>
</head>
<body>
    <button id="hamburgerMenu"><i class="fas fa-bars"></i></button>
    <div id="dashboard">
        <div id="menu">
            <div id="logo">
                <img src="image/llss.PNG" alt="Logo">
            </div>
            <ul>
                <?php
                if ($userRole === 'admin') {
                    echo '<li><a href="menu1.php" target="contentFrame"><i class="fas fa-tachometer-alt" style="color: #1a237e;"></i> Quick Deals</a></li>';
                    echo '<li><a href="www/quickbooking.php" target="contentFrame"><i class="fas fa-user-plus" style="color: #1a237e;"></i> Quick Booking</a></li>';
                } elseif ($userRole === 'user') {
                    echo '<li><a href="employee_dashboard.php" target="contentFrame"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>';
                    echo '<li><a href="update_data.php" target="contentFrame"><i class="fas fa-briefcase"></i> Update Password</a></li>';
                    echo '<li><a href="holiday.php" target="contentFrame"><i class="fas fa-file-alt"></i> Holiday Calendar</a></li>';
                }
                ?>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
        <iframe id="contentFrame" name="contentFrame" src="<?php echo $initialIframeSrc; ?>"></iframe>
    </div>
    <script>
        const hamburger = document.getElementById('hamburgerMenu');
        const menu = document.getElementById('menu');
        const contentFrame = document.getElementById('contentFrame');

        // Toggle menu
        hamburger.addEventListener('click', () => {
            menu.classList.toggle('active');
        });

        // Handle menu item clicks
        const menuLinks = document.querySelectorAll('#menu ul li a');
        menuLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                const src = event.target.closest('a').getAttribute('href');
                contentFrame.src = src;
                
                // Close menu on mobile after click
                if (window.innerWidth <= 768) {
                    menu.classList.remove('active');
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                menu.classList.remove('active');
            }
        });
    </script>
</body>
</html>
