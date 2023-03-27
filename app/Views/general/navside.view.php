<?php
$navigationFiller = "/";
$url = "$_SERVER[HTTP_HOST]"; // gives the URL
$havePort = preg_match('/[0-9]/', $url); // the localhost page has a specific port, so also a root folder

if (!$havePort) {
    $navigationFiller .= "IPA_Olivier/";
}
echo "<button id='burger' onclick='toggleSidebar()' title='Show sidenavigation'>&#9776;</button>";

echo "<nav id='sidebar'>
        <h2>Journal <br>
            Web-App</h2>
        <hr>";

if(isset($_SESSION['role'])){
    if ($_SESSION['role'] == 0 || $_SESSION['role'] == 1) {
        echo "<input type='text' placeholder='Search'>";
        
        $a = '<button title="Go To Home" onclick="navigateTo(\'home\')"';
        if (preg_match("/home/i", $actual_link)) {
            $a .= ' class="active"';
        }
        $a .= '>Home</button>';
        echo $a;
    }
    if($_SESSION['role'] == 0){
        $a = '<button title="Go To Daily Raports" onclick="navigateTo(\'dailyraport\')"';
        if (preg_match("/dailyraport/i", $actual_link)) {
            $a .= ' class="active"';
        }
        $a .= '>Daily reports</button>';
        echo $a;
    
        $a = '<button title="Go To Weekly Raports" onclick="navigateTo(\'weeklyraport\')"';
        if (preg_match("/weeklyraport/i", $actual_link)) {
            $a .= ' class="active"';
        }
        $a .= '>Weekly reports</button>';
        echo $a;
    
        $a = '<button title="Go To My Keywords" onclick="navigateTo(\'keywords\')"';
        if (preg_match("/keywords/i", $actual_link)) {
            $a .= ' class="active"';
        }
        $a .= '>My keywords</button>';
        echo $a;
    }
    if($_SESSION['role'] == 1){
        $a = '<button title="Go To Overview" onclick="navigateTo(\'overview\')"';
        if (preg_match("/overview/i", $actual_link)) {
            $a .= ' class="active"';
        }
        $a .= '>Overview</button>';
        echo $a;
    }
    if($_SESSION['loggedin'] == true){
        $a = '<button title="Go To Logout" onclick="navigateTo(\'logout\')"';
        $a .= '>Logout</button>';
        echo $a;
    }
}
?>
</nav>

<header>
    <div class="grid-container">
        <div>
            <?php
            // Define an array with key-value pairs where keys are links and values are titles
            $links = [
                'home' => '<h1>Home</h1>',
                'dailyraport' => '<h1>Daily reports</h1>',
                'editDailyReport' => '<h1>Edit reports</h1>',
                'weeklyraport' => '<h1>Weekly reports</h1>',
                'keywords' => '<h1>Keywords</h1>',
                'editKeyword' => '<h1>Edit Keyword</h1>',
                'deleteKeyword' => '<h1>Delete Keyword</h1>',
                'login' => '<h1>Login</h1>',
                'editUser' => '<h1>Edit User</h1>',
                'useroverview' => '<h1>User Overview</h1>',
                'overview' => '<h1>Overview</h1>',
                'releasedreports' => '<h1>Released Reports</h1>',
                'adddailyjournal' => '<h1>Add Daily Report</h1>',
                'addweeklyjournal' => '<h1>Add Weekly Report</h1>',
                'addkeyword' => '<h1>Add Keyword</h1>',
                'editWeeklyRaport' => '<h1>Edit Weekly Reports</h1>',
            ];
            
            // Initialize a variable to indicate if a link is found
            $found = false;
            
            // Loop through the links and check if any match the current URL
            foreach($links as $link => $title) {
                // Use regular expression to check if the link is found in the current URL (case-insensitive)
                if (preg_match("/$link/i", $actual_link)) {
                    // Print the title of the link
                    echo $title;
                    // Set the found variable to true
                    $found = true;
                    // Break out of the loop once a match is found
                    break;
                }
            }
        ?>
        </div>
        <div></div>
        <div>
            <?php
            if(isset($_SESSION['role'])){
                echo '<img src="' . $_SESSION['profileImageUrl'] . '" class="user-image" />';
                ?>
            <h2>Hey, <?= $_SESSION['full_name'] ?>!</h2>
            <?php } ?>
        </div>
    </div>
</header>