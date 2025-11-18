<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected payment method
    $paymentMethod = $_POST['payment_method'];

    if ($paymentMethod === 'bank_transfer') {
        // Retrieve bank transfer details
        $bankName = $_POST['bank_name'];
        $transactionId = $_POST['transaction_id'];
        $amount = $_POST['amount'];

        // Process bank transfer payment (e.g., save to database, send email notification)
        echo "<h2>Bank Transfer Payment</h2>";
        echo "<p>Thank you for your payment.</p>";
        echo "<p><strong>Bank Name:</strong> $bankName</p>";
        echo "<p><strong>Transaction ID:</strong> $transactionId</p>";
        echo "<p><strong>Amount:</strong> $amount</p>";
    } elseif ($paymentMethod === 'paypal') {
        // Retrieve PayPal details
        $payerEmail = $_POST['payer_email'];
        $amount = $_POST['amount'];

        // Process PayPal payment (e.g., save to database, call PayPal API)
        echo "<h2>PayPal Payment</h2>";
        echo "<p>Thank you for your payment.</p>";
        echo "<p><strong>Payer Email:</strong> $payerEmail</p>";
        echo "<p><strong>Amount:</strong> $amount</p>";
    } else {
        // Handle invalid payment method
        echo "<h2>Error</h2>";
        echo "<p>Invalid payment method selected.</p>";
    }
} else {
    // Handle invalid request method
    echo "<h2>Error</h2>";
    echo "<p>Invalid request.</p>";
}
?>
