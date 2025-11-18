<?php
// Start session and connect to the database
session_start();

// Check if employee_id is set in the session
if (!isset($_SESSION['employee_id'])) {
    // If employee is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

include('db.php'); // Include your database connection

$employee_id = $_SESSION['employee_id']; // Get employee ID from session

// Debug: Check if employee_id is properly set
// Uncomment the following line to debug (remove after debugging)
// var_dump($_SESSION);

// Handle attendance submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mark_attendance'])) {
    $status = $_POST['status'];
    $attendance_date = date('Y-m-d'); // Current date

    // Check if attendance for today already exists
    $query_check = "SELECT * FROM attendance WHERE employee_id = ? AND attendance_date = ?";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bind_param("is", $employee_id, $attendance_date);
    
    if ($stmt_check->execute()) {
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows == 0) {
            // Insert attendance record
            $query = "INSERT INTO attendance (employee_id, attendance_date, status) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iss", $employee_id, $attendance_date, $status);
            
            if ($stmt->execute()) {
                // Redirect to attendance.php with success message
                header("Location: cattendance.php?success=1");
                exit();
            } else {
                echo "Error inserting attendance: " . $stmt->error; // For debugging
            }
        } else {
            // Redirect with error message if attendance already marked
            header("Location: cattendance.php?error=1");
            exit();
        }
    } else {
        echo "Error checking attendance: " . $stmt_check->error; // For debugging
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="attend.css">
</head>
<body>
    <div class="topbar">
    <h2>Shoe Laundry</h2> <!-- Add this line for the Shoe Laundry heading -->
        <h2>Courier Staff Attendance</h2>
        <ul>
        <li><a href="courier_staff.php">Dashboard</a></li>
                <li><a href="cprofile.php" >Profile</a></li>
                <li><a href="cattendance.php"  class="active">Attendance</a></li>
                <li><a href="cnot.php">Notifications</a></li>
                <li><a href="corders.php">Orders</a></li>
                <li><a href="pickup.php"  >PickUp</a></li>
                <li><a href="courier_delivery.php">Out for delivery</a></li> 
                <li><a href="cor.php">Orders Delivered </a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
    </div>

    <div class="main-content">
        <header>
            <h1>Mark Attendance</h1>
        </header>

        <section class="attendance-section">
            <!-- Display success message if attendance marked successfully -->
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div class="alert success">Attendance marked successfully!</div>
            <?php endif; ?>

            <!-- Display error message if attendance already marked -->
            <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                <div class="alert error">You have already marked attendance for today.</div>
            <?php endif; ?>

            <!-- Attendance marking form -->
            <form method="POST" action="cattendance.php">
                <label for="status">Attendance Status:</label>
                <select name="status" id="status" required>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                    <option value="Leave">Leave</option>
                </select>
                <input type="submit" name="mark_attendance" value="Mark Attendance">
            </form>
            <br><br>

            <!-- Button to view attendance - Redirects to view_attendance.php -->
            <form method="GET" action="view_cattendance.php">
                <input type="submit" value="View Attendance">
            </form>
        </section>
    </div>
</body>
</html>
