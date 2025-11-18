<?php
session_start();
if (!isset($_SESSION['employee_id'])) {
    header('Location: l.php'); // Redirect to login if not logged in
    exit();
}

include('db.php');

// Get employee ID from the session
$employee_id = $_SESSION['employee_id'];
echo "Employee ID from session: " . htmlspecialchars($employee_id) . "<br>"; // Debug line

// Prepare the statement to get employee details
$stmt = $conn->prepare("SELECT * FROM employee WHERE employee_id = ?");
$stmt->bind_param("i", $employee_id); // 'i' for integer
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $employee = $result->fetch_assoc();
} else {
    echo "No employee data found for ID: " . htmlspecialchars($employee_id);
    exit();
}

$stmt->close();
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h2>Profile</h2>

    <table>
        <tr>
            <th>Name</th>
            <td><?php echo htmlspecialchars($employee['fname'] . ' ' . $employee['lname']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($employee['email']); ?></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td><?php echo htmlspecialchars($employee['phone']); ?></td>
        </tr>
        <tr>
            <th>Role</th>
            <td><?php echo htmlspecialchars($employee['role']); ?></td>
        </tr>
        <tr>
            <th>Department</th>
            <td><?php echo htmlspecialchars($employee['department']); ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?php echo htmlspecialchars($employee['status']); ?></td>
        </tr>
        <tr>
            <th>Attendance</th>
            <td><?php echo htmlspecialchars($employee['attendance']); ?></td>
        </tr>
        <tr>
            <th>Performance Score</th>
            <td><?php echo htmlspecialchars($employee['performance_score']); ?></td>
        </tr>
        <tr>
            <th>Created At</th>
            <td><?php echo htmlspecialchars($employee['created_at']); ?></td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td><?php echo htmlspecialchars($employee['updated_at']); ?></td>
        </tr>
    </table>
</body>
</html>
