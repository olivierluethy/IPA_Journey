<?php
/**
 * Nutze diese Funktion um einfach eine Ausgabe
 * mit htmlspecialchars() zu erstellen.
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
}

/**
 * Nutze diese Funktion um auf einen POST-Wert
 * zuzugreifen.
 */
function post(string $key, $default = '')
{
    return $_POST[$key] ?? $default;
}

/**
 * True if the request was made via fetch/XHR (used by inline editing).
 */
function isAjax(): bool
{
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Send a JSON response and stop.
 */
function jsonResponse(array $data, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

/*
 * Server-side HTML sanitizer (defense in depth alongside DOMPurify on render).
 * Allow-list matches the rich-text editor output: formatting, lists, links,
 * images and tables. Strips <script>, on* handlers, iframe/object, and any
 * style except a whitelisted text-align.
 */
function sanitizeHtml(string $html): string
{
    $html = trim($html);
    if ($html === '') {
        return '';
    }

    $allowedTags = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'strike', 'ul', 'ol', 'li',
        'a', 'h1', 'h2', 'h3', 'h4', 'blockquote', 'code', 'pre', 'hr',
        'img', 'table', 'thead', 'tbody', 'tfoot', 'tr', 'th', 'td', 'colgroup', 'col',
    ];
    $allowedAttrs = [
        'a'   => ['href', 'title', 'target', 'rel'],
        'img' => ['src', 'alt', 'title'],
        'td'  => ['colspan', 'rowspan'],
        'th'  => ['colspan', 'rowspan'],
        'col' => ['span'],
    ];
    $dropEntirely = ['script', 'style', 'iframe', 'object', 'embed', 'form', 'input', 'svg'];

    $dom = new DOMDocument('1.0', 'UTF-8');
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="utf-8"?><div id="__root__">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();

    $root = $dom->getElementById('__root__');
    if (!$root) {
        return '';
    }
    sanitizeHtmlNode($root, $allowedTags, $allowedAttrs, $dropEntirely);

    $out = '';
    foreach ($root->childNodes as $child) {
        $out .= $dom->saveHTML($child);
    }
    return trim($out);
}

function sanitizeHtmlNode(DOMNode $node, array $allowedTags, array $allowedAttrs, array $dropEntirely): void
{
    foreach (iterator_to_array($node->childNodes) as $child) {
        if ($child->nodeType === XML_COMMENT_NODE) {
            $node->removeChild($child);
            continue;
        }
        if ($child->nodeType !== XML_ELEMENT_NODE) {
            continue; // keep text nodes
        }

        $tag = strtolower($child->nodeName);

        if (!in_array($tag, $allowedTags, true)) {
            if (in_array($tag, $dropEntirely, true)) {
                $node->removeChild($child);      // drop element AND its contents
            } else {
                while ($child->firstChild) {     // unwrap: keep inner text/children
                    $node->insertBefore($child->firstChild, $child);
                }
                $node->removeChild($child);
            }
            continue;
        }

        $keepStyle = null;
        foreach (iterator_to_array($child->attributes) as $attr) {
            $an = strtolower($attr->nodeName);
            $av = trim($attr->nodeValue);

            if (strpos($an, 'on') === 0) { $child->removeAttribute($attr->nodeName); continue; }
            if ($an === 'style') {
                if (preg_match('/text-align\s*:\s*(left|right|center|justify)/i', $av, $m)) {
                    $keepStyle = 'text-align:' . strtolower($m[1]);
                }
                $child->removeAttribute($attr->nodeName);
                continue;
            }
            $tagAllowed = $allowedAttrs[$tag] ?? [];
            if (!in_array($an, $tagAllowed, true)) { $child->removeAttribute($attr->nodeName); continue; }
            if ($an === 'href' && preg_match('#^\s*javascript:#i', $av)) { $child->removeAttribute($attr->nodeName); continue; }
            if ($an === 'src' && !preg_match('#^(/|public/|images/|uploads/|data:image/)#i', $av)) { $child->removeAttribute($attr->nodeName); continue; }
        }
        if ($keepStyle !== null) {
            $child->setAttribute('style', $keepStyle);
        }

        sanitizeHtmlNode($child, $allowedTags, $allowedAttrs, $dropEntirely);
    }
}

/** Markup for a rich-text editor field bound to a hidden input named $name. */
function rteField(string $name, string $html = '', string $placeholder = ''): string
{
    return '<div class="rte-field">'
        . '<div class="rte" data-editor data-placeholder="' . e($placeholder) . '"></div>'
        . '<input type="hidden" name="' . e($name) . '" class="rte-input" value="' . e($html) . '">'
        . '</div>';
}

/** Plain text (tags stripped) for search/previews. */
function htmlToText(string $html): string
{
    return trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($html), ENT_QUOTES, 'UTF-8')));
}

/*
 * Submission cadence (edit here to change deadlines).
 * Default: daily report due every working day by 18:00 local;
 *          weekly report due by Friday 18:00 local (current ISO week).
 */
function submissionSchedule(): array
{
    return ['daily_hour' => 18, 'weekly_weekday' => 'friday', 'weekly_hour' => 18];
}

/** Next daily-report deadline (today 18:00 on a working day, else upcoming Monday 18:00). */
function dailyDeadline(): DateTime
{
    $cfg = submissionSchedule();
    $now = new DateTime('now');
    $d = new DateTime('today');
    $d->setTime($cfg['daily_hour'], 0, 0);
    if ((int) $now->format('N') >= 6) { // weekend → upcoming Monday
        $d = new DateTime('monday this week');
        $d->modify('+7 days');
        $d->setTime($cfg['daily_hour'], 0, 0);
    }
    return $d;
}

/** Weekly-report deadline: this ISO week's Friday at 18:00. */
function weeklyDeadline(): DateTime
{
    $cfg = submissionSchedule();
    $d = new DateTime($cfg['weekly_weekday'] . ' this week');
    $d->setTime($cfg['weekly_hour'], 0, 0);
    return $d;
}

/** Current ISO week number, matching the weeklyReport.calendarWeek field. */
function currentIsoWeek(): int
{
    return (int) date('W');
}

/**
 * Stellt eine Verbindung zur Datenbank her und gibt die
 * Datenbankverbindung als PDO zurück.
 */
$dbInstance = null;

function db(): PDO
{
    global $dbInstance;

    if ($dbInstance) {
        return $dbInstance;
    }

    try {
        $dbInstance = new PDO('mysql:host=127.0.0.1;journal=' . $db['name'], $db['username'], $db['password'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ]);
    } catch (PDOException $e) {
        die('Keine Verbindung zur Datenbank möglich: ' . $e->getMessage());
    }
}