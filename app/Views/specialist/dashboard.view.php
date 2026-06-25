<!DOCTYPE html>
<html lang="en">

<head>
    <?php $pageTitle = 'Journal - Dashboard'; include 'app/Views/general/head.php'; ?>
    <script src="public/js/route.js" defer></script>
    <script src="public/js/app.js" defer></script>
</head>

<body>
    <?php
    $actual_link = basename(__FILE__);

    // Notifications = released reports, newest first (so the header bell renders).
    $notifications = [];
    foreach ($dailyReleased as $r)  { $notifications[] = ['type' => 'daily',  'id' => $r['journalId'],      'name' => $r['full_name'], 'date' => $r['date']]; }
    foreach ($weeklyReleased as $r) { $notifications[] = ['type' => 'weekly', 'id' => $r['weeklyReportId'],  'name' => $r['full_name'], 'date' => $r['date']]; }
    usort($notifications, fn($a, $b) => strtotime($b['date']) - strtotime($a['date']));

    include __DIR__ . '/../general/navside.view.php';

    // ---- Summary metrics -------------------------------------------------
    $isoWeek = currentIsoWeek();
    $releasedThisWeek = 0;
    foreach ($dailyReleased as $r)  { if ((int) date('W', strtotime($r['date'])) === $isoWeek) $releasedThisWeek++; }
    foreach ($weeklyReleased as $r) { if ((int) date('W', strtotime($r['date'])) === $isoWeek) $releasedThisWeek++; }

    $now       = new DateTime('now');
    $pastDaily  = $now > dailyDeadline();
    $pastWeekly = $now > weeklyDeadline();
    $overdueCount = 0;
    foreach ($lastSubs as $s) {
        $dt = !empty($dailyTodayCounts[$s['userId']]);
        $wk = !empty($weeklyWeekCounts[$s['userId']]);
        if (($pastDaily && !$dt) || ($pastWeekly && !$wk)) $overdueCount++;
    }

    // ---- Recently released cards (merge + sort + slice 6) ----------------
    $recent = [];
    foreach ($dailyReleased as $r)  { $recent[] = ['type' => 'daily',  'row' => $r, 'date' => $r['date']]; }
    foreach ($weeklyReleased as $r) { $recent[] = ['type' => 'weekly', 'row' => $r, 'date' => $r['date']]; }
    usort($recent, fn($a, $b) => strtotime($b['date']) - strtotime($a['date']));
    $recent = array_slice($recent, 0, 6);

    // Report cards — same markup as overview.view.php so the Full Size modal works.
    function dashDailyCard($r) { ?>
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

    function dashWeeklyCard($r) { ?>
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

    // ---- Keyword usage data ---------------------------------------------
    $maxCnt = 0;
    foreach ($orgKeywords as $k) { if ((int) $k['cnt'] > $maxCnt) $maxCnt = (int) $k['cnt']; }
    $mostUsed   = array_slice($orgKeywords, 0, 5);
    $rarelyUsed = array_reverse(array_slice($orgKeywords, -5));
    ?>

    <main class="md:ml-60 px-4 sm:px-6 lg:px-8 py-8 max-w-6xl">

        <!-- A) Summary tiles -->
        <section class="grid sm:grid-cols-3 gap-4 mb-8">
            <div class="card p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-slate-400 text-sm">Apprentices</div>
                        <div class="text-3xl font-semibold mt-1"><?= count($learners) ?></div>
                    </div>
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-accent/15 text-indigo-200 border border-accent/30"><i class="fa-solid fa-users"></i></span>
                </div>
            </div>
            <div class="card p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-slate-400 text-sm">Released this week</div>
                        <div class="text-3xl font-semibold mt-1"><?= $releasedThisWeek ?></div>
                    </div>
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-success/15 text-success border border-success/30"><i class="fa-solid fa-circle-check"></i></span>
                </div>
            </div>
            <div class="card p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-slate-400 text-sm">Pending / overdue</div>
                        <div class="text-3xl font-semibold mt-1 <?= $overdueCount ? 'text-danger' : '' ?>"><?= $overdueCount ?></div>
                    </div>
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-danger/15 text-danger border border-danger/30"><i class="fa-solid fa-triangle-exclamation"></i></span>
                </div>
            </div>
        </section>

        <!-- B) Recently released -->
        <section class="mb-8">
            <h2 class="text-lg font-semibold mb-4">Recently released</h2>
            <?php if ($recent): ?>
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <?php foreach ($recent as $item): ?>
                    <?php $item['type'] === 'daily' ? dashDailyCard($item['row']) : dashWeeklyCard($item['row']); ?>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="card p-10 text-center"><h3 class="text-base font-semibold">No released reports yet</h3></div>
            <?php endif; ?>
        </section>

        <!-- C) Apprentice roster -->
        <section class="mb-8">
            <h2 class="text-lg font-semibold mb-4">Apprentice roster</h2>
            <div class="card p-2 sm:p-3">
                <?php if ($lastSubs): ?>
                <ul class="divide-y divide-border">
                    <?php foreach ($lastSubs as $s): ?>
                        <?php
                        $dt = !empty($dailyTodayCounts[$s['userId']]);
                        $wk = !empty($weeklyWeekCounts[$s['userId']]);
                        $overdue = ($pastDaily && !$dt) || ($pastWeekly && !$wk);
                        $initials = '';
                        foreach (preg_split('/\s+/', trim($s['full_name'])) as $part) {
                            if ($part !== '') $initials .= mb_strtoupper(mb_substr($part, 0, 1));
                        }
                        $initials = mb_substr($initials, 0, 2);
                        ?>
                        <li class="flex items-center gap-4 px-3 py-3 cursor-pointer hover:bg-white/5 rounded-lg"
                            onclick="location.href='overview#a=<?= rawurlencode($s['full_name']) ?>'">
                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-accent/20 text-indigo-200 font-semibold border border-accent/30"><?= e($initials) ?></span>
                            <div class="min-w-0 flex-1">
                                <div class="font-medium truncate"><?= e($s['full_name']) ?></div>
                                <div class="text-xs text-slate-500">Last submission: <?= $s['last_sub'] ? date('j M Y · H:i', strtotime($s['last_sub'])) : '—' ?></div>
                            </div>
                            <?php if ($overdue): ?>
                                <span class="chip bg-danger/15 border-danger/30 text-danger shrink-0"><i class="fa-solid fa-triangle-exclamation mr-1"></i>Overdue</span>
                            <?php else: ?>
                                <span class="chip bg-success/15 border-success/30 text-success shrink-0"><i class="fa-solid fa-check mr-1"></i>On track</span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <div class="p-8 text-center text-slate-500">No apprentices yet.</div>
                <?php endif; ?>
            </div>
        </section>

        <!-- D) Org-wide keyword usage -->
        <section>
            <h2 class="text-lg font-semibold mb-4">Org-wide keyword usage</h2>
            <div class="card p-5">
                <?php if ($orgKeywords): ?>
                <div class="grid md:grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <div class="text-sm font-semibold text-slate-400 mb-3">Most used</div>
                        <div class="space-y-3">
                            <?php foreach ($mostUsed as $k): $pct = $maxCnt > 0 ? round((int) $k['cnt'] / $maxCnt * 100) : 0; ?>
                            <div>
                                <div class="flex items-center justify-between text-sm mb-1">
                                    <span class="truncate text-slate-200"><?= e($k['topic']) ?></span>
                                    <span class="text-slate-500 ml-2 shrink-0"><?= (int) $k['cnt'] ?></span>
                                </div>
                                <div class="h-2 rounded bg-surface-2 overflow-hidden">
                                    <div class="h-2 rounded bg-accent" style="width: <?= $pct ?>%"></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-400 mb-3">Rarely used</div>
                        <div class="space-y-3">
                            <?php foreach ($rarelyUsed as $k): $pct = $maxCnt > 0 ? round((int) $k['cnt'] / $maxCnt * 100) : 0; ?>
                            <div>
                                <div class="flex items-center justify-between text-sm mb-1">
                                    <span class="truncate text-slate-200"><?= e($k['topic']) ?></span>
                                    <span class="text-slate-500 ml-2 shrink-0"><?= (int) $k['cnt'] ?></span>
                                </div>
                                <div class="h-2 rounded bg-surface-2 overflow-hidden">
                                    <div class="h-2 rounded bg-accent/60" style="width: <?= $pct ?>%"></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="p-8 text-center text-slate-500">No keyword usage data yet.</div>
                <?php endif; ?>
            </div>
        </section>

    </main>
</body>

</html>
