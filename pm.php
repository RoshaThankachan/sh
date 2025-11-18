<?php
session_start();
include("connect.php");

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch customer ID from session
$cust_id = $_SESSION['cust_id'] ?? null;
$payment_details = []; // Initialize an empty array to store payment details

if ($cust_id) {
    // Fetch payment details from the database
    $sql_payment = "SELECT card_number, exp_month, exp_year, cvv, account_number, bank_name, ifsc_code, paypal_email, paypal_note 
                    FROM payment WHERE cust_id = ? LIMIT 1";
    $stmt_payment = $conn->prepare($sql_payment);
    $stmt_payment->bind_param("i", $cust_id);
    $stmt_payment->execute();
    $result_payment = $stmt_payment->get_result();
    if ($result_payment->num_rows > 0) {
        $payment_details = $result_payment->fetch_assoc();
    }
    $stmt_payment->close();
}

// Get booking ID and service type from query parameters
$booking_id = $_GET['booking_id'] ?? null;
$service_id = $_GET['service_type'] ?? null;

// Calculate total price (base service price + addons)
$total_price = 0;
if ($service_id) {
    // Fetch base service price
    $sql_price = "SELECT price FROM services WHERE service_id = ?";
    $stmt_price = $conn->prepare($sql_price);
    $stmt_price->bind_param("i", $service_id);
    $stmt_price->execute();
    $stmt_price->bind_result($base_price);
    $stmt_price->fetch();
    $stmt_price->close();

    // Initialize total_price with base service price
    $total_price += $base_price;

    // Fetch addon services and their prices
    $sql_addons = "SELECT addon_services FROM bookings WHERE booking_id = ?";
    $stmt_addons = $conn->prepare($sql_addons);
    $stmt_addons->bind_param("i", $booking_id);
    $stmt_addons->execute();
    $stmt_addons->bind_result($addon_services);
    $stmt_addons->fetch();
    $stmt_addons->close();

    if (!empty($addon_services)) {
        $addons_array = explode(',', $addon_services); // Assuming addons are stored as comma-separated IDs
        foreach ($addons_array as $addon_id) {
            $sql_addon_price = "SELECT price FROM services WHERE service_id = ?";
            $stmt_addon_price = $conn->prepare($sql_addon_price);
            $stmt_addon_price->bind_param("i", $addon_id);
            $stmt_addon_price->execute();
            $stmt_addon_price->bind_result($addon_price);
            if ($stmt_addon_price->fetch()) {
                $total_price += $addon_price; // Accumulate addon prices
            }
            $stmt_addon_price->close();
        }
        
    }
}

