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
        header('Location: cprofile.php');
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
        <li><a href="courier_staff.php">Dashboard</a></li>
                <li><a href="cprofile.php"  class="active">Profile</a></li>
                <li><a href="cattendance.php">Attendance</a></li>
                <li><a href="cnot.php">Notifications</a></li>
                <li><a href="corders.php">Orders</a></li>
                <li><a href="pickup.php"  >PickUp</a></li>
                <li><a href="courier_delivery.php">Out for delivery</a></li> 
                <li><a href="cor.php">Orders Delivered</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
    </div>
    <div class="main-content">
        <h1>Edit Profile Details</h1>
        <form action="editcprofile.php" method="POST">
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
