<?php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $customer_name = $_POST['customer_name'] ?? '';
    $booking_date = $_POST['booking_date'] ?? '';
    $service_id = $_POST['service_id'] ?? '';
    $payment_amount = $_POST['payment_amount'] ?? '';
    $payment_mode = $_POST['payment_mode'] ?? '';

    // Basic validation
    if (!$customer_name || !$booking_date || !$service_id || !$payment_amount || !$payment_mode) {
        $message = "All fields are required!";
    } else {
        // Here you would typically store the booking details in a database or process the payment
        // For now, we just show a success message
        $message = "Booking successful for $customer_name on $booking_date. Payment mode: $payment_mode. Amount: ₹$payment_amount.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden; /* Hide scrollbars */
            background: linear-gradient(to bottom right, #2196f3, #e91e63);
        }
        canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; /* Behind other content */
        }
        .container {
            position: relative;
            max-width: 600px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.95); /* Slightly transparent */
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            z-index: 1; /* Above the canvas */
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input, select {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        button {
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <canvas id="backgroundCanvas"></canvas>

    <div class="container">
        <h2>Quick Booking</h2>
        
        <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>

        <form method="POST" action="">
            <label for="customer_name">Customer Name</label>
            <input type="text" id="customer_name" name="customer_name" required>

            <label for="booking_date">Booking Date</label>
            <input type="date" id="booking_date" name="booking_date" required>

            <label for="service_id">Service</label>
            <select id="service_id" name="service_id" required onchange="updatePaymentAmount()">
                <option value="">Select a Service</option>
                <option value="1" data-price="100">Service A - $100</option>
                <option value="2" data-price="200">Service B - $200</option>
                <option value="3" data-price="300">Service C - $300</option>
            </select>

            <label for="payment_amount">Payment Amount</label>
            <input type="number" id="payment_amount" name="payment_amount" readonly required>

            <label for="payment_mode">Payment Mode</label>
            <select id="payment_mode" name="payment_mode" required>
                <option value="online">Online Payment</option>
                <option value="cod">Cash on Delivery</option>
            </select>

            <button type="submit">Book Now</button>
        </form>
    </div>

    <script>
        // Update payment amount based on selected service
        function updatePaymentAmount() {
            const serviceSelect = document.getElementById('service_id');
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            const paymentAmountInput = document.getElementById('payment_amount');
            paymentAmountInput.value = price ? price : '';
        }

        const canvas = document.getElementById('backgroundCanvas');
        const ctx = canvas.getContext('2d');

        // Resize canvas to fit window
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        // Create a Circle class
        class Circle {
            constructor(x, y, size, speedX, speedY, color) {
                this.x = x;
                this.y = y;
                this.size = size;
                this.speedX = speedX;
                this.speedY = speedY;
                this.color = color;
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fillStyle = this.color;
                ctx.fill();
                ctx.closePath();
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;

                // Bounce off walls
                if (this.x + this.size > canvas.width || this.x - this.size < 0) {
                    this.speedX *= -1;
                }
                if (this.y + this.size > canvas.height || this.y - this.size < 0) {
                    this.speedY *= -1;
                }
            }
        }

        // Initialize circles
        const circles = [];
        const colors = ['rgba(255, 99, 71, 0.6)', 'rgba(0, 150, 255, 0.5)', 'rgba(75, 192, 192, 0.6)', 'rgba(255, 206, 86, 0.6)'];

        for (let i = 0; i < 30; i++) {
            const size = Math.random() * 15 + 10;
            const x = Math.random() * (canvas.width - size * 2) + size;
            const y = Math.random() * (canvas.height - size * 2) + size;
            const speedX = (Math.random() - 0.5) * 2;
            const speedY = (Math.random() - 0.5) * 2;
            const color = colors[Math.floor(Math.random() * colors.length)];
            circles.push(new Circle(x, y, size, speedX, speedY, color));
        }

        // Animation loop
        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            circles.forEach(circle => {
                circle.update();
                circle.draw();
            });

            requestAnimationFrame(animate);
        }

        animate();
    </script>
</body>
</html>
