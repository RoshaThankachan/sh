<?php
session_start();
include('db_connect.php'); // Include your database connection

// Check if the ID and new status are set
if (isset($_GET['id']) && isset($_GET['status'])) {
    $employee_id = $_GET['id'];
    $new_status = $_GET['status'];

    // Update the status of the employee in the database
    $query = "UPDATE employees SET status = ? WHERE employee_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $new_status, $employee_id);
    mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $_SESSION['status_message'] = "Employee status updated successfully.";
    } else {
        $_SESSION['status_message'] = "Failed to update employee status.";
    }

    // Redirect back to the employees page
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: employees.php");
    exit();
} else {
    // Redirect if the ID or status is not provided
    header("Location: employees.php");
    exit();
}
?>
