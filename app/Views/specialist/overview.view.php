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

    <script src="public/js/search.js" defer></script>
    <script src="public/js/responsive.js" defer></script>
    <script src="public/js/route.js" defer></script>
    <script src="ckeditor/ckeditor.js" defer></script>
    <title>Journal - Overview</title>
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

        <input type="text" id="inputSearch" onkeyup="search()"
            placeholder="Search by user, content inside text, keyword or date">

        <h1>Weekly reports:</h1>
        <?php if(count($arrayWeeklyRaports)){?>
        <div class="flex-container" id="weekly">
            <?php
            // Go through the entire array
                    foreach ($arrayWeeklyRaports as $weeklyRaports){?>
            <div class="container-child">
                <div class="content">
                    <div class="contentText">
                        <h1><?= $weeklyRaports['full_name'] ?></h1>
                        <h3>Done Work:</h3>
                        <textarea readonly class="ckeditor" name="doneWork"
                            id="doneWork"><?php echo $weeklyRaports['doneWork'] ?></textarea>
                        <h3>Ongoing work:</h3>
                        <textarea readonly class="ckeditor" name="ongoingWork"
                            id="ongoingWork"><?php echo $weeklyRaports['ongoingWork'] ?></textarea>
                        <h3>Reflection:</h3>
                        <textarea readonly class="ckeditor" name="reflection"
                            id="reflection"><?php echo $weeklyRaports['reflection'] ?></textarea>
                        <h3>Occurred problems:</h3>
                        <textarea readonly class="ckeditor" name="occurredProblems"
                            id="occurredProblems"><?php echo $weeklyRaports['occurredProblems'] ?></textarea>
                        <div class="datopic">
                            <h3>Published:</h3>
                            <?php $date = date('dS M Y H:i:s', strtotime($weeklyRaports['date']));?>
                            <p><?= $date?> o'clock</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <h2 style="color: red;" id="noWeeklyMatches"></h2>
        </div>
        <?php }else{?>
            <h2 style="color: red;">There Are No Weekly Entries</h2>
        <?php } ?>

        <h1>Daily reports:</h1>
        <?php if(count($arrayDailyRaports)){?>
        <div class="flex-container" id="daily">
            <?php
                    foreach ($arrayDailyRaports as $dailyRaports) {?>
            <div class="container-child">
                <div class="content">
                    <div class="contentText">
                        <h1><?= $dailyRaports['full_name'] ?></h1>
                        <textarea readonly class="ckeditor" name="text"
                            id="text"><?php echo $dailyRaports['text'] ?></textarea>
                        <?php 
                        // Check if there are no selected topics
                        if(!empty($dailyRaports['selected_topics'])){?>
                        <div class="datopic">
                            <h3>Topics:</h3>
                            <p><?= $dailyRaports['selected_topics'] ?></p>
                        </div>
                        <?php } ?>
                        <div class="datopic">
                            <h3>Published:</h3>
                            <?php $date = date('dS M Y H:i:s', strtotime($dailyRaports['date']));?>
                            <p><?= $date?> o'clock</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <h2 style="color: red;" id="noDailyMatches"></h2>
        </div>
<?php }else {?>
    <h2 style="color: red;">There Are No Daily Entries</h2>
<?php }?>
    </main>

    <script>
    CKEDITOR.replace('doneWork');
    CKEDITOR.replace('ongoingWork');
    CKEDITOR.replace('reflection');
    CKEDITOR.replace('occurredProblems');
    CKEDITOR.replace('text');
    </script>

</body>

</html>