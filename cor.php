<?php
session_start();
require('db.php');

// Fetch 'Delivered' orders
$query_delivered_orders = "
    SELECT b.booking_id AS order_id, b.username AS cust_fname, b.booking_status AS order_status, 
    b.booking_date AS order_date, b.pickup_status, c.cust_address
    FROM bookings b
    JOIN customers c ON b.cust_id = c.cust_id
    WHERE b.pickup_status = 'Delivered'";
$stmt_delivered_orders = $conn->prepare($query_delivered_orders);
$stmt_delivered_orders->execute();
$delivered_orders = $stmt_delivered_orders->get_result();

// Display orders
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delivered Orders</title>
    <link rel="stylesheet" href="cor.css">

</head>
<body>
    <h1>Delivered Orders to Store</h1>
  
    <div class="topbar">
        <h2>Shoe Laundry</h2>
        <h2>Delivery done to Store</h2>
        <ul>
        <li><a href="courier_staff.php">Dashboard</a></li>
                <li><a href="cprofile.php">Profile</a></li>
                <li><a href="cattendance.php">Attendance</a></li>
                <li><a href="cnot.php">Notifications</a></li>
                <li><a href="corders.php">Orders</a></li>
                <li><a href="pickup.php"  >PickUp</a></li>
                <li><a href="courier_delivery.php">Out for delivery</a></li> 
                <li><a href="cor.php"  class="active">Orders Delivered </a></li>
                <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Order Date</th>
                <th>Pickup Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = $delivered_orders->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                    <td><?php echo htmlspecialchars($order['cust_fname']); ?></td>
                    <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                    <td><?php echo htmlspecialchars($order['pickup_status']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
