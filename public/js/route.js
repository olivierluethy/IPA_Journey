// Navigation + non-edit row actions.
// Editing is now done inline on the page (see app.js) — no edit sub-pages.
function navigateTo(page) {
    window.location = page;
}

/* For keywords */
function deleteKeyword(id) {
    if (confirm("Delete this keyword?")) location.href = "deleteKeyword?id=" + id;
}

/* For daily reports */
function deleteDailyReport(id) {
    if (confirm("Delete this daily report?")) location.href = "deleteDailyReport?id=" + id;
}
function releaseDailyReport(id) {
    location.href = "releaseDailyReport?id=" + id;
}

/* For weekly reports */
function deleteWeeklyReport(id) {
    if (confirm("Delete this weekly report?")) location.href = "deleteWeeklyRaport?id=" + id;
}
function releaseWeeklyReport(id) {
    location.href = "releaseWeeklyReport?id=" + id;
}

/* For users in overview */
function deleteUser(id) {
    if (confirm("Delete this user?")) location.href = "deleteUser?id=" + id;
}
