<?php
session_start();
include('db_connect.php'); // Database connection

$current_page = basename($_SERVER['PHP_SELF']);

// Check if a date filter is applied
$date_filter = isset($_GET['payment_date']) ? $_GET['payment_date'] : null;
$date_filter_sql = '';

if ($date_filter) {
    // If a date is provided, filter by payment_date
    $date_filter_sql = " AND DATE(p.payment_date) = '" . mysqli_real_escape_string($conn, $date_filter) . "'";
}

// Fetch all payments with customer details, with optional date filter
$query = "
    SELECT 
        p.payment_id, p.total_price, p.payment_date, p.payment_status, 
        p.booking_id, p.cust_id, customers.cust_fname, customers.cust_lname, customers.phone
    FROM payment p
    JOIN customers ON p.cust_id = customers.cust_id
    WHERE 1" . $date_filter_sql . "
    ORDER BY DATE_FORMAT(p.payment_date, '%Y-%m') DESC, p.payment_date DESC";
$result = mysqli_query($conn, $query);

// Fetch all cancelled bookings where the bk_user_status is 'Cancelled'
$cancelled_query = "
    SELECT 
        b.booking_id, b.service_type, b.delivery_date, b.delivery_time, b.booking_date, 
        b.bk_user_status, c.cust_fname, c.cust_lname, c.phone
    FROM bookings b
    JOIN customers c ON b.cust_id = c.cust_id
    WHERE b.bk_user_status = 'Cancelled'";  // Filter by cancelled bookings
$cancelled_result = mysqli_query($conn, $cancelled_query);

$all_payments = mysqli_fetch_all($result, MYSQLI_ASSOC);
$cancelled_bookings = mysqli_fetch_all($cancelled_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments Management</title>
    <link rel="stylesheet" href="payment.css">
</head>
<body>

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

<!-- Main Content -->
<div class="main-content">
    <div class="header">
        <h1>Manage Payments</h1>
        <p>Overview of all payments made in the system.</p>
    </div>



    <!-- Payments Table -->
    <?php 
    $current_month = null; 
    if (!empty($all_payments)): 
    ?>
        <?php foreach ($all_payments as $row): ?>
            <?php
            $payment_month = date('F Y', strtotime($row['payment_date'])); // Format: "Month Year"
            if ($current_month !== $payment_month):
                if ($current_month !== null): ?>
                    </tbody>
                    </table>
                <?php endif; ?>
                <h2><?php echo $payment_month; ?></h2>
                <table>
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>Amount</th>
                            <th>Payment Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php 
                $current_month = $payment_month; 
            endif; 
            ?>
            <tr>
                <td><?php echo $row['payment_id']; ?></td>
                <td><?php echo htmlspecialchars($row['cust_fname'] . ' ' . $row['cust_lname']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td>₹<?php echo number_format($row['total_price'], 2); ?></td>
                <td><?php echo date("M d, Y", strtotime($row['payment_date'])); ?></td>
                <td>
                    <a href="pview.php?payment_id=<?php echo $row['payment_id']; ?>" class="btn-view">View</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
    <?php else: ?>
        <p>No payments found.</p>
    <?php endif; ?>

    <!-- Refunded Bookings Section (Cancelled Bookings Only) -->
    <h3>Refunded Bookings (Cancelled)</h3>
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Customer Name</th>
                <th>Booking Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($cancelled_bookings)): ?>
                <?php foreach ($cancelled_bookings as $booking): ?>
                    <tr>
                        <td><?php echo $booking['booking_id']; ?></td>
                        <td><?php echo htmlspecialchars($booking['cust_fname'] . ' ' . $booking['cust_lname']); ?></td>
                        
                        <td><?php echo date("M d, Y", strtotime($booking['booking_date'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No cancelled bookings to display.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

</body>
</html>
