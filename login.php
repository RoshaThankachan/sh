<?php
session_start();
include("connect.php");

$username = '';
$password = '';
$login_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    if ($user_type === 'admin') {
        $query = "SELECT * FROM admin WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $_SESSION['admin'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $login_error = "Invalid admin credentials.";
        }

    } elseif ($user_type === 'staff') {
        $query = "SELECT employee_id, username, department FROM employees WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $employee = $result->fetch_assoc();
            $_SESSION['employee_id'] = $employee['employee_id'];
            $_SESSION['username'] = $employee['username'];

            // Check if department is "courier" and redirect accordingly
            if ($employee['department'] === 'Courier') {
                header("Location: courier_staff.php");
            } else {
                header("Location: dash.php");
            }
            exit();
        } else {
            $login_error = "Invalid staff credentials.";
        }

    } elseif ($user_type === 'customer') {
        $query = "SELECT cust_id, cust_fname, password FROM customers WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($cust_id, $cust_fname, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $username;
                $_SESSION['cust_fname'] = $cust_fname;
                $_SESSION['cust_id'] = $cust_id;
                header("Location: home.php");
                exit();
            } else {
                $login_error = "Invalid password!";
            }
        } else {
            $login_error = "No customer account found.";
        }
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="si.css">
    <style>
        /* Additional styles for the radio buttons */
        .radio-group {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .radio-group input[type="radio"] {
            accent-color: blue;
            transform: scale(1.2);
        }

        .radio-group label {
            color: #483d8b;
            font-weight: bold;
            margin-right: 10px;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <h1>Shoe Laundry</h1>
    </div>
    <nav>
        <a href="home.php">Home</a>
        <a href="contact.php">Contact Us</a>
        <a href="login.php">Login</a>
    </nav>
</header>

<div class="login-container">
    <section class="login-form">
        <form method="POST" action="login.php">
            <h2>LOGIN</h2><br>
            <div class="radio-group">
                <label>Login as:</label>
                <label><input type="radio" name="user_type" value="admin" required> Admin</label>
                <label><input type="radio" name="user_type" value="staff" required> Staff</label>
                <label><input type="radio" name="user_type" value="customer" required> Customer</label>
            </div>
            <?php if (!empty($login_error)): ?>
                <div class="error-message" style="color: red;"><?php echo htmlspecialchars($login_error); ?></div>
            <?php endif; ?>
            <div class="input-field">
                <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                <label>Username</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" required>
                <label>Password</label>
            </div>
            <button type="submit">Login</button>
        </form>
        <br><br>
        <p>Don't have an account? <a href="signup.php">Sign Up here</a>.</p>
    </section>
</div>
</body>
</html>
