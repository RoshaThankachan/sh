<?php
session_start();
include('db_connect.php'); // Include your database connection

// Check if the customer ID is passed via GET request
if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Fetch customer data from the database based on the provided ID
    $query = "SELECT cust_id, cust_fname, cust_lname, username, house_name, street_name, district, pincode, phone, gender FROM customers WHERE cust_id = ?";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        // Bind the customer ID as a parameter
        mysqli_stmt_bind_param($stmt, 'i', $customer_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Check if customer data was retrieved
        if ($result && mysqli_num_rows($result) > 0) {
            $customer = mysqli_fetch_assoc($result);
        } else {
            echo "Customer not found!";
            exit();
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error in preparing query!";
        exit();
    }

    // Fetch past orders for the customer using the correct $customer_id
    $orders_query = "SELECT 
    o.booking_id, 
    o.booking_date, 
    s.service_name, 
    o.delivery_date, 
    o.delivery_time, 
    o.booking_status
 FROM bookings o
 INNER JOIN services s ON o.service_type = s.service_id
 WHERE o.cust_id = ?";

    $orders_stmt = mysqli_prepare($conn, $orders_query);

    if ($orders_stmt) {
        mysqli_stmt_bind_param($orders_stmt, 'i', $customer_id); // Use the correct customer_id variable here
        mysqli_stmt_execute($orders_stmt);
        $orders_result = mysqli_stmt_get_result($orders_stmt);
        mysqli_stmt_close($orders_stmt);
    } else {
        echo "Error in preparing orders query!";
        exit();
    }
} else {
    echo "No customer ID provided!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customer</title>
    <link rel="stylesheet" href="vs.css"> <!-- Link to the external CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Shoe Laundry</h2>
        <ul>
        <li><a href="dashboard.php" class="<?= $current_page == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="customers.php" class="<?= $current_page == 'customers.php' ? 'active' : '' ?>">Customers</a></li>
        <li><a href="admin_orders.php" class="<?= $current_page == 'admin_orders.php' ? 'active' : '' ?>">Orders</a></li>
        <li><a href="report.php" class="<?= $current_page == 'report.php' ? 'active' : '' ?>">Report</a></li> <!-- Added Report Link -->
        <li><a href="employees.php" class="<?= $current_page == 'employees.php' ? 'active' : '' ?>">Employees</a></li>
        <li><a href="payments.php" class="<?= $current_page == 'payments.php' ? 'active' : '' ?>">Payments</a></li>
        <li><a href="admin_inventory.php" class="<?= $current_page == 'admin_inventory.php' ? 'active' : '' ?>">Inventory</a></li>
        <li><a href="assign_orders.php" class="<?= $current_page == 'assign_orders.php' ? 'active' : '' ?>">Assign Orders</a></li>
        <li><a href="message.php" class="<?= $current_page == 'message.php' ? 'active' : '' ?>">Messages</a></li>
        <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Customer Details</h1>
            <p>Details of customer: <?php echo htmlspecialchars($customer['cust_fname']) . ' ' . htmlspecialchars($customer['cust_lname']); ?></p>
        </div>

       <!-- Customer Info -->
<div class="customer-info">
    <table>
        <tr>
            <th>ID</th>
            <td><?php echo htmlspecialchars($customer['cust_id']); ?></td>
        </tr>
        <tr>
            <th>Name</th>
            <td><?php echo htmlspecialchars($customer['cust_fname']) . ' ' . htmlspecialchars($customer['cust_lname']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($customer['username']); ?></td>
        </tr>
       
        <tr>
            <th>House Name</th>
            <td><?php echo htmlspecialchars($customer['house_name']); ?></td>
        </tr>
        <tr>
            <th>Street Name</th>
            <td><?php echo htmlspecialchars($customer['street_name']); ?></td>
        </tr>
        <tr>
            <th>District</th>
            <td><?php echo htmlspecialchars($customer['district']); ?></td>
        </tr>
        <tr>
            <th>Pincode</th>
            <td><?php echo htmlspecialchars($customer['pincode']); ?></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td><?php echo htmlspecialchars($customer['phone']); ?></td>
        </tr>
        <tr>
            <th>Gender</th>
            <td><?php echo htmlspecialchars($customer['gender']); ?></td>
        </tr>
    </table>
</div>


        <!-- Past Orders Section -->
        <div class="past-orders">
            <h2>Past Orders</h2>
            <div class="past-orders-container">
                <?php if ($orders_result && mysqli_num_rows($orders_result) > 0): ?>
                    <?php while ($order = mysqli_fetch_assoc($orders_result)): ?>
                        <div class="order-card">
                            <h3>Order ID: <?php echo htmlspecialchars($order['booking_id']); ?></h3>
                            <p><strong>Booking Date:</strong> <?php echo htmlspecialchars(date('Y-m-d', strtotime($order['booking_date']))); ?></p>
                            <p><strong>Service Type:</strong> <?php echo htmlspecialchars($order['service_name']); ?></p>
                            <p><strong>Delivery Date:</strong> <?php echo htmlspecialchars(date('Y-m-d', strtotime($order['delivery_date']))); ?></p>
                            <p><strong>Delivery Time:</strong> <?php echo htmlspecialchars($order['delivery_time']); ?></p>
                            <p><strong>Status:</strong> <?php echo htmlspecialchars($order['booking_status']); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No past orders found.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Back Button -->
        <div class="back-btn">
            <a href="customers.php" class="btn">Back to Customers</a>
        </div>
    </div>

</body>
</html>
