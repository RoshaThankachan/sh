<?php
session_start();
include("connect.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables for booking information
$service_type = '';
$number_of_shoes = '';
$booking_error = '';
$booking_success = '';

// Fetch cust_id based on the logged-in user
$cust_id = $_SESSION['cust_id'] ?? null;

// If cust_id is not in session, retrieve it from the database based on the username
if (!$cust_id) {
    $sql_cust_id = "SELECT cust_id FROM customers WHERE username = ?";
    $stmt_cust_id = $conn->prepare($sql_cust_id);
    $stmt_cust_id->bind_param("s", $_SESSION['username']);
    $stmt_cust_id->execute();
    $stmt_cust_id->bind_result($cust_id);
    $stmt_cust_id->fetch();
    $stmt_cust_id->close();
    $_SESSION['cust_id'] = $cust_id;
}

// Fetch main services (service_type), add-on services, shoe types, and material types
$main_services_query = "SELECT service_id, service_name FROM services WHERE service_category = 'Main'";
$main_services_result = mysqli_query($conn, $main_services_query);
$main_services_array = [];

$shoe_types_query = "SELECT shoe_type_id, shoe_type_name FROM shoe_types";
$shoe_types_result = mysqli_query($conn, $shoe_types_query);
$shoe_types_array = [];

$addon_services_query = "SELECT service_id, service_name FROM services WHERE service_category = 'Add-on'";
$addon_services_result = mysqli_query($conn, $addon_services_query);
$addon_services_array = [];

$materials_query = "SELECT material_id, material_name FROM materials";
$materials_result = mysqli_query($conn, $materials_query);
$materials_array = [];

while ($row = mysqli_fetch_assoc($shoe_types_result)) {
    $shoe_types_array[] = $row;
}

while ($row = mysqli_fetch_assoc($main_services_result)) {
    $main_services_array[] = $row;
}

while ($row = mysqli_fetch_assoc($addon_services_result)) {
    $addon_services_array[] = $row;
}

while ($row = mysqli_fetch_assoc($materials_result)) {
    $materials_array[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the posted booking information
    $service_type = trim($_POST['service_type'] ?? '');
    $number_of_shoes = trim($_POST['number_of_shoes'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $delivery_date = $_POST['delivery_date'] ?? '';

    // Validate the phone number (must be exactly 10 digits)
    if (!preg_match('/^\d{10}$/', $phone)) {
        $booking_error = "Please enter a valid 10-digit phone number.";
    }

    // Validate the delivery date (must not be in the past)
    $today = date('Y-m-d');
    if ($delivery_date < $today) {
        $booking_error = "Delivery date cannot be in the past.";
    }

    // Validate input fields
    if (empty($service_type) || empty($number_of_shoes)) {
        $booking_error = "Service type and number of shoes are required.";
    } else if (empty($booking_error)) {
        // Insert into bookings table for each shoe
        for ($i = 1; $i <= $number_of_shoes; $i++) {
            $shoe_type = trim($_POST["shoe_type_$i"] ?? '');
            $material_type = trim($_POST["material_type_$i"] ?? '');

            // Check for add-on services for the current shoe
            if (isset($_POST["addon_services_$i"])) {
                $addon_services = $_POST["addon_services_$i"];
            } else {
                $addon_services = []; // Default to empty array if not set
            }

            // Validate shoe type and material type
            if (empty($shoe_type) || empty($material_type)) {
                $booking_error = "All shoe details are required.";
                break;
            }

            // Prepare add-on services as a string if necessary
            $addon_services_str = !empty($addon_services) ? implode(", ", $addon_services) : null;

        // Insert into bookings table
$sql = "INSERT INTO bookings (
    cust_id, 
    username, 
    customer_email, 
    service_type, 
    shoe_type, 
    material_type, 
    delivery_date, 
    delivery_time, 
    phone, 
    number_of_shoes, 
    special_requests, 
    addon_services
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
"isssssssssss", 
$cust_id, 
$_SESSION['username'], 
$_SESSION['username'], // Use username for customer_email
$service_type, 
$shoe_type, 
$material_type, 
$delivery_date, 
$_POST['delivery_time'], 
$phone, 
$number_of_shoes, 
$_POST['special_requests'], 
$addon_services_str
);

if (!$stmt->execute()) {
$booking_error = "Booking failed! Please try again. Error: " . $stmt->error; 
break;
}

        }

        if (empty($booking_error)) {
            $booking_id = $conn->insert_id; // Get last inserted ID
            // Redirect to address.php with booking details
            header("Location: address.php?booking_id={$booking_id}&service_type={$service_type}");
            exit(); 
        }
        
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <title>Book Service</title><style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            background: url("b.jpg") no-repeat center center fixed;
  

        }
        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }
        form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .input-field {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #34495e;
        }
        input[type="text"], input[type="number"], input[type="date"], select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        select {
    appearance: none;
    background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E');
    background-repeat: no-repeat;
    background-position: right 10px top 50%;
    background-size: 12px auto;
    font-family: 'Arial', sans-serif; /* Ensure consistent font */
    font-size: 16px; /* Adjust font size */
    color: #2c3e50; /* Font color */
    font-weight: bold; /* Make the font bold */
    padding-right: 40px; /* Add padding to prevent text overlap with the icon */
    transition: border-color 0.3s, box-shadow 0.3s; /* Smooth transition effects */
}

select:hover, select:focus {
    border-color: #3498db; /* Change border color on focus */
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.5); /* Add shadow on hover/focus */
    outline: none; /* Remove default outline */
}

option {
    font-family: 'Arial', sans-serif;
    font-size: 16px;
}

        .addon-services {
            display: flex;
            flex-wrap: wrap;
            gap: 13px;
        }
        .addon-services div {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            display: flex;
            align-items: center;
        }
        button[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #2980b9;
        }
        .error {
            color: #e74c3c;
            margin-top: 5px;
        }
    </style>
    <script>
        const mainServices = <?php echo json_encode($main_services_array); ?>;
        const addonServices = <?php echo json_encode($addon_services_array); ?>;
        const shoeTypes = <?php echo json_encode($shoe_types_array); ?>;
        const materials = <?php echo json_encode($materials_array); ?>;

        function addShoeFields() {
            const numberOfShoes = document.getElementById('number_of_shoes').value;
            const shoeContainer = document.getElementById('shoe-container');
            shoeContainer.innerHTML = ''; // Clear previous entries

            for (let i = 1; i <= numberOfShoes; i++) {
                shoeContainer.innerHTML += `
                    <h3>Shoe ${i}</h3>
                    <div class="input-field">
                        <label for="shoe_type_${i}">Shoe Type:</label>
                        <select name="shoe_type_${i}" required>
                            <option value="" disabled selected>Select a shoe type</option>
                            ${shoeTypes.map(shoe => 
                                `<option value="${shoe.shoe_type_id}">${shoe.shoe_type_name}</option>`
                            ).join('')}
                        </select>
                    </div>
                    <div class="input-field">
                        <label for="material_type_${i}">Material Type:</label>
                        <select name="material_type_${i}" required>
                            <option value="" disabled selected>Select material</option>
                            ${materials.map(material => 
                                `<option value="${material.material_id}">${material.material_name}</option>`
                            ).join('')}
                        </select>
                    </div>
                    <div class="input-field">
                        <label for="service_type">Service Type:</label>
                        <select name="service_type" required>
                            <option value="" disabled selected>Select a service</option>
                            ${mainServices.map(service => 
                                `<option value="${service.service_id}">${service.service_name}</option>`
                            ).join('')}
                        </select>
                    </div>
                    <div class="input-field">
                        <label for="addon_services_${i}">Add-on Services:</label>
                        <div class="addon-services">
                            ${addonServices.map(service => 
                                `<div>
                                    <input type='checkbox' name='addon_services_${i}[]' value='${service.service_id}' id='addon_${service.service_id}'>
                                    <label for='addon_${service.service_id}'>${service.service_name}</label>
                                </div>`
                            ).join('')}
                        </div>
                    </div>
                `;
            }
        }

        function validateDate() {
    const dateInput = document.getElementById('delivery_date').value;
    const dateError = document.getElementById('date-error');
    const today = new Date().toISOString().split('T')[0]; // Get today's date in yyyy-mm-dd format

    if (dateInput < today) {
        dateError.textContent = 'Delivery date cannot be in the past.';
        return false; // Prevent form submission
    }

    dateError.textContent = ''; // Clear error message if valid
    return true; // Allow form submission
}




        function validatePhoneNumber() {
            const phoneInput = document.querySelector('input[name="phone"]');
            const phone = phoneInput.value;
            const phoneError = document.getElementById('phone-error');

            const phoneRegex = /^\d{10}$/;

            if (!phoneRegex.test(phone)) {
                phoneError.textContent = 'Please enter a valid 10-digit phone number.';
                return false;
            }

            phoneError.textContent = '';  // Clear error message if valid
            return true;
        }

        function validateTime() {
            const timeInput = document.getElementById('delivery_time').value;
            const timePeriod = document.getElementById('time_period').value;
            const timeError = document.getElementById('time-error');

            const timeRegex = /^(0?[1-9]|1[0-2]):([0-5][0-9])$/;

            if (!timeRegex.test(timeInput) || !timePeriod) {
                timeError.textContent = 'Please enter a valid time in hh:mm format and select AM or PM.';
                return;
            }

            let [hours, minutes] = timeInput.split(':').map(Number);

            if (timePeriod === 'PM' && hours < 12) {
                hours += 12;
            } else if (timePeriod === 'AM' && hours === 12) {
                hours = 0;
            }

            const startHour = 9;
            const endHour = 19;

            if (hours < startHour || hours >= endHour) {
                timeError.textContent = 'Delivery time must be between 9:00 AM and 7:00 PM.';
            } else {
                timeError.textContent = ''; // Clear error message if valid
            }
        }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#delivery_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K", // Format: 12-hour clock
            time_24hr: false, // Set to true if you want 24-hour format
            minTime: "09:00",
            maxTime: "19:00",
            onChange: function (selectedDates, dateStr, instance) {
                const timeError = document.getElementById('time-error');
                timeError.textContent = ''; // Clear error message on valid input
            }
        });
    });
