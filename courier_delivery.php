<?php
session_start();
require('db.php');

if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

// Get the courier employee's ID from session
$courier_employee_id = $_SESSION['employee_id'];

// Fetch orders assigned to this courier that are "Out for Delivery"
$delivery_orders_query = "
    SELECT b.booking_id AS order_id, 
           b.username AS cust_name, 
           b.house_name AS house_name, 
           b.street_name AS street_name, 
           b.district AS district, 
           b.pincode AS pincode, 
           b.booking_date AS order_date, 
           b.courier_status AS order_status,
           b.username AS customer_email,
           b.phone
    FROM bookings b
    WHERE b.employee_id = ? AND b.booking_status = 'Completed' AND b.Courier_status = ''";
$stmt = $conn->prepare($delivery_orders_query);
$stmt->bind_param("i", $courier_employee_id);
$stmt->execute();
$delivery_orders_result = $stmt->get_result();

// Handle updating order status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];  // Status can be "Out for Delivery" or "Delivered"
    $customer_email = $_POST['customer_email'];  // The customer's email for notification

    // Update the order status in the database
    $update_status_query = "UPDATE bookings SET courier_status = ? WHERE booking_id = ?";
    $stmt = $conn->prepare($update_status_query);
    $stmt->bind_param("si", $new_status, $order_id);

    if ($stmt->execute()) {
        // Send a notification to the customer
        $notification_message = "Your order #{$order_id} has been delivered to you.";
        $notification_date = date("Y-m-d H:i:s");
        
        $insert_notification_query = "INSERT INTO notifications (customer_email, message, date_sent) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_notification_query);
        $stmt->bind_param("sss", $customer_email, $notification_message, $notification_date);
        $stmt->execute();

        // Display a success message
        echo "<div class='alert success'>Order #{$order_id} status updated to 'Delivered'. A notification has been sent to the customer.</div>";
    } else {
        echo "<div class='alert error'>Failed to update order status. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deliveries Assigned to You</title>
    <link rel="stylesheet" href="pickup.css">
</head>
<body>
<div class="orders-container">
        <div class="topbar">
            <h2>Shoe Laundry</h2>
            <h2>Order Pickup</h2>
            <ul>
            <li><a href="courier_staff.php">Dashboard</a></li>
                <li><a href="cprofile.php" >Profile</a></li>
                <li><a href="cattendance.php"  >Attendance</a></li>
                <li><a href="cnot.php">Notifications</a></li>
                <li><a href="corders.php"  >Orders</a></li>
                <li><a href="pickup.php"  >PickUp</a></li>
                <li><a href="courier_delivery.php" class="active">Out for delivery</a></li> 
                <li><a href="cor.php">Orders Delivered </a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
<div class="main-content">
    <header>
        <h1>Orders Out for Delivery</h1>
    </header>

    <section class="orders-section">
        <h2>Your Assigned Deliveries</h2>
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Phone Number</th>
                    <th>Delivery Address</th>
                    <th>Order Date</th>
                    <th>Order Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $delivery_orders_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['cust_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['phone']); ?></td>
                        <td>
                            <?php 
                                echo htmlspecialchars($order['house_name']) . ", " .
                                     htmlspecialchars($order['street_name']) . ", " .
                                     htmlspecialchars($order['district']) . ", " .
                                     htmlspecialchars($order['pincode']);
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars(date("Y-m-d", strtotime($order['order_date']))); ?></td>
                        <td>
                            <?php if ($order['order_status'] == 'Delivered'): ?>
                                <span>Order Delivered</span>
                            <?php else: ?>
                                <form method="POST" action="courier_delivery.php">
                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <input type="hidden" name="customer_email" value="<?php echo htmlspecialchars($order['customer_email']); ?>">
                                    <select name="new_status" required>
                                        <option value="">Select Status</option>
                                        <option value="Delivered">Delivered</option>
                                    </select>
                                    <input type="submit" name="update_status" value="Update Status">
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</div>
</body>
</html>
