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

// Fetch orders assigned to this courier employee, excluding 'Completed' and 'Delivered' orders
$query_new_orders = "
    SELECT b.booking_id AS order_id, b.username AS cust_fname, b.booking_status AS order_status, 
    b.booking_date AS order_date, b.pickup_status,b.phone, c.cust_address, b.house_name AS house_name, 
           b.street_name AS street_name, 
           b.district AS district, 
           b.pincode AS pincode, 
    c.customer_email
    FROM bookings b
    JOIN customers c ON b.cust_id = c.cust_id
    WHERE b.employee_id = ? AND b.booking_status <> 'Completed'";
$stmt_new_orders = $conn->prepare($query_new_orders);
$stmt_new_orders->bind_param("i", $employee_id);
$stmt_new_orders->execute();
$new_orders = $stmt_new_orders->get_result(); 

// Handle status update action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $pickup_status = $_POST['pickup_status'];

    // Update pickup status in the bookings table
    $update_query = "UPDATE bookings SET pickup_status = ? WHERE booking_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("si", $pickup_status, $order_id);

    if ($update_stmt->execute()) {
        echo "<div class='alert success'>Order pickup status updated to '$pickup_status'.</div>";

        // Send a notification to the customer
        // Fetch customer's email
        $customer_email_query = "SELECT customer_email FROM bookings WHERE booking_id = ?";
        $email_stmt = $conn->prepare($customer_email_query);
        $email_stmt->bind_param("i", $order_id);
        $email_stmt->execute();
        $email_result = $email_stmt->get_result();
        $customer_email = $email_result->fetch_assoc()['customer_email'];

        // Create a notification message
        $notification_message = "Your order #$order_id status has been updated to '$pickup_status'.";

        // Insert the notification into the database
        $notification_query = "INSERT INTO notifications (customer_email, message) VALUES (?, ?)";
        $notification_stmt = $conn->prepare($notification_query);
        $notification_stmt->bind_param("ss", $customer_email, $notification_message);
        $notification_stmt->execute();
    } else {
        echo "<div class='alert error'>Error updating pickup status. Please try again.</div>";
    }

    // Refresh orders list to reflect updated status
    $stmt_new_orders->execute();
    $new_orders = $stmt_new_orders->get_result();
}
?>

<!-- HTML remains unchanged -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Pickup</title>
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
                <li><a href="pickup.php" class="active" >PickUp</a></li>
                <li><a href="courier_delivery.php" >Out for delivery</a></li> 
                <li><a href="cor.php">Orders Delivered </a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <header>
                <h1>Your New Orders for Pickup</h1>
            </header>

            <section class="orders-section">
                <h2>Orders Awaiting Pickup</h2>

                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Phone Number</th>
                            <th>Delivery Address</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Pickup Status</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($new_orders->num_rows > 0): ?>
                            <?php while ($order = $new_orders->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                    <td><?php echo htmlspecialchars($order['cust_fname']); ?></td>
                                    <td><?php echo htmlspecialchars($order['phone']); ?></td>
                                    <td>
                            <?php 
                                echo htmlspecialchars($order['house_name']) . ", " .
                                     htmlspecialchars($order['street_name']) . ", " .
                                     htmlspecialchars($order['district']) . ", " .
                                     htmlspecialchars($order['pincode']);
                            ?>
                        </td>
                                    <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                                    <td><?php echo htmlspecialchars(date("Y-m-d", strtotime($order['order_date']))); ?></td>
                                    <td><?php echo htmlspecialchars($order['pickup_status']); ?></td>
                                    <td>
                                        <?php if ($order['pickup_status'] != 'Delivered'): ?>
                                            <!-- Show dropdown and update button for non-Delivered statuses -->
                                            <form method="POST" action="pickup.php">
                                                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                                <select name="pickup_status">
                                                    <option value="Not Picked" <?php echo $order['pickup_status'] == 'Not Picked' ? 'selected' : ''; ?>>Not Picked</option>
                                                    <option value="Picked" <?php echo $order['pickup_status'] == 'Picked' ? 'selected' : ''; ?>>Picked</option>
                                                    <option value="In Transit" <?php echo $order['pickup_status'] == 'In Transit' ? 'selected' : ''; ?>>In Transit</option>
                                                    <option value="Delivered" <?php echo $order['pickup_status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                                </select>
                                                <input type="submit" name="update_status" value="Update Status">
                                            </form>
                                        <?php else: ?>
                                            <!-- Show message when the status is 'Delivered' -->
                                            <span>Order Delivered</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No orders are awaiting pickup.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</body>
</html>
