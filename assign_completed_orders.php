<?php
session_start();
include('db_connect.php'); // Include your database connection file

$current_page = basename($_SERVER['PHP_SELF']);
// Fetch completed orders
$completed_orders_query = "
    SELECT b.booking_id AS order_id, b.username AS cust_fname, b.booking_date AS order_date
    FROM bookings b
    WHERE b.booking_status = 'Completed' AND b.courier_status='Assigned' AND b.pickup_status='Delivered'";
$completed_orders_result = $conn->query($completed_orders_query);

// Fetch available courier employees for assignment
$available_couriers_query = "
    SELECT employee_id, fname, lname
    FROM employees
    WHERE is_available = 1 AND status = 'active' AND department = 'Courier'";
$available_couriers_result = $conn->query($available_couriers_query);

// Handle assigning completed orders to couriers
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assign_to_courier'])) {
    $order_id = $_POST['order_id'];
    $courier_employee_id = $_POST['courier_employee_id'];  // Using employee_id instead of courier_id

    // Update booking to assign the courier
    $assign_query = "UPDATE bookings SET employee_id = ?, courier_status = 'Out for Delivery' WHERE booking_id = ?";
    $stmt = $conn->prepare($assign_query);
    $stmt->bind_param("ii", $courier_employee_id, $order_id);

    if ($stmt->execute()) {
        echo "<div class='alert success'>Order #{$order_id} assigned to courier successfully.</div>";
    } else {
        echo "<div class='alert error'>Failed to assign order. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Completed Orders</title>
    <link rel="stylesheet" href="ascom.css">
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
    
        <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
<div class="main-content">
    <header>
        <h1>Assign Completed Orders to Courier</h1>
    </header>

    <section class="orders-section">
        <h2>Completed Orders</h2>
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Assign to Courier</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $completed_orders_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['cust_fname']); ?></td>
                        <td><?php echo htmlspecialchars(date("Y-m-d", strtotime($order['order_date']))); ?></td>
                        <td>
                            <form method="POST" action="assign_completed_orders.php">
                                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                <select name="courier_employee_id" required>  <!-- Changed to courier_employee_id -->
                                    <option value="">Select Courier</option>
                                    <?php
                                    $available_couriers_result->data_seek(0); // Reset courier result pointer
                                    while ($courier = $available_couriers_result->fetch_assoc()):
                                    ?>
                                        <option value="<?php echo htmlspecialchars($courier['employee_id']); ?>">
                                            <?php echo htmlspecialchars($courier['fname'] . " " . $courier['lname']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                                <input type="submit" name="assign_to_courier" value="Assign">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
     <!-- Back Button -->
     <a href="assign_orders.php" class="back-button">Back to Assigned Orders</a>

</div>
</body>
</html>
