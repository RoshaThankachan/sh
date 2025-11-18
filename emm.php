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
    header('Location: dash.php');
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
    <link rel="stylesheet" href="empl.css">
</head>
<body>
    <div class="topbar">
        <h2>Shoe Laundry</h2>
        <h2>Staff Dashboard</h2>
        <ul>
                <li><a href="dash.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="emm.php" class="active"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="attendance.php"><i class="fas fa-calendar-check"></i> Attendance</a></li>
                <li><a href="notification.php"><i class="fas fa-bell"></i> Notifications</a></li>
                <li><a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a></li>
                <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <li><a href="or.php"><i class="fas fa-shopping-cart"></i> Orders Managed</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
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
            <a href="edit_profile.php" class="edit-button">Edit Details</a>
        </div>
    </div>
</body>
</html>
