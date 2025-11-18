<?php
// Database connection
// Database connection
include('connect.php'); // Include your database connection
$current_page = basename($_SERVER['PHP_SELF']);
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_name = $_POST['service_name'];
    $service_category = $_POST['service_category'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $photo = $_POST['photo'];

    $stmt = $conn->prepare("INSERT INTO services (service_name, service_category, price, description, photo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $service_name, $service_category, $price, $description, $photo);

    if ($stmt->execute()) {
        header("Location: add_services.php"); // Redirect after adding
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Service</title>
</head>
<body>

<h2>Add New Service</h2>
<form method="POST" action="">
    <label for="service_name">Service Name:</label>
    <input type="text" name="service_name" required><br><br>

    <label for="service_category">Category:</label>
    <select name="service_category" required>
        <option value="Main">Main</option>
        <option value="Add-on">Add-on</option>
    </select><br><br>

    <label for="price">Price:</label>
    <input type="number" step="0.01" name="price" required><br><br>

    <label for="description">Description:</label>
    <textarea name="description" required></textarea><br><br>

    <label for="photo">Photo URL:</label>
    <input type="text" name="photo" required><br><br>

    <button type="submit">Add Service</button>
</form>

</body>
</html>
