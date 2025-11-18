<?php
// Start session and connect to the database
session_start();
include('db.php'); 
$employee_id = $_SESSION['employee_id'];

// Fetch attendance records
$query = "SELECT * FROM attendance WHERE employee_id = ? ORDER BY attendance_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$attendance_records = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <link rel="stylesheet" href="viewat.css">
</head>
<body>
<div class="topbar">  <h2>Shoe Laundry</h2> <!-- Add this line for the Shoe Laundry heading -->
<h2>View Attendance</h2>
        <ul>
        <li><a href="courier_staff.php" ><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="cprofile.php" ><i class="fas fa-user"></i> Profile</a></li>
        <li><a href="cattendance.php" class="active"><i class="fas fa-calendar-check"></i> Attendance</a></li>
        <li><a href="cnot.php"><i class="fas fa-bell"></i> Notifications</a></li>
        <li><a href="cdelivery.php"><i class="fas fa-boxes"></i> Delivery</a></li>
        <li><a href="corders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
        <li><a href="cor.php"><i class="fas fa-shopping-cart"></i> Orders Delivered</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
    </div>
    <div class="dashboard-container">
        <div class="main-content">
            <header>
                <h1>Your Attendance History</h1>
            </header>

            <section class="attendance-history-section">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($attendance = $attendance_records->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $attendance['attendance_date']; ?></td>
                                <td><?php echo $attendance['status']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
            
        <!-- Back Button -->
        <div class="back-btn">
            <a href="cattendance.php" class="btn">Back to Attendance</a>
        </div>
        </div>
    </div>
</body>
</html>
