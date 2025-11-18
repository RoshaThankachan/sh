<?php
session_start();
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

require('db.php');
$employee_id = $_SESSION['employee_id'];

// Fetch employee information
$query = "SELECT * FROM employees WHERE employee_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$employee_info = $stmt->get_result()->fetch_assoc();

// Check if employee is in the 'courier' department
if ($employee_info['department'] !== 'Courier') {
    echo "<div class='alert error'>You are not a courier staff member.</div>";
    exit();
}

// Fetch new orders assigned to this courier employee from the bookings table, where courier status is 'Assigned'
$query_new_orders = "
    SELECT b.booking_id AS order_id, b.username AS cust_fname, b.booking_status AS order_status, b.booking_date AS order_date, b.courier_status
    FROM bookings b 
    WHERE b.employee_id = ? AND b.courier_status = 'Assigned' AND b.booking_status <> 'Completed'";
$stmt_new_orders = $conn->prepare($query_new_orders);
$stmt_new_orders->bind_param("i", $employee_id);
$stmt_new_orders->execute();
$new_orders = $stmt_new_orders->get_result(); // Get the result set for new orders

// Handle order status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['order_status'];

    // Update order status in bookings table
    $update_query = "UPDATE bookings SET booking_status = ?, courier_status = 'Collected' WHERE booking_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("si", $new_status, $order_id);

    if ($update_stmt->execute()) {
        echo "<div class='alert success'>Order status updated successfully!</div>";

        // Fetch customer email from the bookings table
        $customer_query = "SELECT username FROM bookings WHERE booking_id = ?";
        $customer_stmt = $conn->prepare($customer_query);
        $customer_stmt->bind_param("i", $order_id);
        $customer_stmt->execute();
        $customer = $customer_stmt->get_result()->fetch_assoc();
        $customer_email = $customer['username'];  // Assuming username is the customer's email

        // Insert notification message for the customer
        $message = "Your order #$order_id status has been updated to '$new_status'.";
        $notification_query = "INSERT INTO notifications (customer_email, message, date_sent) VALUES (?, ?, NOW())";
        $notification_stmt = $conn->prepare($notification_query);
        $notification_stmt->bind_param("ss", $customer_email, $message);
        $notification_stmt->execute();

    } else {
        echo "<div class='alert error'>Error updating order status. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="oder.css">
</head>
<body>
    <div class="orders-container">
        <div class="topbar">
            <h2>Shoe Laundry</h2>
            <h2>Orders Received</h2>
            <ul>
            <li><a href="courier_staff.php">Dashboard</a></li>
                <li><a href="cprofile.php" >Profile</a></li>
                <li><a href="cattendance.php"  >Attendance</a></li>
                <li><a href="cnot.php">Notifications</a></li>
                <li><a href="corders.php"  class="active">Orders</a></li>
                <li><a href="pickup.php"  >PickUp</a></li>
                <li><a href="courier_delivery.php">Out for delivery</a></li> 
                <li><a href="cor.php">Orders Delivered </a></li>
                <li><a href="logout.php"o>Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <header>
                <h1>Your Assigned Orders</h1>
            </header>

            <!-- New Orders Section -->
            <section class="orders-section">
                <h2>New Orders Assigned to You</h2>

                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Status</th>
                            <th>Order Date</th>
                         
                            <th>View Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($new_orders->num_rows > 0): ?>
                            <?php while ($order = $new_orders->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                    <td><?php echo htmlspecialchars($order['cust_fname']); ?></td>
                                    <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                                    <td><?php echo htmlspecialchars(date("Y-m-d", strtotime($order['order_date']))); ?></td>
                              
                                    <td>
                                        <a href="view_corders.php?order_id=<?php echo htmlspecialchars($order['order_id']); ?>" class="btn">View Details</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No new orders assigned to you.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>

        </div>
    </div>
</body>
</html>
