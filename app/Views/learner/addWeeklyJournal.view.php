<!DOCTYPE html>
<html lang="en">

<head>
    <?php $pageTitle = 'Journal - Add weekly report'; include 'app/Views/general/head.php'; ?>
    <script src="public/js/route.js" defer></script>
    <script src="public/js/app.js" defer></script>
    <script type="module" src="public/js/editor.js"></script>
</head>

<body>
    <?php
    // Set a variable to hold the basename of the current file
$actual_link = basename(__FILE__);
// Include the file "navside.view.php" from the "General" directory one level up
// using the constant DIRECTORY_SEPARATOR to ensure platform-independent file path
include(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "general" . DIRECTORY_SEPARATOR . "navside.view.php");
?>

    <main class="md:ml-60 px-4 sm:px-6 lg:px-8 py-8 max-w-2xl">
        <h1 class="text-2xl font-semibold mb-6">Add weekly report</h1>

        <form action="addWeeklyJournal" method="POST" class="card p-6 space-y-5">
            <div>
                <label class="label" for="calendar_week">Calendar week</label>
                <input type="number" name="calendar_week" id="calendar_week" min="1" max="52" class="input w-32">
            </div>

            <div>
                <label class="label">Completed tasks</label>
                <?= rteField('completed_tasks', '', 'For example: I have completed ...') ?>
            </div>

            <div>
                <label class="label">Still in work</label>
                <?= rteField('still_in_work', '', "For example: I'm still working on ...") ?>
            </div>

            <div>
                <label class="label">Reflection</label>
                <?= rteField('reflection', '', 'For example: It was ...') ?>
            </div>

            <div>
                <label class="label">Issues</label>
                <?= rteField('issues', '', 'For example: I had problems with ...') ?>
            </div>

            <button type="submit" class="btn btn-primary">+ Add Weekly Report</button>
        </form>
    </main>

</body>

</html>
