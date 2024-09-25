<?php
session_start(); // Start PHP session

// Replace with your actual username and password validation logic
$valid_username = 'admin';
$valid_password_hash = password_hash('$w3xdBhqTqdwdrztsvfMmy5jj', PASSWORD_DEFAULT); // Example hashed password

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if ($username === $valid_username && password_verify($password, $valid_password_hash)) {
        // Authentication successful
        $_SESSION['user_id'] = 1; // Example user ID, you can set this to any unique identifier for the admin
        header('Location: admin_panel.php');
        exit;
    } else {
        // Authentication failed
        echo "Invalid username or password";
    }
}
?>
