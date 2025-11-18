<?php
// Start session and connect to the database
session_start();
include('db.php'); // Assume you have a db_connection.php file for database connection

// Fetch inventory items
$query = "SELECT * FROM inventory";
$result = mysqli_query($conn, $query);

if(!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="inven.css">
</head>
<body>
<div class="notification-container">
        <!-- Sidebar Menu -->
        <div class="topbar">
        <h2>Shoe Laundry</h2> <!-- Add this line for the Shoe Laundry heading -->
            <h2>Inventory Items</h2>
            <ul>
            <li><a href="dash.php" ><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="emm.php"><i class="fas fa-user"></i> Profile</a></li>
        <li><a href="attendance.php"><i class="fas fa-calendar-check"></i> Attendance</a></li>
        <li><a href="notification.php"><i class="fas fa-bell"></i> Notifications</a></li>
        <li><a href="inventory.php" class="active"><i class="fas fa-boxes"></i> Inventory</a></li>
        <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
        <li><a href="or.php" ><i class="fas fa-shopping-cart"></i> Orders Managed</a></li>

        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>


<h2>Inventory List</h2>
<div class="main-content">
<header>
        <h1>Inventory</h1>
    </header>

<table border="1">
    <tr>
        <th>Item Name</th>
        <th>Quantity</th>
        <th>Action</th>
    </tr>

    <?php
    // Loop through the inventory items and display them
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['item_name'] . "</td>";
        echo "<td>" . $row['stock'] . "</td>";
        echo "<td>
                <form method='POST' action='use_item.php'>
                    <input type='hidden' name='item_id' value='" . $row['item_id'] . "'>
                    <input type='number' name='used_quantity' min='1' max='" . $row['stock'] . "' placeholder='Qty used' required>
                    <button type='submit'>Use Item</button>
                </form>
              </td>";
        echo "</tr>";
    }
    ?>

</table>
</div>
</body>
</html>
