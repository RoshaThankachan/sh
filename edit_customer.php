<?php
session_start();
include("db_connect.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch customer details from the database
$cust_id = $_SESSION['cust_id']; // Assuming cust_id is stored in the session
$sql = "SELECT * FROM customers WHERE cust_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cust_id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();
$stmt->close();

// Check if the form is submitted to update the customer details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Update the customer details in the database
    $update_sql = "UPDATE customers SET cust_fname = ?, cust_lname = ?, username = ?, phone = ?, cust_address = ? WHERE cust_id = ?";
    $stmt_update = $conn->prepare($update_sql);
    $stmt_update->bind_param("sssssi", $fname, $lname, $email, $phone, $address, $cust_id);
    $stmt_update->execute();
    $stmt_update->close();

    // Reload the page to reflect the updated details
    header("Location: customer.php"); // Redirect back to the profile page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ecus.css">
    <title>Edit Customer Details</title>
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
            <li><a href="customer.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<section class="edit-customer-profile">
    <h2>Edit Your Profile</h2>
    <form action="edit_customer.php" method="POST">
        <label for="fname">First Name:</label>
        <input type="text" name="fname" id="fname" value="<?php echo htmlspecialchars($customer['cust_fname']); ?>" required>
        
        <label for="lname">Last Name:</label>
        <input type="text" name="lname" id="lname" value="<?php echo htmlspecialchars($customer['cust_lname']); ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($customer['username']); ?>" required>
        
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>" required>
        
        <label for="address">Address:</label>
        <textarea name="address" id="address" required><?php echo htmlspecialchars($customer['cust_address']); ?></textarea>

        <button type="submit" class="btn">Update Details</button>
    </form>
</section>

<!-- Footer Section -->
<footer>
    <div class="footer-content">
        <p>&copy; 2024 Shoe Laundry. All rights reserved.</p>
    </div>
</footer>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
