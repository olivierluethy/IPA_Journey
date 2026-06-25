<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <?php $pageTitle = 'Journal - Developer Login'; include 'app/Views/general/head.php'; ?>
</head>

<body class="min-h-screen grid place-items-center px-4 py-10">
    <div class="card w-full max-w-xl p-8">
        <h1 class="text-2xl">Developer Login</h1>
        <p class="text-sm text-slate-400 mt-1 mb-6">Local testing only — pick a mock user to log in instantly (no Google needed).</p>

        <?php
        $roleNames = [0 => 'Learners', 1 => 'Specialists', 2 => 'Administrators'];
        $grouped = [0 => [], 1 => [], 2 => []];
        foreach ($users as $u) {
            $grouped[(int) $u['role']][] = $u;
        }
        foreach ($roleNames as $roleId => $label):
            if (empty($grouped[$roleId])) continue;
        ?>
        <div class="mb-7">
            <h2 class="text-sm uppercase tracking-wide text-slate-400 mb-3"><?= $label ?></h2>
            <div class="space-y-2">
                <?php foreach ($grouped[$roleId] as $u): ?>
                <a href="devLogin?email=<?= urlencode($u['email']) ?>" class="flex items-center justify-between rounded-xl border border-border bg-surface-2 px-4 py-3 hover:border-accent/60 transition">
                    <span class="text-slate-100 font-medium"><?= e($u['full_name']) ?></span>
                    <span class="text-xs text-slate-500"><?= e($u['email']) ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>

        <a href="login" class="btn btn-ghost mt-6">&larr; Back to login</a>
    </div>
</body>

</html>
