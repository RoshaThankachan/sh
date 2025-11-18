<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Shoe Laundry</title>
    <link rel="stylesheet" href="faqq.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="main-content"> <!-- Added wrapper for main content -->
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

        <section id="faq">
        <h1>Frequently Asked Questions</h1>
        </section>

        <div class="container">

            <div class="faq-item">
                <div class="faq-question" onclick="toggleAnswer(this)">
                    1. What types of shoes do you clean?
                    <span class="toggle-icon">▼</span>
                </div>
                <div class="faq-answer">We clean a variety of shoes including sneakers, dress shoes, boots, and sandals. For specific materials, please contact us.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleAnswer(this)">
                    2. How long does the cleaning process take?
                    <span class="toggle-icon">▼</span>
                </div>
                <div class="faq-answer">The cleaning process typically takes 2-3 days, depending on the level of cleaning required and current workload.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleAnswer(this)">
                    3. Do you offer pickup and delivery services?
                    <span class="toggle-icon">▼</span>
                </div>
                <div class="faq-answer">Yes, we offer pickup and delivery services for our customers. Please check our website for more details.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleAnswer(this)">
                    4. What is your refund policy?
                    <span class="toggle-icon">▼</span>
                </div>
                <div class="faq-answer">If you are not satisfied with our service, please contact us within 24 hours of receiving your cleaned shoes for a possible refund or re-clean.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleAnswer(this)">
                    5. Can I track the status of my order?
                    <span class="toggle-icon">▼</span>
                </div>
                <div class="faq-answer">Yes, once your order is placed, you can track the status of your order after logging to the Customer page.</div>
            </div>
        </div>
    </div>

    <script>
        function toggleAnswer(question) {
            const answer = question.nextElementSibling;
            question.classList.toggle('active'); // Toggle active class for rotation
            answer.style.display = answer.style.display === 'block' ? 'none' : 'block'; // Toggle answer visibility
        }
    </script>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Shoe Laundry. All rights reserved.</p>
    </footer>
</body>
</html>
