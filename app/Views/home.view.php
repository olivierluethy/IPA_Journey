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
        <?php if($_SESSION['role'] == 0){?>

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

        <?php
        echo "<div class='withData'>";
        if(count($arrayJournalsInRelease) > 0){
            echo "<h2>Recently written reports</h2>";
            foreach ($arrayJournalsInRelease as $journalInReleased){?>
        <div class='grid-container'>
            <div>
                <div><textarea readonly id="recentlyReleased" name="recentlyReleased" cols="30"
                        rows="10"><?= $journalInReleased['text'] ?></textarea></div>
            </div>
        </div>
        <?php } }
        echo "</div>";
            }

        // Check if user is a professional
if ($_SESSION['role'] == 1) {
    if(count($arrayJournalsInRelease) == 0 && count($arrayWeeklyIsInRelease) == 0){
        echo "<h1>No reports found</h1>";
    }else {
        // Check if there are any daily reports that have been released
        if (count($arrayJournalsInRelease) > 0) {
            echo "<h2>Daily reports</h2>";

            // Loop through the array of daily reports that have been released
            foreach ($arrayJournalsInRelease as $journalInReleased) {
                // Format the date to 'dS M Y' format
                $date = date('dS M Y', strtotime($journalInReleased['datum']));
                echo "<div class='grid-container'>
                        <div>Report from {$journalInReleased['full_name']} written on {$date} 
                        <button onclick='seeDaily({$journalInReleased['journalId']})' style='color: black;'>See</button>
                        </div>
                    </div>";
            }
        } else {
            echo "<h1>No daily reports</h1>";
        }

        // Check if there are any weekly reports that have been released
        if (count($arrayWeeklyIsInRelease) > 0) {
            echo "<h2>Weekly reports</h2>";

            // Loop through the array of weekly reports that have been released
            foreach ($arrayWeeklyIsInRelease as $weeklyInReleased) {
                // Format the date to 'dS M Y' format
                $date = date('dS M Y', strtotime($weeklyInReleased['datum']));
                echo "<div class='grid-container'>
                            <div>Report from {$weeklyInReleased['full_name']} written on {$date} 
                            <button onclick='seeWeekly({$weeklyInReleased['wochenreportId']})' style='color: black;'>See</button>
                            </div>
                        </div>";
            }
        } else {
            echo "<h1>No weekly reports</h1>";
        }
    }
}
?>
    </main>

    <script src="public/js/app.js"></script>
    <script src="ckeditor/ckeditor.js"></script>
    <script src="public/js/route.js"></script>

    <script>
    CKEDITOR.replace('recentlyReleased');
    </script>
</body>

</html>