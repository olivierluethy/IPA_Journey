<!DOCTYPE html>
<html lang="en">

<head>
    <?php $pageTitle = 'Journal - Home'; include 'app/Views/general/head.php'; ?>
    <script src="public/js/route.js" defer></script>
    <script src="public/js/app.js" defer></script>
</head>

<body>
    <?php
    $actual_link = basename(__FILE__);
    include 'app/Views/general/navside.view.php';

    $isLearner = ($_SESSION['role'] == 0);
    $hasDaily  = count($arrayJournalsInRelease);
    $hasWeekly = count($arrayWeeklyIsInRelease);
    ?>

    <main class="md:ml-60 px-4 sm:px-6 lg:px-8 py-8 max-w-6xl">

        <?php if ($isLearner && isset($dailyDeadlineMs)): ?>
        <!-- Submission reminders -->
        <section class="card p-5 mb-8">
            <div class="flex items-center gap-2 mb-4">
                <i class="fa-regular fa-bell text-accent"></i>
                <h2 class="font-semibold">Submission reminders</h2>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="rounded-xl border border-border bg-surface-2 p-4">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-sm text-slate-400">Daily report</span>
                        <?php if ($dailySubmitted): ?><span class="chip"><i class="fa-solid fa-check mr-1"></i>Submitted</span><?php endif; ?>
                    </div>
                    <?php if ($dailySubmitted): ?>
                        <div class="mt-2 text-success font-semibold flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> Done for today</div>
                    <?php else: ?>
                        <div class="mt-2 text-2xl font-semibold text-slate-300" data-countdown data-deadline="<?= $dailyDeadlineMs ?>">…</div>
                        <div class="text-xs text-slate-500 mt-0.5">Due today by 18:00</div>
                    <?php endif; ?>
                </div>
                <div class="rounded-xl border border-border bg-surface-2 p-4">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-sm text-slate-400">Weekly report</span>
                        <?php if ($weeklySubmitted): ?><span class="chip"><i class="fa-solid fa-check mr-1"></i>Submitted</span><?php endif; ?>
                    </div>
                    <?php if ($weeklySubmitted): ?>
                        <div class="mt-2 text-success font-semibold flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> Done this week</div>
                    <?php else: ?>
                        <div class="mt-2 text-2xl font-semibold text-slate-300" data-countdown data-deadline="<?= $weeklyDeadlineMs ?>">…</div>
                        <div class="text-xs text-slate-500 mt-0.5">Due Friday by 18:00</div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <?php if ($isLearner): ?>
        <!-- Create CTAs -->
        <section class="grid sm:grid-cols-2 gap-4 mb-10">
            <button onclick="navigateTo('addDailyJournal')"
                    class="card p-5 flex items-center gap-4 text-left hover:border-accent/60 transition">
                <span class="grid h-11 w-11 place-items-center rounded-xl bg-accent/15 text-indigo-200 shrink-0">
                    <i class="fa-solid fa-pen-to-square"></i>
                </span>
                <span>
                    <span class="block font-semibold text-slate-100">Write a daily report</span>
                    <span class="block text-sm text-slate-400">Capture what you did today</span>
                </span>
            </button>
            <button onclick="navigateTo('addWeeklyJournal')"
                    class="card p-5 flex items-center gap-4 text-left hover:border-accent/60 transition">
                <span class="grid h-11 w-11 place-items-center rounded-xl bg-accent/15 text-indigo-200 shrink-0">
                    <i class="fa-solid fa-calendar-week"></i>
                </span>
                <span>
                    <span class="block font-semibold text-slate-100">Write a weekly report</span>
                    <span class="block text-sm text-slate-400">Summarise your week</span>
                </span>
            </button>
        </section>
        <?php endif; ?>

        <?php if ($hasDaily || $hasWeekly): ?>
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <h2 class="text-xl font-semibold"><?= $isLearner ? 'Recently written reports' : 'Recently published reports' ?></h2>
            <div class="toggle" role="tablist" aria-label="Report type">
                <button class="toggle-btn" data-toggle="daily">Daily (<?= $hasDaily ?: 0 ?>)</button>
                <button class="toggle-btn" data-toggle="weekly">Weekly (<?= $hasWeekly ?: 0 ?>)</button>
            </div>
        </div>

        <!-- Daily -->
        <section id="dailyreports" class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            <?php if ($hasDaily): foreach ($arrayJournalsInRelease as $r): ?>
            <article class="report-card card" data-report-card data-type="daily" data-id="<?= $r['journalId'] ?>">
                <div data-card-inner class="flex flex-col">
                    <div class="flex items-start justify-between gap-3 p-4 border-b border-border">
                        <h3 class="text-base font-semibold truncate"><?= e($r['full_name']) ?></h3>
                        <button class="btn-icon shrink-0" data-fullsize aria-label="Open report full size" title="Full size">
                            <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                        </button>
                    </div>
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
            </article>
            <?php endforeach; else: ?>
            <p id="noDailyMessage" class="text-slate-500">No daily reports yet.</p>
            <?php endif; ?>
        </section>

        <!-- Weekly -->
        <section id="weeklyreports" class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            <?php if ($hasWeekly): foreach ($arrayWeeklyIsInRelease as $r): ?>
            <article class="report-card card" data-report-card data-type="weekly" data-id="<?= $r['weeklyReportId'] ?>">
                <div data-card-inner class="flex flex-col">
                    <div class="flex items-start justify-between gap-3 p-4 border-b border-border">
                        <h3 class="text-base font-semibold truncate"><?= e($r['full_name']) ?> · CW <?= e($r['calendarWeek']) ?></h3>
                        <button class="btn-icon shrink-0" data-fullsize aria-label="Open report full size" title="Full size">
                            <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                        </button>
                    </div>
                    <div class="card-body scroll-area p-4 text-sm text-slate-300 space-y-3" data-card-body style="max-height:220px">
                        <div><div class="text-xs font-semibold text-slate-400 mb-1">Done work</div><div class="report-html prose prose-invert prose-sm max-w-none"><?= e($r['doneWork']) ?></div></div>
                        <div><div class="text-xs font-semibold text-slate-400 mb-1">Ongoing work</div><div class="report-html prose prose-invert prose-sm max-w-none"><?= e($r['ongoingWork']) ?></div></div>
                        <div><div class="text-xs font-semibold text-slate-400 mb-1">Reflection</div><div class="report-html prose prose-invert prose-sm max-w-none"><?= e($r['reflection']) ?></div></div>
                        <div><div class="text-xs font-semibold text-slate-400 mb-1">Occurred problems</div><div class="report-html prose prose-invert prose-sm max-w-none"><?= e($r['occurredProblems']) ?></div></div>
                    </div>
                    <div class="p-4 pt-3 border-t border-border">
                        <div class="meta"><i class="fa-regular fa-clock"></i><?= date('j M Y · H:i', strtotime($r['date'])) ?></div>
                    </div>
                </div>
            </article>
            <?php endforeach; else: ?>
            <p id="noWeeklyMessage" class="text-slate-500">No weekly reports yet.</p>
            <?php endif; ?>
        </section>

        <?php else: ?>
        <div class="card p-10 text-center">
            <h2 class="text-lg font-semibold mb-1">There are no entries</h2>
            <p class="text-slate-400">Head to the Daily or Weekly reports section, add an entry and it will show up here.</p>
        </div>
        <?php endif; ?>
    </main>
</body>

</html>
