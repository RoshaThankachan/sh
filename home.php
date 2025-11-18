<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoe Laundry - Home</title>
    <link rel="stylesheet" href="home.css"> <!-- Link to your CSS file -->
    
</head>
<body>

<!-- Header Section -->
<header>
    <div class="logo">
        <h1>Shoe Laundry</h1>
    </div>
    <nav>
        <ul>
           
            <li><a href="ad_services.php">Services</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="testimonials.php">Testimonials</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="fa.php">FAQ</a></li>
          
        </ul>
    </nav>
    <div class="header-actions">
        <div class="social-icons">
        <a href="https://www.facebook.com" target="_blank"><img src="https://img.icons8.com/color/48/000000/facebook-new.png" alt="Facebook" class="social-icon"></a>
            <a href="https://www.twitter.com" target="_blank"><img src="https://img.icons8.com/color/48/000000/twitter--v1.png" alt="Twitter" class="social-icon"></a>
            <a href="https://www.instagram.com" target="_blank"><img src="https://img.icons8.com/color/48/000000/instagram-new--v1.png"  alt="Instagram" class="social-icon"></a>
            <a href="customer.php"><img src="https://img.icons8.com/color/48/000000/user.png" alt="Customer Profile" class="social-icon"></a>
        </div>
    </div>
</header>

<!-- Hero Section -->
<section class="hero">
    <video autoplay muted loop class="hero-video">
        <source src="clean.mp4" type="video/mp4"> <!-- Your video file -->
        Your browser does not support the video tag.
    </video>
    <div class="hero-content">
        <h2>Welcome to Shoe Laundry!</h2>
        <p>Your trusted partner for shoe care and restoration.</p>
        <a href="books.php" class="cta-button">Book Our Services</a>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <h2>Our Services</h2>
    <div class="feature-grid">
        <div class="feature-item">
            <img src="p6.jpeg" alt="Shoe Cleaning" class="feature-image"> <!-- Replace with your image -->
            <h3>Shoe Cleaning</h3>
            <p>Expert cleaning for all types of shoes, removing dirt and stains.</p>
        </div>
        <div class="feature-item">
            <img src="t14.jpeg" alt="Shoe Restoration" class="feature-image"> <!-- Replace with your image -->
            <h3>Shoe Restoration</h3>
            <p>Restore your shoes to their original glory with our repair services.</p>
        </div>
        <div class="feature-item">
            <img src="p4.jpeg" alt="Waterproofing" class="feature-image"> <!-- Replace with your image -->
            <h3>Waterproofing</h3>
            <p>Protect your shoes from water damage with our waterproofing treatments.</p>
        </div>
        <div class="feature-item">
            <img src="p3.jpeg" alt="Shoe Deodorizing" class="feature-image"> <!-- Replace with your image -->
            <h3>Shoe Deodorizing</h3>
            <p>Eliminate odors and keep your shoes smelling fresh.</p>
        </div>
        <div class="feature-item">
            <img src="p2.jpeg" alt="Shoe Repair" class="feature-image"> <!-- Replace with your image -->
            <h3>Shoe Repair</h3>
            <p>Professional repairs for damaged soles, seams, and more to extend the life of your favorite shoes.</p>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="gallery">
    <h2>Before & After</h2>
    <div class="gallery-grid">
        <div class="gallery-item">
            <img src="j1.jpg" alt="Before Cleaning" class="gallery-image">
            <p>Before & After Cleaning</p>
        </div>
        <div class="gallery-item">
            <img src="j2.jpg" alt="After Cleaning" class="gallery-image">
            <p>Before & After Cleaning</p>
        </div>
        <div class="gallery-item">
            <img src="j3.jpg" alt="Before Cleaning" class="gallery-image">
            <p>Before & After Cleaning</p>
        </div>
        <div class="gallery-item">
            <img src="j4.jpg" alt="After Cleaning" class="gallery-image">
            <p>Before & After Cleaning</p>
        </div>
    
        <div class="gallery-item">
            <img src="j6.jpg" alt="After Cleaning" class="gallery-image"> <!-- New After image -->
            <p>Before & After Cleaning</p>
        </div>
    </div>
</section>

<!-- Promotional Section -->
<section class="promotional" style="background-color: #f0f0f5; padding: 40px 20px; text-align: center;">
    <div class="promo-content">
        <h2 style="font-size: 2.5rem; color: #2c3e50;">Special Offer!</h2>
        <p style="font-size: 1.2rem; color: #34495e; margin-bottom: 20px;">
            Get <span class="discount" style="font-weight: bold; color: #e74c3c; font-size: 1.4rem;">20% off</span> your first shoe cleaning service when you book online!
        </p>
        <p style="font-size: 1rem; color: #7f8c8d;">
            Hurry, this offer is available for a limited time only! Bring your shoes back to life with our premium cleaning and restoration services.
        </p>
    </div>
</section>

<!-- Call-to-Action Button Section -->
<section class="cta-section" style="background-color: #2c3e50; padding: 40px 20px; text-align: center; margin-top: 30px;">
    <div class="cta-content">
        <h3 style="font-size: 2rem; color: #ecf0f1; margin-bottom: 20px;">Ready to Refresh Your Shoes?</h3>
        <a href="services.php" class="cta-button">Explore Our Services</a>
    </div>
</section>

<script>
    document.querySelectorAll('.faq-question').forEach(item => {
        item.addEventListener('click', () => {
            const answer = item.nextElementSibling; // Get the next sibling element (the answer)
            const isOpen = answer.style.display === "block"; // Check if the answer is currently displayed
            // Hide all answers first
            document.querySelectorAll('.faq-answer').forEach(ans => {
                ans.style.display = "none"; // Hide all answers
            });
            // Toggle the clicked answer
            answer.style.display = isOpen ? "none" : "block"; // Show the answer if it was hidden, otherwise hide it
        });
    });
</script>

<!-- Footer Section -->
<footer>
    <div class="footer-content">
        <p>&copy; 2024 Shoe Laundry. All rights reserved.</p>
        
    </div>
</footer>

</body>
</html>
