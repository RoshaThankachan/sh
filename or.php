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

// Fetch orders assigned to this employee, separated by status
$query_orders = "
    SELECT b.booking_id AS order_id, b.username AS cust_fname, b.booking_status AS order_status, b.booking_date AS order_date
    FROM bookings b 
    WHERE b.employee_id = ?";
$stmt_orders = $conn->prepare($query_orders);
$stmt_orders->bind_param("i", $employee_id);
$stmt_orders->execute();
$orders_result = $stmt_orders->get_result();

// Initialize arrays for each status category
$pending_orders = [];
$in_progress_orders = [];
$completed_orders = [];

// Categorize orders by status
while ($order = $orders_result->fetch_assoc()) {
    switch ($order['order_status']) {
        case 'Pending':
            $pending_orders[] = $order;
            break;
        case 'In Progress':
            $in_progress_orders[] = $order;
            break;
        case 'Completed':
            $completed_orders[] = $order;
            break;
    }
}

// Handle order status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['order_status'];

    // Update order status in bookings table
    $update_query = "UPDATE bookings SET booking_status = ? WHERE booking_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("si", $new_status, $order_id);
    
    if ($update_stmt->execute()) {
        // Add a new notification entry
        $notification_message = "Your order #{$order_id} status has been updated to '{$new_status}'.";
        $notification_query = "INSERT INTO notifications (employee_id, message) VALUES (?, ?)";
        $notification_stmt = $conn->prepare($notification_query);
        $notification_stmt->bind_param("is", $employee_id, $notification_message);
        $notification_stmt->execute();

        // Redirect to the same page to reflect the updated order list
        header("Location: orders.php");
        exit();
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
    <link rel="stylesheet" href="oder.css"> <!-- Update the CSS file link if needed -->
</head>
<body>
    <div class="orders-container">
        <div class="topbar">
            <h2>Shoe Laundry</h2>
            <h2>Orders Managed</h2>
            <ul>
                <li><a href="dash.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="emm.php"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="attendance.php"><i class="fas fa-calendar-check"></i> Attendance</a></li>
                <li><a href="notification.php"><i class="fas fa-bell"></i> Notifications</a></li>
                <li><a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a></li>
                <li><a href="orders.php" class><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <li><a href="or.php" class="active"><i class="fas fa-shopping-cart"></i> Orders Managed</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <header>
                <h1>Your Assigned Orders</h1>
            </header>

            <!-- Pending Orders Section -->
            <section class="orders-section">
                <h2>Pending Orders</h2>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending_orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['cust_fname']); ?></td>
                                <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                                <td><?php echo htmlspecialchars(date("Y-m-d", strtotime($order['order_date']))); ?></td>
                                <td>
                                    <form method="POST" action="orders.php">
                                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                        <select name="order_status" required>
                                            <option value="Pending" <?php echo ($order['order_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                            <option value="In Progress">In Progress</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                        <input type="submit" name="update_order" value="Update">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

            <!-- In Progress Orders Section -->
            <section class="orders-section">
                <h2>In Progress Orders</h2>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($in_progress_orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['cust_fname']); ?></td>
                                <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                                <td><?php echo htmlspecialchars(date("Y-m-d", strtotime($order['order_date']))); ?></td>
                                <td>
                                    <form method="POST" action="orders.php">
                                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                        <select name="order_status" required>
                                            <option value="Pending">Pending</option>
                                            <option value="In Progress" <?php echo ($order['order_status'] == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                        <input type="submit" name="update_order" value="Update">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

            <!-- Completed Orders Section -->
            <section class="orders-section">
                <h2>Completed Orders</h2>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Status</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($completed_orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['cust_fname']); ?></td>
                                <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                                <td><?php echo htmlspecialchars(date("Y-m-d", strtotime($order['order_date']))); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</body>
</html>
