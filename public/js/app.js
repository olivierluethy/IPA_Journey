/* Responsive Nav Bar */
let showOnOff = 0;

function toggleSidebar() {
showOnOff = showOnOff === 0 ? 1 : 0;

  if (showOnOff === 1) {
    document.getElementById("sidebar").style.left = "0px";
    document.querySelector("#sidebar ul").style.display = "block";
  } else {
    document.getElementById("sidebar").style.left = "-200px";
    document.querySelector("#sidebar ul").style.display = "none";
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

/* Copy link to clipboard */
function copyLink() {
  link = "http://localhost/PA_Journal_Webapplikation/"

   // Copy the text inside the text field
  navigator.clipboard.writeText(link);

  // Alert the copied text
  alert("Copied the text: " + link);
}

function showPart(topic){
  if(topic == "daily"){
    document.querySelector("main .withData .switch button:nth-child(1)").style.zIndex = 100;
    document.querySelector("main .withData .switch button:nth-child(1)").style.backgroundColor ="black";
    document.querySelector("main .withData .switch button:nth-child(1)").style.color ="white";

    document.querySelector("main .withData .switch button:nth-child(2)").style.zIndex = 99;
    document.querySelector("main .withData .switch button:nth-child(2)").style.backgroundColor ="white";
    document.querySelector("main .withData .switch button:nth-child(2)").style.color ="black";

    document.getElementById("dailyreports").style.display="block";
    document.getElementById("weeklyreports").style.display="none";
  }else if(topic == "weekly"){
    document.querySelector("main .withData .switch button:nth-child(1)").style.zIndex = 99;
    document.querySelector("main .withData .switch button:nth-child(1)").style.backgroundColor ="white";
    document.querySelector("main .withData .switch button:nth-child(1)").style.color ="black";

    document.querySelector("main .withData .switch button:nth-child(2)").style.zIndex = 100;
    document.querySelector("main .withData .switch button:nth-child(2)").style.backgroundColor ="black";
    document.querySelector("main .withData .switch button:nth-child(2)").style.color ="white";

    document.getElementById("dailyreports").style.display="none";
    document.getElementById("weeklyreports").style.display="block";
  }
}

document.getElementById("weeklyreports").style.display="none";