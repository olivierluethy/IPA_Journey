/* Responsive Nav Bar */
let showOnOff = 0;

function toggleSidebar() {
showOnOff = showOnOff === 0 ? 1 : 0;

  if (showOnOff === 1) {
    document.getElementById("sidebar").style.left = "0px";
    document.getElementById("burger").title="Hide sidenavigation";
  } else {
    document.getElementById("sidebar").style.left = "-200px";
    document.getElementById("burger").title="Show sidenavigation";
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
const dailyButton = document.querySelector("main .withData .switch button:nth-child(1)");
const weeklyButton = document.querySelector("main .withData .switch button:nth-child(2)");
const dailyReports = document.getElementById("dailyreports");
const weeklyReports = document.getElementById("weeklyreports");

// Function to show the appropriate section based on the topic parameter
function showPart(topic) {
    if (topic === "daily") {
        // Style the daily button to appear selected
        dailyButton.style.zIndex = 100;
        dailyButton.style.backgroundColor = "black";
        dailyButton.style.color = "white";
        // Style the weekly button to appear unselected
        weeklyButton.style.zIndex = 99;
        weeklyButton.style.backgroundColor = "white";
        weeklyButton.style.color = "black";

        // Show the daily reports section and hide the weekly reports section
        dailyReports.style.display = "flex";
        weeklyReports.style.display = "none";
    } else if (topic === "weekly") {
        // Style the weekly button to appear selected
        dailyButton.style.zIndex = 99;
        dailyButton.style.backgroundColor = "white";
        dailyButton.style.color = "black";

        // Style the daily button to appear unselected
        weeklyButton.style.zIndex = 100;
        weeklyButton.style.backgroundColor = "black";
        weeklyButton.style.color = "white";

        // Show the weekly reports section and hide the daily reports section
        dailyReports.style.display = "none";
        weeklyReports.style.display = "flex";
    }
}
// Hide the weekly reports section by default
weeklyReports.style.display = "none";