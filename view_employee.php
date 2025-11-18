<?php
session_start();
include('db_connect.php'); // Include your database connection

// Check if employee_id is set in the URL
if (isset($_GET['id'])) {
    $employee_id = intval($_GET['id']); // Sanitize the input to prevent SQL injection

    // Fetch employee details from the database
    $query = "SELECT * FROM employees WHERE employee_id = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if employee was found
        if ($result->num_rows > 0) {
            $employee = $result->fetch_assoc();
        } else {
            // Redirect or show error if employee not found
            echo "Employee not found.";
            exit;
        }
        
        $stmt->close(); // Close the prepared statement
    } else {
        echo "Error preparing query.";
        exit;
    }
} else {
    // Redirect or show error if no ID provided
    echo "Invalid request.";
    exit;
}

mysqli_close($conn); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <link rel="stylesheet" href="vmp.css">
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
            <h1>Employee Details</h1>
        </div>

        <div class="employee-details">
            <h2><?php echo htmlspecialchars($employee['fname']) . ' ' . htmlspecialchars($employee['lname']); ?></h2>

            <p><strong>Employee ID:</strong> <?php echo htmlspecialchars($employee['employee_id']); ?></p>
            <p><strong>Department:</strong> <?php echo htmlspecialchars($employee['department']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($employee['status']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($employee['phone']); ?></p>
            <p><strong>Performance Score:</strong> <?php echo htmlspecialchars($employee['performance_score']); ?></p>
            <p><strong>Attendance:</strong> <?php echo htmlspecialchars($employee['attendance']); ?></p>
            <p><strong>Created At:</strong> <?php echo htmlspecialchars($employee['created_at']); ?></p>
            <p><strong>Updated At:</strong> <?php echo htmlspecialchars($employee['updated_at']); ?></p>

            <a href="employees.php" class="back-button">Back to Employee List</a>
        </div>
    </div>

</body>
</html>
