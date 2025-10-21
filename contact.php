<?php
session_start();
require("php/connection.php");
require("php/functions.php");

$user = checkSession($con);
$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Contact</title>
</head>
<body>
    <?php
    getNav(getRole($user));
    ?>
    <div class="container">
        <main class="contact">
            <div>
                    <p>If you would like to reach us, please send an email to 
                    <a href="mailto:contact@randommedia.test">contact@randommedia.test</a> 
                    or call us at <a href="tel:+48123456789">(+48) 123 45 67 89</a>.</p>
                    <address>
                        <p>HTML Structure</p>
                        <p>ul. Świdnicka 1235</p>
                         <p>Wrocław, Poland</p>
                    </address>
                    <p>Office hours: Mon–Fri 9:00–17:00</p>
                </div>
                <form action="#" method="post" class="contact-form">
                        <input type="text" name="name" placeholder="Name">
                        <input type="text" name="surname" placeholder="Surname">
                        <input type="email" name="email" placeholder="mail@example.com">
                        <textarea name="message" rows="4" placeholder="Your message..."></textarea>
                        <button type="submit">Send</button>
                </form>
        </main>
        
    </div>
    <?php
    getFooter();
    ?>
</body>
</html>