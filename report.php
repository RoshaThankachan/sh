<?php
session_start();
include('db_connect.php');
$current_page = basename($_SERVER['PHP_SELF']);

// Query to fetch total bookings for each month from the 'bookings' table
$sqlBookings = "
    SELECT DATE_FORMAT(delivery_date, '%Y-%m') AS month, COUNT(*) AS total_bookings
    FROM bookings
    WHERE delivery_date >= '2024-10-01' -- Filter for November onwards
    GROUP BY month
    ORDER BY month ASC";
$resultBookings = $conn->query($sqlBookings);

// Store bookings data in an array with month as key
$bookingsData = [];
while ($row = $resultBookings->fetch_assoc()) {
    $bookingsData[$row['month']] = $row['total_bookings'];
}

// Query to fetch total payments for each month from the 'payments' table
$sqlPayments = "
    SELECT DATE_FORMAT(payment_date, '%Y-%m') AS month, SUM(total_price) AS total_price
    FROM payment
    WHERE payment_date >= '2024-10-01' -- Filter for November onwards
    GROUP BY month
    ORDER BY month ASC";
$resultPayments = $conn->query($sqlPayments);

// Store payments data in an array with month as key
$paymentsData = [];
while ($row = $resultPayments->fetch_assoc()) {
    $paymentsData[$row['month']] = $row['total_price'];
}

// Query to fetch the most booked shoe types by month
$sqlShoeTypeData = "
    SELECT 
        DATE_FORMAT(b.delivery_date, '%Y-%m') AS month, 
        st.shoe_type_name, 
        COUNT(*) AS total_booked
    FROM bookings b
    JOIN shoe_types st ON b.shoe_type = st.shoe_type_id
    WHERE b.delivery_date >= '2024-10-01'
    GROUP BY month, st.shoe_type_name
    ORDER BY month ASC, total_booked DESC";
$resultShoeTypeData = $conn->query($sqlShoeTypeData);

// Store shoe type data in an array by month
$shoeTypeData = [];
while ($row = $resultShoeTypeData->fetch_assoc()) {
    $month = $row['month'];
    if (!isset($shoeTypeData[$month])) {
        $shoeTypeData[$month] = $row['shoe_type_name']; // Only store the top shoe type for each month
    }
}

// Prepare data for the chart
$months = [];
$totalBookings = [];
$totalPrice = [];
$topShoeTypes = [];

foreach ($bookingsData as $month => $total_bookings) {
    $months[] = $month;
    $totalBookings[] = $total_bookings;
    $totalPrice[] = isset($paymentsData[$month]) ? $paymentsData[$month] : 0;
    $topShoeTypes[] = isset($shoeTypeData[$month]) ? $shoeTypeData[$month] : 'N/A';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Booking and Payment Report</title>
    <link rel="stylesheet" href="report.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Include Chart.js -->
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

<div class="main-content">
    <h1>Monthly Booking and Payment Report</h1>

    <canvas id="reportChart" width="800" height="400"></canvas> <!-- Canvas for Chart.js -->

    <h2>Top Shoe Type Bookings by Month</h2>
    <table border="1" cellpadding="10" cellspacing="0" style="margin-top: 20px; width: 100%; border-collapse: collapse; text-align: center;">
        <thead>
            <tr>
                <th>Month</th>
                <th>Top Shoe Type</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shoeTypeData as $month => $shoeTypeName): ?>
                <tr>
                    <td><?= htmlspecialchars($month); ?></td>
                    <td><?= htmlspecialchars($shoeTypeName); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        // Pass PHP data to JavaScript
        const months = <?php echo json_encode($months); ?>;
        const totalBookings = <?php echo json_encode($totalBookings); ?>;
        const totalPrice = <?php echo json_encode($totalPrice); ?>;
        const topShoeTypes = <?php echo json_encode($topShoeTypes); ?>;

        // Initialize Chart.js
        const ctx = document.getElementById('reportChart').getContext('2d');
        const reportChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Total Bookings',
                        data: totalBookings,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Price',
                        data: totalPrice,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            afterBody: function(tooltipItems) {
                                const monthIndex = tooltipItems[0].dataIndex;
                                return `Top Shoe Type: ${topShoeTypes[monthIndex]}`;
                            }
                        }
                    }
                }
            }
        });
    </script>

    <div class="print-button">
        <button onclick="location.href='print_pdf.php'" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">
            Print
        </button>
    </div>

    <style>
        .print-button {
            text-align: center;
            margin-top: 20px;
        }
        .print-button button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .print-button button:hover {
            background-color: #45a049;
        }

        table {
            border: 1px solid #ddd;
            margin-top: 20px;
            margin-left: 100px;
            margin-right: 60px;
            width: 50%;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f9f9f9;
        }
    </style>
</div>


</body>
</html>
