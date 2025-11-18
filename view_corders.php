<?php
session_start();
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

require('db.php');

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0; // Ensure order_id is an integer

if ($order_id > 0) {
    // Fetch booking details and join with customers and services
    $query = "
    SELECT b.booking_id, b.delivery_date, b.delivery_time, b.number_of_shoes, 
           st.shoe_type_name, m.material_name, b.special_requests,
           c.cust_fname, c.cust_lname, c.cust_address, c.phone AS cust_phone, c.gender, 
           s.service_name, s.service_category, s.price
    FROM bookings b
    JOIN customers c ON b.cust_id = c.cust_id
    LEFT JOIN services s ON b.service_type = s.service_id
    LEFT JOIN shoe_types st ON b.shoe_type = st.shoe_type_id
    LEFT JOIN materials m ON b.material_type = m.material_id
    WHERE b.booking_id = ?";



    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $order_details = $result->fetch_assoc();
        } else {
            $error_message = "No details found for this order.";
        }
    } else {
        $error_message = "Error executing query: " . htmlspecialchars($stmt->error);
    }
} else {
    header("Location: orders.php"); // Redirect if no valid order_id is provided
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ord.css">
</head>
<style>
    /* Basic reset and general styles */
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

body {
    background-color: #f4f4f4;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    color: #333;
}

.topbar {
    width: 100%;
    background-color: #2c3e50;
    padding: 15px 0;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
}

.topbar h2 {
    color: #ecf0f1;
    text-align: center;
    margin: 0;
}

.topbar ul {
    list-style-type: none;
    display: flex;
    justify-content: center;
    margin-top: 15px;
}

.topbar ul li {
    padding: 10px 20px;
}

.topbar ul li a {
    color: #ecf0f1;
    text-decoration: none;
    font-size: 18px;
    padding: 10px 15px;
    display: block;
    transition: background-color 0.3s ease;
}

.topbar ul li a:hover,
.topbar ul li a.active {
    background-color: #34495e;
    border-radius: 5px;
}

.topbar ul li a i {
    margin-right: 8px;
}

/* Alert styles */
.alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 4px;
}

.alert.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Back button styles */
.back-btn {
    margin-top: 2rem;
}

.btn {
    display: inline-block;
    background-color: #333;
    color: #fff;
    padding: 0.5rem 1rem;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: #555;
}

/* Responsive design */
@media (max-width: 768px) {
    .topbar {
        width: 100%;
        height: auto;
        position: static;
    }

    .main-content {
        margin-left: 0;
        padding: 1rem;
    }

    .topbar ul {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .topbar ul li {
        margin: 0.25rem;
    }

    .topbar ul li a {
        padding: 0.5rem;
        font-size: 0.9rem;
    }

    .topbar ul li a i {
        margin-right: 0.25rem;
    }
}

/* Additional enhancements */
.order-details-container {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.main-content {
    background-color: #fff;
}

.main-content h2 {
    background-color: #f0f0f0;
    padding: 0.5rem;
    border-radius: 4px;
}

.main-content p {
    padding: 0.5rem;
    border-bottom: 1px solid #eee;
}

.main-content p:last-child {
    border-bottom: none;
}

/* Hover effect for information rows */
.main-content p:hover {
    background-color: #f9f9f9;
}

/* Styling for specific information types */
.main-content p strong {
    display: inline-block;
    width: 150px;
}

/* Print styles */
@media print {
    .topbar, .back-btn {
        display: none;
    }

    .main-content {
        margin-left: 0;
    }

    body {
        font-size: 12pt;
    }

    .main-content h1, .main-content h2 {
        page-break-after: avoid;
    }

    .main-content p {
        page-break-inside: avoid;
    }
}

</style>
<body>
    <div class="order-details-container">
        <div class="topbar">
            <h2>Shoe Laundry</h2>
            <h2>Order Details</h2>
            <ul>
            <li><a href="dash.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="emm.php"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="attendance.php"><i class="fas fa-calendar-check"></i> Attendance</a></li>
                <li><a href="notification.php"><i class="fas fa-bell"></i> Notifications</a></li>
                <li><a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a></li>
                <li><a href="orders.php" class><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <li><a href="or.php" class="active"><i class="fas fa-shopping-cart"></i> Orders Managed</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
           

            <?php if (isset($error_message)): ?>
                <div class="alert error"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <?php if (isset($order_details)): ?>
                <h2>Customer Information</h2>
                <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($order_details['cust_fname'] . " " . $order_details['cust_lname']); ?></p>

                <h2>Booking Information</h2>
                <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($order_details['booking_id']); ?></p>
                <p><strong>Service Name:</strong> <?php echo htmlspecialchars($order_details['service_name']); ?></p>
                <p><strong>Number of Shoes:</strong> <?php echo htmlspecialchars($order_details['number_of_shoes']); ?></p>
                <p><strong>Shoe Type:</strong> <?php echo htmlspecialchars($order_details['shoe_type_name']); ?></p>
<p><strong>Material Type:</strong> <?php echo htmlspecialchars($order_details['material_name']); ?></p>
                <p><strong>Special Requests:</strong> <?php echo htmlspecialchars($order_details['special_requests']); ?></p>

                <h2>Service Information</h2>
                <p><strong>Service Category:</strong> <?php echo htmlspecialchars($order_details['service_category']); ?></p>
            <?php endif; ?>
             <!-- Back Button -->
        <div class="back-btn">
            <a href="orders.php" class="btn">Back to Orders</a>
        </div>
        </div>
    </div>
</body>
</html>
