<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonials - Shoe Laundry</title>
    <link rel="stylesheet" href="tes.css"> <!-- Link to your CSS file -->
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

    <!-- Testimonials Section -->
    <section id="testimonials">
        <h2>What Our Customers Say</h2>
        <div class="testimonial-container">
            <?php
            include("db_connect.php");

            // Fetch testimonials from the database
            $sql = "SELECT t.testimonial, c.cust_fname, c.cust_lname, t.date_posted 
                    FROM testimonials t 
                    JOIN customers c ON t.cust_id = c.cust_id 
                    ORDER BY t.date_posted DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="testimonial-item">';
                    echo '<p>"' . htmlspecialchars($row['testimonial']) . '" - <strong>' . 
                         htmlspecialchars($row['cust_fname']) . ' ' . htmlspecialchars($row['cust_lname']) . '</strong></p>';
                    echo '<p><small>Posted on: ' . htmlspecialchars($row['date_posted']) . '</small></p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No testimonials yet. Be the first to share your experience!</p>';
            }

            $conn->close();
            ?>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Shoe Laundry. All rights reserved.</p>
    </footer>

</body>
</html>
