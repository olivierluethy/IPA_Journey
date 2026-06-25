<!DOCTYPE html>
<html lang="en">

<head>
    <?php $pageTitle = 'Journal - Add keyword'; include 'app/Views/general/head.php'; ?>
    <script src="public/js/route.js" defer></script>
    <script src="public/js/app.js" defer></script>
</head>

<body>
    <?php
    // Set a variable to hold the basename of the current file
$actual_link = basename(__FILE__);
// Include the file "navside.view.php" from the "General" directory one level up
// using the constant DIRECTORY_SEPARATOR to ensure platform-independent file path
include(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "general" . DIRECTORY_SEPARATOR . "navside.view.php");
?>

    <main class="md:ml-60 px-4 sm:px-6 lg:px-8 py-8 max-w-md">
        <h2 class="text-xl font-semibold mb-6">Add keyword</h2>

        <form action="addKeyword" method="POST" class="card p-6">
            <label for="topic" class="label">Topic</label>
            <input type="text" id="topic" name="topic" class="input" placeholder="New keyword…" autocomplete="off">

            <div class="flex items-center gap-2 mt-6">
                <button type="submit" class="btn btn-primary">Add keyword</button>
                <button type="button" onclick="navigateTo('keywords')" class="btn btn-ghost">Back to keywords</button>
            </div>
        </form>
    </main>

</body>

</html>
