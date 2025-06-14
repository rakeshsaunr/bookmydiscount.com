<?php
// Get the booking details from the query string
$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : null;
$payment_amount = isset($_GET['payment_amount']) ? $_GET['payment_amount'] : null;
$payment_mode = isset($_GET['payment_mode']) ? $_GET['payment_mode'] : null;

// If any of the parameters are missing, show an error message
if ($booking_id === null || $payment_amount === null || $payment_mode === null) {
    die("Error: Missing booking details.");
}

// Razorpay API Key (Replace with your keys)
$razorpay_key = "rzp_test_BTGNApoDiHCzn0";  // Replace with your Razorpay Key ID
$razorpay_secret = "DSkqUxk0P7lYwqtLBkm6cMct";  // Replace with your Razorpay Secret Key

// Generate Razorpay Order (Payment Link) for Online Payment
if ($payment_mode == 'online') {
    // Create an order through Razorpay API to generate a payment link
    $url = "https://api.razorpay.com/v1/orders";
    $data = array(
        "amount" => $payment_amount * 100,  // Amount in paisa (1 INR = 100 paisa)
        "currency" => "INR",
        "receipt" => "receipt_" . $booking_id,
        "payment_capture" => 1
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $razorpay_key . ":" . $razorpay_secret);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) {
        echo "Error in payment gateway setup.";
        exit();
    }

    $response_data = json_decode($response, true);
    $order_id = $response_data['id'];
    $payment_link = "https://rzp.io/rzp/2t47Bjz";  // Replace with actual payment link
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Payment Details</h2>

        <table>
            <tr>
                <th>Booking ID</th>
                <td><?php echo isset($booking_id) ? $booking_id : 'Not available'; ?></td>
            </tr>
            <tr>
                <th>Amount to Pay</th>
                <td>₹<?php echo isset($payment_amount) ? $payment_amount : 'Not available'; ?></td>
            </tr>
            <tr>
                <th>Payment Mode</th>
                <td><?php echo isset($payment_mode) ? ucfirst($payment_mode) : 'Not available'; ?></td>
            </tr>
        </table>

        <?php if ($payment_mode == 'online') { ?>
            <h3>Online Payment</h3>
            <p>Please click the link below to proceed with your online payment:</p>
            <a href="<?php echo isset($payment_link) ? $payment_link : '#'; ?>" target="_blank" class="btn">
                Pay Now via Razorpay
            </a>
        <?php } else { ?>
            <h3>Cash on Delivery</h3>
            <p>Your booking has been confirmed. You will pay the amount of ₹<?php echo isset($payment_amount) ? $payment_amount : 'Not available'; ?> upon delivery.</p>
            <p>Thank you for your booking!</p>
        <?php } ?>
    </div>
</body>
</html>
