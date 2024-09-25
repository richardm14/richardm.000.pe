<?php
session_start(); // Start PHP session

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

function displayFileStructure($dir, $root_dir_length) {
    $files = scandir($dir);
    echo '<ul class="file-list">';
    foreach ($files as $file) {
        // Exclude current directory (.) and parent directory (..)
        if ($file != '.' && $file != '..') {
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                echo '<li><strong>' . htmlspecialchars(substr($path, $root_dir_length)) . '</strong>';
                echo '<ul>'; // Start nested list for subdirectories
                displayFileStructure($path, $root_dir_length); // Recursively display subdirectories
                echo '</ul>'; // End nested list
                echo '</li>';
            } else {
                echo '<li><a href="edit_file.php?file=' . urlencode(substr($path, $root_dir_length)) . '">' . htmlspecialchars(substr($path, $root_dir_length)) . '</a></li>';
            }
        }
    }
    echo '</ul>';
}

// Define the root directory of your website
$root_directory = realpath('../'); // Adjust relative path as needed
$root_dir_length = strlen($root_directory) + 1; // Length of root directory path
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Additional CSS for file structure display */
        body {
            font-family: 'Montserrat', sans-serif; /* Montserrat font */
            margin: 20px;
            padding: 0;
            background-color: #151515; /* Background color unchanged */
            color: #ddd; /* Text color */
        }
        h2, h3 {
            color: #ddd;
        }
        h3 {
            margin-top: 20px;
        }
        .file-list {
            list-style-type: none;
            padding-left: 20px;
            margin-top: 0;
            margin-bottom: 0;
        }
        .file-list li {
            margin-bottom: 10px; /* Increased margin between items */
            padding-top: 10px; /* Adjust this value for top padding */
        }
        .file-list li ul {
            list-style-type: none;
            padding-left: 20px;
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .top-button-container {
            margin-top: 5px; /* Adjust margin as needed */
        }
        p {
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div>
        <h2>Welcome, Admin!</h2>
        <div class="top-button-container">
            <a href="create_file.php?type=file&path=" class="btn">Create New File</a>
            <a href="create_file.php?type=folder&path=" class="btn">Create New Folder</a>
            <a href="upload_file.php?path=" class="btn">Upload File</a>
        </div>
        <p><a href="logout.php">Logout</a></p>
        <h3>File Structure</h3>
        <?php
        // Display file structure starting from the root directory
        displayFileStructure($root_directory, $root_dir_length);
        ?>

        <!-- Back to Top button -->
        <a href="#" id="back-to-top" class="btn back-to-top">Back to Top</a>
    </div>

    <!-- JavaScript for smooth scroll -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var backToTopButton = document.getElementById('back-to-top');

            backToTopButton.addEventListener('click', function(e) {
                e.preventDefault();
                // Scroll to top smoothly
                var scrollOptions = {
                    top: 0,
                    behavior: 'smooth'
                };
                window.scrollTo(scrollOptions);
            });
        });
    </script>
</body>
</html>
