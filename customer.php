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

$sql_last_booking = "SELECT courier_status, pickup_status, booking_status, delivery_status FROM bookings WHERE cust_id = ? ORDER BY booking_id DESC LIMIT 1";
$stmt = $conn->prepare($sql_last_booking);
$stmt->bind_param("i", $cust_id);
$stmt->execute();
$result = $stmt->get_result();
$last_booking = $result->fetch_assoc();

// Set both $courier_status and $pickup_status
$courier_status = $last_booking['courier_status'] ?? null;
$pickup_status = $last_booking['pickup_status'] ?? null; // Add this line
$booking_status = $last_booking['pickup_status'] ?? null;
$delivery_status = $last_booking['delivery_status'] ?? null; // Ensure delivery_status is fetched
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Header styles */
        header {
            background: #333;
            color: #fff;
            padding: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo h1 {
            margin: 0;
            font-size: 2em;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        nav ul li {
            margin: 0 15px;
            display: inline;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            color: #ffcc00;
        }

        /* Main content styles */
        .customer-profile, .view-orders, .customer-testimonial {
            background-color: #fff;
            margin: 2rem auto;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 1rem;
            border-bottom: 2px solid #3498db;
            padding-bottom: 0.5rem;
        }

        .profile-details p {
            margin-bottom: 0.5rem;
        }

        .btn {
            display: inline-block;
            background-color: #2c3e50;
            color: #fff;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #2980b9;
        }

       .icons {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 30px;
    margin-bottom: 20px;
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.icon-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.icon {
    font-size: 30px;
    color: #2c3e50;
    transition: transform 0.3s ease, color 0.3s ease;
}

.icon:hover {
    transform: scale(1.3);
    color: #f39c12;
}

.line {
    height: 2px;
    background-color: #2c3e50;
    flex-grow: 1;
    max-width: 50px;
    align-self: center;
}

/* Consistent font styling for the status text */
.icon-container p {
    font-size: 14px;
    color: #2c3e50;
    margin-top: 5px;
    font-weight: bold;
    text-align: center;
}

/* For responsive behavior */
@media (max-width: 768px) {
    .icons {
        flex-direction: column;
        gap: 20px;
    }

    .line {
        display: none; /* Remove lines for stacked layout */
    }
}
.icons {
    background-color: #fff;
    margin: 2rem auto; /* Center with equal spacing */
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    max-width: 800px; /* Match other containers */
    display: flex;
    flex-wrap: wrap; /* Wrap for smaller screens */
    justify-content: space-around; /* Equal spacing for icons */
    align-items: flex-start;
    gap: 20px; /* Space between icons */
    text-align: center; /* Center-align heading and icons */
}

.icons h2 {
    flex-basis: 100%; /* Ensure the heading takes the full width */
    margin-bottom: 20px; /* Space below the heading */
    text-align: left; /* Align the heading to the left */
    color: #2c3e50;
    font-size: 24px;
}


.icon-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-grow: 1;
}

.icon {
    font-size: 40px;
    color: #2c3e50;
    transition: transform 0.3s ease, color 0.3s ease;
}

.icon:hover {
    transform: scale(1.3);
    color: #f39c12;
}
footer {
    background-color: #333;
    color: white;
    text-align: center;
    padding-top: 10px;
    padding-right: 0px;
    padding-bottom: 10px;
    padding-left: 0px;
    height: 77.6px;
    margin-top: 90px;
}


.footer-content p {
    display: block;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    unicode-bidi: isolate;
}
.line {
    width: 50px; /* Adjust the width of the line */
    height: 2px; /* Thickness of the line */
    background-color: #2c3e50; /* Line color */
    margin: 0 10px; /* Add spacing around the line */
    align-self: center; /* Center the line within the flex container */
}

@media (max-width: 768px) {
    .icons {
        flex-direction: column; /* Stack icons vertically */
        gap: 30px;
    }
}
        .line {
            height: 2px;
            background-color: #2c3e50;
            flex-grow: 1;
            max-width: 50px;
            align-self: center;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                align-items: center;
            }

            nav ul li {
                margin: 0.5rem 0;
            }

            .customer-profile, .icons, .view-orders, .customer-testimonial {
                margin: 1rem;
                padding: 1rem;
            }

            .icons {
                gap: 20px;
            }
            
        }
    </style>
</head>

<body>
<header>
    <div class="logo">
        <h1>Shoe Laundry</h1>
    </div>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="testimonials.php">Testimonials</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="sign2.php">SignUp</a></li>
            <li><a href="fa.php">FAQ</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<section class="customer-profile">
    <h2>YOUR PROFILE</h2>
    <div class="profile-details">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($customer['cust_fname']) . ' ' . htmlspecialchars($customer['cust_lname']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($customer['username']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($customer['phone']); ?></p>
        <p><strong>Address:</strong> 
            <?php 
                echo htmlspecialchars($customer['house_name']) . ', ' . 
                     htmlspecialchars($customer['street_name']) . ', ' . 
                     htmlspecialchars($customer['district']) . ', ' . 
                     htmlspecialchars($customer['pincode']); 
            ?>
        </p>
    </div>

    <a href="edit_customer.php" class="btn">Edit Details</a>
</section>

<div class="icons">
    <h2 style="text-align: left; color: #2c3e50; margin-bottom: 20px; font-size: 24px;">
        Tracking Your Last Order
    </h2>

    <!-- Stage 1: Courier Assigned -->
    <div class="icon-container">
        <i class="fa-solid fa-truck-moving icon"
           style="<?php echo ($booking_status === 'Pending' && in_array($pickup_status, ['Picked', 'In Transit', 'Delivered'])) ? 
                  'color: green; transform: scale(1.3); text-shadow: 0 0 10px rgba(0, 255, 0, 0.7);' : ''; ?>">
        </i>
        <?php if ($booking_status === 'Pending' && in_array($pickup_status, ['Picked', 'In Transit', 'Delivered'])): ?>
            <p>Picked Up by Courier</p>
        <?php endif; ?>
    </div>

    <div class="line"></div>

    <!-- Stage 2: Cleaning in Progress -->
    <div class="icon-container">
        <i class="fa-solid fa-building icon"
           style="<?php echo (in_array($booking_status, ['In Progress', 'Completed']) && $pickup_status === 'Delivered') ? 
                  'color: green; transform: scale(1.3); text-shadow: 0 0 10px rgba(0, 255, 0, 0.7);' : ''; ?>">
        </i>
        <?php if ($booking_status === 'In Progress'): ?>
            <p>Cleaning In Progress</p>
        <?php elseif ($booking_status === 'Completed'): ?>
            <p>Cleaning Completed</p>
        <?php elseif ($pickup_status === 'Delivered'): ?>
            <p>Cleaning finished Ready for Delivery</p>
        <?php endif; ?>
    </div>

    <div class="line"></div>

    <!-- Stage 3: Out for Delivery -->
    <div class="icon-container">
        <i class="fa-solid fa-user-tie icon"
           style="<?php echo ($pickup_status === 'Delivered' && $courier_status === 'Delivered') ? 
                  'color: green; transform: scale(1.3); text-shadow: 0 0 10px rgba(0, 255, 0, 0.7);' : ''; ?>">
        </i>
        <?php if ($pickup_status === 'Delivered' && $courier_status === 'Delivered'): ?>
            <p>Delivered to Customer</p>
        <?php endif; ?>
    </div>
</div>





    <section class="view-orders">
    <form action="past_order.php" method="get">
        <button type="submit" class="btn">View Past Orders</button>
    </form>
</section>


<section class="customer-testimonial">
    <h2>Post Your Testimonial</h2>
    <form action="post_testimonial.php" method="post">
        <textarea name="testimonial" rows="5" placeholder="Write your testimonial here..." required></textarea>
        <button type="submit" class="btn">Submit Testimonial</button>
    </form>
</section>

<footer>
    <div class="footer-content">
        <p>&copy; 2024 Shoe Laundry. All rights reserved.</p>
    </div>
</footer>

</body>
</html>

<?php
$conn->close();
?>