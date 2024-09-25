<?php

session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check cooldown

    $cooldownTime = 180; // 3 minutes

    $currentTime = time();



    if (isset($_SESSION['last_submit']) && ($currentTime - $_SESSION['last_submit']) < $cooldownTime) {

        echo "Please wait before sending another message.";

        exit;

    }



    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));

    $email = htmlspecialchars(strip_tags(trim($_POST['email'])));

    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));



    // Set your email and subject

    $to = 'morarescuri23@saintedmunds.org.uk'; // Replace with your email

    $subject = 'New Message from Contact Form';

    $body = "Name: $name

Email: $email

Message: $message";



    // Additional headers

    $headers = "From: $email";



    if (mail($to, $subject, $body, $headers)) {

        echo "Message sent successfully!";

        $_SESSION['last_submit'] = $currentTime; // Update last submit time

    } else {

        echo "Failed to send message.";

    }

} else {

    echo "Invalid request.";

}

?>

