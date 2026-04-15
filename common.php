<?php
const RPG_SCORES_COOKIE = 'rpg_scores';
const RPG_SCORES_LIMIT = 10;
const RPG_SCORES_COOKIE_TTL_SECONDS = 30 * 24 * 60 * 60;

function normalizeScores(array $scores): array
{
    $cleanScores = [];

    foreach ($scores as $entry) {
        if (!is_array($entry)) {
            continue;
        }

        $username = trim((string) ($entry['username'] ?? 'Explorer'));
        if ($username === '') {
            $username = 'Explorer';
        }

        $ending = trim((string) ($entry['ending'] ?? 'Unknown'));
        if ($ending === '') {
            $ending = 'Unknown';
        }

        $cleanScores[] = [
            'username' => $username,
            'score' => (int) ($entry['score'] ?? 0),
            'ending' => $ending,
        ];
    }



    return $cleanScores;
}

function persistScoresCookie(array $scores): void
{
    $scores = normalizeScores($scores);
    $encodedScores = json_encode($scores);

    if (!is_string($encodedScores)) {
        return;
    }

    $isSecure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

    if (!headers_sent()) {
        setcookie(
            RPG_SCORES_COOKIE,
            $encodedScores,
            [
                'expires' => time() + RPG_SCORES_COOKIE_TTL_SECONDS,
                'path' => '/',
                'secure' => $isSecure,
                'httponly' => true,
                'samesite' => 'Lax',
            ]
        );
    }

    $_COOKIE[RPG_SCORES_COOKIE] = $encodedScores;
}

function requireLogin(): void
{
    session_start();

    // 1) one-time migration from the old session key
    if (isset($_SESSION['run_history']) && !isset($_SESSION['scores'])) {
        $_SESSION['scores'] = normalizeScores($_SESSION['run_history']);
        persistScoresCookie(scores: $_SESSION['scores']);
    }
    unset($_SESSION['run_history']);

} ?>
    // 2) load scores from cookie if session does not already have them
    if (!isset($_SESSION['scores']) || !is_array($_SESSION['scores'])) {
        if (isset($_COOKIE[RPG_SCORES_COOKIE]) && $_COOKIE[RPG_SCORES_COOKIE] !== '') {
            $cookieScores = json_decode($_COOKIE[RPG_SCORES_COOKIE], true);
            $_SESSION['scores'] = is_array($cookieScores) ? normalizeScores($cookieScores) : [];
        } else {
            $_SESSION['scores'] = [];
        }
    } else {
        $_SESSION['scores'] = normalizeScores($_SESSION['scores']);
    }

    // 3) normal auth or anonymous restore
    if (isset($_SESSION['user_id'])) {
        if (!isset($_SESSION['username']) || trim((string) $_SESSION['username']) === '') {
            $_SESSION['username'] = 'Explorer';
        }
        return;
    }

    if (!empty($_SESSION['scores'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = bin2hex(random_bytes(8));
        $_SESSION['username'] = 'Explorer';
        persistScoresCookie($_SESSION['scores']);
        return;
    }

    header('Location: login.php');
    exit;
}

function renderTop(string $title): void
{
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="styles.css">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-32x32.png">
        <link rel="manifest" href="/site.webmanifest">
        <title>
            <?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>
        </title>
    </head>

    <body>
        <header class="site-header">
            <a class="brand" href="index.php">RPG Explorer</a>
            <nav class="site-nav">
                <ul>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>
        <?php
}

function renderBottom(): void
{
    ?>
        <footer class="site-footer">
            <p>
                ©2026 RPG Explorer.
            </p>
        </footer>
        </div>
    </body>

    </html>
    <?php
}

?>