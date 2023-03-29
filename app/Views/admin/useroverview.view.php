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
$actual_link = basename(__FILE__);
include(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "General" . DIRECTORY_SEPARATOR . "navside.view.php");
?>

    <main>
        <?php if(count($arrayUsers) > 0){?>
        <div class="withData">
            <div class="flex-container">
                <?php foreach($arrayUsers as $user){?>
                <div>
                    <div class="content">
                        <div class="header">
                            <h2><?= $user['full_name'] ?></h2>
                            <h2><?= $user['email'] ?></h2>
                            <button onclick="editUser(<?= $user['userId'] ?>)">Edit</button>
                            <button onclick="deleteUser(<?= $user['userId'] ?>)">Delete</button>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } else {?>
        <h1>There are no users</h1>
        <?php }?>
    </main>

    <script src="public/js/responsive.js"></script>
    <script src="public/js/route.js"></script>

</body>

</html>