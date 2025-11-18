<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include('db.php');

$username = $_SESSION['username'];
$employee_id = $_SESSION['employee_id'];
// Fetch the logged-in employee's details
$query = "SELECT employee_id, fname, status, department FROM employees WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();

// Fetch courier's assigned orders
$query = "
    SELECT b.booking_id AS order_id, b.username AS cust_fname, b.booking_status AS order_status, 
           b.booking_date AS order_date, b.pickup_status, b.house_name, b.street_name, b.district, b.pincode
    FROM bookings b
    JOIN customers c ON b.cust_id = c.cust_id
    WHERE b.employee_id = ? AND b.pickup_status = 'Not Picked' AND b.booking_status <> 'Completed'";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$orders = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Dashboard</title>
    <link rel="stylesheet" href="cdashh.css">
  
</head>
<body>
<div class="topbar">
    <h2>Shoe Laundry</h2>
    <h2>Courier Staff Dashboard</h2>
    <ul>
        <li><a href="courier_staff.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="cprofile.php"><i class="fas fa-user"></i> Profile</a></li>
        <li><a href="cattendance.php"><i class="fas fa-calendar-check"></i> Attendance</a></li>
        <li><a href="cnot.php"><i class="fas fa-bell"></i> Notifications</a></li>
        <li><a href="corders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
        <li><a href="pickup.php"><i class="fas fa-truck"></i> PickUp</a></li>
        <li><a href="courier_delivery.php"><i class="fas fa-shipping-fast"></i> Out for Delivery</a></li>
        <li><a href="cor.php"><i class="fas fa-warehouse"></i> Orders Delivered </a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="header">
    <h1>Welcome, <?php echo htmlspecialchars($employee['fname']); ?></h1>
    </div>
<!-- Employee Details Section -->
<div class="employee-details">
        <table>
            <tr>
                <th>Employee ID</th>
                <td><?php echo htmlspecialchars($employee['employee_id']); ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?php echo htmlspecialchars($employee['fname']); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo htmlspecialchars($employee['status']); ?></td>
            </tr>
            <tr>
                <th>Department</th>
                <td><?php echo htmlspecialchars($employee['department']); ?></td>
            </tr>
        </table>
    </div>
    <!-- Assigned Orders Section -->
    <div class="assigned-orders">
    <h2>Assigned Orders</h2>
        <?php if ($orders->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Status</th>
                    <th>Order Date</th>
                </tr>
                <?php while ($order = $orders->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['cust_fname']); ?></td>
                        <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                        <td><?php echo htmlspecialchars(date("Y-m-d", strtotime($order['order_date']))); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No assigned orders currently.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
