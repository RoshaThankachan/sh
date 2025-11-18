<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Shoe Laundry</title>
    <link rel="stylesheet" href="about.css"> <!-- Link to your CSS file -->
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

    <!-- About Us Section -->
    <h2>About Us</h2>
    <section id="about">
    
        <div class="about-container">
            <div class="about-content">
                <p>Welcome to <strong>Shoe Laundry</strong>! We are dedicated to providing high-quality shoe cleaning and restoration services. Our team of experts uses the best products and techniques to ensure your shoes look and feel great.</p>
                <p>Founded in <strong><?php echo date('Y'); ?></strong>, we have built a reputation for excellence in shoe care. Our mission is to extend the life of your favorite footwear while offering unmatched customer service.</p>
                <p>Whether you need a simple cleaning or a complete restoration, we've got you covered. Trust us to take care of your shoes as if they were our own!</p>
            </div>
            <div class="about-image">
                <img src="p5.jpeg" alt="Shoe Laundry Team" />
            </div>
        </div>

        <!-- Mission Statement Section -->
        <div class="mission-section">
            <h3>Our Mission</h3>
            <p>To deliver exceptional shoe care services that enhance the longevity and appearance of your footwear while ensuring a customer-centric experience.</p>
        </div>

        <!-- Core Values Section -->
        <div class="values-section">
            <h3>Core Values</h3>
            <ul>
                <li><strong>Quality:</strong> We use only the best materials and techniques.</li>
                <li><strong>Integrity:</strong> Honesty and transparency in all our dealings.</li>
                <li><strong>Customer Satisfaction:</strong> We prioritize our customers' needs.</li>
                <li><strong>Innovation:</strong> Constantly improving our services and techniques.</li>
            </ul>
        </div>

        <!-- Team Members Section -->
        <div class="team-section">
            <h3>Meet Our Team</h3>
            <p>We have a dedicated team of <strong>5</strong> members who are passionate about shoe care and restoration.</p>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Shoe Laundry. All rights reserved.</p>
    </footer>

</body>
</html>
