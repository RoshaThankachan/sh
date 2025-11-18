<?php
// Start the session
session_start();

// Check if the user confirmed logout by checking the "confirm" query parameter
if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    // Destroy session and logout
    session_unset();
    session_destroy();
    // Redirect to the home page (you can change this to your actual home page URL)
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        /* Basic styling for the page and button */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .logout-button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .logout-button:hover {
            background-color: #2980b9;
        }
    </style>
    <script>
        function confirmLogout() {
            // Show confirmation dialog
            const userConfirmed = confirm("Do you really want to logout?");
            if (userConfirmed) {
                // Redirect to logout page with confirmation
                window.location.href = "logout.php?confirm=yes";
            }
            // If canceled, do nothing (remain on the same page)
        }
    </script>
</head>
<body>
    <button class="logout-button" onclick="confirmLogout()">Logout</button>
</body>
</html>
