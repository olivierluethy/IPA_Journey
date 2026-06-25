<!DOCTYPE html>
<html lang="en">

<head>
    <?php $pageTitle = 'Journal - Daily reports'; include 'app/Views/general/head.php'; ?>
    <script src="public/js/route.js" defer></script>
    <script src="public/js/app.js" defer></script>
    <script type="module" src="public/js/editor.js"></script>
</head>

<body>
    <?php
    $actual_link = basename(__FILE__);
    include __DIR__ . '/../general/navside.view.php';

    $nProcess  = count($arrayJournalsInProcess);
    $nReleased = count($arrayJournalIsReleased);

    function dailyTopicBoxes($allTopics, $selectedString) {
        $selected = !empty($selectedString) ? array_map('trim', explode('|', $selectedString)) : [];
        foreach ($allTopics as $tp) {
            $checked = in_array($tp['topic'], $selected) ? 'checked' : '';
            echo '<label class="inline-flex items-center gap-2 rounded-lg border border-border bg-surface-2 px-2.5 py-1 text-sm cursor-pointer">'
               . '<input type="checkbox" name="topics[]" value="' . $tp['topicId'] . '" ' . $checked . ' class="accent-accent">'
               . e($tp['topic']) . '</label>';
        }
    }

    /* Renders one daily card. $editable adds the inline edit form + actions. */
    function dailyCard($r, $section, $editable, $allTopics) { ?>
        <article class="report-card card" data-search-item data-report-card data-type="daily"
                 data-id="<?= $r['journalId'] ?>" data-section="<?= $section ?>"
                 data-author="<?= e($r['full_name']) ?>" data-date="<?= date('Y-m-d', strtotime($r['date'])) ?>"
                 data-topics="<?= e(str_replace('|', ' ', $r['selected_topics'] ?? '')) ?>">
            <div data-card-inner class="flex flex-col">
                <div class="flex items-center justify-between gap-2 p-4 border-b border-border">
                    <h3 class="text-base font-semibold truncate"><?= e($r['full_name']) ?></h3>
                    <div class="flex items-center gap-1 shrink-0">
                        <?php if ($editable): ?>
                        <button class="btn-icon h-8 w-8" data-edit aria-label="Edit report" title="Edit"><i class="fa-solid fa-pen text-xs"></i></button>
                        <button class="btn-icon h-8 w-8 hover:text-success" onclick="releaseDailyReport(<?= $r['journalId'] ?>)" aria-label="Publish report" title="Publish"><i class="fa-solid fa-paper-plane text-xs"></i></button>
                        <button class="btn-icon h-8 w-8 hover:text-danger" onclick="deleteDailyReport(<?= $r['journalId'] ?>)" aria-label="Delete report" title="Delete"><i class="fa-solid fa-trash text-xs"></i></button>
                        <?php endif; ?>
                        <button class="btn-icon h-8 w-8" data-fullsize aria-label="Open report full size" title="Full size"><i class="fa-solid fa-up-right-and-down-left-from-center text-xs"></i></button>
                    </div>
                </div>

                <div data-display>
                    <div class="card-body scroll-area p-4 text-sm text-slate-300" data-card-body style="max-height:220px">
                        <div class="report-html prose prose-invert prose-sm max-w-none" data-field="text"><?= e($r['text']) ?></div>
                    </div>
                    <div class="p-4 pt-3 border-t border-border space-y-2.5">
                        <?php if (!empty($r['selected_topics'])): ?>
                        <div class="flex flex-wrap gap-1.5">
                            <?php foreach (array_filter(array_map('trim', explode('|', $r['selected_topics']))) as $tp): ?>
                                <span class="chip"><?= e($tp) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <div class="meta"><i class="fa-regular fa-clock"></i><?= date('j M Y · H:i', strtotime($r['date'])) ?></div>
                    </div>
                </div>

                <?php if ($editable): ?>
                <form data-edit-form action="editDailyReport?id=<?= $r['journalId'] ?>" method="POST" class="hidden p-4 space-y-3">
                    <div><label class="label">Text</label><?= rteField('text', $r['text']) ?></div>
                    <div><label class="label">Topics</label><div class="flex flex-wrap gap-2"><?php dailyTopicBoxes($allTopics, $r['selected_topics']); ?></div></div>
                    <div class="flex gap-2 pt-1">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" data-cancel class="btn btn-ghost">Cancel</button>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </article>
    <?php }
    ?>

    <main class="md:ml-60 px-4 sm:px-6 lg:px-8 py-8 max-w-6xl">
        <?php if (!$nProcess && !$nReleased): ?>
        <div class="card p-10 text-center">
            <h2 class="text-lg font-semibold mb-1">There are no daily reports</h2>
            <p class="text-slate-400 mb-5">Write your first daily report to get started.</p>
            <button onclick="navigateTo('addDailyJournal')" class="btn btn-primary mx-auto"><i class="fa-solid fa-plus"></i> Add daily report</button>
        </div>
        <?php else: ?>
        <div data-filter-root>
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div class="toggle" role="tablist" aria-label="Report section" data-tabgroup data-key="section">
                    <button class="toggle-btn" data-tab data-value="process">Still in process (<?= $nProcess ?>)</button>
                    <button class="toggle-btn" data-tab data-value="released">Recently completed (<?= $nReleased ?>)</button>
                </div>
                <div class="flex items-center gap-2">
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                        <input type="text" class="input pl-9 w-72" placeholder="Search reports…" data-search aria-label="Search reports">
                    </div>
                    <button onclick="navigateTo('addDailyJournal')" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add</button>
                </div>
            </div>

            <p data-closest class="text-sm text-amber-400 mb-3" style="display:none"><i class="fa-solid fa-wand-magic-sparkles mr-1"></i>No exact matches — showing closest matches</p>
            <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <?php foreach ($arrayJournalsInProcess as $r) dailyCard($r, 'process', true, $arrayTopics); ?>
                <?php foreach ($arrayJournalIsReleased as $r) dailyCard($r, 'released', false, $arrayTopics); ?>
            </section>
            <p data-empty class="text-slate-500 mt-4" style="display:none">No matching reports.</p>
        </div>
        <?php endif; ?>
    </main>
</body>

</html>
