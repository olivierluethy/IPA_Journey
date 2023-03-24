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
    <title>Journal - Weekly Raport</title>
</head>

<body>

    <?php
$actual_link = basename(__FILE__); // aktueller dateiname (wird für header.php benötigt)
include(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "General" . DIRECTORY_SEPARATOR . "navside.view.php");
?>

    <main>
        <?php if(count($arrayWeeklyInProcess) > 0 || count($arrayWeeklyIsReleased) > 0){?>
        <?php if(count($arrayWeeklyInProcess) > 0){?>
        <h1>Still in process</h1>

        <div class="flex-container">
            <?php
                        foreach ($arrayWeeklyInProcess as $weeklyIsProcess){?>
            <div>
                <div class="content">
                    <div class="contentText">
                        <h1><?= $weeklyIsProcess['full_name'] ?></h1>
                        <button onclick="editWeeklyReport(<?= $weeklyIsProcess['weeklyReportId'] ?>)">Edit</button>
                        <button onclick="deleteWeeklyReport(<?= $weeklyIsProcess['weeklyReportId'] ?>)">Delete</button>
                        <button onclick="releaseWeeklyReport(<?= $weeklyIsProcess['weeklyReportId'] ?>)">Publish</button>
                        <h3>Done Work:</h3>
                        <textarea readonly class="ckeditor" name="doneWork"
                            id="doneWork"><?php echo $weeklyIsProcess['doneWork'] ?></textarea>
                        <h3>Ongoing work:</h3>
                        <textarea readonly class="ckeditor" name="ongoingWork"
                            id="ongoingWork"><?php echo $weeklyIsProcess['ongoingWork'] ?></textarea>
                        <h3>Reflection:</h3>
                        <textarea readonly class="ckeditor" name="reflection"
                            id="reflection"><?php echo $weeklyIsProcess['reflection'] ?></textarea>
                        <h3>Occurred problems:</h3>
                        <textarea readonly class="ckeditor" name="occurredProblems"
                            id="occurredProblems"><?php echo $weeklyIsProcess['occurredProblems'] ?></textarea>
                        <div class="datopic">
                            <h3>Published:</h3>
                            <?php $date = date('dS M Y H:i:s', strtotime($weeklyIsProcess['date']));?>
                            <p><?= $date?> o'clock</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php } ?>

        <?php if(count($arrayWeeklyIsReleased) > 0){?>
        <div class="withData">
            <div class="title">
                <h1>Recently completed</h1>
                <button title="Add a weekly report" onclick='navigateTo("addweeklyjournal")'>+</button>
            </div>
            <div class="flex-container">
                <?php
                    foreach ($arrayWeeklyIsReleased as $weeklyIsReleased){?>
                <div>
                    <div class="content">
                        <div class="contentText">
                            <h1><?= $weeklyIsReleased['full_name'] ?></h1>
                            <h3>Done Work:</h3>
                            <textarea readonly class="ckeditor" name="doneWork"
                                id="doneWork"><?php echo $weeklyIsReleased['doneWork'] ?></textarea>
                            <h3>Ongoing work:</h3>
                            <textarea readonly class="ckeditor" name="ongoingWork"
                                id="ongoingWork"><?php echo $weeklyIsReleased['ongoingWork'] ?></textarea>
                            <h3>Reflection:</h3>
                            <textarea readonly class="ckeditor" name="reflection"
                                id="reflection"><?php echo $weeklyIsReleased['reflection'] ?></textarea>
                            <h3>Occurred problems:</h3>
                            <textarea readonly class="ckeditor" name="occurredProblems"
                                id="occurredProblems"><?php echo $weeklyIsReleased['occurredProblems'] ?></textarea>
                            <div class="datopic">
                                <h3>Published:</h3>
                                <?php $date = date('dS M Y H:i:s', strtotime($weeklyIsReleased['date']));?>
                                <p><?= $date?> o'clock</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php }
    } else {?>
        <h1>There are no weekly reports</h1>
        <?php } ?>
    </main>

    <script src="public/js/app.js"></script>
    <script src="public/js/route.js"></script>
    <script src="ckeditor/ckeditor.js"></script>

    <script>
    CKEDITOR.replace('doneWork');
    CKEDITOR.replace('ongoingWork');
    CKEDITOR.replace('reflection');
    CKEDITOR.replace('occurredProblems');
    </script>

</body>

</html>