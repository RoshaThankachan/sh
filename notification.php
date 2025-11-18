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
    WHERE m.status = 1 AND m.employee_id = ?
    ORDER BY m.date_sent DESC";
$stmt_admin_messages = $conn->prepare($query_admin_messages);
$stmt_admin_messages->bind_param("i", $employee_id);
$stmt_admin_messages->execute();
$admin_messages = $stmt_admin_messages->get_result();

// Handle sending new notifications to customers
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_notification'])) {
    $customer_email = $_POST['customer_email'];
    $message = $_POST['message'];

    if (!empty($customer_email) && !empty($message)) {
        $insert_query = "INSERT INTO notifications (employee_id, customer_email, message, date_sent) VALUES (?, ?, ?, NOW())";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("iss", $employee_id, $customer_email, $message);

        if ($insert_stmt->execute()) {
            echo "<div class='alert success'>Notification sent successfully!</div>";
        } else {
            echo "<div class='alert warning'>Error sending notification. Please try again.</div>";
        }
    } else {
        echo "<div class='alert warning'>Please fill in both email and message fields.</div>";
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
    <h2>Staff Notifications</h2>
    <ul>
        <li><a href="dash.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="emm.php"><i class="fas fa-user"></i> Profile</a></li>
        <li><a href="attendance.php"><i class="fas fa-calendar-check"></i> Attendance</a></li>
        <li><a href="notification.php" class="active"><i class="fas fa-bell"></i> Notifications</a></li>
        <li><a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a></li>
        <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
        <li><a href="or.php"><i class="fas fa-shopping-cart"></i> Orders Managed</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

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

    <!-- Admin Messages Section -->
    <section class="admin-messages-section">
        <h2>Messages Sent by Admin</h2>
        <table class="notification-table">
            <thead>
                <tr>
                    <th>Date Sent</th>
                    <th>Admin Name</th>
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

    <!-- Sent Notifications Section -->
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
