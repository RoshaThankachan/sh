<?php
session_start();
include('db_connect.php'); // Include the database connection file

// Check if 'payment_id' is passed in the URL
if (isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id']; // Get the payment ID from the URL

    // Prepare the query to fetch payment details
    $query = "SELECT payment.payment_id, payment.total_price, payment.payment_date, payment.payment_status, 
                     payment.cust_id, payment.payment_method,payment.payment_reference,customers.cust_fname, customers.cust_lname, customers.phone
              FROM payment
              JOIN customers ON payment.cust_id = customers.cust_id
              WHERE payment.payment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $payment_id); // Bind the payment_id parameter to the query
    $stmt->execute();
    $result = $stmt->get_result(); // Get the result of the query

    // Check if the payment details are found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch the payment details
    } else {
        // If no result, display an error or redirect
        echo "Payment details not found.";
        exit;
    }
} else {
    echo "No payment ID specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <link rel="stylesheet" href="pv.css">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Shoe Laundry</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="customers.php">Customers</a></li>
            <li><a href="admin_orders.php">Orders</a></li>
            <li><a href="report.php">Report</a></li>
            <li><a href="employees.php">Employees</a></li>
            <li><a href="payments.php">Payments</a></li>
            <li><a href="admin_inventory.php">Inventory</a></li>
            <li><a href="assign_orders.php">Assign Orders</a></li>
            <li><a href="add_services.php">Add Services</a></li>
            <li><a href="shoe.php">Shoes</a></li>
            <li><a href="message.php">Messages</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Payment Details</h1>
            <p>Details of payment #<?php echo $row['payment_id']; ?></p>
        </div>

        <!-- Payment Details Table -->
        <div class="payment-details">
            <table>
                <tr>
                    <th>Payment ID</th>
                    <td><?php echo $row['payment_id']; ?></td>
                </tr>
                <tr>
                    <th>Customer Name</th>
                    <td><?php echo htmlspecialchars($row['cust_fname'] . ' ' . $row['cust_lname']); ?></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                </tr>
                <tr>
                    <th>Amount</th>
                    <td>₹<?php echo number_format($row['total_price'], 2); ?></td>
                </tr>
                <tr>
                    <th>Payment Date</th>
                    <td><?php echo date("M d, Y", strtotime($row['payment_date'])); ?></td>
                </tr>
                <tr>
                    <th>Payment Method</th>
                    <td><?php echo $row['payment_method'];  ?></td>
                </tr>
                <tr>
                    <th>Payment Reference</th>
                    <td><?php echo $row['payment_reference'];  ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?php echo ucfirst($row['payment_status']); ?></td>
                </tr>
            </table>
        </div>
        <div class="back-btn">
            <a href="payments.php" class="btn-back">Back to Payment</a>
        </div>
    </div>

</body>
</html>
