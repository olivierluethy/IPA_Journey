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
    <title>Journal - Overview</title>
</head>

<body>

    <?php
$actual_link = basename(__FILE__);
include(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "General" . DIRECTORY_SEPARATOR . "navside.view.php");
?>

    <main>

        <input type="text" id="inputSearch" onkeyup="search()"
            placeholder="Search by user, content inside text, keyword or date">

        <h1>Weekly reports:</h1>
        <div class="flex-container" id="weekly">
            <?php
                    foreach ($arrayWeeklyRaports as $weeklyraports){?>
            <div class="container-child">
                <div class="content">
                    <div class="contentText">
                        <h1><?= $weeklyraports['full_name'] ?></h1>
                        <h3>Done Work:</h3>
                        <textarea readonly class="ckeditor" name="doneWork"
                            id="doneWork"><?php echo $weeklyraports['doneWork'] ?></textarea>
                        <h3>Ongoing work:</h3>
                        <textarea readonly class="ckeditor" name="ongoingWork"
                            id="ongoingWork"><?php echo $weeklyraports['ongoingWork'] ?></textarea>
                        <h3>Reflection:</h3>
                        <textarea readonly class="ckeditor" name="reflection"
                            id="reflection"><?php echo $weeklyraports['reflection'] ?></textarea>
                        <h3>Occurred problems:</h3>
                        <textarea readonly class="ckeditor" name="occurredProblems"
                            id="occurredProblems"><?php echo $weeklyraports['occurredProblems'] ?></textarea>
                        <div class="datopic">
                            <h3>Published:</h3>
                            <?php $date = date('dS M Y H:i:s', strtotime($weeklyraports['date']));?>
                            <p><?= $date?> o'clock</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <h1>Daily reports:</h1>
        <div class="flex-container" id="daily">
            <?php
                    foreach ($arrayDailyRaports as $dailyraports) {?>
            <div class="container-child">
                <div class="content">
                    <div class="contentText">
                        <h1><?= $dailyraports['full_name'] ?></h1>
                        <textarea readonly class="ckeditor" name="text"
                            id="text"><?php echo $dailyraports['text'] ?></textarea>
                        <?php if(!empty($dailyraports['selected_topics'])){?>
                        <div class="datopic">
                            <h3>Topics:</h3>
                            <p><?= $dailyraports['selected_topics'] ?></p>
                        </div>
                        <?php } ?>
                        <div class="datopic">
                            <h3>Published:</h3>
                            <?php $date = date('dS M Y H:i:s', strtotime($dailyraports['date']));?>
                            <p><?= $date?> o'clock</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

    </main>

    <script src="public/js/search.js"></script>
    <script src="public/js/app.js"></script>
    <script src="public/js/route.js"></script>
    <script src="ckeditor/ckeditor.js"></script>

    <script>
    CKEDITOR.replace('doneWork');
    CKEDITOR.replace('ongoingWork');
    CKEDITOR.replace('reflection');
    CKEDITOR.replace('occurredProblems');
    CKEDITOR.replace('text');
    </script>

</body>

</html>