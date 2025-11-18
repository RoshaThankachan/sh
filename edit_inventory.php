<?php
session_start();
include('db_connect.php'); // Database connection

// CSRF Protection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }
}
$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;

// Check if the item ID is set and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $item_id = intval($_GET['id']);

    // Fetch the existing item details
    $stmt = $conn->prepare("SELECT * FROM inventory WHERE item_id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        $_SESSION['message'] = "Item not found.";
        $_SESSION['alert_type'] = 'error';
        header('Location: admin_inventory.php');
        exit;
    }
} else {
    $_SESSION['message'] = "Invalid item ID.";
    $_SESSION['alert_type'] = 'error';
    header('Location: admin_inventory.php');
    exit;
}

// Handle form submission for updating the item
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);
    $item_description = filter_input(INPUT_POST, 'item_description', FILTER_SANITIZE_STRING);
    $reorder_level = filter_input(INPUT_POST, 'reorder_level', FILTER_VALIDATE_INT);
    $supplier_name = filter_input(INPUT_POST, 'supplier_name', FILTER_SANITIZE_STRING);
    $last_restock_date = filter_input(INPUT_POST, 'last_restock_date', FILTER_SANITIZE_STRING);

    if ($price === false || $stock === false || $reorder_level === false || 
        empty($item_description) || empty($supplier_name) || empty($last_restock_date)) {
        $_SESSION['message'] = "Invalid input. Please check your data and try again.";
        $_SESSION['alert_type'] = 'error';
    } else {
        // Prepare and bind the update statement
        $stmt = $conn->prepare("UPDATE inventory SET price = ?, stock = ?, item_description = ?, reorder_level = ?, supplier_name = ?, last_restock_date = ? WHERE item_id = ?");
        $stmt->bind_param("diisssi", $price, $stock, $item_description, $reorder_level, $supplier_name, $last_restock_date, $item_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Inventory item updated successfully!";
            $_SESSION['alert_type'] = 'success';
        } else {
            $_SESSION['message'] = "Error updating inventory item. Please try again.";
            $_SESSION['alert_type'] = 'error';
        }
    }

    // Redirect to the inventory page after updating
    header('Location: admin_inventory.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Inventory Item</title>
    <link rel="stylesheet" href="edin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .inventory-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-actions {
            grid-column: 1 / -1;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }
        .btn-submit,
        .btn-cancel,
        .btn-back {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }
        .btn-submit {
            background-color: #4CAF50;
            color: white;
        }
        .btn-cancel,
        .btn-back {
            background-color: #f44336;
            color: white;
        }
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
        }
        .alert.success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .alert.error {
            background-color: #f2dede;
            color: #a94442;
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
            <h1>Edit Inventory Item</h1>
        </div>

        <!-- Display message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert <?php echo $_SESSION['alert_type']; ?>">
                <?php 
                    echo htmlspecialchars($_SESSION['message']); 
                    unset($_SESSION['message']); // Clear the message after displaying it
                ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="inventory-form" id="editInventoryForm">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($item['price']); ?>" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($item['stock']); ?>" required min="0">
            </div>
            <div class="form-group">
                <label for="item_description">Item Description:</label>
                <textarea id="item_description" name="item_description" required><?php echo htmlspecialchars($item['item_description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="reorder_level">Reorder Level:</label>
                <input type="number" id="reorder_level" name="reorder_level" value="<?php echo htmlspecialchars($item['reorder_level']); ?>" required min="0">
            </div>
            <div class="form-group">
                <label for="supplier_name">Supplier Name:</label>
                <input type="text" id="supplier_name" name="supplier_name" value="<?php echo htmlspecialchars($item['supplier_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_restock_date">Last Restock Date:</label>
                <input type="date" id="last_restock_date" name="last_restock_date" value="<?php echo htmlspecialchars($item['last_restock_date']); ?>" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit">Update Item</button>
                <a href="admin_inventory.php" class="btn-cancel">Cancel</a>
            </div>
        </form>

        <!-- Back to Inventory Button -->
        <div class="back-btn">
            <a href="admin_inventory.php" class="btn-back">Back to Inventory</a>
        </div>
    </div>

    <script>
        document.getElementById('editInventoryForm').addEventListener('submit', function(event) {
            var price = document.getElementById('price').value;
            var stock = document.getElementById('stock').value;
            var reorderLevel = document.getElementById('reorder_level').value;
            var supplierName = document.getElementById('supplier_name').value;
            var lastRestockDate = document.getElementById('last_restock_date').value;

            if (isNaN(price) || price <= 0) {
                alert('Please enter a valid price.');
                event.preventDefault();
                return;
            }

            if (!Number.isInteger(Number(stock)) || stock < 0) {
                alert('Please enter a valid stock quantity.');
                event.preventDefault();
                return;
            }

            if (!Number.isInteger(Number(reorderLevel)) || reorderLevel < 0) {
                alert('Please enter a valid reorder level.');
                event.preventDefault();
                return;
            }

            if (supplierName.trim() === '') {
                alert('Please enter a supplier name.');
                event.preventDefault();
                return;
            }

            if (lastRestockDate === '') {
                alert('Please enter a valid last restock date.');
                event.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>