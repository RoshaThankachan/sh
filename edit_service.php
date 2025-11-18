<?php
// Database connection
// Database connection
include('connect.php'); // Include your database connection
$current_page = basename($_SERVER['PHP_SELF']);

// Get service details for editing
$service_id = $_GET['id'];
$sql = "SELECT * FROM services WHERE service_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $service_id);
$stmt->execute();
$result = $stmt->get_result();
$service = $result->fetch_assoc();

// Handle form submission for editing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_name = $_POST['service_name'];
    $service_category = $_POST['service_category'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $photo = $_POST['photo'];

    $update_query = "UPDATE services SET service_name = ?, service_category = ?, price = ?, description = ?, photo = ? WHERE service_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssdssi", $service_name, $service_category, $price, $description, $photo, $service_id);

    if ($stmt->execute()) {
        header("Location: add_services.php"); // Redirect after editing
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Service</title>
    <link rel="stylesheet" href="eds.css">

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
<h2>Edit Service</h2>
<form method="POST" action="">
    <label for="service_name">Service Name:</label>
    <input type="text" name="service_name" value="<?php echo $service['service_name']; ?>" required><br><br>

    <label for="service_category">Category:</label>
    <select name="service_category" required>
        <option value="Main" <?php if ($service['service_category'] == 'Main') echo 'selected'; ?>>Main</option>
        <option value="Add-on" <?php if ($service['service_category'] == 'Add-on') echo 'selected'; ?>>Add-on</option>
    </select><br><br>

    <label for="price">Price:</label>
    <input type="number" step="0.01" name="price" value="<?php echo $service['price']; ?>" required><br><br>

    <label for="description">Description:</label>
    <textarea name="description" required><?php echo $service['description']; ?></textarea><br><br>

    <label for="photo">Photo URL:</label>
    <input type="text" name="photo" value="<?php echo $service['photo']; ?>" required><br><br>

    <button type="submit">Update Service</button>
</form>

</body>
</html>