// Handle payment processing
$payment_error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = trim($_POST['payment_method'] ?? '');
    if (empty($payment_method)) {
        $payment_error = "Please select a payment method.";
    } else {
        // Validate and process payment details
        $card_number = trim($_POST['card_number'] ?? '');
        $exp_month = trim($_POST['exp_month'] ?? '');
        $exp_year = trim($_POST['exp_year'] ?? '');
        $cvv = trim($_POST['cvv'] ?? '');
        $account_number = trim($_POST['account_number'] ?? '');
        $bank_name = trim($_POST['bank_name'] ?? '');
        $ifsc_code = trim($_POST['ifsc_code'] ?? '');
        $paypal_email = trim($_POST['paypal_email'] ?? '');
        $paypal_note = trim($_POST['paypal_note'] ?? '');

        // Process based on payment method
        if ($payment_method === 'credit_card' && (!preg_match('/^\d{16}$/', $card_number) || !preg_match('/^\d{3}$/', $cvv))) {
            $payment_error = "Invalid credit card details.";
        } elseif ($payment_method === 'bank_transfer' && (!preg_match('/^\d{11}$/', $account_number) || empty($bank_name) || !preg_match('/^[A-Za-z]{4}\d{7}$/', $ifsc_code))) {
            $payment_error = "Invalid bank transfer details.";
        } elseif ($payment_method === 'paypal' && empty($paypal_email)) {
            $payment_error = "Invalid PayPal details.";
        } else {
            // Payment successful simulation
            $payment_date = date('Y-m-d');
            $payment_status = 1; // Payment success
            $payment_reference = uniqid("payment_");

            // Insert/update payment details
            $sql_insert_payment = "INSERT INTO payment
                (cust_id, card_number, exp_month, exp_year, cvv, account_number, bank_name, ifsc_code, paypal_email, paypal_note, payment_date, payment_method, payment_reference, payment_status, total_price) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                card_number = VALUES(card_number), exp_month = VALUES(exp_month), exp_year = VALUES(exp_year), 
                cvv = VALUES(cvv), account_number = VALUES(account_number), bank_name = VALUES(bank_name), 
                ifsc_code = VALUES(ifsc_code), paypal_email = VALUES(paypal_email), paypal_note = VALUES(paypal_note),
                payment_date = VALUES(payment_date), payment_method = VALUES(payment_method), 
                payment_reference = VALUES(payment_reference), payment_status = VALUES(payment_status), 
                total_price = VALUES(total_price)";
            $stmt_payment = $conn->prepare($sql_insert_payment);
            $stmt_payment->bind_param("isssssssssssssd", $cust_id, $card_number, $exp_month, $exp_year, $cvv, $account_number, $bank_name, $ifsc_code, $paypal_email, $paypal_note, $payment_date, $payment_method, $payment_reference, $payment_status, $total_price);
            $stmt_payment->execute();

            // Redirect to bill page
            header("Location: bill.php?booking_id=$booking_id&amount=$total_price&payment_method=$payment_method&payment_reference=$payment_reference");
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
    <title>Payment</title>
    <style>
        /* Styling goes here */
    </style>
<script>
function togglePaymentDetails() {
    const paymentMethod = document.querySelector('select[name="payment_method"]').value;

    // Hide all payment method sections initially
    document.getElementById('credit-card-details').style.display = 'none';
    document.getElementById('bank-transfer-details').style.display = 'none';
    document.getElementById('paypal-details').style.display = 'none';

    // Show the relevant section based on the selected payment method
    if (paymentMethod === 'credit_card') {
        document.getElementById('credit-card-details').style.display = 'block';
    } else if (paymentMethod === 'bank_transfer') {
        document.getElementById('bank-transfer-details').style.display = 'block';
    } else if (paymentMethod === 'paypal') {
        document.getElementById('paypal-details').style.display = 'block';
    }
}

function validateExpiryDate() {
            const expMonth = document.querySelector('input[name="exp_month"]');
            const expYear = document.querySelector('input[name="exp_year"]');

            const validate = () => {
                const monthValue = parseInt(expMonth.value, 10);
                const yearValue = parseInt(expYear.value, 10);
                const currentDate = new Date();
                const currentMonth = currentDate.getMonth() + 1; // Months are 0-indexed
                const currentYear = currentDate.getFullYear();

                clearErrorMessage(expMonth);
                clearErrorMessage(expYear);

                let valid = true;

                if (isNaN(monthValue) || monthValue < 1 || monthValue > 12) {
                    showErrorMessage(expMonth, "Enter a valid month (01 to 12).");
                    valid = false;
                }

                if (isNaN(yearValue) || yearValue < currentYear || (yearValue === currentYear && monthValue < currentMonth)) {
                    showErrorMessage(expYear, "Expiry date must be in the future.");
                    valid = false;
                }

                return valid;
            };

            const showErrorMessage = (inputElement, message) => {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.textContent = message;
                inputElement.insertAdjacentElement('afterend', errorDiv);
            };

            const clearErrorMessage = (inputElement) => {
                const errorMessage = inputElement.nextElementSibling;
                if (errorMessage && errorMessage.classList.contains('error-message')) {
                    errorMessage.remove();
                }
            };

            expMonth.addEventListener('input', validate);
            expYear.addEventListener('input', validate);
            validate();
        }

        document.addEventListener('DOMContentLoaded', validateExpiryDate);

// Ensure the correct section is displayed on page load if a method is already selected
document.addEventListener('DOMContentLoaded', togglePaymentDetails);
</script>

</head>
<body>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
        color: #333;
    }

    .wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
    }

    .payment-form {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 600px;
    }

    h2 {
        margin-bottom: 20px;
        font-size: 24px;
        text-align: center;
        color: #007bff;
    }

    p {
        font-size: 16px;
        margin-bottom: 20px;
        text-align: center;
    }

    .error-message {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        margin-bottom: 15px;
        text-align: center;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    select, input[type="text"], input[type="email"], textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    textarea {
        resize: vertical;
        height: 100px;
    }

    button[type="submit"] {
        width: 100%;
        background-color: #007bff;
        color: #fff;
        padding: 12px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }

    #credit-card-details, #bank-transfer-details, #paypal-details {
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .payment-form {
            padding: 15px;
        }
        h2 {
            font-size: 20px;
        }
    }
