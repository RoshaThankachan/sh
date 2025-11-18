<?php
session_start();
include("connect.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch the customer ID from the session
$cust_id = $_SESSION['cust_id']; // Assuming cust_id is stored in the session

// Query to fetch past order details from books and services tables for the current customer
$orders_sql = "
    SELECT services.service_name, bookings .shoe_type, bookings .material_type, bookings .delivery_date 
    FROM bookings 
    JOIN services ON bookings .service_type = services.service_id 
    WHERE bookings .cust_id = ?
    ORDER BY bookings .delivery_date DESC"; // Orders by delivery_date in descending order
$orders_stmt = $conn->prepare($orders_sql);
$orders_stmt->bind_param("i", $cust_id);
$orders_stmt->execute();
$orders_result = $orders_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="past.css">
    <title>Past Orders</title>
</head>
<body>
<header>
    <div class="logo">
        <h1>Shoe Laundry</h1>
    </div>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="customer.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<section class="customer-orders">
    <h2><br>YOUR PAST ORDERS<br><br></h2>
    <?php if ($orders_result->num_rows > 0): ?>
        <table border="1" cellspacing="5" cellpadding="5">
            <thead>
                <tr>
                    <th>Service Type</th>
                    <th>Shoe Type</th>
                    <th>Material Type</th>
                    <th>Delivery Date</th>
                    <th>Actions</th> <!-- Added Actions column -->
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['service_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['shoe_type']); ?></td>
                        <td><?php echo htmlspecialchars($order['material_type']); ?></td>
                        <td><?php echo htmlspecialchars($order['delivery_date']); ?></td>
                        <td>
                            <!-- Cancel Booking Button -->
                            <form action="cancel_booking.php" method="post" style="display:inline;">
                                <input type="hidden" name="booking_id" value="<?php echo $order['booking_id']; ?>">
                                <button type="submit" class="btn" onclick="return confirm('Are you sure you want to cancel this booking?');">Cancel</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No past orders found.</p>
    <?php endif; ?>
</section>


<section class="redirect-button">
    <form action="cnotification.php" method="get">
        <br><button type="submit" class="btn">Go to Notifications</button>
    </form>
</section>

<br><br>
<footer>
    <div class="footer-content">
        <p>&copy; 2024 Shoe Laundry. All rights reserved.</p>
    </div>
</footer>

</body>
</html>

<?php
// Close the statement and connection
$orders_stmt->close();
$conn->close();
?>
