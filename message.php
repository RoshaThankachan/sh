<?php
session_start();
require('db.php');
// Send a message to an individual employee or all employees
if (isset($_POST['send_message'])) {
    $message = $_POST['message'];
    $status = 1; // 1 means 'sent by admin'
    $employee_id = $_POST['employee_id'] ?? null; // If null, it's for all employees
    $recipient = $employee_id ? 'individual' : 'all'; // Flag to differentiate the recipient

    if ($employee_id) {
        // Send message to a specific employee
        $stmt = $conn->prepare("INSERT INTO messages (employee_id, message, status, recipient, date_sent) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("isis", $employee_id, $message, $status, $recipient);
        $stmt->execute();
    } else {
        // Send message to all employees
        $employees = $conn->query("SELECT employee_id FROM employees WHERE status = 'active'");
        while ($row = $employees->fetch_assoc()) {
            $stmt = $conn->prepare("INSERT INTO messages (employee_id, message, status, recipient, date_sent) VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("isis", $row['employee_id'], $message, $status, $recipient);
            $stmt->execute();
        }
    }
    header("Location: message.php"); // Redirect after sending the message
    exit();
}



// Fetch active employees for the dropdown
$employees = $conn->query("SELECT employee_id, fname, lname FROM employees WHERE status = 'active'");

// Fetch all messages sent by employees to customers
$employee_messages = $conn->query("SELECT m.id, e.fname, e.lname, m.message, m.date_sent, m.status 
    FROM messages AS m 
    JOIN employees AS e ON m.employee_id = e.employee_id 
    WHERE m.status = 0 OR m.status = 1"); // Customize status filter as needed

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Messaging</title>
    <link rel="stylesheet" href="msg.css">
</head>
<body>
         <!-- Sidebar -->
         <div class="sidebar">
        <h2>Shoe Laundry</h2>
        <ul>
        <li><a href="dashboard.php" class="<?= $current_page == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="customers.php" class="<?= $current_page == 'customers.php' ? 'active' : '' ?>">Customers</a></li>
        <li><a href="admin_orders.php" class="<?= $current_page == 'admin_orders.php' ? 'active' : '' ?>">Orders</a></li>
        <li><a href="report.php" class="<?= $current_page == 'report.php' ? 'active' : '' ?>">Report</a></li>
        <li><a href="employees.php" class="<?= $current_page == 'employees.php' ? 'active' : '' ?>">Employees</a></li>
        <li><a href="payments.php" class="<?= $current_page == 'payments.php' ? 'active' : '' ?>">Payments</a></li>
        <li><a href="admin_inventory.php" class="<?= $current_page == 'admin_inventory.php' ? 'active' : '' ?>">Inventory</a></li>
        <li><a href="assign_orders.php" class="<?= $current_page == 'assign_orders.php' ? 'active' : '' ?>">Assign Orders</a></li>
        <li><a href="add_services.php" class="<?= $current_page == 'add_services.php' ? 'active' : '' ?>">Add Services</a></li>    
        <li><a href="shoe.php" class="<?= $current_page == 'shoe.php' ? 'active' : '' ?>">Shoes</a></li>
        <li><a href="message.php" class="<?= $current_page == 'message.php' ? 'active' : '' ?>">Messages</a></li>

        <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
   
 
<div class="container">
   

    <!-- Send Message to Employee or All Employees Section -->
    <section class="send-message">
    <header>
    <h2>Admin Messaging</h2>
    </header>
        <h3>Send Message to Employee</h3>
        <form method="POST">
            <label for="employee_id">Select Employee (Optional):</label>
            <select name="employee_id" id="employee_id">
                <option value="">Send to All Employees</option>
                <?php while ($row = $employees->fetch_assoc()): ?>
                    <option value="<?php echo $row['employee_id']; ?>">
                        <?php echo $row['fname'] . ' ' . $row['lname']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="4" required></textarea>
            <button type="submit" name="send_message">Send Message</button>
        </form>
    </section>

    <!-- View Messages from Employees Section -->
    <section class="view-messages">
        <h3>Messages Sent by Employees to Customers</h3>
        <table>
            <tr>
                <th>Employee Name</th>
                <th>Message</th>
                <th>Date Sent</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $employee_messages->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['fname'] . ' ' . $row['lname']; ?></td>
                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                    <td><?php echo $row['date_sent']; ?></td>
                    <td><?php echo $row['status'] ? 'Read' : 'Unread'; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>
</div>

</body>
</html>
