<?php
session_start();
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

require('db.php');
$employee_id = $_SESSION['employee_id'];

// Fetch employee information
$query = "SELECT * FROM employees WHERE employee_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$employee_info = $stmt->get_result()->fetch_assoc();

// Fetch notification records
$query_notifications = "SELECT * FROM notifications WHERE employee_id = ?";
$stmt_notifications = $conn->prepare($query_notifications);
$stmt_notifications->bind_param("i", $employee_id);
$stmt_notifications->execute();
$notifications = $stmt_notifications->get_result();

// Fetch messages sent by the admin to the current employee
$query_admin_messages = "
    SELECT e.fname, e.lname, m.message, m.date_sent
    FROM messages AS m
    JOIN employees AS e ON m.employee_id = e.employee_id
    WHERE m.status = 1 AND m.recipient = 'individual' 
    AND m.employee_id = ?
    ORDER BY m.date_sent DESC";
$stmt_admin_messages = $conn->prepare($query_admin_messages);
$stmt_admin_messages->bind_param("i", $employee_id); // The current employee's ID
$stmt_admin_messages->execute();
$admin_messages = $stmt_admin_messages->get_result();


// Handle sending new notifications
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_message'])) {
    $message = $_POST['message'];
    $status = 1; // Assuming 1 is for messages sent by admin

    if (!empty($message)) {
        $insert_query = "INSERT INTO messages (employee_id, message, status, date_sent) VALUES (?, ?, ?, NOW())";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("isi", $employee_id, $message, $status);

        if ($insert_stmt->execute()) {
            echo "<div class='alert success'>Message sent successfully!</div>";
        } else {
            echo "<div class='alert warning'>Error sending message. Please try again.</div>";
        }
    } else {
        echo "<div class='alert warning'>Please fill in the message field.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Notifications</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="not.css">
</head>
<body>
<div class="topbar">
    <h2>Shoe Laundry</h2>
    <h2>Courier Staff Notifications</h2>
    <ul>
        <li><a href="courier_staff.php">Dashboard</a></li>
        <li><a href="cprofile.php">Profile</a></li>
        <li><a href="cattendance.php">Attendance</a></li>
        <li><a href="cnot.php" class="active">Notifications</a></li>
        <li><a href="corders.php">Orders</a></li>
        <li><a href="pickup.php">PickUp</a></li>
        <li><a href="courier_delivery.php">Out for delivery</a></li> 
        <li><a href="cor.php">Orders Delivered</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <header>
        <h1>Notifications</h1>
    </header>

 <!-- Send New Notification Section -->
 <section class="notification-section">
        <h2>Send a New Notification</h2>
        <form method="POST" action="notification.php" class="notification-form">
            <input type="email" name="customer_email" placeholder="Customer Email" required>
            <textarea name="message" placeholder="Write your message here..." required></textarea>
            <input type="submit" name="send_notification" value="Send Notification" class="btn">
        </form>
    </section>
    <section class="admin-messages-section">
    <h2>Messages Sent by Admin</h2>
    <table class="notification-table">
        <thead>
            <tr>
                <th>Date Sent</th>
                <th>Employee Name</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($admin_messages->num_rows > 0): ?>
                <?php while ($message = $admin_messages->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($message['date_sent']); ?></td>
                        <td><?php echo htmlspecialchars($message['fname']) . ' ' . htmlspecialchars($message['lname']); ?></td>
                        <td><?php echo htmlspecialchars($message['message']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No messages from the admin.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>


    <!-- Employee Notifications Section -->
    <section class="sent-notifications-section">
        <h2>Your Sent Notifications</h2>
        <table class="notification-table">
            <thead>
                <tr>
                    <th>Date Sent</th>
                    <th>Customer Email</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($notifications->num_rows > 0): ?>
                    <?php while ($notification = $notifications->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($notification['date_sent']); ?></td>
                            <td><?php echo htmlspecialchars($notification['customer_email']); ?></td>
                            <td><?php echo htmlspecialchars($notification['message']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No notifications sent yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

</div>
</body>
</html>
