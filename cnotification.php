<?php
session_start();
include("db_connect.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$customer_email = trim($_SESSION['username']);  // Remove any leading/trailing spaces

// Query to fetch notifications for the current customer
$notifications_sql = "SELECT message, date_sent FROM notifications WHERE customer_email = ? ORDER BY date_sent DESC";
$notifications_stmt = $conn->prepare($notifications_sql);

if (!$notifications_stmt) {
    die("Error preparing query: " . $conn->error);
}

$notifications_stmt->bind_param("s", $customer_email);
$notifications_stmt->execute();

if ($notifications_stmt->errno) {
    die("Query execution error: " . $notifications_stmt->error);
}

$notifications_result = $notifications_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cnoti.css">
    <title>Notifications</title>
</head>
<body>

<!-- Header Section -->
<header>
    <div class="logo">
        <h1>Shoe Laundry</h1>
    </div>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="testimonials.php">Testimonials</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="sign2.php">SignUp</a></li>
            <li><a href="fa.php">FAQ</a></li>
        </ul>
    </nav>
</header>

<!-- Notifications Section -->
<section class="customer-notifications">
    <h2>Your Notifications</h2>
    <?php if ($notifications_result->num_rows > 0): ?>
        <div class="notifications-container">
            <?php while ($notification = $notifications_result->fetch_assoc()): ?>
                <div class="notification-card">
                    <div class="notification-date">
                        <?php echo htmlspecialchars(date("F j, Y, g:i a", strtotime($notification['date_sent']))); ?>
                    </div>
                    <div class="notification-message">
                        <?php echo htmlspecialchars($notification['message']); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No notifications found.</p>
    <?php endif; ?>
</section>

<!-- Back to Profile Button -->
<section class="redirect-button">
    <form action="customer.php" method="get">
        <button type="submit" class="btn">Back to Profile</button>
    </form>
</section>

<footer>
    <div class="footer-content">
        <p>&copy; 2024 Shoe Laundry. All rights reserved.</p>
    </div>
</footer>

</body>
</html>

<?php
// Close the statement and connection
$notifications_stmt->close();
$conn->close();
?>
