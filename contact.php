<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Shoe Laundry</title>
    <link rel="stylesheet" href="contact.css"> <!-- Link to your CSS file -->
    <script>
        // Function to handle form submission
        function handleFormSubmit(event) {
            event.preventDefault(); // Prevent form submission

            // Display a confirmation message
            alert("Thank you for your message. We will contact you after reviewing your message.");
            
            // Optionally, reset the form fields
            document.getElementById("contactForm").reset();
        }
    </script>
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

    <!-- Contact Section -->
    <section id="contact">
        <h2>Contact Us</h2>
        <p>If you have any questions, feedback, or would like to book a service, please reach out to us using the form below or through our contact details.</p>

        <div class="contact-details">
            <h3>Contact Information</h3>
            <p><strong>Email:</strong> <a href="shoelaundryinfo@gmail.com">shoelaundryinfo@gmail.com</a></p>
            <p><strong>Phone:</strong> 8590006955</a></p>
            <p><strong>Address:</strong> Shoe Laundry Store,Kakkanad,Ernakulam</p>
        </div>

        <div class="contact-form">
            <h3>Send Us a Message</h3>
            <form id="contactForm" onsubmit="handleFormSubmit(event)">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" required></textarea>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </section>

    <!-- Interactive Map Section -->
    <section class="map-section">
        <h3>Find Us Here</h3>
        <div class="map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d251473.140419789!2d76.0530251945312!3d9.99472210000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b080d5991771765%3A0x3ae2017fa74af5d7!2sRajagiri%20College%20of%20Management%20and%20Applied%20Sciences!5e0!3m2!1sen!2sus!4v1728797391915!5m2!1sen!2sus"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Shoe Laundry. All rights reserved.</p>
    </footer>

</body>
</html>
