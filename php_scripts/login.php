<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Montserrat", sans-serif;
    }
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: #151515;
        background-size: cover;
        background-position: center;
    }
    .wrapper {
        width: 420px;
        background: transparent;
        border: 2px solid rgba(255, 255, 255, .2);
        backdrop-filter: blur(9px);
        color: #fff;
        border-radius: 12px;
        padding: 30px 40px;
    }
    .wrapper h1 {
        font-size: 36px;
        text-align: center;
    }
    .wrapper .input-box {
        position: relative;
        width: 100%;
        height: 50px;
        margin: 30px 0;
    }
    .input-box input {
        width: 100%;
        height: 100%;
        background: transparent;
        border: none;
        outline: none;
        border: 2px solid rgba(255, 255, 255, .2);
        border-radius: 40px;
        font-size: 16px;
        color: #fff;
        padding: 20px 45px 20px 20px;
    }
    .input-box input::placeholder {
        color: #fff;
    }
    .input-box i {
        position: absolute;
        right: 20px;
        top: 30%;
        transform: translate(-50%);
        font-size: 20px;
    }
    .wrapper .btn {
        width: 100%;
        height: 45px;
        background: #fff;
        border: none;
        outline: none;
        border-radius: 40px;
        box-shadow: 0 0 10px rgba(0, 0, 0, .1);
        cursor: pointer;
        font-size: 16px;
        color: #333;
        font-weight: 600;
        transition: background-color 0.3s ease; /* Transition effect for background color */
    }
    .wrapper .btn:hover {
        background-color: #b1b1b1; /* Darker background color on hover */
    }
    /* Remove default blue highlight */
    ::-moz-selection {
        background-color: transparent;
        color: inherit;
    }
    ::selection {
        background-color: transparent;
        color: inherit;
    }
    .wrapper a {
        display: block;
        text-align: center;
        color: white;
        margin-top: 20px; /* Adjusted margin to create space */
        text-decoration: none;
        }
</style>
</head>
<body>
    <div class="wrapper">
        <form method="post" action="login_process.php">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" class="btn">Login</button>
            <a href="../index.html">Back to website</a>
        </form>
    </div>
</body>
</html>
