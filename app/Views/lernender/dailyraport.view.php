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
    <title>Journal - Daily Raport</title>
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
                <button title="Add a daily report" onclick='navigateTo("adddailyjournal")'>+</button>
            </div>

            <?php
            foreach ($arrayJournalIsReleased as $journalIsReleased) {?>
            <div class="flex-container">
                <div>
                    <div class="content">
                        <div class="contentText">
                            <h2><?= $journalIsReleased['full_name'] ?></h2>
                            <textarea readonly class="ckeditor" name="text"
                                id="text"><?php echo $journalIsReleased['text'] ?></textarea>
                            <div class="datopic">
                                <?php 
                                    $pickedKeywordsIds = array_column($getPickedKeywords, 'topicId');
                                    foreach ($getKeywords as $keyword) {
                                        $checked = in_array($keyword['topicId'], $pickedKeywordsIds);
                                        echo "<p>" . ($checked ? $keyword['topic'] : "") . "</p>";
                                    }
                                    ?>
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
    CKEDITOR.replace('text');
    </script>
</body>

</html>