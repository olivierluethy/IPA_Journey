<!DOCTYPE html>
<html lang="en">

<head>
    <?php $pageTitle = 'Journal - Weekly reports'; include 'app/Views/general/head.php'; ?>
    <script src="public/js/route.js" defer></script>
    <script src="public/js/app.js" defer></script>
    <script type="module" src="public/js/editor.js"></script>
</head>

<body>
    <?php
    $actual_link = basename(__FILE__);
    include __DIR__ . '/../general/navside.view.php';

    $nProcess  = count($arrayWeeklyInProcess);
    $nReleased = count($arrayWeeklyIsReleased);

    function weeklyBody($r) { ?>
        <div class="card-body scroll-area p-4 text-sm text-slate-300 space-y-3" data-card-body style="max-height:240px">
            <span class="chip">CW <span data-field="calendar_week"><?= e($r['calendarWeek']) ?></span></span>
            <div><div class="text-xs font-semibold text-slate-400 mb-1">Done work</div><div class="report-html prose prose-invert prose-sm max-w-none" data-field="completed_tasks"><?= e($r['doneWork']) ?></div></div>
            <div><div class="text-xs font-semibold text-slate-400 mb-1">Ongoing work</div><div class="report-html prose prose-invert prose-sm max-w-none" data-field="still_in_work"><?= e($r['ongoingWork']) ?></div></div>
            <div><div class="text-xs font-semibold text-slate-400 mb-1">Reflection</div><div class="report-html prose prose-invert prose-sm max-w-none" data-field="reflection"><?= e($r['reflection']) ?></div></div>
            <div><div class="text-xs font-semibold text-slate-400 mb-1">Occurred problems</div><div class="report-html prose prose-invert prose-sm max-w-none" data-field="issues"><?= e($r['occurredProblems']) ?></div></div>
        </div>
    <?php }

    function weeklyCard($r, $section, $editable) { ?>
        <article class="report-card card" data-search-item data-report-card data-type="weekly"
                 data-id="<?= $r['weeklyReportId'] ?>" data-section="<?= $section ?>"
                 data-author="<?= e($r['full_name']) ?>" data-date="<?= date('Y-m-d', strtotime($r['date'])) ?>">
            <div data-card-inner class="flex flex-col">
                <div class="flex items-center justify-between gap-2 p-4 border-b border-border">
                    <h3 class="text-base font-semibold truncate"><?= e($r['full_name']) ?></h3>
                    <div class="flex items-center gap-1 shrink-0">
                        <?php if ($editable): ?>
                        <button class="btn-icon h-8 w-8" data-edit aria-label="Edit report" title="Edit"><i class="fa-solid fa-pen text-xs"></i></button>
                        <button class="btn-icon h-8 w-8 hover:text-success" onclick="releaseWeeklyReport(<?= $r['weeklyReportId'] ?>)" aria-label="Publish report" title="Publish"><i class="fa-solid fa-paper-plane text-xs"></i></button>
                        <button class="btn-icon h-8 w-8 hover:text-danger" onclick="deleteWeeklyReport(<?= $r['weeklyReportId'] ?>)" aria-label="Delete report" title="Delete"><i class="fa-solid fa-trash text-xs"></i></button>
                        <?php endif; ?>
                        <button class="btn-icon h-8 w-8" data-fullsize aria-label="Open report full size" title="Full size"><i class="fa-solid fa-up-right-and-down-left-from-center text-xs"></i></button>
                    </div>
                </div>

                <div data-display>
                    <?php weeklyBody($r); ?>
                    <div class="p-4 pt-3 border-t border-border"><div class="meta"><i class="fa-regular fa-clock"></i><?= date('j M Y · H:i', strtotime($r['date'])) ?></div></div>
                </div>

                <?php if ($editable): ?>
                <form data-edit-form action="editWeeklyRaport?id=<?= $r['weeklyReportId'] ?>" method="POST" class="hidden p-4 space-y-3">
                    <div><label class="label">Calendar week</label><input type="number" name="calendar_week" min="1" max="52" value="<?= e($r['calendarWeek']) ?>" class="input w-32"></div>
                    <div><label class="label">Done work</label><?= rteField('completed_tasks', $r['doneWork']) ?></div>
                    <div><label class="label">Ongoing work</label><?= rteField('still_in_work', $r['ongoingWork']) ?></div>
                    <div><label class="label">Reflection</label><?= rteField('reflection', $r['reflection']) ?></div>
                    <div><label class="label">Occurred problems</label><?= rteField('issues', $r['occurredProblems']) ?></div>
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
            <h2 class="text-lg font-semibold mb-1">There are no weekly reports</h2>
            <p class="text-slate-400 mb-5">Write your first weekly report to get started.</p>
            <button onclick="navigateTo('addWeeklyJournal')" class="btn btn-primary mx-auto"><i class="fa-solid fa-plus"></i> Add weekly report</button>
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
                    <button onclick="navigateTo('addWeeklyJournal')" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add</button>
                </div>
            </div>

            <p data-closest class="text-sm text-amber-400 mb-3" style="display:none"><i class="fa-solid fa-wand-magic-sparkles mr-1"></i>No exact matches — showing closest matches</p>
            <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <?php foreach ($arrayWeeklyInProcess as $r) weeklyCard($r, 'process', true); ?>
                <?php foreach ($arrayWeeklyIsReleased as $r) weeklyCard($r, 'released', false); ?>
            </section>
            <p data-empty class="text-slate-500 mt-4" style="display:none">No matching reports.</p>
        </div>
        <?php endif; ?>
    </main>
</body>

</html>
