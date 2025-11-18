<?php
session_start();
require('db.php');

// Fetch services from the database
$query = "SELECT * FROM services";
$stmt = $conn->prepare($query);
$stmt->execute();
$services = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - Shoe Laundry</title>
    <link rel="stylesheet" href="services.css">
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
            <li><a href="services.php">Services</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="testimonials.php">Testimonials</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="fa.php">FAQ</a></li>
        </ul>
    </nav>
</header>

<!-- Services Section -->
<section id="services">
    <h2>Our Services</h2>
    <div class="service-grid">
        <?php while ($service = $services->fetch_assoc()): ?>
            <div class="service-item">
                <!-- Display Image -->
                <img src="<?php echo htmlspecialchars($service['photo']); ?>" alt="<?php echo htmlspecialchars($service['service_name']); ?>" class="service-image">
                
                <h3><?php echo htmlspecialchars($service['service_name']); ?></h3>
               
                <p> <?php echo htmlspecialchars($service['description']); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<!-- Footer Section -->
<footer>
    <p>&copy; 2024 Shoe Laundry. All rights reserved.</p>
</footer>

</body>
</html>
