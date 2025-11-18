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
                header("Location: attendance.php?success=1");
                exit();
            } else {
                echo "Error inserting attendance: " . $stmt->error; // For debugging
            }
        } else {
            // Redirect with error message if attendance already marked
            header("Location: attendance.php?error=1");
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
        <h2>Staff Attendance</h2>
        <ul>
                <li><a href="dash.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="emm.php"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="attendance.php" class="active"><i class="fas fa-calendar-check"></i> Attendance</a></li>
                <li><a href="notification.php"><i class="fas fa-bell"></i> Notifications</a></li>
                <li><a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a></li>
                <li><a href="orders.php" ><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <li><a href="or.php" ><i class="fas fa-shopping-cart"></i> Orders Managed</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
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
            <form method="POST" action="attendance.php">
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
            <form method="GET" action="view_attendance.php">
                <input type="submit" value="View Attendance">
            </form>
        </section>
    </div>
</body>
</html>
