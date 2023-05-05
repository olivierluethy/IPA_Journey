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
    <script src="ckeditor/ckeditor.js" defer></script>
    <script src="public/js/search.js" defer></script>
    <title>Journal - Daily Raport</title>
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
        <?php 
        /* Check if there are any journals available */
        if(count($arrayJournalsInProcess) > 0 || count($arrayJournalIsReleased) > 0){ ?>
        <!-- Check if there are journals currently in process -->
        <?php if(count($arrayJournalsInProcess) > 0){ ?>
        <h1>Still in process</h1>
        <div class="flex-container">
            <?php
                    foreach ($arrayJournalsInProcess as $journalIsProcess) {?>
            <div>
                <div class="content">
                    <div class="contentText">
                        <h2><?= $journalIsProcess['full_name'] ?></h2>
                        <button onclick="editDailyReport(<?= $journalIsProcess['journalId'] ?>)"
                            title="Edit this daily report">Edit</button>
                        <button onclick="deleteDailyReport(<?= $journalIsProcess['journalId'] ?>)"
                            title="Delete this daily report">Delete</button>
                        <button onclick="releaseDailyReport(<?= $journalIsProcess['journalId'] ?>)"
                            title="Publish this daily report">Publish</button><br><br>
                        <textarea readonly class="ckeditor" name="text"
                            id="text"><?php echo $journalIsProcess['text'] ?></textarea>
                        <!-- Check if there are any topics -->
                        <?php if(!empty($journalIsProcess['selected_topics'])){?>
                        <div class="datopic">
                            <h3>Topics:</h3>
                            <p><?= $journalIsProcess['selected_topics'] ?></p>
                        </div>
                        <?php } ?>
                        <div class="datopic">
                            <h3>Published:</h3>
                            <?php $date = date('dS M Y H:i:s', strtotime($journalIsProcess['date']));?>
                            <p><?= $date?> o'clock</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
        <!-- Check if there are any released journals -->
        <?php if(count($arrayJournalIsReleased) > 0){ ?>
        <div class="withData">
            <div class="title">
                <h1>Recently completed</h1>
                <button title="Add a daily report" onclick='navigateTo("addDailyJournal")'>+</button>
                <input type="text" id="inputSearch" onkeyup="sortByDaily()"
                    placeholder="Search by content inside text, keyword or date">
            </div>

            <div class="flex-container" id="daily">
                <?php
                    foreach ($arrayJournalIsReleased as $journalIsReleased) {?>
                <div class="container-child">
                    <div class="content">
                        <div class="contentText">
                            <h2><?= $journalIsReleased['full_name'] ?></h2>
                            <textarea readonly class="ckeditor" name="text"
                                id="text"><?php echo $journalIsReleased['text'] ?></textarea>
                            <?php if(!empty($journalIsReleased['selected_topics'])){?>
                            <div class="datopic">
                                <h3>Topics:</h3>
                                <p><?= $journalIsReleased['selected_topics'] ?></p>
                            </div>
                            <?php } ?>
                            <div class="datopic">
                                <h3>Published:</h3>
                                <?php $date = date('dS M Y H:i:s', strtotime($journalIsReleased['date']));?>
                                <p><?= $date?> o'clock</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
        <?php } else { ?>
        <div class="withData">
            <div class="title">
                <h1>There are no daily reports</h1>
                <button title="Add a daily report"
                    onclick='navigateTo("addDailyJournal")'>+</button>&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </div>
        <?php } ?>

    </main>

    <script>
    CKEDITOR.replace('text');
    </script>
</body>

</html>