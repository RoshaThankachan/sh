<?php
include('db.php');
session_start();
if (!isset($_SESSION['employee_id'])) {
    die("Employee ID is not set in the session. Please log in again.");
}
$employee_id = $_SESSION['employee_id'];


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['item_id'];
    $used_quantity = $_POST['used_quantity'];
    $staff_id = $_SESSION['employee_id'];  // Assuming the staff ID is stored in session

    // Update inventory quantity
    $update_query = "UPDATE inventory SET stock = stock - ? WHERE item_id = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, 'ii', $used_quantity, $item_id);
    if (mysqli_stmt_execute($stmt)) {
        // Log the usage in inventory_usage table
        $log_query = "INSERT INTO inventory_usage (item_id, employee_id, used_quantity) VALUES (?, ?, ?)";
        $log_stmt = mysqli_prepare($conn, $log_query);
        mysqli_stmt_bind_param($log_stmt, 'iii', $item_id, $employee_id, $used_quantity);
        mysqli_stmt_execute($log_stmt);
        mysqli_stmt_close($log_stmt);
    } else {
        echo "Error updating inventory: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);

    header("Location: inventory.php");
    exit();
}
?>
