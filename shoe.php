<?php
session_start();
require('db.php');

// Fetch Shoe Types and Materials
$query_shoe_types = "SELECT * FROM shoe_types";
$shoe_types_result = $conn->query($query_shoe_types);

$query_materials = "SELECT * FROM materials";
$materials_result = $conn->query($query_materials);

// Add, Delete, and Edit Shoe Types
if (isset($_POST['add_shoe_type'])) {
    $shoe_type = $_POST['shoe_type'];
    $stmt = $conn->prepare("INSERT INTO shoe_types (shoe_type_name) VALUES (?)");
    $stmt->bind_param("s", $shoe_type);
    $stmt->execute();
    header("Location: shoe.php");
    exit();
}

if (isset($_POST['delete_shoe_type'])) {
    $shoe_type_id = $_POST['shoe_type_id'];
    $stmt = $conn->prepare("DELETE FROM shoe_types WHERE shoe_type_id = ?");
    $stmt->bind_param("i", $shoe_type_id);
    $stmt->execute();
    header("Location: shoe.php");
    exit();
}

if (isset($_POST['save_shoe_type'])) {
    $shoe_type_id = $_POST['shoe_type_id'];
    $shoe_type_name = $_POST['shoe_type_name'];
    $stmt = $conn->prepare("UPDATE shoe_types SET shoe_type_name = ? WHERE shoe_type_id = ?");
    $stmt->bind_param("si", $shoe_type_name, $shoe_type_id);
    $stmt->execute();
    header("Location: shoe.php");
    exit();
}

// Add, Delete, and Edit Materials
if (isset($_POST['add_material'])) {
    $material_name = $_POST['material_name'];
    $stmt = $conn->prepare("INSERT INTO materials (material_name) VALUES (?)");
    $stmt->bind_param("s", $material_name);
    $stmt->execute();
    header("Location: shoe.php");
    exit();
}

if (isset($_POST['delete_material'])) {
    $material_id = $_POST['material_id'];
    $stmt = $conn->prepare("DELETE FROM materials WHERE material_id = ?");
    $stmt->bind_param("i", $material_id);
    $stmt->execute();
    header("Location: shoe.php");
    exit();
}

if (isset($_POST['save_material'])) {
    $material_id = $_POST['material_id'];
    $material_name = $_POST['material_name'];
    $stmt = $conn->prepare("UPDATE materials SET material_name = ? WHERE material_id = ?");
    $stmt->bind_param("si", $material_name, $material_id);
    $stmt->execute();
    header("Location: shoe.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shoe Types and Materials</title>
    <link rel="stylesheet" href="shoe.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Shoe Laundry</h2>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="customers.php">Customers</a></li>
        <li><a href="admin_orders.php">Orders</a></li>
        <li><a href="report.php">Report</a></li>
        <li><a href="employees.php">Employees</a></li>
        <li><a href="payments.php">Payments</a></li>
        <li><a href="admin_inventory.php">Inventory</a></li>
        <li><a href="assign_orders.php">Assign Orders</a></li>
        <li><a href="add_services.php">Add Services</a></li>
        <li><a href="shoe.php" class="active">Shoes</a></li>
        <li><a href="message.php" class="<?= $current_page == 'message.php' ? 'active' : '' ?>">Messages</a></li>

        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<div class="section-container">
    <!-- Shoe Types Section -->
    <section class="type-box">
        <h2>SHOE TYPES</h2>
        <table>
            <tr>
                <th>Shoe Type ID</th>
                <th>Shoe Type Name</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $shoe_types_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['shoe_type_id']; ?></td>
                <td>
                    <?php if (isset($_POST['edit_shoe_type_id']) && $_POST['edit_shoe_type_id'] == $row['shoe_type_id']): ?>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="shoe_type_id" value="<?php echo $row['shoe_type_id']; ?>">
                            <input type="text" name="shoe_type_name" value="<?php echo htmlspecialchars($row['shoe_type_name']); ?>">
                            <button type="submit" name="save_shoe_type">Save</button>
                        </form>
                    <?php else: ?>
                        <?php echo htmlspecialchars($row['shoe_type_name']); ?>
                    <?php endif; ?>
                </td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="edit_shoe_type_id" value="<?php echo $row['shoe_type_id']; ?>">
                        <button type="submit">Edit</button>
                    </form>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="shoe_type_id" value="<?php echo $row['shoe_type_id']; ?>">
                        <button type="submit" class="dbtn" name="delete_shoe_type">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <form method="POST">
            <input type="text" name="shoe_type" placeholder="Enter shoe type">
            <button type="submit" name="add_shoe_type">Add Shoe Type</button>
        </form>
    </section>

    <!-- Materials Section -->
    <section class="material-box">
        <h2>MATERIALS</h2>
        <table>
            <tr>
                <th>Material ID</th>
                <th>Material Name</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $materials_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['material_id']; ?></td>
                <td>
                    <?php if (isset($_POST['edit_material_id']) && $_POST['edit_material_id'] == $row['material_id']): ?>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="material_id" value="<?php echo $row['material_id']; ?>">
                            <input type="text" name="material_name" value="<?php echo htmlspecialchars($row['material_name']); ?>">
                            <button type="submit" name="save_material">Save</button>
                        </form>
                    <?php else: ?>
                        <?php echo htmlspecialchars($row['material_name']); ?>
                    <?php endif; ?>
                </td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="edit_material_id" value="<?php echo $row['material_id']; ?>">
                        <button type="submit">Edit</button>
                    </form>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="material_id" value="<?php echo $row['material_id']; ?>">
                        <button type="submit" class="dbtn" name="delete_material">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <form method="POST">
            <input type="text" name="material_name" placeholder="Enter material name">
            <button type="submit" name="add_material">Add Material</button>
        </form>
    </section>
</div>

</body>
</html>
