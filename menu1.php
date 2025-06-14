<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Payment Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
        }

        .dashboard-header h1 {
            text-align: center;
            margin: 0;
            color: #333;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .card {
            background-color: transparent;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card p {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #333;
        }

        .bmd {
            text-align: center;
            word-spacing: 10px;
            /* Space between words */
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            margin-top: -22px;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
            /* Dark background for modal */
        }

        .modal-content {
            background-color: #fefefe;
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 0;
            padding: 0;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }


        .close {
            color: red;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        iframe {
            width: 100%;
            height: 700px;
            border: none;
        }

        /* General card styles */
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            /* justify-content: space-around; */
        }

        .card {
            background-color: #ffe6e6;
            border-radius: 10px;
            width: 90px;
            height: 90px;
            margin-bottom: -15px;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            /* Ensures the image fits within its dimensions */
            margin-bottom: -10px;
            /* Adds spacing below the image */
            border-radius: 5px;
            /* Optional: Adds slight rounding to the image corners */
            display: block;
            /* Ensures consistent rendering */
            margin-left: auto;
            /* Centers the image horizontally */
            margin-right: auto;
        }


        .card i {
            font-size: 50px;
            /* Increase icon size */
            color: #3498db;
            /* Colorful icon (you can change this to any color) */
            margin-bottom: 10px;
        }

        .card p {
            font-size: 16px;
            color: #333;
            display: block;
        }

        /* Card hover effect */
        .card:hover {
            transform: scale(1.1);
        }

        /* Mobile responsiveness: Hide text and make icons bigger */
        @media (max-width: 768px) {
            .card h5 {
                display: none;
                /* Hide text on smaller screens */
            }

            .card i {
                font-size: 70px;
                /* Make icon larger on small screens */
            }
        }

        p {
            font-size: 10px;

        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="dashboard">
        <div class="card-container">
            <div class="card" id="card1">
                <img src="image/add-store.png" width="100px" height="100px" alt="Add Store">
                <p>Add Store</p>
            </div>
            <div class="card" id="card2">
                <img src="image/view store.png" width="100px" height="100px" alt="View Store">
                <p>View Store</p>
            </div>
            <div class="card" id="card3">
                <img src="image/add inb.png" width="100px" height="100px" alt="Add Inventory Name">
                <p>Add INB</p>
            </div>
            <div class="card" id="card4">
                <img src="image/view inventory.png" width="100px" height="100px" alt="View Inventory">
                <p>View Inventory</p>
            </div>
            <div class="card" id="card5">
                <img src="image/add & view Stock.png" width="100px" height="100px" alt="Add & View Stock">
                <p>Add & View Stock</p>
            </div>
            <div class="card" id="card6">
                <img src="image/view stock.png" width="100px" height="100px" alt="View Stock">
                <p>View Stock</p>
            </div>
            <div class="card" id="card7">
                <img src="image/Add deals.png" width="100px" height="100px" alt="Add Deals">
                <p>Add Deals</p>
            </div>

        </div>



        <!-- Modal for Link View -->
        <div id="cardModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h1 id="modalTitle">My Stock</h1> <!-- Dynamically change title -->
                <iframe id="modalIframe" src=""></iframe> <!-- iframe for the external link -->
            </div>
        </div>

        <script>
            // Get modal element
            var modal = document.getElementById("cardModal");

            // Get all card elements
            var cards = document.querySelectorAll(".card");

            // Get the <span> element that closes the modal
            var closeModal = document.getElementsByClassName("close")[0];

            // Add event listeners to all cards to open the modal
            cards.forEach(function(card) {
                card.addEventListener("click", function() {
                    // Set the link to be opened in the modal based on clicked card
                    var cardId = card.id;
                    var link = "";
                    var title = ""; // Variable for modal title

                    switch (cardId) {
                        case "card1":
                            link = "menu2.php"; // Add Store link
                            title = "Add Store"; // Set modal title
                            break;
                        case "card2":
                            link = "employee_update_table.php"; // View Store link
                            title = "View Store"; // Set modal title
                            break;
                        case "card3":
                            link = "Personal_Details.php"; // Add Inventory Name link
                            title = "Add Inventory"; // Set modal title
                            break;
                        case "card4":
                            link = "view_invantory.php"; // View Inventory link
                            title = "View Inventory"; // Set modal title
                            break;
                        case "card5":
                            link = "userlogin.php"; // Add/View Stock link
                            title = "Add & View Stock"; // Set modal title
                            break;
                        case "card6":
                            link = "payroll.php"; // View Stock link
                            title = "View Stock"; // Set modal title
                            break;
                        case "card7":
                            link = "Attendance_Report.php"; // Add Deals link
                            title = "Add Deals"; // Set modal title
                            break;
                        default:
                            link = "default.html"; // Default link if no match
                            title = "My Stock"; // Set default modal title
                    }

                    // Set the iframe src to the link
                    document.getElementById("modalIframe").src = link;

                    // Change the title in the modal
                    document.getElementById("modalTitle").textContent = title;

                    // Show the modal
                    modal.style.display = "block";
                });
            });

            // When the user clicks on <span> (x), close the modal
            closeModal.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
</body>

</html>