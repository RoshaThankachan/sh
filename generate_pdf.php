<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
require 'connect.php';

// Get the booking ID from the URL
$booking_id = $_GET['booking_id'] ?? null;

// Fetch booking details including shoe type, material name, service type, and addon services
$query = "
    SELECT 
        b.*, 
        st.shoe_type_name, 
        m.material_name, 
        s1.service_name AS service_type_name, 
        GROUP_CONCAT(s2.service_name SEPARATOR ', ') AS addon_services_names
    FROM 
        bookings b 
    LEFT JOIN 
        shoe_types st ON b.shoe_type = st.shoe_type_id 
    LEFT JOIN 
        materials m ON b.material_type = m.material_id 
    LEFT JOIN 
        services s1 ON b.service_type = s1.service_id 
    LEFT JOIN 
        services s2 ON FIND_IN_SET(s2.service_id, b.addon_services) > 0
    WHERE 
        b.booking_id = ?
    GROUP BY 
        b.booking_id
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
} else {
    echo "Error: Booking not found.";
    exit();
}

// Create a downloadable HTML receipt
$htmlContent = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Payment Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .receipt-container { max-width: 800px; margin: 50px auto; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #0077be; }
        .receipt-details { margin-bottom: 30px; }
        .receipt-details th { text-align: left; width: 40%; padding: 10px; background-color: #f7f7f7; }
        .receipt-details td { padding: 10px; background-color: #ffffff; }
        .footer { text-align: center; margin-top: 20px; font-size: 1.1em; color: #555; }
    </style>
</head>
<body>
    <div class='receipt-container'>
        <div class='header'>
            <h1>Shoe Laundry - Payment Receipt</h1>
        </div>

        <table class='receipt-details'>
            <tr><th>Booking ID</th><td>" . $booking['booking_id'] . "</td></tr>
            <tr><th>Username</th><td>" . $booking['username'] . "</td></tr>
            <tr><th>Phone</th><td>" . ($booking['phone'] ? $booking['phone'] : 'N/A') . "</td></tr>
            <tr><th>Service Type</th><td>" . $booking['service_type_name'] . "</td></tr>
            <tr><th>Shoe Type</th><td>" . $booking['shoe_type_name'] . "</td></tr>
            <tr><th>Material Type</th><td>" . $booking['material_name'] . "</td></tr>
            <tr><th>Addon Services</th><td>" . ($booking['addon_services_names'] ? $booking['addon_services_names'] : 'None') . "</td></tr>
            <tr><th>Delivery Date</th><td>" . $booking['delivery_date'] . "</td></tr>
            <tr><th>Delivery Time</th><td>" . $booking['delivery_time'] . "</td></tr>
            <tr><th>Number of Shoes</th><td>" . $booking['number_of_shoes'] . "</td></tr>
            <tr><th>Special Requests</th><td>" . ($booking['special_requests'] ? $booking['special_requests'] : 'None') . "</td></tr>
        </table>

        <div class='footer'>
            <p>Thank you for using Shoe Laundry Services!</p>
        </div>
    </div>
</body>
</html>
";

// Create a filename for the downloadable HTML file
$filename = "receipt_" . $booking['booking_id'] . ".html";

// Set headers to force file download
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=$filename");
header("Content-Length: " . strlen($htmlContent));

// Output the content
echo $htmlContent;
exit();
?>
