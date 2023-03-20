<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/dailyweeklyreport.css">
    <link rel="stylesheet" href="public/css/navside.css">
    <link rel="stylesheet" href="public/fontawesome/css/all.css">
    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Journal - User Overview</title>
</head>

<body>
    <button id="burger" onclick="toggleSidebar()">&#9776;</button>

    <?php
$actual_link = basename(__FILE__); // aktueller dateiname (wird für header.php benötigt)
include ("navside.view.php");
?>

    <main>
        <div class="withData">
            <h2>User</h2>
        </div>
    </main>

    <script src="public/js/app.js"></script>
    <script src="public/js/route.js"></script>

</body>

</html>