<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/navside.css">
    <link rel="stylesheet" href="public/fontawesome/css/all.css">
    <link rel="stylesheet" href="public/css/home.css">
    <link rel="shortcut icon" href="images/favicon.ico">

    <script src="public/js/responsive.js" defer></script>
    <title>Journal - Login</title>
</head>

<body>
    <?php
$actual_link = basename(__FILE__);
include ("navside.view.php");
?>

    <main>
        <div class="login">
            <h1>Welcome To Journal Web-App</h1>
            <p>Write journals like never before!</p>
            <?php
            // Check if user is already logged in
            if (isset($_SESSION['user_token'])) {
                 // Redirect to home page if user is already logged in
                header("Location: home");
            } else {
        ?>
            <button onclick="window.location='<?php echo $client->createAuthUrl(); ?>'" class="loginBtn">
                <img src="images/google logo.png" alt="Image">
                <span>Login with Google</span>
            </button>
            <?php
            }
        ?>
        </div>
    </main>

</body>

</html>