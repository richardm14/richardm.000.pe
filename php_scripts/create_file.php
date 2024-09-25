<?php
session_start(); // Start PHP session

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// CSRF token generation and validation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Define the root directory of your website
$root_directory = realpath('../'); // Adjust relative path as needed

function isValidPath($path) {
    global $root_directory;
    $real_path = realpath($root_directory . '/' . $path);
    return $real_path !== false && strpos($real_path, $root_directory) === 0;
}

$message = ''; // Initialize message variable

// Initialize variables
$type = isset($_GET['type']) ? $_GET['type'] : ''; // Get the type (file or folder) from the URL parameter
$path = isset($_GET['path']) ? $_GET['path'] : ''; // Get the path where to create the file/folder

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // CSRF token validation
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    // Determine if creating a file or a folder based on 'type' parameter
    $type = $_POST['type'] ?? ''; // Use empty string as default if 'type' is not set
    $path = $_POST['path'] ?? ''; // Get the path where to create the file/folder

    // Ensure path is valid and exists
    if (!isValidPath($path)) {
        die("Invalid path.");
    }

    if ($type === 'file') {
        // Creating a new file
        $file_name = $_POST['file_name'];

        // Validate file name (add more validation as needed)
        if (empty($file_name)) {
            $message = 'File Name cannot be empty.';
        } else {
            $file_path = $root_directory . '/' . $path . '/' . $file_name;

            // Check if file already exists
            if (file_exists($file_path)) {
                $message = 'File already exists.';
            } else {
                // Create the file
                if (touch($file_path)) { // Create an empty file
                    $message = 'File created successfully!';
                } else {
                    $message = 'Failed to create file.';
                }
            }
        }
    } elseif ($type === 'folder') {
        // Creating a new folder
        $folder_name = $_POST['folder_name'];

        // Validate folder name (add more validation as needed)
        if (empty($folder_name)) {
            $message = 'Folder Name cannot be empty.';
        } else {
            $folder_path = $root_directory . '/' . $path . '/' . $folder_name;

            // Check if folder already exists
            if (file_exists($folder_path) && is_dir($folder_path)) {
                $message = 'Folder already exists.';
            } else {
                // Create the folder
                if (mkdir($folder_path, 0755, true)) { // Create folder with recursive flag
                    $message = 'Folder created successfully!';
                } else {
                    $message = 'Failed to create folder.';
                }
            }
        }
    } else {
        die('Invalid operation.');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create File/Folder</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Additional CSS */
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
        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 2px solid #444;
            background-color: #333;
            color: #ddd;
            border-radius: 5px;
            width: 40%; /* Adjusted width to 40% of the screen */
            max-width: 400px; /* Limit maximum width to 400px */
        }
        .btn-create {
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
        .btn-create:hover {
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
        <h2>Create File or Folder</h2>
        <form method="post" action="">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="<?php echo ($type === 'file') ? 'file_name' : 'folder_name'; ?>" required>
            </div>
            <div class="form-group">
                <label for="path">Create in directory:</label>
                <input type="text" id="path" name="path" value="<?php echo htmlspecialchars($_POST['path'] ?? ''); ?>">
            </div>
            <input type="hidden" name="type" value="<?php echo htmlspecialchars($type); ?>">
            <button type="submit" class="btn-create">Create <?php echo ($type === 'file') ? 'File' : 'Folder'; ?></button>
        </form>
        <?php if (!empty($message)): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <p><a href="admin_panel.php">Back to Admin Panel</a></p>
    </div>
</body>
</html>
