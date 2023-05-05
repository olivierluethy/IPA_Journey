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
    <script src="public/js/addKeywordValidation.js" defer></script>
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
        <!-- Get the ID of keyword currently edited -->
        <form action="editKeyword?id=<?= $getKeyword[0][0] ?>" method="POST">
            <h2>Edit Keyword</h2>
            <label for="title">Topic:</label><br>
            <!-- Display the text of keyword from array -->
            <input type="text" id="title" name="topic" id="title" value="<?= $getKeyword[0][1] ?>"><br>
            <input type="submit" class="" name="addTask" value="Edit Keyword"><br><br>
        </form>
    </main>

</body>

</html>