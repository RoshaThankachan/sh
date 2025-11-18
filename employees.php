<?php
session_start();
include('db_connect.php'); // Include your database connection
$current_page = basename($_SERVER['PHP_SELF']);

// Fetch employees from the database without grouping by department
$query = "SELECT employee_id, fname, status FROM employees";
$result = mysqli_query($conn, $query);
$employees = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>
    <link rel="stylesheet" href="emcss.css">
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
            <h1>Employees Management</h1>
            <p>List of all employees</p>
        </div>

        <!-- Display Status Update Message -->
        <?php if (isset($_SESSION['status_message'])): ?>
            <div class="status-message">
                <?php 
                    echo $_SESSION['status_message']; 
                    unset($_SESSION['status_message']); // Clear the message after displaying
                ?>
            </div>
        <?php endif; ?>

        <div class="employee-list">
            <?php if (empty($employees)): ?>
                <p>No employees found.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($employee['employee_id']); ?></td>
                            <td><?php echo htmlspecialchars($employee['fname']); ?></td>
                            <td><?php echo htmlspecialchars($employee['status']); ?></td>
                            <td>
                                <a href="view_employee.php?id=<?php echo $employee['employee_id']; ?>">View</a> |
                                <?php if ($employee['status'] == 'inactive'): ?>
                                    <a href="edit_status.php?id=<?php echo $employee['employee_id']; ?>&status=active">Set Active</a>
                                <?php else: ?>
                                    <a href="edit_status.php?id=<?php echo $employee['employee_id']; ?>&status=inactive">Set Inactive</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            
            <!-- Centered button container -->
            <div class="button-container">
                <a href="add_employee.php" class="add-employee-button">Add New Employee</a>
            </div>
        </div>
    </div>

</body>
</html>
