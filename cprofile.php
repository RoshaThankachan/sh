<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include('db.php');

$username = $_SESSION['username'];

$query = "SELECT employee_id, fname, lname, username, department,  phone, status FROM employees WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header('Location: courier_staff.php');
    exit();
}

$employee = mysqli_fetch_assoc($result);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Staff Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="cp.css">
</head>
<body>
    <div class="topbar">
        <h2>Shoe Laundry</h2>
        <h2>Courier Staff Profile</h2>
        <ul>
        <li><a href="courier_staff.php">Dashboard</a></li>
                <li><a href="cprofile.php"  class="active">Profile</a></li>
                <li><a href="cattendance.php">Attendance</a></li>
                <li><a href="cnot.php">Notifications</a></li>
                <li><a href="corders.php">Orders</a></li>
                <li><a href="pickup.php"  >PickUp</a></li>
                <li><a href="courier_delivery.php">Out for delivery</a></li> 
                <li><a href="cor.php">Orders Delivered </a></li>
                <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Profile Details</h1>
  
        </div>

        <div class="employee-details">
            <table>
                <tr>
                    <th>Employee ID</th>
                    <td><?php echo htmlspecialchars($employee['employee_id']); ?></td>
                </tr>
                <tr>
                    <th>First Name</th>
                    <td><?php echo htmlspecialchars($employee['fname']); ?></td>
                </tr>
                <tr>
                    <th>Last Name</th>
                    <td><?php echo htmlspecialchars($employee['lname']); ?></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?php echo htmlspecialchars($employee['username']); ?></td>
                </tr>
                
                <tr>
                    <th>Phone</th>
                    <td><?php echo htmlspecialchars($employee['phone']); ?></td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td><?php echo htmlspecialchars($employee['department']); ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?php echo htmlspecialchars($employee['status']); ?></td>
                </tr>
            </table>
        </div>

        <!-- Edit Details Button -->
        <div>
            <a href="editcprofile.php" class="edit-button">Edit Details</a>
        </div>
    </div>
</body>
</html>
