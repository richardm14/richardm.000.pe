<?php
session_start(); // Start PHP session

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get HTML and CSS content from form
    $html_content = $_POST['html_content'];
    $css_content = $_POST['css_content'];
    
    // Save HTML content to file
    $html_file = 'html_content.html';
    if (file_put_contents($html_file, $html_content) !== false) {
        echo "HTML content saved successfully<br>";
    } else {
        echo "Error saving HTML content<br>";
    }
    
    // Save CSS content to file
    $css_file = 'style.css';
    if (file_put_contents($css_file, $css_content) !== false) {
        echo "CSS content saved successfully<br>";
    } else {
        echo "Error saving CSS content<br>";
    }
}
?>
