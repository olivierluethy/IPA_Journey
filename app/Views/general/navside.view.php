<?php
/* Sidebar + top bar — shared chrome for every page (dark design system). */

/* Role-based navigation as [route, label] pairs. */
$navLinks = [];
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 0 || $_SESSION['role'] == 1) {
        $navLinks[] = ['home', 'Home'];
    }
    if ($_SESSION['role'] == 0) {
        $navLinks[] = ['dailyRaport', 'Daily reports'];
        $navLinks[] = ['weeklyRaport', 'Weekly reports'];
        $navLinks[] = ['keywords', 'My keywords'];
    }
    if ($_SESSION['role'] == 1) {
        $navLinks[] = ['overview', 'Overview'];
    }
    if ($_SESSION['role'] == 2) {
        $navLinks[] = ['userOverview', 'User overview'];
    }
}

/* Page title for the top bar (most-specific keys first). */
$titles = [
    'addDailyJournal'  => 'Add daily report',
    'addWeeklyJournal' => 'Add weekly report',
    'addKeyword'       => 'Add keyword',
    'userOverview'     => 'User overview',
    'dailyRaport'      => 'Daily reports',
    'weeklyRaport'     => 'Weekly reports',
    'keyword'          => 'Keywords',
    'overview'         => 'Overview',
    'home'             => 'Home',
    'login'            => 'Login',
];
$pageHeading = 'Journal';
foreach ($titles as $needle => $title) {
    if (isset($actual_link) && stripos($actual_link, $needle) !== false) {
        $pageHeading = $title;
        break;
    }
}

/* Sidebar active-state helper. */
$isActive = function ($route) {
    global $actual_link;
    return isset($actual_link) && stripos($actual_link, $route) !== false;
};

$fullName = $_SESSION['full_name'] ?? '';
$avatar   = $_SESSION['profileImageUrl'] ?? '';
$initials = '';
if ($fullName) {
    $parts = preg_split('/\s+/', trim($fullName));
    $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
}
?>

<!-- Mobile sidebar toggle -->
<button id="burger" type="button" aria-label="Toggle navigation"
        class="btn-icon fixed top-3 left-3 z-50 md:hidden bg-surface border border-border">
    <i class="fa-solid fa-bars"></i>
</button>
<div id="sidebarBackdrop" class="fixed inset-0 z-30 bg-black/50 md:hidden hidden"></div>

<!-- Sidebar -->
<aside id="sidebar"
       class="fixed top-0 left-0 z-40 h-screen w-60 bg-surface border-r border-border
              flex flex-col p-4 -translate-x-full md:translate-x-0 transition-transform duration-200">
    <div class="px-2 py-3 flex items-center gap-2.5">
        <span class="grid h-9 w-9 place-items-center rounded-xl bg-accent text-white">
            <i class="fa-solid fa-feather-pointed"></i>
        </span>
        <span class="text-base font-semibold text-slate-100 leading-tight">
            Journal<br><span class="text-slate-400 text-sm font-medium">Web-App</span>
        </span>
    </div>
    <hr class="border-border my-3">
    <nav class="flex flex-col gap-1">
        <?php foreach ($navLinks as [$route, $label]): ?>
            <button type="button" onclick="navigateTo('<?= $route ?>')"
                    class="sidebar-link <?= $isActive($route) ? 'active' : '' ?>"><?= $label ?></button>
        <?php endforeach; ?>
    </nav>
    <?php if (!empty($_SESSION['loggedin'])): ?>
    <div class="mt-auto">
        <hr class="border-border my-3">
        <button type="button" onclick="navigateTo('logout')" class="sidebar-link flex items-center gap-2">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
        </button>
    </div>
    <?php endif; ?>
</aside>

<!-- Top bar -->
<header class="sticky top-0 z-20 md:ml-60 h-16 bg-base/80 backdrop-blur border-b border-border
               flex items-center justify-between px-4 sm:px-6 lg:px-8">
    <h1 class="text-lg font-semibold text-slate-100 pl-10 md:pl-0"><?= $pageHeading ?></h1>
    <?php if (isset($_SESSION['role'])): ?>
    <div class="flex items-center gap-3">
        <?php if ($_SESSION['role'] == 1 && isset($notifications)): ?>
        <div class="relative">
            <button id="notifBtn" type="button" data-uid="<?= e((string)($_SESSION['id'] ?? '')) ?>"
                    class="btn-icon relative" aria-haspopup="true" aria-expanded="false" aria-label="Notifications">
                <i class="fa-solid fa-bell"></i>
                <span id="notifBadge" class="hidden absolute -top-1 -right-1 min-w-[1.1rem] h-[1.1rem] px-1 rounded-full bg-accent text-white text-[10px] font-semibold leading-[1.1rem] text-center"></span>
            </button>
            <div id="notifPanel" class="hidden absolute right-0 mt-2 w-80 max-h-96 scroll-area card p-2 z-50" role="menu" aria-label="Recently released reports">
                <div class="px-2 py-1.5 text-xs font-semibold text-slate-400 uppercase tracking-wide">Recently released</div>
                <ul id="notifList" class="space-y-1">
                    <?php foreach ($notifications as $n): ?>
                    <li data-notif data-id="<?= $n['id'] ?>" data-type="<?= $n['type'] ?>" data-ts="<?= strtotime($n['date']) * 1000 ?>"
                        role="menuitem" tabindex="0" class="cursor-pointer rounded-lg px-2.5 py-2 hover:bg-white/5">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-sm text-slate-100 truncate"><?= e($n['name']) ?></span>
                            <span class="chip"><?= $n['type'] === 'daily' ? 'Daily' : 'Weekly' ?></span>
                        </div>
                        <div class="text-xs text-slate-500 mt-0.5"><?= date('j M Y · H:i', strtotime($n['date'])) ?></div>
                    </li>
                    <?php endforeach; ?>
                    <?php if (empty($notifications)): ?>
                    <li class="px-2.5 py-2 text-sm text-slate-500">No released reports.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>
        <span class="hidden sm:block text-sm text-slate-400">Hey, <span class="text-slate-200 font-medium"><?= e($fullName) ?></span>!</span>
        <?php if ($avatar): ?>
            <img src="<?= e($avatar) ?>" alt="" class="h-9 w-9 rounded-full object-cover border border-border">
        <?php else: ?>
            <span class="grid h-9 w-9 place-items-center rounded-full bg-accent/20 text-indigo-200 text-sm font-semibold border border-accent/30"><?= $initials ?: '?' ?></span>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</header>
