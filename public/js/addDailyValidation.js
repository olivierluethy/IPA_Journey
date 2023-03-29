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
        if (document.querySelector('#text') != null) {
            if (document.querySelector('#text').value.trim() === '') {
                document.querySelector('#text').insertAdjacentHTML("afterend", "<label class=\"warning\" style='color:red;font-weight:bold;'> Please enter a text!</label>");
                errors = true;
            }
        }
        if (errors) {
            evt.preventDefault();
        }
    });
});