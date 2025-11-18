<?php
session_start();
include('db_connect.php'); // Include your database connection file

// Redirect to the correct page based on the selection
if (isset($_GET['assign_type'])) {
    if ($_GET['assign_type'] == 'courier') {
        header("Location: assign_orders_to_courier.php");
        exit();
    } elseif ($_GET['assign_type'] == 'employee') {
        header("Location: assign_orders_to_employees.php");
        exit();
    }
}

$current_page = basename($_SERVER['PHP_SELF']);

// Fetch new bookings that need to be assigned to courier employees first
$new_orders_query = "SELECT b.booking_id, b.username, s.service_name, b.delivery_date, b.delivery_time, 
                     b.phone, b.number_of_shoes, st.shoe_type_name, m.material_name, 
                     b.booking_status, b.courier_status 
                     FROM bookings b
                     LEFT JOIN shoe_types st ON b.shoe_type = st.shoe_type_id
                     LEFT JOIN materials m ON b.material_type = m.material_id
                     LEFT JOIN services s ON b.service_type = s.service_id
                     WHERE b.booking_status = 'Pending' AND b.courier_status IS NULL";
$new_orders_result = mysqli_query($conn, $new_orders_query);

// Fetch available and active courier employees for the initial assignment
$available_couriers_query = "SELECT employee_id, fname, lname 
                             FROM employees 
                             WHERE is_available = 1 AND status = 'active' AND department = 'Courier'";
$available_couriers_result = mysqli_query($conn, $available_couriers_query);

// Create an array to hold courier employee information
$available_couriers = [];
while ($courier = mysqli_fetch_assoc($available_couriers_result)) {
    $available_couriers[] = $courier;
}

// Handle assignment to courier employees
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign_courier'])) {
    $booking_id = $_POST['booking_id'];
    $courier_id = $_POST['courier_id'];

    // Update the booking's courier status and assigned courier employee
    $update_courier_query = "UPDATE bookings SET courier_status = 'Assigned', employee_id = ? WHERE booking_id = ?";
    $stmt = mysqli_prepare($conn, $update_courier_query);
    mysqli_stmt_bind_param($stmt, 'ii', $courier_id, $booking_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    // Redirect after assignment
    header("Location: assign_orders_to_courier.php");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asc.css"> <!-- Link to your CSS file -->
    <title>Assign Orders to Courier</title>
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
    <h1>Assign Orders to Courier</h1>

    <div class="assignments-section">
        
        <?php if (mysqli_num_rows($new_orders_result) > 0 && count($available_couriers) > 0): ?>
            <?php while ($booking = mysqli_fetch_assoc($new_orders_result)): ?>
                <form method="POST" action="assign_orders_to_courier.php">
                    <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['booking_id']); ?>">

                    <!-- Display all details of the booking -->
                    <p><strong>Booking ID:</strong> <?= htmlspecialchars($booking['booking_id']); ?></p>
                    <p><strong>Username:</strong> <?= htmlspecialchars($booking['username']); ?></p>
                    <p><strong>Service Type:</strong> <?= htmlspecialchars($booking['service_name']); ?></p>
                    <p><strong>PickUp Date:</strong> <?= htmlspecialchars($booking['delivery_date']); ?></p>
                    <p><strong>PickUp Time:</strong> <?= htmlspecialchars($booking['delivery_time']); ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($booking['phone']); ?></p>
                    <p><strong>Number of Shoes:</strong> <?= htmlspecialchars($booking['number_of_shoes']); ?></p>
                    <p><strong>Shoe Type:</strong> <?= htmlspecialchars($booking['shoe_type_name']); ?></p>
                    <p><strong>Material Type:</strong> <?= htmlspecialchars($booking['material_name']); ?></p>

                    <select name="courier_id" required>
                        <option value="">Select Courier</option>
                        <?php foreach ($available_couriers as $courier): ?>
                            <option value="<?= $courier['employee_id']; ?>"><?= $courier['fname'] . ' ' . $courier['lname']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" name="assign_courier">Assign to Courier</button>
                </form>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No new orders need assignment, or no available couriers.</p>
        <?php endif; ?>
    </div>

    <a href="assign_orders.php" class="back-button">Back to Assign Orders</a>
</div>
</body>
</html>
