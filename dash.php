<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include('db.php');

$username = $_SESSION['username'];

// Fetch the logged-in employee's details
$query = "SELECT employee_id, fname, status, department FROM employees WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();

// Fetch assigned bookings for the employee, joining with the services table to get the service name
$bookings_query = "
    SELECT b.booking_id AS order_id, s.service_name AS service_type, b.booking_status AS status, b.delivery_date AS order_date
    FROM bookings b
    JOIN services s ON b.service_type = s.service_id
    WHERE b.employee_id = ?";
$stmt_bookings = $conn->prepare($bookings_query);
$stmt_bookings->bind_param("i", $employee['employee_id']);
$stmt_bookings->execute();
$bookings_result = $stmt_bookings->get_result();

// Fetch recent notifications (if any)
$notifications_query = "SELECT message FROM notifications WHERE employee_id = ?";
$stmt_notifications = $conn->prepare($notifications_query);
$stmt_notifications->bind_param("i", $employee['employee_id']);
$stmt_notifications->execute();
$notifications_result = $stmt_notifications->get_result();

// Fetch attendance data for the logged-in employee
$attendance_query = "SELECT COUNT(*) AS total_days FROM attendance WHERE employee_id = ? AND MONTH(attendance_date) = MONTH(CURRENT_DATE)";
$attendance_stmt = $conn->prepare($attendance_query);
$attendance_stmt->bind_param("i", $employee['employee_id']);
$attendance_stmt->execute();
$attendance_result = $attendance_stmt->get_result();
$total_days = $attendance_result->fetch_assoc()['total_days'];

$attendance_status_query = "SELECT COUNT(*) AS attended_days FROM attendance WHERE employee_id = ? AND status = 'present' AND MONTH(attendance_date) = MONTH(CURRENT_DATE)";
$attendance_status_stmt = $conn->prepare($attendance_status_query);
$attendance_status_stmt->bind_param("i", $employee['employee_id']);
$attendance_status_stmt->execute();
$attendance_status_result = $attendance_status_stmt->get_result();
$attended_days = $attendance_status_result->fetch_assoc()['attended_days'];

$attendance_percentage = ($total_days > 0) ? round(($attended_days / $total_days) * 100, 2) : 0;

// Fetch completed orders count
$order_query = "SELECT COUNT(*) AS completed_orders FROM orders WHERE employee_id = ? AND order_status = 'completed'";
$order_stmt = $conn->prepare($order_query);
$order_stmt->bind_param("i", $employee['employee_id']);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
$completed_orders = $order_result->fetch_assoc()['completed_orders'];

// Monthly score (static value for now)
$monthly_score = 4.8;

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="dashh.css">
</head>
<body>
<div class="topbar">
    <h2>Shoe Laundry</h2>
    <h2>Staff Dashboard</h2>
    <ul>
        <li><a href="dash.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="emm.php"><i class="fas fa-user"></i> Profile</a></li>
        <li><a href="attendance.php"><i class="fas fa-calendar-check"></i> Attendance</a></li>
        <li><a href="notification.php"><i class="fas fa-bell"></i> Notifications</a></li>
        <li><a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a></li>
        <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
        <li><a href="or.php"><i class="fas fa-shopping-cart"></i> Orders Managed</a></li>
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
        <?php if ($bookings_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Service Type</th>
                    <th>Status</th>
                    <th>Order Date</th>
                </tr>
                <?php while ($booking = $bookings_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($booking['service_type']); ?></td>
                        <td><?php echo htmlspecialchars($booking['status']); ?></td>
                        <td><?php echo htmlspecialchars($booking['order_date']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No orders assigned currently.</p>
        <?php endif; ?>
    </div>

    <!-- Performance Summary Section -->
    <div class="performance-summary">
        <h2>Performance Summary</h2>
        <p>Attendance: <?php echo $attendance_percentage; ?>%</p>
        <p>Monthly Score: <?php echo $monthly_score; ?>/5</p>
        <p>Completed Orders: <?php echo $completed_orders; ?></p>
    </div>
</div>
</body>
</html>
