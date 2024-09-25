<?php
session_start(); // Start PHP session

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Adjust relative path
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // CSRF token validation
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    // Save the edited content to the file
    $file = $_POST['file'];
    $content = $_POST['content'];

    if (isValidPath($file) && file_exists($root_directory . '/' . $file) && is_writable($root_directory . '/' . $file)) {
        file_put_contents($root_directory . '/' . $file, $content);
        $message = "File saved successfully!";
    } else {
        $message = "File does not exist or is not writable.";
    }
} else {
    // Load the file content for editing
    $file = $_GET['file'];
    if (isValidPath($file) && file_exists($root_directory . '/' . $file)) {
        $content = file_get_contents($root_directory . '/' . $file);
    } else {
        die("File does not exist or is invalid.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css" />
    <meta charset="UTF-8">
    <title>Edit File</title>
    <style>
        textarea {
            width: 50%;
            height: 400px;
            padding: 10px;
            font-size: 16px;
            font-family: "Poppins", sans-serif;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
        }
        .btn-save {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-top: 20px; /* Add margin to move the button further down */
        }
        .btn-save:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.querySelector('textarea[name="content"]');
            textarea.addEventListener('keydown', function (e) {
                if (e.key === 'Tab') {
                    e.preventDefault();
                    const start = this.selectionStart;
                    const end = this.selectionEnd;
                    this.value = this.value.substring(0, start) + "\t" + this.value.substring(end);
                    this.selectionStart = this.selectionEnd = start + 1;
                }
            });
        });
    </script>
</head>
<body>
    <h2>Edit File: <?php echo htmlspecialchars($file); ?></h2>
    
    <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
    
    <form method="post" action="edit_file.php">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <input type="hidden" name="file" value="<?php echo htmlspecialchars($file); ?>">
        <textarea name="content" rows="20" cols="100"><?php echo htmlspecialchars($content); ?></textarea><br>
        <button type="submit" class="btn-save">Save</button>
    </form>
    
    <p><a href="admin_panel.php">Back to Admin Panel</a></p>
</body>
</html>
