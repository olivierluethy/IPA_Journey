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
        <div class="withData">
            <div class="title">
                <h1>Recently completed</h1>
                <button title="Add a weekly report" onclick='navigateTo("addweeklyjournal")'>+</button>
            </div>
            <?php
           foreach ($arrayWeeklyIsReleased as $weeklyIsReleased){?>
            <div class="flex-container">
                <div>
                    <div class="content">
                        <div class="contentText">
                            <h2><?= $weeklyIsReleased['full_name'] ?></h2>
                            <p>Done Work:</p>
                            <textarea readonly class="ckeditor" name="doneWork"
                                id="doneWork"><?php echo $weeklyIsReleased['doneWork'] ?></textarea>
                            <p>Ongoing work:</p>
                            <textarea readonly class="ckeditor" name="ongoingWork"
                                id="ongoingWork"><?php echo $weeklyIsReleased['ongoingWork'] ?></textarea>
                                <p>Reflection:</p>
                            <textarea readonly class="ckeditor" name="reflection"
                                id="reflection"><?php echo $weeklyIsReleased['reflection'] ?></textarea>
                                <p>Occurred problems:</p>
                            <textarea readonly class="ckeditor" name="occurredProblems"
                                id="occurredProblems"><?php echo $weeklyIsReleased['occurredProblems'] ?></textarea>
                            <div class="datopic">
                                <p><?= $weeklyIsReleased['date'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
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