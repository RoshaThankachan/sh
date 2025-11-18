<?php
// address.php
session_start();
include("connect.php");

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch the logged-in user's details from the customers table
$username = $_SESSION['username'];
$query = "SELECT house_name, street_name, district, pincode FROM customers WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

// Initialize address variables
$house_name = $street_name = $district = $pincode = '';

// Fetch the data if the user exists in the database
if ($stmt->num_rows > 0) {
    $stmt->bind_result($house_name, $street_name, $district, $pincode);
    $stmt->fetch();
}
$stmt->close();

// Check if booking ID and service type were passed from the previous page
$booking_id = $_GET['booking_id'] ?? null;
$service_type = $_GET['service_type'] ?? null;

// If the form is submitted, insert the address details into the bookings table
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $house_name = trim($_POST['house_name']);
    $street_name = trim($_POST['street_name']);
    $district = trim($_POST['district']);  // This will be 'Ernakulam' from the dropdown
    $pincode = trim($_POST['pincode']);

    // Validate the fields
    if (empty($house_name) || empty($street_name) || empty($district) || empty($pincode)) {
        $error = "All fields are required.";
    } elseif (!preg_match('/^\d{6}$/', $pincode)) {
        $error = "Please enter a valid 6-digit pincode.";
    } else {
        // Insert address details into the bookings table
        $sql = "UPDATE bookings SET house_name = ?, street_name = ?, district = ?, pincode = ? WHERE booking_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $house_name, $street_name, $district, $pincode, $booking_id);

        if ($stmt->execute()) {
            // Redirect to pm.php after successful submission
            header("Location: pm.php?booking_id={$booking_id}&service_type={$service_type}");
            exit();
        } else {
            $error = "Failed to save address details. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Address</title>
    <link rel="stylesheet" href="adcss.css">
</head>
<body>
<style>
    /* Same styles as before */
    body {
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
        color: #333;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f4f4f4;
    }

    h2 {
        color: #2c3e50;
        text-align: center;
        margin-top: 30px;
    }

    form {
        margin-left: 175px;
        width: 370px;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    div {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #34495e;
    }

    input[type="text"], select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    select {
        appearance: none;
        background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E');
        background-repeat: no-repeat;
        background-position: right 10px top 50%;
        background-size: 12px auto;
    }

    button[type="submit"] {
        background-color: #3498db;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #2980b9;
    }

    .error {
        color: #e74c3c;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
    }
</style>

<h2>Enter Your Address</h2>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST" action="address.php?booking_id=<?php echo htmlspecialchars($booking_id); ?>&service_type=<?php echo htmlspecialchars($service_type); ?>">
    <div>
        <label for="house_name">House Name:</label>
        <input type="text" id="house_name" name="house_name" value="<?php echo htmlspecialchars($house_name); ?>" required>
    </div>
    <div>
        <label for="street_name">Street Name:</label>
        <input type="text" id="street_name" name="street_name" value="<?php echo htmlspecialchars($street_name); ?>" required>
    </div>
    <div>
        <label for="district">District:</label>
        <select id="district" name="district" required>
            <option value="Ernakulam" <?php echo ($district == "Ernakulam") ? 'selected' : ''; ?>>Ernakulam</option>
            <!-- Add other districts if needed -->
        </select>
    </div>
    <div>
        <label for="pincode">Pincode:</label>
        <input type="text" id="pincode" name="pincode" value="<?php echo htmlspecialchars($pincode); ?>" required pattern="\d{6}" title="Enter a 6-digit pincode">
    </div>
    <button type="submit">Submit</button>
</form>

</body>
</html>
