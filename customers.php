<?php
session_start();
include('db_connect.php'); // Include your database connection

// Fetch customer data
// Fetch customer data with newest first
$query = "SELECT * FROM customers ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

$customers = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $customers[] = $row;
    }
}

// Determine the current page for active sidebar highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers Management</title>
    <link rel="stylesheet" href="customer.css"> <!-- Link to the external CSS -->
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
        <li><a href="shoe.php" class="<?= $current_page == 'shoe.php' ? 'active' : '' ?>">Shoes</a></li>

        <li><a href="add_services.php" class="<?= $current_page == 'add_services.php' ? 'active' : '' ?>">Add Services</a></li>  
        <li><a href="message.php" class="<?= $current_page == 'message.php' ? 'active' : '' ?>">Messages</a></li>
      
        <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Customers Management</h1>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" placeholder="Search Customers..." id="searchInput">
        </div>

        <!-- Customers Table -->
        <div class="customers-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                       
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Created at</th>
                        <th>Actions</th> <!-- Added a new column for the View button -->
                       
                    </tr>
                </thead>
                <tbody id="customerTableBody">
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo $customer['cust_id']; ?></td>
                            <td><?php echo $customer['cust_fname']; ?></td>
                        
                            <td><?php echo $customer['phone']; ?></td>
                            <td><?php echo $customer['gender']; ?></td>
                            <td><?php echo $customer['created_at']; ?></td>
                            <td>
                                <a href="view_customer.php?id=<?php echo $customer['cust_id']; ?>" class="view-btn">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const customerTableBody = document.getElementById('customerTableBody');

        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            const rows = customerTableBody.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let match = false;

                for (let j = 0; j < cells.length - 1; j++) { // Exclude the actions column
                    if (cells[j].innerText.toLowerCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }

                rows[i].style.display = match ? '' : 'none';
            }
        });
    </script>

</body>
</html>
