<?php
session_start(); // Start PHP session

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Define the root directory of your website
$root_directory = realpath('../'); // Adjust relative path as needed

function isValidPath($path) {
    global $root_directory;
    $real_path = realpath($root_directory . '/' . $path);
    return $real_path !== false && strpos($real_path, $root_directory) === 0;
}

$message = ''; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle file upload
    $path = $_POST['path'] ?? ''; // Get the path where to upload the file

    // Ensure path is valid and exists
    if (!isValidPath($path)) {
        die("Invalid path.");
    }

    $upload_directory = $root_directory . '/' . $path . '/';

    // Check if file was uploaded
    if (!isset($_FILES['file'])) {
        die('No file uploaded.');
    }

    $uploaded_file = $_FILES['file'];

    // Check for errors during file upload
    if ($uploaded_file['error'] !== UPLOAD_ERR_OK) {
        die('File upload failed with error code ' . $uploaded_file['error']);
    }

    // Move uploaded file to destination directory
    $destination = $upload_directory . basename($uploaded_file['name']);

    if (move_uploaded_file($uploaded_file['tmp_name'], $destination)) {
        $message = 'File uploaded successfully!';
    } else {
        $message = 'Failed to upload file.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload File</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Common CSS */
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #151515;
            color: #ddd;
            margin: 20px;
        }
        h2 {
            color: #ddd;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #aaa;
        }
        input[type="text"], input[type="file"] {
            padding: 10px;
            font-size: 16px;
            border: 2px solid #444;
            background-color: #333;
            color: #ddd;
            border-radius: 5px;
            width: 40%; /* Adjusted width to 40% of the screen */
            max-width: 400px; /* Limit maximum width to 400px */
        }
        .btn-create, .btn-upload {
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
        }
        .btn-create:hover, .btn-upload:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            background-color: #444;
            color: #fff;
            border-radius: 5px;
            display: <?php echo (!empty($message)) ? 'block' : 'none'; ?>; /* Show only if there's a message */
        }
    </style>
</head>
<body>
    <div>
        <h2>Upload File</h2>
        <?php if (!empty($message)): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file">Choose file:</label>
                <input type="file" id="file" name="file" required>
            </div>
            <div class="form-group">
                <label for="path">Upload to directory:</label>
                <input type="text" id="path" name="path" value="<?php echo htmlspecialchars($_POST['path'] ?? ''); ?>">
            </div>
            <button type="submit" class="btn-upload">Upload File</button>
        </form>
        <p><a href="admin_panel.php">Back to Admin Panel</a></p>
    </div>
</body>
</html>
