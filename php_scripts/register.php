<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../php_scripts/style.css" />
<?php
// Example registration script

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Replace with your database connection details
    $host = 'sql312.infinityfree.com'; // Example: sqlXXX.epizy.com
    $db = 'if0_36840367_website_users_content_db';   // Example: epiz_XXXXXX_yourdbname
    $user = 'if0_36840367'; // Example: epiz_XXXXXX
    $pass = '3w6AfSR7Cs'; // Your database password
    
    // Connect to database
    $conn = new mysqli($host, $user, $pass, $db);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Securely escape input
    $username = $conn->real_escape_string($username);
    $hashed_password = $conn->real_escape_string($hashed_password);
    
    // Insert user into database
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
    
    if ($conn->query($query) === TRUE) {
        echo "New user registered successfully";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Register">
    </form>
</body>
</html>
