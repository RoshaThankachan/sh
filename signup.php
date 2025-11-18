<?php
include("connect.php");

// Initialize variables for form input
$username = '';
$cust_fname = '';
$cust_lname = '';
$cust_address = '';
$street_name = '';
$house_name = '';
$district = '';
$pincode = '';
$phone = '';
$gender = '';
$signup_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the posted input
    $username = trim($_POST['username'] ?? '');
    $cust_fname = trim($_POST['firstname'] ?? '');
    $cust_lname = trim($_POST['lastname'] ?? '');
    $password = $_POST['password'] ?? '';
    $street_name = trim($_POST['street_name'] ?? '');
    $house_name = trim($_POST['house_name'] ?? '');
    $district = trim($_POST['district'] ?? '');
    $pincode = trim($_POST['pincode'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $gender = $_POST['gender'] ?? '';

    // Validate input fields
    if (empty($username) || empty($cust_fname) || empty($cust_lname)  || empty($street_name) || empty($house_name) || empty($district) || empty($pincode) ||  empty($password) || empty($phone)) {
        $signup_error = "All fields are required.";
    } else {
        // Validate email format
        if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $signup_error = "Invalid email format.";
        } elseif (!preg_match("/^\d{10}$/", $phone)) { // Check if phone number is 10 digits
            $signup_error = "Phone number must be 10 digits.";
        } elseif (strtolower($district) !== 'ernakulam') {
            $signup_error = "Service is only available in Ernakulam.";
        } elseif (!preg_match("/^\d{6}$/", $pincode)) { // Check if pincode is 6 digits
            $signup_error = "Pincode must be 6 digits.";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Check if username or phone already exists in the database
            $check_sql = "SELECT * FROM customers WHERE username = ? OR phone = ?";
            $check_stmt = $conn->prepare($check_sql);
            if ($check_stmt) {
                $check_stmt->bind_param("ss", $username, $phone);
                $check_stmt->execute();
                $check_stmt->store_result();

                if ($check_stmt->num_rows > 0) {
                    $signup_error = "Username or phone number already exists. Please use a different one.";
                } else {
                    // Insert new user if validations pass
                    $sql = "INSERT INTO customers (username, password, cust_fname, cust_lname, street_name, house_name, district, pincode, phone, gender, customer_email) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    if ($stmt) {
                        // Use $username for both username and customer_email
                        $stmt->bind_param("sssssssssss", $username, $hashed_password, $cust_fname, $cust_lname, $street_name, $house_name, $district, $pincode, $phone, $gender, $username);

                        if ($stmt->execute()) {
                            // Redirect to login page after successful signup
                            header("Location: login.php");
                            exit();
                        } else {
                            $signup_error = "Sign up failed! Please try again.";
                        }
                    } else {
                        $signup_error = "Database error! Please try again later.";
                    }
                }
                $check_stmt->close();
            } else {
                $signup_error = "Database error! Please try again later.";
            }
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="sign.css">

</head>
<body>
<header>
    <div class="logo">
        <h1>Shoe Laundry</h1>
    </div>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<div class="wrapper">
    <section class="sign-form">
        <form method="POST" action="signup.php">
            <h2>SIGN UP</h2>
            <?php if (!empty($signup_error)): ?>
                <div class="error-message" style="color: red;"><?php echo htmlspecialchars($signup_error); ?></div>
            <?php endif; ?>
            <div class="input-field">
                <input type="email" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                <label>Username(Email Address)</label>
            </div>
            <div class="input-field">
                <input type="text" name="firstname" value="<?php echo htmlspecialchars($cust_fname); ?>" required>
                <label>First Name</label>
            </div>
            <div class="input-field">
                <input type="text" name="lastname" value="<?php echo htmlspecialchars($cust_lname); ?>" required>
                <label>Last Name</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" required>
                <label>Password</label>
            </div>
            <div class="input-field">
                <input type="text" name="house_name" value="<?php echo htmlspecialchars($house_name); ?>" required>
                <label>House Name</label>
            </div>
            <div class="input-field">
                <input type="text" name="street_name" value="<?php echo htmlspecialchars($street_name); ?>" required>
                <label>Street Name</label>
            </div>
            <div class="input-field">
                <input type="text" name="district" value="<?php echo htmlspecialchars($district); ?>" required>
                <label>District</label>
            </div>
            <div class="input-field">
                <input type="text" name="pincode" value="<?php echo htmlspecialchars($pincode); ?>" required>
                <label>Pincode</label>
            </div>
            <div class="input-field">
                <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                <label>Phone No</label>
            </div>
            <div class="input-field">
                <label>Gender</label>
                <select name="gender" required>
                    <option value="Male" <?php echo ($gender == "Male") ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($gender == "Female") ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
            <button type="submit">Sign Up</button>
        </form>
    </section>
</div>
</body>
</html>
