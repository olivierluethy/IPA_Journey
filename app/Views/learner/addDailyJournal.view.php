<!DOCTYPE html>
<html lang="en">

<head>
    <?php $pageTitle = 'Journal - Add daily report'; include 'app/Views/general/head.php'; ?>
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
        <header class="mb-6">
            <h1 class="text-2xl font-semibold text-slate-100">Add daily report</h1>
            <p class="text-sm text-slate-400 mt-1">Capture what you did today and tag the relevant keywords.</p>
        </header>

        <form action="addDailyJournal" method="POST" class="card p-6 space-y-6">
            <div>
                <label class="label">Write your report</label>
                <?= rteField('text', '', 'For example: My day was ...') ?>
            </div>

            <div>
                <h2 class="text-base font-semibold text-slate-100 mb-3">Topics</h2>
                <?php
                /* Check for available topics */
                if (count($arrayTopics) > 0) {
                    /* Display all of them */
                    echo "<div class='flex flex-wrap gap-2'>";
                    foreach ($arrayTopics as $topic) {
                        echo "<label class='inline-flex items-center gap-2 rounded-lg border border-border bg-surface-2 px-2.5 py-1 text-sm cursor-pointer'>";
                        echo "<input type='checkbox' name='topics[]' value='" . $topic['topicId'] . "' class='accent-accent'> ";
                        echo htmlspecialchars($topic['topic']);
                        echo "</label>";
                    }
                    echo "</div>";
                    echo "<div class='pt-2'><input type='submit' class='btn btn-primary' value='+ Add your daily report'></div>";
                } else { ?>
                    <div class="rounded-xl border border-border bg-surface-2 p-6 text-center">
                        <h1 class="text-lg font-semibold text-slate-100">No keywords</h1>
                        <h3 class="text-sm text-slate-400 mt-1">Please enter under the 'my keywords' section a keyword to proceed</h3>
                    </div>
                <?php } ?>
            </div>
        </form>
    </main>

</body>

</html>
