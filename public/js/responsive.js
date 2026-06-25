/* Responsive Nav Bar */
let showOnOff = 0;

function toggleSidebar() {
    showOnOff = showOnOff === 0 ? 1 : 0;

    if (showOnOff === 1) {
        document.getElementById("sidebar").style.left = "0px";
        document.getElementById("burger").title = "Hide sidenavigation";
    } else {
        document.getElementById("sidebar").style.left = "-200px";
        document.getElementById("burger").title = "Show sidenavigation";
    }
}

window.addEventListener("resize", reportWindowSize);

function reportWindowSize() {
    if (window.innerWidth > 768) {
        /* Display sidebar */
        if (document.getElementById("sidebar").style.left === "-200px") {
            document.getElementById("sidebar").style.left = "0px";
            document.querySelector("#sidebar ul").style.display = "block";
        }
    } else {
        /* Don't display sidebar */
        if (document.getElementById("sidebar").style.left === "0px") {
            document.getElementById("sidebar").style.left = "-200px";
            document.querySelector("#sidebar ul").style.display = "none";
            showOnOff = 0;
        }
    }
}

// When the user clicks an daily or weekly on the switch, parts will be shown or hidden
// Get the HTML elements we will be manipulating
const dailyButton = document.querySelector(".switch button:nth-child(1)");
const weeklyButton = document.querySelector(".switch button:nth-child(2)");
const dailyReports = document.getElementById("dailyreports");
const weeklyReports = document.getElementById("weeklyreports");

// Function to show the appropriate section based on the topic parameter.
// Every element is looked up defensively: depending on whether reports exist,
// either the report container OR its "no entries" message is in the DOM, not both.
function showPart(topic) {
    // The empty-state messages only exist when there are no reports of that kind.
    const noDailyMessage = document.getElementById("noDailyMessage");
    const noWeeklyMessage = document.getElementById("noWeeklyMessage");

    const dailySelected = topic === "daily";

    // Style the toggle buttons to reflect the selection.
    if (dailyButton && weeklyButton) {
        dailyButton.style.zIndex = dailySelected ? 100 : 99;
        dailyButton.style.backgroundColor = dailySelected ? "black" : "white";
        dailyButton.style.color = dailySelected ? "white" : "black";

        weeklyButton.style.zIndex = dailySelected ? 99 : 100;
        weeklyButton.style.backgroundColor = dailySelected ? "white" : "black";
        weeklyButton.style.color = dailySelected ? "black" : "white";
    }

    // Show the selected section (or its empty-state message) and hide the other.
    if (dailyReports) dailyReports.style.display = dailySelected ? "flex" : "none";
    if (noDailyMessage) noDailyMessage.style.display = dailySelected ? "block" : "none";
    if (weeklyReports) weeklyReports.style.display = dailySelected ? "none" : "flex";
    if (noWeeklyMessage) noWeeklyMessage.style.display = dailySelected ? "none" : "block";
}

// Add click event listeners to the daily and weekly buttons and set the
// initial state to the "daily" view (only on pages that have the switch).
if (dailyButton && weeklyButton) {
    dailyButton.addEventListener("click", function() {
        showPart("daily");
    });
    weeklyButton.addEventListener("click", function() {
        showPart("weekly");
    });
    showPart("daily");
}