<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <?php $pageTitle = 'Journal - Login'; include 'app/Views/general/head.php'; ?>
</head>

<body class="min-h-screen grid place-items-center px-4">
    <div class="card w-full max-w-sm p-8 text-center">
        <div class="mx-auto mb-5 grid h-14 w-14 place-items-center rounded-2xl bg-accent text-white text-xl">
            <i class="fa-solid fa-feather-pointed"></i>
        </div>
        <h1 class="text-xl">Journal Web-App</h1>
        <p class="mt-1 text-sm text-muted">Write journals like never before!</p>

        <?php
        // Check if user is already logged in
        if (isset($_SESSION['user_token'])) {
             // Redirect to home page if user is already logged in
            header("Location: home");
        } else {
        ?>
        <button onclick="window.location='<?php echo $client->createAuthUrl(); ?>'" class="btn btn-primary w-full justify-center mt-6">
            <img src="images/google logo.png" alt="Google" class="h-5 w-5">
            <span>Login with Google</span>
        </button>

        <?php if (getenv('APP_ENV') !== 'production'): ?>
        <div class="my-4 flex items-center gap-3 text-xs text-muted">
            <span class="h-px flex-1 bg-border"></span>
            <span>— or —</span>
            <span class="h-px flex-1 bg-border"></span>
        </div>
        <a href="devLogin" class="btn btn-ghost w-full justify-center">Developer login (mock users)</a>
        <?php endif; ?>
        <?php
        }
        ?>
    </div>
</body>

</html>
