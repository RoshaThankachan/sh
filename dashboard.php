<?php
session_start();
include('connect.php'); // Include your database connection
$current_page = basename($_SERVER['PHP_SELF']);

// Fetch data from the database for the dashboard metrics

// Query for total customers
$query = "SELECT COUNT(*) AS total_customers FROM customers";
$result = mysqli_query($conn, $query);
$total_customers = $result ? mysqli_fetch_assoc($result)['total_customers'] : 0;

// Query for total employees
$query = "SELECT COUNT(*) AS total_employees FROM employees";
$result = mysqli_query($conn, $query);
$total_employees = $result ? mysqli_fetch_assoc($result)['total_employees'] : 0;

// Query for total orders
$query = "SELECT COUNT(*) AS total_orders FROM orders";
$result = mysqli_query($conn, $query);
$total_orders = $result ? mysqli_fetch_assoc($result)['total_orders'] : 0;

// Query for reorder level
$query = "SELECT COUNT(*) AS reorder FROM inventory WHERE stock < '25' ";
$result = mysqli_query($conn, $query);
$reorder = $result ? mysqli_fetch_assoc($result)['reorder'] : 0;

// Query for new orders (assuming status is 'pending')
$query = "SELECT COUNT(*) AS new_orders FROM bookings WHERE booking_status = 'pending'";
$result = mysqli_query($conn, $query);
$new_orders = $result ? mysqli_fetch_assoc($result)['new_orders'] : 0;

// Query for completed orders
$query = "SELECT COUNT(*) AS completed_orders FROM bookings WHERE booking_status = 'completed'";
$result = mysqli_query($conn, $query);
$completed_orders = $result ? mysqli_fetch_assoc($result)['completed_orders'] : 0;

// Query for pending orders
$query = "SELECT COUNT(*) AS pending_orders FROM bookings WHERE booking_status = 'pending'";
$result = mysqli_query($conn, $query);
$pending_orders = $result ? mysqli_fetch_assoc($result)['pending_orders'] : 0;

// Query for inv items
$query = "SELECT COUNT(*) AS total_inv FROM inventory WHERE stock >'0'";
$result = mysqli_query($conn, $query);
$total_inv = $result ? mysqli_fetch_assoc($result)['total_inv'] : 0;

// Query for total revenue
$query = "SELECT SUM(total_price) AS total_revenue FROM payment";
$result = mysqli_query($conn, $query);
$total_revenue = $result ? mysqli_fetch_assoc($result)['total_revenue'] : 0;

// Query for new bookings in the last 7 days for the chart
$query = "SELECT DATE(booking_date) AS order_date, COUNT(*) AS order_count
          FROM bookings
          WHERE booking_status = 'pending' AND booking_date >= CURDATE() - INTERVAL 7 DAY
          GROUP BY booking_date";
$result = mysqli_query($conn, $query);

$order_dates = [];
$order_counts = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $order_dates[] = $row['order_date'];
        $order_counts[] = $row['order_count'];
    }
}

mysqli_close($conn); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="daash.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body >

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

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Welcome, Admin</h1>
            <br>
        </div>

        <!-- Dashboard Overview Cards -->
        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Customers</h3>
                <p><?php echo $total_customers; ?></p>
            </div>
            <div class="card">
                <h3>Total Employees</h3>
                <p><?php echo $total_employees; ?></p>
            </div>
            <div class="card">
                <h3>Total Orders</h3>
                <p><?php echo $total_orders; ?></p>
            </div>

            <div class="card">
                <h3>Reorder items</h3>
                <p><?php echo $reorder; ?></p>
            </div>
            <div class="card">
                <h3>New Orders</h3>
                <p><?php echo $new_orders; ?></p>
            </div>
            <div class="card">
                <h3>Completed Orders</h3>
                <p><?php echo $completed_orders; ?></p>
            </div>
            <div class="card">
                <h3>Pending Orders</h3>
                <p><?php echo $pending_orders; ?></p>
            </div>
            <div class="card">
                <h3>Total Revenue</h3>
                <p>₹<?php echo number_format($total_revenue, 2); ?></p>
            </div>
            <div class="card">
                <h3>Inventory Items</h3>
                <p><?php echo $total_inv; ?></p>
            </div>
        </div>

        <!-- Chart for New Orders -->
        <h2>New Orders in the Last 7 Days</h2>
        <canvas id="ordersChart" width="50" height="9"></canvas>

        <script>
            // Prepare data for the chart directly from PHP
            const labels = <?php echo json_encode($order_dates); ?>; // Dates for x-axis
            const data = {
                labels: labels,
                datasets: [{
                    label: 'New Orders',
                    data: <?php echo json_encode($order_counts); ?>, // Order counts for y-axis
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1,
                    tension: 0.1
                }]
            };

            // Chart configuration
            const config = {
                type: 'bar', // Change to 'line' for a line chart
                data: data,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Orders'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                    }
                }
            };

            // Render the chart
            const ordersChart = new Chart(
                document.getElementById('ordersChart'),
                config
            );
        </script>
    </div>

</body>
</html>
