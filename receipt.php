<?php
// receipt.php
$booking_id = $_GET['booking_id'] ?? '';
$service_id = $_GET['service_id'] ?? '';
$amount = $_GET['amount'] ?? '';
$payment_method = $_GET['payment_method'] ?? '';
$payment_reference = $_GET['payment_reference'] ?? '';

// Display the receipt
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
</head>
<body>
    <h1>Payment Receipt</h1>
    <p>Booking ID: <?php echo htmlspecialchars($booking_id); ?></p>
    <p>Service Type: <?php echo htmlspecialchars($service_id); ?></p>
    <p>Payment Method: <?php echo htmlspecialchars($payment_method); ?></p>
    <p>Payment Reference: <?php echo htmlspecialchars($payment_reference); ?></p>
    <p>Amount Paid: ₹<?php echo htmlspecialchars($amount); ?></p>
    <p>Status: Payment Successful</p>
    <a href="home.php">Go Back to Home</a>
</body>
</html>
