<?php
session_start();
include('db_connect.php'); // Include your database connection file

$current_page = basename($_SERVER['PHP_SELF']);

// Fetch orders that are ready to be assigned to non-courier employees after collection
// Fetch orders ready for assignment
$ready_orders_query = "
    SELECT b.booking_id, b.username, b.service_type, b.delivery_date, b.delivery_time, 
           b.phone, b.number_of_shoes, st.shoe_type_name, mt.material_name
    FROM bookings b
    LEFT JOIN shoe_types st ON b.shoe_type = st.shoe_type_id
    LEFT JOIN materials mt ON b.material_type = mt.material_id
    WHERE b.courier_status = 'Assigned' 
    AND b.pickup_status = 'Delivered' 
    AND (b.employee_id IS NULL OR b.booking_status != 'Assigned')";
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

// Handle manual assignment to non-courier employees
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign_employee'])) {
    $booking_id = $_POST['booking_id'];
    $employee_id = $_POST['employee_id'];

    // Update the booking status and assigned employee in the bookings table
    $update_booking_query = "UPDATE bookings SET booking_status = 'Assigned', employee_id = ? WHERE booking_id = ?";
    $stmt = mysqli_prepare($conn, $update_booking_query);
    mysqli_stmt_bind_param($stmt, 'ii', $employee_id, $booking_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: assign_orders_to_employees.php");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Orders to Employees</title>
    <link rel="stylesheet" href="ase.css"> <!-- Link to your CSS file -->
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
    <h1>Assign Orders to Employees</h1>
    
 
    <div class="assignments-section">
    <?php if (mysqli_num_rows($ready_orders_result) > 0 && count($available_employees) > 0): ?>
        <?php while ($booking = mysqli_fetch_assoc($ready_orders_result)): ?>
            <form method="POST" action="assign_orders_to_employees.php">
                <div class="assignment-card">
                    <h3>Booking ID: <?= htmlspecialchars($booking['booking_id']); ?></h3>
                    <p><strong>Username:</strong> <?= htmlspecialchars($booking['username']); ?></p>
                    <p><strong>Service Type:</strong> <?= htmlspecialchars($booking['service_type']); ?></p>
                    <p><strong>Pickup Date:</strong> <?= htmlspecialchars($booking['delivery_date']); ?></p>
                    <p><strong>Pickup Time:</strong> <?= htmlspecialchars($booking['delivery_time']); ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($booking['phone']); ?></p>
                    <p><strong>No. of Shoes:</strong> <?= htmlspecialchars($booking['number_of_shoes']); ?></p>
                    <p><strong>Shoe Type:</strong> <?= htmlspecialchars($booking['shoe_type_name']); ?></p>
<p><strong>Material Type:</strong> <?= htmlspecialchars($booking['material_name']); ?></p>

                    <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['booking_id']); ?>">
                    <select name="employee_id" required>
                        <?php foreach ($available_employees as $employee): ?>
                            <option value="<?= htmlspecialchars($employee['employee_id']); ?>">
                                <?= htmlspecialchars($employee['fname'] . " " . $employee['lname']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="assign_employee">Assign</button>
                </div>
            </form>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No ready orders or no available non-courier employees for assignment.</p>
    <?php endif; ?>
</div>

       <!-- Back Button -->
       <a href="assign_orders.php" class="back-button">Back to Assigned Orders</a>

</div>

<!-- Add styles for the Back button -->
<style>
    .back-button {
        display: inline-block;
        padding: 10px 20px;
        font-size: 18px;
        color: white;
        background-color: #28a745;
        border-radius: 5px;
        text-decoration: none;
        margin-bottom: 20px;
    }

    .back-button:hover {
        background-color: #218838;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>
</body>
</html>