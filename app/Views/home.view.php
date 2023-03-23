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
    </main>

    <script src="public/js/app.js"></script>
    <script src="ckeditor/ckeditor.js"></script>
    <script src="public/js/route.js"></script>

    <script>
    CKEDITOR.replace('recentlyReleased');
    </script>
</body>

</html>