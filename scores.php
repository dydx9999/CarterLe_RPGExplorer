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
