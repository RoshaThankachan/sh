<?php
include("connect.php");

// Initialize variables
$bookings_data = [];
$payments_data = [];
$selected_month = $_GET['month'] ?? null; // Retrieve selected month from query parameters

// Fetch all months for the dropdown
$months_query = "
    SELECT DISTINCT DATE_FORMAT(delivery_date, '%Y-%m') AS month FROM bookings
    UNION
    SELECT DISTINCT DATE_FORMAT(payment_date, '%Y-%m') AS month FROM payment
    ORDER BY month ASC
";
$months_result = $conn->query($months_query);
$all_months = [];
while ($row = $months_result->fetch_assoc()) {
    $all_months[] = $row['month'];
}

// Fetch bookings data
if ($selected_month) {
    // Fetch data for a specific month
    $bookings_query = "
        SELECT DATE_FORMAT(delivery_date, '%Y-%m') AS month, COUNT(*) AS total_bookings 
        FROM bookings 
        WHERE DATE_FORMAT(delivery_date, '%Y-%m') = ?
        GROUP BY DATE_FORMAT(delivery_date, '%Y-%m')
    ";
    $stmt = $conn->prepare($bookings_query);
    $stmt->bind_param("s", $selected_month);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $bookings_data[$row['month']] = $row['total_bookings'];
    }
    $stmt->close();
} else {
    // Fetch data for all months
    $bookings_query = "
        SELECT DATE_FORMAT(delivery_date, '%Y-%m') AS month, COUNT(*) AS total_bookings 
        FROM bookings 
        GROUP BY DATE_FORMAT(delivery_date, '%Y-%m')
    ";
    $result = $conn->query($bookings_query);
    while ($row = $result->fetch_assoc()) {
        $bookings_data[$row['month']] = $row['total_bookings'];
    }
}

// Fetch payments data
if ($selected_month) {
    // Fetch data for a specific month
    $payments_query = "
        SELECT DATE_FORMAT(payment_date, '%Y-%m') AS month, SUM(total_price) AS total_payments 
        FROM payment
        WHERE DATE_FORMAT(payment_date, '%Y-%m') = ?
        GROUP BY DATE_FORMAT(payment_date, '%Y-%m')
    ";
    $stmt = $conn->prepare($payments_query);
    $stmt->bind_param("s", $selected_month);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $payments_data[$row['month']] = $row['total_payments'];
    }
    $stmt->close();
} else {
    // Fetch data for all months
    $payments_query = "
        SELECT DATE_FORMAT(payment_date, '%Y-%m') AS month, SUM(total_price) AS total_payments 
        FROM payment 
        GROUP BY DATE_FORMAT(payment_date, '%Y-%m')
    ";
    $result = $conn->query($payments_query);
    while ($row = $result->fetch_assoc()) {
        $payments_data[$row['month']] = $row['total_payments'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            color: #333;
            margin: 20px 0;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 10px;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        .button {
            text-align: center;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #45a049;
        }
        select {
            padding: 10px;
            font-size: 16px;
            margin: 20px auto;
            display: block;
            width: 50%;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        #chart-container {
            width: 90%; 
            margin: 30px auto;
            display: none; 
        }
    </style>
</head>
<body>
    <h1>Monthly Bookings and Payments Report</h1>

    <!-- Dropdown for Month Selection -->
    <form method="GET" style="text-align: center;">
        <label for="month">Select Month:</label>
        <select id="month" name="month" onchange="this.form.submit()">
            <option value="">-- All Months --</option>
            <?php foreach ($all_months as $month): ?>
                <option value="<?php echo $month; ?>" <?php echo ($month === $selected_month) ? 'selected' : ''; ?>>
                    <?php echo date("F Y", strtotime($month . "-01")); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <!-- Table to Display Data -->
    <table>
        <thead>
            <tr>
                <th>Month</th>
                <th>Total Bookings</th>
                <th>Total Payments (₹)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (($selected_month ? [$selected_month] : $all_months) as $month): ?>
                <tr>
                    <td><?php echo date("F Y", strtotime($month . "-01")); ?></td>
                    <td><?php echo $bookings_data[$month] ?? 0; ?></td>
                    <td><?php echo number_format($payments_data[$month] ?? 0, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Chart Container -->
    <?php if ($selected_month): ?>
        <div id="chart-container">
            <canvas id="monthlyReportChart"></canvas>
        </div>
    <?php endif; ?>

    <script>
        <?php if ($selected_month): ?>
            const bookings = <?php echo json_encode($bookings_data[$selected_month] ?? 0); ?>;
            const payments = <?php echo json_encode($payments_data[$selected_month] ?? 0); ?>;
            const selectedMonth = "<?php echo date('F Y', strtotime($selected_month . '-01')); ?>";

            document.getElementById('chart-container').style.display = 'block';

            const ctx = document.getElementById('monthlyReportChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Total Bookings', 'Total Payments'],
                    datasets: [{
                        label: selectedMonth,
                        data: [bookings, payments],
                        backgroundColor: [
                            'rgba(76, 175, 80, 0.7)',  
                            'rgba(54, 162, 235, 0.7)'
                        ],
                        borderColor: [
                            'rgba(76, 175, 80, 1)',    
                            'rgba(54, 162, 235, 1)'   
                        ],
                        borderWidth: 1,
                        barThickness: 100,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false 
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        <?php endif; ?>
    </script>

    <!-- Buttons for Print and Go Back -->
    <div class="button-container">
    <button class="button" onclick="printReport()">Print Report</button>
    <button class="button" onclick="location.href='report.php'">Back</button>
</div>
    <script>
        function printReport() {
            window.print(); // Triggers the print dialog
        }
    </script>
</body>
</html>
