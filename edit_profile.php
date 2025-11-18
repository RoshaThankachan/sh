<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include('db.php');

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $role = $_POST['role'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
   
    $update_query = "UPDATE employees SET fname = '$fname', lname = '$lname', phone = '$phone', department = '$department' WHERE username = '$username'";
    if (mysqli_query($conn, $update_query)) {
        header('Location: emm.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

$query = "SELECT employee_id, fname, lname, username, department, phone FROM employees WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$employee = mysqli_fetch_assoc($result);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Staff Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="mp.css">
</head>
<body>
<div class="topbar">
        <h2>Shoe Laundry</h2>
        <h2>Edit Details</h2>
        <ul>
                <li><a href="dash.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="emm.php"class="active"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="attendance.php"><i class="fas fa-calendar-check"></i> Attendance</a></li>
                <li><a href="notification.php"><i class="fas fa-bell"></i> Notifications</a></li>
                <li><a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a></li>
                <li><a href="orders.php" ><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <li><a href="or.php"><i class="fas fa-shopping-cart"></i> Orders Managed</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
    </div>
    <div class="main-content">
        <h1>Edit Profile Details</h1>
        <form action="edit_profile.php" method="POST">
            <label>First Name</label>
            <input type="text" name="fname" value="<?php echo htmlspecialchars($employee['fname']); ?>" required>

            <label>Last Name</label>
            <input type="text" name="lname" value="<?php echo htmlspecialchars($employee['lname']); ?>" required>

            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($employee['phone']); ?>" required>

            <label>Department</label>
            <input type="text" name="department" value="<?php echo htmlspecialchars($employee['department']); ?>" required>

           

            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
