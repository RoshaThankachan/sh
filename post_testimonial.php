<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['cust_id'])) {
    header("Location: login.php");
    exit();
}

$cust_id = $_SESSION['cust_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $testimonial = trim($_POST['testimonial']);
    
    if (!empty($testimonial)) {
        $sql = "INSERT INTO testimonials (cust_id, testimonial, date_posted) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $cust_id, $testimonial);
        
        if ($stmt->execute()) {
            $_SESSION['success_msg'] = "Your testimonial has been posted!";
        } else {
            $_SESSION['error_msg'] = "Failed to post testimonial. Please try again.";
        }
        
        $stmt->close();
    }
}

$conn->close();
header("Location: customer.php");
exit();
?>
