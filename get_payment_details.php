<?php
include('db_connect.php');

if (isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];

    // Fetch payment details by ID
    $query = "SELECT payment.payment_id, payment.total_price, payment.payment_date, payment.payment_status, 
                     payment.cust_id, customers.cust_fname, customers.cust_lname, customers.phone,
                     books.service_type, books.delivery_date
              FROM payment
              JOIN customers ON payment.cust_id = customers.cust_id
              JOIN books ON payment.cust_id = books.cust_id
              WHERE payment.payment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $payment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $payment = $result->fetch_assoc();
        
        // Display the payment details
        echo "<p><strong>Payment ID:</strong> " . $payment['payment_id'] . "</p>";
        echo "<p><strong>Customer:</strong> " . htmlspecialchars($payment['cust_fname']) . " " . htmlspecialchars($payment['cust_lname']) . "</p>";
        echo "<p><strong>Phone:</strong> " . htmlspecialchars($payment['phone']) . "</p>";
        echo "<p><strong>Amount:</strong> ₹" . number_format($payment['total_price'], 2) . "</p>";
        echo "<p><strong>Payment Date:</strong> " . date("M d, Y", strtotime($payment['payment_date'])) . "</p>";
        echo "<p><strong>Status:</strong> " . ucfirst($payment['payment_status']) . "</p>";
        echo "<p><strong>Service Type:</strong> " . htmlspecialchars($payment['service_type']) . "</p>";
        echo "<p><strong>Delivery Date:</strong> " . date("M d, Y", strtotime($payment['delivery_date'])) . "</p>";
    } else {
        echo "<p>No details found for this payment.</p>";
    }
}
?>
