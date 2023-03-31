<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/userOverview.css">
    <link rel="stylesheet" href="public/css/navside.css">
    <link rel="stylesheet" href="public/fontawesome/css/all.css">
    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Journal - User Overview</title>
</head>

<body>
    <?php
    // Set a variable to hold the basename of the current file
$actual_link = basename(__FILE__);
// Include the file "navside.view.php" from the "General" directory one level up
// using the constant DIRECTORY_SEPARATOR to ensure platform-independent file path
include(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "General" . DIRECTORY_SEPARATOR . "navside.view.php");
?>

    <main>
        <?php if(count($arrayUsers) > 0){?>
        <!-- If there are users in the array -->
        <div class="withData">
            <div class="flex-container">
                <!-- Go through the entire array -->
                <?php foreach($arrayUsers as $user){?>
                <div>
                    <div class="content">
                        <div class="header">
                            <!-- Display full name -->
                            <h2><?= $user['full_name'] ?></h2>
                            <!-- Display email adress -->
                            <h2><?= $user['email'] ?></h2>
                            <button onclick="editUser(<?= $user['userId'] ?>)">Edit</button>
                            <button onclick="deleteUser(<?= $user['userId'] ?>)">Delete</button>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <!-- If there are no users in the array -->
        <?php } else {?>
        <h1>There are no users</h1>
        <?php }?>
    </main>

    <script src="public/js/responsive.js"></script>
    <script src="public/js/route.js"></script>

</body>

</html>