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
                <button title="Add a daily report">+</button>
            </div>

            <div class="flex-container">
                <div>
                    <div class="content">
                        <div class="contentText">
                            <h2>{Name}</h2>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint illum eveniet
                                reprehenderit eius rem sequi
                                voluptatem adipisci quaerat explicabo, voluptate odit perspiciatis cupiditate cumque eum
                                amet quidem omnis
                                quae distinctio.<br>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint illum eveniet
                                reprehenderit eius rem sequi
                                voluptatem adipisci quaerat explicabo, voluptate odit perspiciatis cupiditate cumque eum
                                amet quidem omnis
                                quae distinctio.<br>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint illum eveniet
                                reprehenderit eius rem sequi
                                voluptatem adipisci quaerat explicabo, voluptate odit perspiciatis cupiditate cumque eum
                                amet quidem omnis
                                quae distinctio.<br>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint illum eveniet
                                reprehenderit eius rem sequi
                                voluptatem adipisci quaerat explicabo, voluptate odit perspiciatis cupiditate cumque eum
                                amet quidem omnis
                                quae distinctio.<br>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint illum eveniet
                                reprehenderit eius rem sequi
                                voluptatem adipisci quaerat explicabo, voluptate odit perspiciatis cupiditate cumque eum
                                amet quidem omnis
                                quae distinctio.<br>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint illum eveniet
                                reprehenderit eius rem sequi
                                voluptatem adipisci quaerat explicabo, voluptate odit perspiciatis cupiditate cumque eum
                                amet quidem omnis
                                quae distinctio.<br>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint illum eveniet
                                reprehenderit eius rem sequi
                                voluptatem adipisci quaerat explicabo, voluptate odit perspiciatis cupiditate cumque eum
                                amet quidem omnis
                                quae distinctio.<br>
                            </p>
                            <div class="datopic">
                                <p>{Datum}</p>
                                <p>{Themen}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="public/js/app.js"></script>
    <script src="public/js/route.js"></script>

</body>

</html>