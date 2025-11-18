<?php
session_start();
include("connect.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if booking_id is provided in the POST request
if (isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    // Prepare the query to update the booking status
    $update_sql = "UPDATE bookings SET bk_user_status = 'Cancelled' WHERE booking_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    
    // Bind the booking_id to the prepared statement and execute the query
    $update_stmt->bind_param("i", $booking_id);
    $update_stmt->execute();

    // Check if the update was successful
    if ($update_stmt->affected_rows > 0) {
        // Redirect to the past orders page with a success message
        $_SESSION['message'] = "Booking has been successfully cancelled.";
        header("Location: past_order.php");  // Assuming this is the page showing past orders
    } else {
        // Redirect with an error message if no rows were affected
        $_SESSION['message'] = "Error: Could not cancel the booking.";
        header("Location: past_order.php");
    }

    // Close the prepared statement
    $update_stmt->close();
} else {
    // Redirect if no booking_id is provided
    $_SESSION['message'] = "Invalid request.";
    header("Location: past_order.php");
}

// Close the database connection
$conn->close();
?>
