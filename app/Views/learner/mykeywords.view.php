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
    <title>Journal - My Keywords</title>
</head>

<body>

    <?php
$actual_link = basename(__FILE__);
include(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "General" . DIRECTORY_SEPARATOR . "navside.view.php");
?>

    <main>
        <?php if(count($arrayKeywords) > 0){?>
        <div class="withData">
            <div class="title">
                <h1>My keywords</h1>
                <button title="Add a keyword" onclick='navigateTo("addKeyword")'>+</button>
            </div>

            <?php
            foreach ($arrayKeywords as $keyword) {?>
            <div class="flex-container">
                <div>
                    <div class="content">
                        <div class="contentText">
                            <h2><?= $keyword['topic'] ?></h2>
                            <button onclick="editKeyword(<?= $keyword['topicId'] ?>)">Edit</button>
                            <button onclick="deleteKeyword(<?= $keyword['topicId'] ?>)">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php } else {?>
        <div class="withData">
            <div class="title">
                <h1>There are no keywords</h1>
                <button title="Add a keyword" onclick='navigateTo("addKeyword")'>+</button>
            </div>
        </div>
        <?php } ?>
    </main>

    <script src="public/js/app.js"></script>
    <script src="public/js/route.js"></script>

</body>

</html>