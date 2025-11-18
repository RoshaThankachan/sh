<?php
session_start();
if (!isset($_SESSION['employee_id'])) {
    header('Location: l.php');
    exit();
}

include('db.php');

// Get employee ID from session
$employee_id = $_SESSION['employee_id'];

if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
    $file_tmp = $_FILES['profile_pic']['tmp_name'];
    $file_name = $_FILES['profile_pic']['name'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    
    // Allowed extensions
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($file_ext, $allowed_ext)) {
        // Set destination path
        $new_file_name = $employee_id . '_profile.' . $file_ext;
        $destination = 'uploads/' . $new_file_name;

        // Move the file
        if (move_uploaded_file($file_tmp, $destination)) {
            // Update employee profile picture in the database
            $query = "UPDATE employee SET profile_pic = '$new_file_name' WHERE employee_id = '$employee_id'";
            mysqli_query($conn, $query);
        }
    }
}

mysqli_close($conn);

// Redirect back to profile page
header('Location: prof.php');
exit();
?>
