<?php
session_start();
include('db_connect.php'); // Include your database connection

$error_message = ""; // Initialize error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form inputs
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Validate phone number (10 digits)
    $phone = trim($_POST['phone']);
    if (!preg_match('/^\d{10}$/', $phone)) {
        $error_message = "Invalid phone number. Please enter a 10-digit phone number.";
    } else {
        // Sanitize phone number
        $phone = mysqli_real_escape_string($conn, $phone);

        // Insert the new employee into the database
        $query = "INSERT INTO employees (fname, lname, username, password, phone, department, status) 
                  VALUES ('$fname', '$lname', '$username', '$password', '$phone', '$department', '$status')";
        if (mysqli_query($conn, $query)) {
            header('Location: employees.php'); // Redirect to employees list
            exit();
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Employee</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="empadd.css">
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
            <h1>Add New Employee</h1>
        </div>

        <form method="POST" action="">
    <label for="fname">First Name:</label>
    <input type="text" id="fname" name="fname" value="<?= htmlspecialchars($_POST['fname'] ?? '') ?>" required>

    <label for="lname">Last Name:</label>
    <input type="text" id="lname" name="lname" value="<?= htmlspecialchars($_POST['lname'] ?? '') ?>" required>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>

    <label for="password">Password:</label>
    <input type="text" id="password" name="password" value="<?= htmlspecialchars($_POST['password'] ?? '') ?>" required>

    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required 
           pattern="^\d{10}$" title="Phone number must be 10 digits long">
    <small style="color: red;"><?= $error_message ?></small>

    <label for="department">Department:</label>
    <input type="text" id="department" name="department" value="<?= htmlspecialchars($_POST['department'] ?? '') ?>" required>

    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="Active" <?= isset($_POST['status']) && $_POST['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
        <option value="Inactive" <?= isset($_POST['status']) && $_POST['status'] == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
    </select>

    <button type="submit" class="add-employee-btn">Add Employee</button>
</form>
<div class="button-container">
    <a href="employees.php" class="Back-btn">Back to Employee</a>
</div>

     
    </div>

</body>
</html>
