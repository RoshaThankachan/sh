

<?php
session_start();
include('db_connect.php'); // Database connection
$current_page = basename($_SERVER['PHP_SELF']);

// Check if a date filter is applied
$date_filter = isset($_GET['date']) ? $_GET['date'] : null;
$date_filter_sql = '';

if ($date_filter) {
    // If a date is provided, filter by booking_date
    $date_filter_sql = " AND DATE(b.booking_date) = '" . mysqli_real_escape_string($conn, $date_filter) . "'";
}

// Fetch all bookings sorted by booking date, with optional date filter
$query = "
    SELECT 
        b.booking_id, b.username, s.service_name, b.delivery_date, 
        b.delivery_time, b.booking_date, b.booking_status, b.bk_user_status
    FROM bookings b
    INNER JOIN services s ON b.service_type = s.service_id
    WHERE 1" . $date_filter_sql . "
    ORDER BY b.booking_date DESC, b.delivery_date ASC";

$result = mysqli_query($conn, $query);
$all_bookings = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch all canceled bookings if any, with the same date filter
$query_cancel = "
    SELECT 
        b.booking_id, b.username, s.service_name, b.delivery_date, 
        b.delivery_time, b.booking_date, b.booking_status, b.bk_user_status
    FROM bookings b
    INNER JOIN services s ON b.service_type = s.service_id
    WHERE b.bk_user_status = 'Cancelled'" . $date_filter_sql . "
    ORDER BY b.booking_date DESC";

$result_cancel = mysqli_query($conn, $query_cancel);
$cancelled_bookings = mysqli_fetch_all($result_cancel, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
    <link rel="stylesheet" href="ordercss.css">
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
            <li><a href="add_services.php" class="<?= $current_page == 'add_services.php' ? 'active' : '' ?>">Add Services</a></li>
            <li><a href="shoe.php" class="<?= $current_page == 'shoe.php' ? 'active' : '' ?>">Shoes</a></li>
            <li><a href="message.php" class="<?= $current_page == 'message.php' ? 'active' : '' ?>">Messages</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Bookings</h1>
        </div>

        <!-- Date Filter Form -->
        <form action="admin_orders.php" method="get">
            <label for="date">Filter by Booking Date:</label>
            <input type="date" name="date" id="date" value="<?php echo htmlspecialchars($date_filter); ?>" />
            <button type="submit" class="btn">Filter</button>
        </form>

        <?php 
        // Display all bookings
        if (!empty($all_bookings)): 
        ?>
            <h2>Active Bookings</h2>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Customer Name</th>
                        <th>Service Type</th>
                        <th>Pickup Date</th>
                        <th>Pickup Time</th>
                        <th>Booking Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_bookings as $booking): ?>
                        <tr>
                            <td><?php echo $booking['booking_id']; ?></td>
                            <td><?php echo htmlspecialchars($booking['username']); ?></td>
                            <td><?php echo htmlspecialchars($booking['service_name']); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($booking['delivery_date'])); ?></td>
                            <td><?php echo date('H:i', strtotime($booking['delivery_time'])); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($booking['booking_date'])); ?></td>
                            <td><?php echo ucfirst(htmlspecialchars($booking['bk_user_status'])); ?></td>
                            <td>
                                <a href="view_booking.php?id=<?php echo $booking['booking_id']; ?>" class="btn-view">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No bookings found for the selected date.</p>
        <?php endif; ?>

        <!-- Canceled Bookings Section -->
        <h3>Canceled Bookings</h3>
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Customer Name</th>
                    <th>Service Type</th>
                    <th>Pickup Date</th>
                    <th>Pickup Time</th>
                    <th>Booking Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cancelled_bookings)): ?>
                    <?php foreach ($cancelled_bookings as $canceled_booking): ?>
                        <tr>
                            <td><?php echo $canceled_booking['booking_id']; ?></td>
                            <td><?php echo htmlspecialchars($canceled_booking['username']); ?></td>
                            <td><?php echo htmlspecialchars($canceled_booking['service_name']); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($canceled_booking['delivery_date'])); ?></td>
                            <td><?php echo date('H:i', strtotime($canceled_booking['delivery_time'])); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($canceled_booking['booking_date'])); ?></td>
                            <td><?php echo ucfirst(htmlspecialchars($canceled_booking['bk_user_status'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7">No canceled bookings found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
