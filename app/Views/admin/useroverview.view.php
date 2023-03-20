<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/useroverview.css">
    <link rel="stylesheet" href="public/css/navside.css">
    <link rel="stylesheet" href="public/fontawesome/css/all.css">
    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Journal - User Overview</title>
</head>

<body>
    <?php
$actual_link = basename(__FILE__); // aktueller dateiname (wird für header.php benötigt)
include(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "General" . DIRECTORY_SEPARATOR . "navside.view.php");
?>

    <main>
        <div class="withData">
            <div class="flex-container">
                <div>
                    <div class="content">
                        <div class="header">
                            <h2>{Name}</h2>
                            <h2>{Email}</h2>
                            <button>Edit</button>
                            <button>Delete</button>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="content">
                        <div class="header">
                            <h2>{Name}</h2>
                            <h2>{Email}</h2>
                            <button>Edit</button>
                            <button>Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="public/js/app.js"></script>
    <script src="public/js/route.js"></script>

</body>

</html>