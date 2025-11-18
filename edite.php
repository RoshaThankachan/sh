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
    $status = $_POST['status'];

    $update_query = "UPDATE employees SET fname = '$fname', lname = '$lname', phone = '$phone', department = '$department', status = '$status' WHERE username = '$username'";
    if (mysqli_query($conn, $update_query)) {
        header('Location: emm.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

$query = "SELECT employee_id, fname, lname, username, department, phone, status FROM employees WHERE username = '$username'";
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
    <link rel="stylesheet" href="empl.css">
</head>
<body>
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

            <label>Status</label>
            <input type="text" name="status" value="<?php echo htmlspecialchars($employee['status']); ?>" required>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
