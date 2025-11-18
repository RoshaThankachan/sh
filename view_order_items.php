<?php
session_start();
include('db_connect.php');

$item_id = $_GET['item_id'];

// Fetch the item details and usage log
$item_query = "SELECT item_name FROM inventory WHERE item_id = ?";
$stmt = mysqli_prepare($conn, $item_query);
mysqli_stmt_bind_param($stmt, 'i', $item_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $item_name);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Fetch usage log for the item
$usage_query = "
    SELECT u.used_quantity, u.usage_date, e.fname, e.lname
    FROM inventory_usage u
    JOIN employees e ON u.employee_id = e.employee_id
    WHERE u.item_id = ?
    ORDER BY u.usage_date DESC";
$usage_stmt = mysqli_prepare($conn, $usage_query);
mysqli_stmt_bind_param($usage_stmt, 'i', $item_id);
mysqli_stmt_execute($usage_stmt);
$usage_result = mysqli_stmt_get_result($usage_stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Item Usage</title>
    <link rel="stylesheet" href="orview.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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
       <!-- Main Content -->
       <div class="main-content">
        <div class="header">
            <h1>Usage Log for <?php echo htmlspecialchars($item_name); ?></h1>
           
        </div>
    <table border="1">
        <tr>
            <th>Staff Name</th>
            <th>Quantity Used</th>
            <th>Date</th>
        </tr>

        <?php while ($usage = mysqli_fetch_assoc($usage_result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($usage['fname'] . " " . $usage['lname']); ?></td>
                <td><?php echo htmlspecialchars($usage['used_quantity']); ?></td>
                <td><?php echo htmlspecialchars($usage['usage_date']); ?></td>
            </tr>
        <?php endwhile; ?>

    </table>
    <div class="button-container">
        <a href="admin_inventory.php" class="back-button">Back to Inventory</a>
    </div>
</body>
</html>
