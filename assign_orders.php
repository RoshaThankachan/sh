<?php
session_start();
include('db_connect.php'); // Include your database connection file

$current_page = basename($_SERVER['PHP_SELF']);

// Fetch new bookings that need to be assigned to courier employees first
$new_orders_query = "SELECT b.booking_id, b.username, s.service_name, b.delivery_date, b.delivery_time, 
                     b.phone, b.number_of_shoes, b.shoe_type, b.material_type 
                     FROM bookings b 
                     JOIN services s ON b.service_type = s.service_id
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

// Fetch orders that are ready to be assigned to non-courier employees after collection
$ready_orders_query = "SELECT b.booking_id, b.username, b.service_type, b.delivery_date, b.delivery_time, 
                       b.phone, b.number_of_shoes, b.shoe_type, b.material_type 
                       FROM bookings b 
                       WHERE b.booking_status = 'Paid' AND b.courier_status = 'Collected'";
$ready_orders_result = mysqli_query($conn, $ready_orders_query);

// Fetch available and active non-courier employees for further assignment
$available_employees_query = "SELECT employee_id, fname, lname 
                              FROM employees 
                              WHERE is_available = 1 AND status = 'active' AND department != 'Courier'";  
$available_employees_result = mysqli_query($conn, $available_employees_query);

// Create an array to hold non-courier employee information
$available_employees = [];
while ($employee = mysqli_fetch_assoc($available_employees_result)) {
    $available_employees[] = $employee;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Orders</title>
    <link rel="stylesheet" href="ascss.css"> <!-- Link to your CSS file -->
    <style>
        .assign-button {
            display: inline-block;
            padding: 20px 40px;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            color: white;
            background-color: #007bff;
            border-radius: 5px;
            text-decoration: none;
            margin: 20px 0;
        }

        .assign-button:hover {
            background-color: #0056b3;
        }

        .order-list {
            width: 885px;
            margin-bottom: 30px;
        }

        .order-list table {
            width: 99%;
            border-collapse: collapse;
        }

        .order-list th, .order-list td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
    </style>
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
        <h1>Assign Orders</h1>
    </div>

    <!-- Display new orders -->
    <div class="order-list">
        <h2>NEW ORDERS</h2>
        <?php if (mysqli_num_rows($new_orders_result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Username</th>
                        <th>Service Type</th>
                        <th>Delivery Date</th>
                        <th>Delivery Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($booking = mysqli_fetch_assoc($new_orders_result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($booking['booking_id']); ?></td>
                            <td><?= htmlspecialchars($booking['username']); ?></td>
                            <td><?= htmlspecialchars($booking['service_name']); ?></td>

                            <td><?= htmlspecialchars($booking['delivery_date']); ?></td>
                            <td><?= htmlspecialchars($booking['delivery_time']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No new orders available for assignment.</p>
        <?php endif; ?>
    </div>

    <!-- Buttons to navigate to assignment pages -->
    <div class="assignment-buttons">
        <a href="assign_orders_to_courier.php" class="assign-button">Assign to Courier</a>
        <a href="assign_orders_to_employees.php" class="assign-button">Assign to Employees</a>
        <div class="assignment-buttons">

    <a href="assign_completed_orders.php" class="assign-button">Assign Completed Orders</a>
</div>

    </div>
</div>
</body>
</html>
