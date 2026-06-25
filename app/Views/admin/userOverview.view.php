<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <?php $pageTitle = 'Journal - User overview'; include 'app/Views/general/head.php'; ?>
    <script src="public/js/route.js" defer></script>
    <script src="public/js/app.js" defer></script>
</head>

<body>
    <?php
    $actual_link = basename(__FILE__);
    include __DIR__ . '/../general/navside.view.php';

    $roleLabels = [0 => 'Learner', 1 => 'Specialist', 2 => 'Administrator'];
    ?>

    <main class="md:ml-60 px-4 sm:px-6 lg:px-8 py-8 max-w-5xl">
        <h2 class="text-xl font-semibold mb-6">Users</h2>

        <?php if (count($arrayUsers) > 0): ?>
        <div class="grid gap-4 md:grid-cols-2">
            <?php foreach ($arrayUsers as $user): $role = (int) $user['role']; ?>
            <article class="card p-5" data-report-card data-type="user" data-id="<?= $user['userId'] ?>">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <h3 class="text-base font-semibold truncate"><?= e($user['full_name']) ?></h3>
                        <p class="text-sm text-slate-400 truncate"><?= e($user['email']) ?></p>
                    </div>
                    <div class="flex items-center gap-1 shrink-0">
                        <button class="btn-icon h-8 w-8" data-edit aria-label="Edit role" title="Edit role"><i class="fa-solid fa-pen text-xs"></i></button>
                        <button class="btn-icon h-8 w-8 hover:text-danger" onclick="deleteUser(<?= $user['userId'] ?>)" aria-label="Delete user" title="Delete"><i class="fa-solid fa-trash text-xs"></i></button>
                    </div>
                </div>

                <!-- Display -->
                <div data-display class="mt-3">
                    <span class="chip">Role: <span data-field="role"><?= $roleLabels[$role] ?? $role ?></span></span>
                </div>

                <!-- Inline edit -->
                <form data-edit-form action="editUser?id=<?= $user['userId'] ?>" method="POST" class="hidden mt-3 flex items-center gap-2">
                    <select name="role" class="input max-w-[12rem]">
                        <?php foreach ($roleLabels as $value => $label): ?>
                            <option value="<?= $value ?>" <?= $role === $value ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" data-cancel class="btn btn-ghost">Cancel</button>
                </form>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="card p-10 text-center">
            <h2 class="text-lg font-semibold">There are no users</h2>
        </div>
        <?php endif; ?>
    </main>
</body>

</html>
