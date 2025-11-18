<?php
session_start();
include("connect.php");

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve booking details
$booking_id = $_GET['booking_id'] ?? null;

if (!$booking_id) {
    die("Booking ID is missing!");
}

// Fetch booking details along with shoe type, material name, service type, and addon services
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

if ($result->num_rows === 0) {
    die("No booking found for the given ID!");
}

$booking = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <link rel="stylesheet" href="receipt.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
        header a {
            color: #ffc107;
            text-decoration: none;
        }
        .receipt-wrapper {
            max-width: 800px;
            margin: 170px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #444;
        }
        .receipt-details {
            margin-top: 20px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .receipt-details p {
            margin: 8px 0;
        }
        .actions {
            margin-top: 20px;
            text-align: center;
        }
        .actions button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
        }
        .actions button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<header>
    <h1>Shoe Laundry</h1>
    <p><a href="home.php">Home</a></p>
</header>
<div class="receipt-wrapper">
    <h2>Payment Receipt</h2>
    <div class="receipt-details">
        <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($booking['booking_id']); ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($booking['username']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($booking['phone'] ?? 'N/A'); ?></p>
        <p><strong>Service Type:</strong> <?php echo htmlspecialchars($booking['service_type_name']); ?></p> <!-- Service Type -->
        <p><strong>Shoe Type:</strong> <?php echo htmlspecialchars($booking['shoe_type_name']); ?></p>
        <p><strong>Material Type:</strong> <?php echo htmlspecialchars($booking['material_name']); ?></p>
        <p><strong>Addon Services:</strong> <?php echo htmlspecialchars($booking['addon_services_names'] ?? 'None'); ?></p> <!-- Addon Services -->
        <p><strong>PickUp Date:</strong> <?php echo htmlspecialchars($booking['delivery_date']); ?></p>
        <p><strong>PickUp Time:</strong> <?php echo htmlspecialchars($booking['delivery_time']); ?></p>
        <p><strong>Number of Shoes:</strong> <?php echo htmlspecialchars($booking['number_of_shoes']); ?></p>
        <p><strong>Special Requests:</strong> <?php echo htmlspecialchars($booking['special_requests'] ?? 'None'); ?></p>
    </div>
    <div class="actions">
     
        <a href="generate_pdf.php?booking_id=<?php echo $booking['booking_id']; ?>">
            <button>Download Bill</button>
        </a>
    </div>
</div>
</body>
</html>
