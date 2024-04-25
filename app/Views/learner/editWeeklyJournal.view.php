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
    <script src="ckeditor/ckeditor.js" defer></script>
    <script src="public/js/route.js" defer></script>
    <script src="public/js/addWeeklyValidation.js" defer></script>
    <title>Journal - Edit Weekly Journal</title>
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
        <!-- Get the ID of weekly report currently edited -->
        <form action="editWeeklyRaport?id=<?= $getWeeklyReport[0][0] ?>" method="POST">
            <h2>Calendar week:</h2>
            <!-- Display the calendar week from array -->
            <input type="number" name="calendar_week" id="calendar_week" min="1" max="52"
                value="<?= $getWeeklyReport[0][1] ?>"><br><br><br><br>

            <h2>Completed tasks:</h2>
            <!-- Display the text for completed tasks from array -->
            <textarea name="completed_tasks" id="completed_tasks" cols="30" rows="10"
                placeholder="For example: I have completed ..."><?php echo $getWeeklyReport[0][2] ?></textarea>

            <h2>Still in work:</h2>
            <!-- Display the text for still in work from array -->
            <textarea name="still_in_work" id="still_in_work" cols="30" rows="10"
                placeholder="For example: I'm still working on ..."><?php echo $getWeeklyReport[0][3] ?></textarea>

            <h2>Reflection:</h2>
            <!-- Display the text for the reflection from array -->
            <textarea name="reflection" id="reflection" cols="30" rows="10"
                placeholder="For example: It was ..."><?php echo $getWeeklyReport[0][4] ?></textarea>

            <h2>Issues:</h2>
            <!-- Display the text with issues from array -->
            <textarea name="issues" id="issues" cols="30" rows="10"
                placeholder="For example: I had problems with ..."><?php echo $getWeeklyReport[0][5] ?></textarea><br>
            <input type="submit" class="send" value="+ Add Weekly Report">
        </form>
    </main>

    <script>
    ['completed_tasks', 'still_in_work', 'reflection', 'issues'].forEach(function(id) {
        CKEDITOR.replace(id);
    });
    </script>

</body>

</html>