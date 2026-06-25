<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/navside.css">
    <link rel="stylesheet" href="public/fontawesome/css/all.css">
    <link rel="stylesheet" href="public/css/home.css">
    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Journal - Developer Login</title>
    <style>
        .devlogin { max-width: 640px; margin: 60px auto; font-family: sans-serif; }
        .devlogin h1 { margin-bottom: 4px; }
        .devlogin .hint { color: #666; margin-bottom: 24px; }
        .devlogin .role-group { margin-bottom: 28px; }
        .devlogin .role-group h2 { font-size: 1.05rem; border-bottom: 2px solid #eee; padding-bottom: 6px; }
        .devlogin ul { list-style: none; padding: 0; margin: 0; }
        .devlogin li { margin: 8px 0; }
        .devlogin a.user {
            display: flex; justify-content: space-between; align-items: center;
            padding: 12px 16px; border: 1px solid #ddd; border-radius: 8px;
            text-decoration: none; color: #222; transition: background .15s, border-color .15s;
        }
        .devlogin a.user:hover { background: #f5f8ff; border-color: #6c8cff; }
        .devlogin .email { color: #888; font-size: .85rem; }
        .devlogin .back { display: inline-block; margin-top: 10px; color: #6c8cff; text-decoration: none; }
    </style>
</head>

<body>
    <main>
        <div class="devlogin">
            <h1>Developer Login</h1>
            <p class="hint">Local testing only — pick a mock user to log in instantly (no Google needed).</p>

            <?php
            $roleNames = [0 => 'Learners', 1 => 'Specialists', 2 => 'Administrators'];
            $grouped = [0 => [], 1 => [], 2 => []];
            foreach ($users as $u) {
                $grouped[(int) $u['role']][] = $u;
            }
            foreach ($roleNames as $roleId => $label):
                if (empty($grouped[$roleId])) continue;
            ?>
            <div class="role-group">
                <h2><?= $label ?></h2>
                <ul>
                    <?php foreach ($grouped[$roleId] as $u): ?>
                    <li>
                        <a class="user" href="devLogin?email=<?= urlencode($u['email']) ?>">
                            <span><?= e($u['full_name']) ?></span>
                            <span class="email"><?= e($u['email']) ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>

            <a class="back" href="login">&larr; Back to normal login</a>
        </div>
    </main>
</body>

</html>