</script>

</head>
<body>
    <div>
        <h2>Book a Service</h2>
      <form method="POST" onsubmit="return validatePhoneNumber() && validateTime() && validateDate();">

            <div class="input-field">
                <label for="number_of_shoes">Number of Shoes(In pairs):</label>
                <input type="number" id="number_of_shoes" name="number_of_shoes" min="1" max="10" required onchange="addShoeFields()">
            </div>
            <div id="shoe-container"></div>
            <div class="input-field">
                <label for="delivery_date">PickUp Date:</label>
                <input type="date" id="delivery_date" name="delivery_date" required min="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="input-field">
    <label for="delivery_time">PickUp Time:</label>
    <input type="text" id="delivery_time" name="delivery_time" placeholder="Select time" required>
    <div id="time-error" style="color: red;"></div>
</div>

        
            <div class="input-field">
                <label for="phone">Phone Number:</label>
                <input type="text" name="phone" placeholder="Enter your phone number" maxlength="10" required onblur="validatePhoneNumber()">
                <div id="phone-error" style="color: red;"></div>
            </div>
            <div class="input-field">
                <label for="special_requests">Special Requests:</label>
                <textarea id="special_requests" name="special_requests"></textarea>
            </div>
            <button type="submit">Submit Booking</button>
        </form>
        <?php if (!empty($booking_error)) { ?>
            <div class="error"><?php echo $booking_error; ?></div>
        <?php } ?>
    </div>
</body>
</html>
