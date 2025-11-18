<?php
// Database connection
include('connect.php');
$current_page = basename($_SERVER['PHP_SELF']);


// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM services WHERE service_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: add_services.php"); // Refresh the list after deletion
    exit();
}

// Handle add service request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_name = $_POST['service_name'];
    $service_category = $_POST['service_category'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $photo = $_POST['photo'];

    $add_query = "INSERT INTO services (service_name, service_category, price, description, photo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($add_query);
    $stmt->bind_param("ssdss", $service_name, $service_category, $price, $description, $photo);
    $stmt->execute();
    $stmt->close();
    header("Location: add_services.php"); // Refresh the page after adding
    exit();
}

// Fetch all services
$sql = "SELECT * FROM services";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Services</title>
    <link rel="stylesheet" href="adds.css">
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
        <h1>SERVICES</h1>

        <!-- Add Service Button -->
        <button id="addServiceBtn" class="add-button">Add a New Service</button>

        <table>
            <tr>
                <th>Service ID</th>
                <th>Service Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Description</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['service_id']; ?></td>
                        <td><?php echo $row['service_name']; ?></td>
                        <td><?php echo $row['service_category']; ?></td>
                        <td><?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><img src="<?php echo $row['photo']; ?>" alt="Service Photo" width="80"></td>
                        <td>
                            <button class="edit" onclick="window.location.href='edit_service.php?id=<?php echo $row['service_id']; ?>'">Edit</button>
                            <button class="delete" onclick="if(confirm('Are you sure you want to delete this service?')) window.location.href='add_services.php?delete_id=<?php echo $row['service_id']; ?>'">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No services found.</td>
                </tr>
            <?php endif; ?>
        </table>

        <!-- Modal for Adding New Service -->
        <div id="addServiceModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('addServiceModal').style.display='none'">&times;</span>
                <h2>Add New Service</h2>
                <form method="POST" action="">
                    <label for="service_name">Service Name:</label>
                    <input type="text" name="service_name" required><br>

                    <label for="service_category">Category:</label>
                    <select name="service_category" required>
                        <option value="Main">Main</option>
                        <option value="Add-on">Add-on</option>
                    </select><br>

                    <label for="price">Price:</label>
                    <input type="number" step="0.01" name="price" required><br>

                    <label for="description">Description:</label>
                    <textarea name="description" required></textarea><br>

                    <label for="photo">Photo URL:</label>
                    <input type="text" name="photo" required><br>

                    <button type="submit" class="add">Add Service</button>
                </form>
            </div>
        </div>

        <script>
            // Open the Add Service Modal
            document.getElementById('addServiceBtn').onclick = function() {
                document.getElementById('addServiceModal').style.display = 'flex';
            }

            // Close the modal when clicking outside of it
            window.onclick = function(event) {
                const modal = document.getElementById('addServiceModal');
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
    </div>

</body>
</html>

<?php
$conn->close();
?>
