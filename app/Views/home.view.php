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
    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Journal - Home</title>
</head>

<body>
    <?php
$actual_link = basename(__FILE__); // aktueller dateiname (wird für header.php benötigt)
include ("general/navside.view.php");
?>

    <main>
        <div class="menu">
            <div onclick="navigateTo('adddailyjournal')">
                <img src="images/writedailyreport.png" alt="">
                <p>Write the daily report</p>
            </div>
            <div onclick="navigateTo('addweeklyjournal')">
                <img src="images/writedailyreport.png" alt="">
                <p>Write the weekly report</p>
            </div>
        </div>

        <div class="withData">
            <h2>Recently written reports</h2>
            <div class="switch">
                <button title="Show daily sector" onclick="showPart('daily')">Daily</button>
                <button title="Show weekly sector" onclick="showPart('weekly')">Weekly</button>
            </div>
        </div>

        <div class="flex-container" id="dailyreports">
            <?php
            foreach($arrayJournalsInRelease as $dailyreports){?>
            <div>
                <div class="content">
                    <div class="contentText">
                        <h2><?= $dailyreports['full_name'] ?></h2>
                        <textarea readonly class="ckeditor" name="text"
                            id="text"><?php echo $dailyreports['text'] ?></textarea>
                        <div class="datopic">
                            <?php $date = date('dS M Y H:i:s', strtotime($dailyreports['date']));?>
                            <p><?= $date?> o'clock</p>&nbsp;
                            <p><?= $dailyreports['selected_topi&cs'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="flex-container" id="weeklyreports">
            <?php
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
                            <?php $date = date('dS M Y H:i:s', strtotime($weeklyreports['date']));?>
                            <p><?= $date?> o'clock</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </main>

    <script src="public/js/app.js"></script>
    <script src="ckeditor/ckeditor.js"></script>
    <script src="public/js/route.js"></script>

    <script>
    CKEDITOR.replace('recentlyReleased');
    CKEDITOR.replace('dailyreport');
    </script>
</body>

</html>