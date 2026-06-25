<!DOCTYPE html>
<html lang="en">

<head>
    <?php $pageTitle = 'Journal - My Keywords'; include 'app/Views/general/head.php'; ?>
    <script src="public/js/route.js" defer></script>
    <script src="public/js/app.js" defer></script>
</head>

<body>
    <?php
    $actual_link = basename(__FILE__);
    include __DIR__ . '/../general/navside.view.php';
    ?>

    <main class="md:ml-60 px-4 sm:px-6 lg:px-8 py-8 max-w-4xl">
        <div class="flex items-center justify-between gap-4 mb-6">
            <h2 class="text-xl font-semibold">My keywords</h2>
            <button type="button" data-kw-add-toggle class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Add keyword
            </button>
        </div>

        <!-- Usage analytics -->
        <?php
            $usage    = isset($keywordUsage) && is_array($keywordUsage) ? $keywordUsage : [];
            $maxCount = 0;
            foreach ($usage as $u) { $maxCount = max($maxCount, (int)($u['daily_count'] ?? 0)); }
            $maxCount = max(1, $maxCount);
        ?>
        <section class="card p-5 mb-6">
            <div class="flex items-center justify-between gap-4 mb-1">
                <h3 class="text-base font-semibold">Usage analytics</h3>
                <span class="meta"><i class="fa-solid fa-chart-simple"></i> Daily reports</span>
            </div>
            <p class="text-xs text-slate-500 mb-4">Weekly reports don't carry keywords in this app, so weekly usage is always 0.</p>

            <?php if (count($usage) === 0): ?>
                <p class="text-slate-500 text-sm">No keyword usage yet — start linking keywords in your daily reports.</p>
            <?php else: ?>
                <?php
                    $top  = $usage[0];
                    $rare = $usage[count($usage) - 1];
                ?>
                <!-- Highlights row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                    <div class="rounded-xl border border-accent/30 bg-accent/10 px-4 py-3">
                        <div class="meta text-indigo-300 mb-1"><i class="fa-solid fa-arrow-trend-up"></i> Top keyword</div>
                        <div class="flex items-baseline justify-between gap-3">
                            <span class="text-sm font-medium text-slate-100 truncate"><?= e($top['topic']) ?></span>
                            <span class="text-sm font-semibold text-indigo-200"><?= (int)$top['daily_count'] ?> <span class="text-xs font-normal text-slate-400">daily</span></span>
                        </div>
                    </div>
                    <div class="rounded-xl border border-border bg-surface-2 px-4 py-3">
                        <div class="meta mb-1"><i class="fa-solid fa-arrow-trend-down"></i> Rarely used</div>
                        <div class="flex items-baseline justify-between gap-3">
                            <span class="text-sm font-medium text-slate-100 truncate"><?= e($rare['topic']) ?></span>
                            <span class="text-sm font-semibold text-slate-300"><?= (int)$rare['daily_count'] ?> <span class="text-xs font-normal text-slate-400">daily</span></span>
                        </div>
                    </div>
                </div>

                <!-- Per-keyword bars -->
                <div class="flex flex-col gap-3">
                    <?php foreach ($usage as $row): ?>
                        <?php
                            $daily = (int)($row['daily_count'] ?? 0);
                            $weekly = 0;
                            $pct = ($daily / $maxCount) * 100;
                        ?>
                        <div>
                            <div class="flex items-center justify-between gap-3 mb-1.5">
                                <span class="text-sm text-slate-200 truncate"><?= e($row['topic']) ?></span>
                                <span class="meta whitespace-nowrap">D <?= $daily ?> &middot; W <?= $weekly ?></span>
                            </div>
                            <div class="h-2 w-full rounded-full bg-surface-2 overflow-hidden" role="img"
                                 aria-label="<?= e($row['topic']) ?>: <?= $daily ?> daily, <?= $weekly ?> weekly">
                                <div class="h-full rounded-full bg-accent" style="width: <?= round($pct, 1) ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- Inline add row -->
        <div data-kw-add-row class="hidden mb-6">
            <form data-kw-add-form action="addKeyword" method="POST"
                  class="flex items-center gap-2 max-w-md">
                <input type="text" name="topic" class="input" placeholder="New keyword…" autocomplete="off">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" data-kw-add-toggle class="btn btn-ghost">Cancel</button>
            </form>
        </div>

        <!-- Keyword chips -->
        <div id="keywordList" class="flex flex-wrap gap-2.5">
            <?php foreach ($arrayKeywords as $keyword): ?>
            <div data-keyword data-id="<?= $keyword['topicId'] ?>"
                 class="rounded-xl border border-border bg-surface px-3 py-2">
                <div data-kw-view class="flex items-center gap-3">
                    <span data-kw-label class="text-sm font-medium text-slate-100"><?= e($keyword['topic']) ?></span>
                    <span class="flex items-center gap-1">
                        <button type="button" data-kw-edit-btn class="btn-icon h-7 w-7" aria-label="Edit keyword" title="Edit"><i class="fa-solid fa-pen text-xs"></i></button>
                        <button type="button" data-kw-delete class="btn-icon h-7 w-7 hover:text-danger" aria-label="Delete keyword" title="Delete"><i class="fa-solid fa-trash text-xs"></i></button>
                    </span>
                </div>
                <form data-kw-form action="editKeyword?id=<?= $keyword['topicId'] ?>" method="POST"
                      class="hidden flex items-center gap-2">
                    <input type="text" name="topic" class="input py-1 text-sm" value="<?= e($keyword['topic']) ?>" autocomplete="off">
                    <button type="submit" class="btn btn-primary px-2.5 py-1 text-xs">Save</button>
                    <button type="button" data-kw-cancel class="btn btn-ghost px-2.5 py-1 text-xs">Cancel</button>
                </form>
            </div>
            <?php endforeach; ?>

            <?php if (count($arrayKeywords) === 0): ?>
            <p id="keywordsEmpty" class="text-slate-500">No keywords yet — add your first one.</p>
            <?php endif; ?>
        </div>
    </main>

    <!-- Template for newly added chips (used by app.js) -->
    <template id="kwChipTemplate">
        <div data-keyword data-id=""
             class="rounded-xl border border-border bg-surface px-3 py-2">
            <div data-kw-view class="flex items-center gap-3">
                <span data-kw-label class="text-sm font-medium text-slate-100"></span>
                <span class="flex items-center gap-1">
                    <button type="button" data-kw-edit-btn class="btn-icon h-7 w-7" aria-label="Edit keyword" title="Edit"><i class="fa-solid fa-pen text-xs"></i></button>
                    <button type="button" data-kw-delete class="btn-icon h-7 w-7 hover:text-danger" aria-label="Delete keyword" title="Delete"><i class="fa-solid fa-trash text-xs"></i></button>
                </span>
            </div>
            <form data-kw-form action="editKeyword" method="POST" class="hidden flex items-center gap-2">
                <input type="text" name="topic" class="input py-1 text-sm" autocomplete="off">
                <button type="submit" class="btn btn-primary px-2.5 py-1 text-xs">Save</button>
                <button type="button" data-kw-cancel class="btn btn-ghost px-2.5 py-1 text-xs">Cancel</button>
            </form>
        </div>
    </template>
</body>

</html>
