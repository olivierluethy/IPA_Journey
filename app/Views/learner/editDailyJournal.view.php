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
    <title>Journal - Edit Daily Report</title>
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
        <!-- Get the ID of daily report currently edited -->
        <form action="editDailyReport?id=<?= $getDailyReport[0][0] ?>" method="POST">
            <h1>Edit Daily Report</h1>
            <h2>Text:</h2><br>
            <textarea name="text" id="text" cols="30" rows="10"
                placeholder="For example: I have completed ..."><?php echo $getDailyReport[0][1] ?></textarea>

            <h2>Keywords:</h2>
            <?php 
            // Get an array of topic ids for the picked keywords
            $pickedKeywordsIds = array_column($getPickedKeywords, 'topicId');

            // Loop through all available keywords and create a checkbox for each
            foreach ($getKeywords as $keyword) {
            // Check if the keyword is in the list of picked keywords
            $checked = in_array($keyword['topicId'], $pickedKeywordsIds);

            echo "<input type='checkbox' name='topics[]' id=" . $keyword['topicId'] . " " . ($checked ? "checked" : "") . " value=" . $keyword['topicId'] .">";

            echo "<label for=" . $keyword['topicId'] . ">" . $keyword['topic'] . "</label>";
            }

            echo "<br><input type='submit'>";
            ?>
        </form>
    </main>

    <script src="public/js/responsive.js"></script>
    <script src="public/js/route.js"></script>
    <script src="public/js/addDailyValidation.js"></script>
    <script src="ckeditor/ckeditor.js"></script>

    <script>
    CKEDITOR.replace('text');
    </script>

</body>

</html>