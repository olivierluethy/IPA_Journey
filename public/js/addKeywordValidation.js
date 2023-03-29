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
        if (document.querySelector('#topic') != null) {
            if (document.querySelector('#topic').value.trim() === '') {
                document.querySelector('#topic').insertAdjacentHTML("afterend", "<label class=\"warning\" style='color:red;font-weight:bold;'> Please enter a topic!</label>");
                errors = true;
            }
        }
        if (errors) {
            evt.preventDefault();
        }
    });
});