</style>
 
    <div class="wrapper">
        <section class="payment-form">
            <h2>Payment for Booking ID: <?php echo htmlspecialchars($booking_id); ?></h2>
            <p><strong>Total Price: Rs. <?php echo htmlspecialchars($total_price); ?></strong></p>
            <?php if (!empty($payment_error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($payment_error); ?></div>
            <?php endif; ?>

            <form method="POST">
                <div>
                    <label>Select Payment Method:</label>
                    <select name="payment_method" onchange="togglePaymentDetails()" required>
                        <option value="">--Select--</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="paypal">PayPal</option>
                    </select>
                </div>
                <div id="credit-card-details" style="display:none;">
    <label>Card Number:</label>
    <input type="text" name="card_number" value="<?php echo htmlspecialchars($payment_details['card_number'] ?? ''); ?>" maxlength="16" oninput="this.value=this.value.replace(/[^0-9]/g,'');">

    <label for="exp_month">Expiration Month:</label>
            <input type="text" name="exp_month" id="exp_month" placeholder="MM" maxlength="2" 
                   value="<?php echo htmlspecialchars($payment_details['exp_month'] ?? ''); ?>">

            <label for="exp_year">Expiration Year:</label>
            <input type="text" name="exp_year" id="exp_year" placeholder="YYYY" maxlength="4" 
                   value="<?php echo htmlspecialchars($payment_details['exp_year'] ?? ''); ?>">

    <label>CVV:</label>
    <input type="text" name="cvv" value="<?php echo htmlspecialchars($payment_details['cvv'] ?? ''); ?>" maxlength="3" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
</div>

<div id="bank-transfer-details" style="display:none;">
    <label>Account Number:</label>
    <input type="text" name="account_number" value="<?php echo htmlspecialchars($payment_details['account_number'] ?? ''); ?>" maxlength="11" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
    
    <label>Bank Name:</label>
    <input type="text" name="bank_name" value="<?php echo htmlspecialchars($payment_details['bank_name'] ?? ''); ?>">
    
    <label>IFSC Code:</label>
    <input type="text" name="ifsc_code" value="<?php echo htmlspecialchars($payment_details['ifsc_code'] ?? ''); ?>" maxlength="11" oninput="this.value=this.value.toUpperCase().replace(/[^A-Z0-9]/g,'');">
</div>

                <div id="paypal-details" style="display:none;">
                    <label>PayPal Email:</label>
                    <input type="email" name="paypal_email" value="<?php echo htmlspecialchars($payment_details['paypal_email'] ?? ''); ?>">
                    <label>Note:</label>
                    <textarea name="paypal_note"><?php echo htmlspecialchars($payment_details['paypal_note'] ?? ''); ?></textarea>
                </div>
                <button type="submit">Proceed to Payment</button>
            </form>
        </section>
    </div>
</body>
</html>
