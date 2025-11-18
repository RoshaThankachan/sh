<?php
session_start();
include('db_connect.php'); // Database connection

// Initialize message variable
$message = '';

// Fetch inventory details from the database
$query = "SELECT * FROM inventory";
$result = mysqli_query($conn, $query);

// Handle item creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_item'])) {
    $item_name = $_POST['item_name'];
    $item_description = $_POST['item_description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $reorder_level = $_POST['reorder_level'];
    $supplier_name = $_POST['supplier_name'];

    // Prepare and bind the statement to prevent SQL injection
    $stmt = $conn->prepare(
        "INSERT INTO inventory 
        (item_name, item_description, price, stock, reorder_level, supplier_name) 
        VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "ssdiii",
        $item_name,
        $item_description,
        $price,
        $stock,
        $reorder_level,
        $supplier_name,
    );

    if ($stmt->execute()) {
        $_SESSION['message'] = "New inventory item created successfully!";
    } else {
        $_SESSION['message'] = "Error creating inventory item. Please try again.";
    }
}

// Handle item deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_item'])) {
    $item_id = $_POST['item_id'];

    // Prepare and bind the statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM inventory WHERE item_id = ?");
    $stmt->bind_param("i", $item_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Inventory item deleted successfully!";
    } else {
        $_SESSION['message'] = "Error deleting inventory item. Please try again.";
    }

    // Redirect to avoid form resubmission
    header("Location: admin_inventory.php");
    exit();
}

// Clear message after displaying it
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Determine the current page
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="invent.css">
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
            <h1>Inventory</h1>
        </div>

        <!-- Display message -->
        <?php if ($message): ?>
            <div class="alert success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <table class="inventory-table">
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['item_id']); ?></td>
                        <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                        <td>₹<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($item['stock']); ?></td>
                        <td>
                            <a href="edit_inventory.php?id=<?php echo htmlspecialchars($item['item_id']); ?>" class="btn-edit">Edit</a>
                            <a href="view_order_items.php?item_id=<?php echo htmlspecialchars($item['item_id']); ?>" class="btn-view">View</a>
                            <form method="POST" action="admin_inventory.php" style="display:inline;">
                                <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['item_id']); ?>">
                                <input type="submit" name="delete_item" value="Delete" class="btn-delete" onclick="return confirm('Are you sure you want to delete this item?');">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <button id="create-item-btn" class="btn-create">Create New Item</button>

        <div class="new-item-form" style="display:none;">
    <h2>Add New Inventory Item</h2>
    <form method="POST" action="admin_inventory.php">
        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" required>

        <label for="item_description">Item Description:</label>
        <textarea name="item_description" rows="3" required></textarea>

        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" required>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" required>

        <label for="reorder_level">Reorder Level:</label>
        <input type="number" name="reorder_level" required>

        <label for="supplier_name">Supplier Name:</label>
        <input type="text" name="supplier_name" required>

        <input type="submit" name="create_item" value="Create Item">
        <button type="button" class="btn-cancel" onclick="toggleNewItemForm()">Cancel</button>
    </form>
</div>

    </div>

    <script>
        // Function to toggle the visibility of the new item form
        document.getElementById('create-item-btn').onclick = function() {
            var form = document.querySelector('.new-item-form');
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        }

        function toggleNewItemForm() {
            var form = document.querySelector('.new-item-form');
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        }
    </script>

</body>
</html>
