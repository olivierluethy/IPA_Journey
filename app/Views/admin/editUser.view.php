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

    <script src="public/js/responsive.js" defer></script>
    <script src="public/js/route.js" defer></script>
    <title>Journal - Edit Keyword</title>
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
        <form action="editUser?id=<?= $getUser[0][0] ?>" method="POST">
            <h2>Edit User</h2>
            <label for="title">Role:</label><br>
            <input type="text" id="title" name="role" id="title" value="<?= $getUser[0][9] ?>"><br><br><br><br><br><br>
            <input type="submit" class="send" name="addTask" value="Edit User"><br><br>
        </form>
    </main>

</body>

</html>