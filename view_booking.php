<?php
session_start();
include('db_connect.php'); // Include your database connection file

// Initialize variables
$booking_id = '';
$booking_details = [];

// Check if booking ID is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Prepare the SQL statement to fetch booking details
    $sql = "SELECT b.booking_id, b.cust_id, b.username, s.service_name, b.delivery_date, 
    b.delivery_time, b.booking_status 
FROM bookings b
INNER JOIN services s ON b.service_type = s.service_id
WHERE b.booking_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $booking_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the booking exists
    if ($result && mysqli_num_rows($result) > 0) {
        $booking_details = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('No booking found with this ID.');</script>";
        exit();
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "<script>alert('Booking ID is missing.');</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Booking Details</title>
    <link rel="stylesheet" href="viewb.css">
</head>
<body>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Shoe Laundry</h2>
        <ul>
        <li><a href="dashboard.php" class="<?= $current_page == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a></li>
            <li><a href="customers.php" class="<?= $current_page == 'customers.php' ? 'active' : '' ?>">Customers</a></li>
            <li><a href="admin_orders.php" class="<?= $current_page == 'admin_orders.php' ? 'active' : '' ?>">Orders</a></li>
            <li><a href="report.php" class="<?= $current_page == 'report.php' ? 'active' : '' ?>">Report</a></li>
            <li><a href="employees.php" class="<?= $current_page == 'employees.php' ? 'active' : '' ?>">Employees</a></li>
            <li><a href="payments.php" class="<?= $current_page == 'payments.php' ? 'active' : '' ?>">Payments</a></li>
            <li><a href="admin_inventory.php" class="<?= $current_page == 'admin_inventory.php' ? 'active' : '' ?>">Inventory</a></li>
            <li><a href="assign_orders.php" class="<?= $current_page == 'assign_orders.php' ? 'active' : '' ?>">Assign Orders</a></li>
            <li><a href="shoe.php" class="<?= $current_page == 'shoe.php' ? 'active' : '' ?>">Shoes</a></li>
            <li><a href="add_services.php" class="<?= $current_page == 'add_services.php' ? 'active' : '' ?>">Add Services</a></li>
            <li><a href="message.php" class="<?= $current_page == 'message.php' ? 'active' : '' ?>">Messages</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
        <h1>Booking Details</h1>
   
        </div>
    <div class="wrapper">
        <section class="booking-details">
           
            <table>
                <tr>
                    <th>Booking ID</th>
                    <td><?php echo htmlspecialchars($booking_details['booking_id']); ?></td>
                </tr>
                <tr>
                    <th>Customer ID</th>
                    <td><?php echo htmlspecialchars($booking_details['cust_id']); ?></td>
                </tr>
                <tr>
                    <th>Customer Name</th>
                    <td><?php echo htmlspecialchars($booking_details['username']); ?></td>
                </tr>
                <tr>
                
    <th>Service Type</th>
    <td><?php echo htmlspecialchars($booking_details['service_name']); ?></td>

                </tr>
                <tr>
                    <th>Pickup Date</th>
                    <td><?php echo date('Y-m-d', strtotime($booking_details['delivery_date'])); ?></td>
                </tr>
                <tr>
                    <th>Pickup Time</th>
                    <td><?php echo htmlspecialchars($booking_details['delivery_time']); ?></td>
                </tr>
                <tr>
                    <th>Booking Status</th>
                    <td><?php echo htmlspecialchars($booking_details['booking_status']); ?></td>
                </tr>
            </table>
           
        <!-- Back Button -->
        <div class="back-btn">
            <a href="admin_orders.php" class="btn">Back to Orders</a>
        </div>
    </div>
        </section>
    </div>
</body>
</html>
