<!DOCTYPE html>
<html lang="en">

<head>
    <?php $pageTitle = 'Journal - Overview'; include 'app/Views/general/head.php'; ?>
    <script src="public/js/route.js" defer></script>
    <script src="public/js/app.js" defer></script>
</head>

<body>
    <?php
    $actual_link = basename(__FILE__);

    // Apprentice list (only those with entries) for the dropdown.
    $authors = [];
    foreach ($arrayDailyRaports as $r)  { $authors[$r['full_name']] = true; }
    foreach ($arrayWeeklyRaports as $r) { $authors[$r['full_name']] = true; }
    $authors = array_keys($authors);
    sort($authors);

    // Notifications = released reports, newest first (Publish = released = status 1).
    $notifications = [];
    foreach ($arrayDailyRaports as $r)  { $notifications[] = ['type' => 'daily',  'id' => $r['journalId'],     'name' => $r['full_name'], 'date' => $r['date']]; }
    foreach ($arrayWeeklyRaports as $r) { $notifications[] = ['type' => 'weekly', 'id' => $r['weeklyReportId'], 'name' => $r['full_name'], 'date' => $r['date']]; }
    usort($notifications, fn($a, $b) => strtotime($b['date']) - strtotime($a['date']));

    include __DIR__ . '/../general/navside.view.php';

    $nDaily  = count($arrayDailyRaports);
    $nWeekly = count($arrayWeeklyRaports);

    function ovDailyCard($r) { ?>
        <article class="report-card card" data-search-item data-report-card data-type="daily"
                 data-id="<?= $r['journalId'] ?>" data-author="<?= e($r['full_name']) ?>" data-date="<?= date('Y-m-d', strtotime($r['date'])) ?>"
                 data-topics="<?= e(str_replace('|', ' ', $r['selected_topics'] ?? '')) ?>">
            <div data-card-inner class="flex flex-col">
                <div class="flex items-center justify-between gap-2 p-4 border-b border-border">
                    <button type="button" data-apprentice data-name="<?= e($r['full_name']) ?>" class="text-base font-semibold truncate text-left hover:text-accent transition" title="View profile"><?= e($r['full_name']) ?></button>
                    <button class="btn-icon h-8 w-8 shrink-0" data-fullsize aria-label="Open report full size" title="Full size"><i class="fa-solid fa-up-right-and-down-left-from-center text-xs"></i></button>
                </div>
                <div class="card-body scroll-area p-4 text-sm text-slate-300" data-card-body style="max-height:220px">
                    <div class="report-html prose prose-invert prose-sm max-w-none"><?= e($r['text']) ?></div>
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
        </article>
    <?php }

    function ovWeeklyCard($r) { ?>
        <article class="report-card card" data-search-item data-report-card data-type="weekly"
                 data-id="<?= $r['weeklyReportId'] ?>" data-author="<?= e($r['full_name']) ?>" data-date="<?= date('Y-m-d', strtotime($r['date'])) ?>">
            <div data-card-inner class="flex flex-col">
                <div class="flex items-center justify-between gap-2 p-4 border-b border-border">
                    <button type="button" data-apprentice data-name="<?= e($r['full_name']) ?>" class="text-base font-semibold truncate text-left hover:text-accent transition" title="View profile"><?= e($r['full_name']) ?></button>
                    <button class="btn-icon h-8 w-8 shrink-0" data-fullsize aria-label="Open report full size" title="Full size"><i class="fa-solid fa-up-right-and-down-left-from-center text-xs"></i></button>
                </div>
                <div class="card-body scroll-area p-4 text-sm text-slate-300 space-y-3" data-card-body style="max-height:240px">
                    <span class="chip">CW <?= e($r['calendarWeek']) ?></span>
                    <div><div class="text-xs font-semibold text-slate-400 mb-1">Done work</div><div class="report-html prose prose-invert prose-sm max-w-none"><?= e($r['doneWork']) ?></div></div>
                    <div><div class="text-xs font-semibold text-slate-400 mb-1">Ongoing work</div><div class="report-html prose prose-invert prose-sm max-w-none"><?= e($r['ongoingWork']) ?></div></div>
                    <div><div class="text-xs font-semibold text-slate-400 mb-1">Reflection</div><div class="report-html prose prose-invert prose-sm max-w-none"><?= e($r['reflection']) ?></div></div>
                    <div><div class="text-xs font-semibold text-slate-400 mb-1">Occurred problems</div><div class="report-html prose prose-invert prose-sm max-w-none"><?= e($r['occurredProblems']) ?></div></div>
                </div>
                <div class="p-4 pt-3 border-t border-border"><div class="meta"><i class="fa-regular fa-clock"></i><?= date('j M Y · H:i', strtotime($r['date'])) ?></div></div>
            </div>
        </article>
    <?php }
    ?>

    <main class="md:ml-60 px-4 sm:px-6 lg:px-8 py-8 max-w-6xl">
        <div data-filter-root>
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div class="toggle" role="tablist" aria-label="Report type" data-tabgroup data-key="type">
                    <button class="toggle-btn" data-tab data-value="daily">Daily (<?= $nDaily ?>)</button>
                    <button class="toggle-btn" data-tab data-value="weekly">Weekly (<?= $nWeekly ?>)</button>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <select data-filter-select class="input w-48" aria-label="Filter by apprentice">
                        <option value="all">All apprentices</option>
                        <?php foreach ($authors as $name): ?>
                            <option value="<?= e($name) ?>"><?= e($name) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                        <input type="text" class="input pl-9 w-72" placeholder="Search reports…" data-search aria-label="Search reports">
                    </div>
                </div>
            </div>

            <!-- Per-apprentice profile header (shown when one apprentice is selected) -->
            <div data-profile style="display:none" class="card p-5 mb-6">
                <div class="flex items-center gap-4">
                    <span data-profile-initials class="grid h-12 w-12 place-items-center rounded-full bg-accent/20 text-indigo-200 font-semibold border border-accent/30"></span>
                    <div class="flex-1 min-w-0">
                        <h2 data-profile-name class="text-lg font-semibold truncate"></h2>
                        <div class="text-sm text-slate-400"><span data-profile-daily>0</span> daily · <span data-profile-weekly>0</span> weekly reports</div>
                    </div>
                    <button type="button" data-profile-back class="btn btn-ghost shrink-0"><i class="fa-solid fa-arrow-left"></i> All apprentices</button>
                </div>
            </div>

            <p data-closest class="text-sm text-amber-400 mb-3" style="display:none"><i class="fa-solid fa-wand-magic-sparkles mr-1"></i>No exact matches — showing closest matches</p>
            <?php if ($nDaily || $nWeekly): ?>
            <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <?php foreach ($arrayDailyRaports as $r) ovDailyCard($r); ?>
                <?php foreach ($arrayWeeklyRaports as $r) ovWeeklyCard($r); ?>
            </section>
            <p data-empty class="text-slate-500 mt-4" style="display:none">No matching reports.</p>
            <?php else: ?>
            <div class="card p-10 text-center"><h2 class="text-lg font-semibold">There are no released reports yet</h2></div>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>
