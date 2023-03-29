// Clientside Validierung - Add daily report
window.addEventListener("load", function() {
    this.document.querySelector("form").addEventListener('submit', function(evt) {
        var errors = false;
        var warnings = document.querySelectorAll(".warning");
        if (warnings != null) {
            warnings.forEach(element => {
                element.remove();
            });
        }
        if (document.querySelector('#calendar_week') != null) {
            if (document.querySelector('#calendar_week').value.trim() === '') {
                document.querySelector('#calendar_week').insertAdjacentHTML("afterend", "<label class=\"warning\" style='color:red;font-weight:bold;'> Please enter a date!</label>");
                errors = true;
            }
        }
        if (document.querySelector('#reflection') != null) {
            if (document.querySelector('#reflection').value.trim() === '') {
                document.querySelector('#reflection').insertAdjacentHTML("afterend", "<label class=\"warning\" style='color:red;font-weight:bold;'> Please enter a reflection!</label>");
                errors = true;
            }
        }
        if (errors) {
            evt.preventDefault();
        }
    });
});