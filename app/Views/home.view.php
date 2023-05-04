<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/home.css">
    <link rel="stylesheet" href="public/css/navside.css">
    <link rel="stylesheet" href="public/css/dailyweeklyreport.css">
    <link rel="stylesheet" href="public/fontawesome/css/all.css">

    <script src="public/js/responsive.js" defer></script>
    <script src="ckeditor/ckeditor.js" defer></script>
    <script src="public/js/route.js" defer></script>
    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Journal - Home</title>
</head>

<body>
    <?php
    // Set a variable to hold the basename of the current file
$actual_link = basename(__FILE__);
// Include the file "navside.view.php" from the "General" directory one level up
include ("general/navside.view.php");
?>
    <main>

        <?php 
        // Check if the user's role is equal to 0
        if ($_SESSION['role'] == 0) {?>
        <div class="menu">
            <div onclick="navigateTo('addDailyJournal')">
                <img src="images/writedailyreport.png" alt="">
                <p>Write a daily report</p>
            </div>
            <div onclick="navigateTo('addWeeklyJournal')">
                <img src="images/writedailyreport.png" alt="">
                <p>Write a weekly report</p>
            </div>
        </div>
        <?php } ?>

        <?php
if(count($arrayJournalsInRelease) || count($arrayWeeklyIsInRelease)){?>
    <div class="withData">
        <?php 
            // Check if the user's role is equal to 0
            if ($_SESSION['role'] == 0) {?>
                <h2>Recently written reports</h2>
        <?php } else 
                // Check if the user's role is equal to 1
                if ($_SESSION['role'] == 1){?>
                <h2>Recently published reports</h2>
        <?php } ?>
        <?php
        // Check if the user's role is not equal to 2
        if ($_SESSION['role'] != 2){?>
            <div class="switch">
                <button title="Show daily sector" onclick="showPart('daily')">Daily <?= (count($arrayJournalsInRelease) ? '(' . count($arrayJournalsInRelease) . ')' : "(empty)") ?></button>
                <button title="Show weekly sector" onclick="showPart('weekly')">Weekly <?= (count($arrayWeeklyIsInRelease) ? '(' . count($arrayWeeklyIsInRelease) . ')' : "(empty)") ?></button>
            </div>
        <?php } ?>
    </div>
<?php } ?>

    <?php
        if(count($arrayJournalsInRelease) || count($arrayWeeklyIsInRelease)){
            if(count($arrayJournalsInRelease)){
            ?>

        <div class="flex-container" id="dailyreports">
            <?php
            // Go through the entire array
            foreach($arrayJournalsInRelease as $dailyreports){?>
            <div>
                <div class="content">
                    <div class="contentText">
                        <h2><?= $dailyreports['full_name'] ?></h2>
                        <textarea readonly class="ckeditor" name="text"
                            id="text"><?php echo $dailyreports['text'] ?></textarea>
                        <?php 
                        // Check if there is no selected topics
                        if(!empty($dailyreports['selected_topics'])){?>
                        <div class="datopic">
                            <h3>Topics:</h3>
                            <p><?= $dailyreports['selected_topics'] ?></p>
                        </div>
                        <?php } ?>
                        <div class="datopic">
                            <h3>Published:</h3>
                            <?php $date = date('dS M Y H:i:s', strtotime($dailyreports['date']));?>
                            <p><?= $date?> o'clock</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
   <?php }else { ?>
    <div id="noDailyMessage">
        <h2 style="text-align: center;">There are no Daily Journals</h2>
        <p>Please got to the "Daily reports" section, add an entry and then you'll see it here!</p>
    </div>
    <?php }
        if(count($arrayWeeklyIsInRelease)) {
            ?>
   
        <div class="flex-container" id="weeklyreports">
            <?php
            // Go through the entire array
            foreach($arrayWeeklyIsInRelease as $weeklyreports){?>
            <div>
                <div class="content">
                    <div class="contentText">
                        <h1><?= $weeklyreports['full_name'] ?></h1>
                        <h3>Done Work:</h3>
                        <textarea readonly class="ckeditor" name="doneWork"
                            id="doneWork"><?php echo $weeklyreports['doneWork'] ?></textarea>
                        <h3>Ongoing work:</h3>
                        <textarea readonly class="ckeditor" name="ongoingWork"
                            id="ongoingWork"><?php echo $weeklyreports['ongoingWork'] ?></textarea>
                        <h3>Reflection:</h3>
                        <textarea readonly class="ckeditor" name="reflection"
                            id="reflection"><?php echo $weeklyreports['reflection'] ?></textarea>
                        <h3>Occurred problems:</h3>
                        <textarea readonly class="ckeditor" name="occurredProblems"
                            id="occurredProblems"><?php echo $weeklyreports['occurredProblems'] ?></textarea>
                        <div class="datopic">
                            <h3>Published:</h3>
                            <?php $date = date('dS M Y H:i:s', strtotime($weeklyreports['date']));?>
                            <p><?= $date?> o'clock</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php } } else {?>
            <div id="noWeeklyMessage">
                <h2 style="text-align: center;">There are no Weekly Reports</h2>
                <p>Please got to the "Weekly reports" section, add an entry and then you'll see it here!</p>
            </div>
<?php } ?>

<?php 
        } else {?>
            <h2>There are no entries</h2>
            <p>Please got to the "Daily reports" or "Weekly reports" section, add an entry and then you'll see it here!</p>
        <?php } ?>
    </main>

    <script>
    CKEDITOR.replace('recentlyReleased');
    CKEDITOR.replace('dailyreport');
    </script>
</body>

</html>