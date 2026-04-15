<?php
require_once 'common.php';
requireLogin();

$endingNode = $_SESSION['ending_node'] ?? null;
$endingNodeText = $_SESSION['ending_node_text'] ?? null;
$username = $_SESSION['username'] ?? 'Explorer';
$score = $_SESSION['hero']['score'] ?? 0;
$runHistory = $_SESSION['scores'] ?? [];

if (!is_array($runHistory)) {
    $runHistory = [];
}

$runHistory = array_reverse(normalizeScores($runHistory));

?>
<?php rendertop('RPG Explorer - Conclusion'); ?>

<main class="site-main conclusion-main">
    <!-- Display ending type -->
    <div class="ending-header">
        <?php if (!empty($endingNode) && !empty($endingNodeText)): ?>
            <h1>
                <?= htmlspecialchars($endingNode) ?>
            </h1>
        <?php else: ?>
            <h1>No ending reached yet.</h1>
            <p>Complete a playthrough in story mode to unlock an ending.</p>
        <?php endif ?>
    </div>




    <!-- Display custom ending screen -->
    <?php if (isset($endingNode)): ?>
        <div>
            <img class="conclusion story-banner" src="assets/<?= htmlspecialchars($endingNode) ?>.gif">
        </div>
    <?php endif; ?>
    <?php if (!empty($endingNode) && !empty($endingNodeText)): ?>
        <h2> <?= htmlspecialchars($endingNodeText) ?> </h2>
    <?php endif; ?>

    <!-- End Screen Overview -->
    <div class="ending-stats-overview ending-overview-primary">
        <h2>Overview for: <?= htmlspecialchars($username) ?></h2>
        <div class="overview-row">
            <strong>Ending Achieved:</strong>
            <span><?= htmlspecialchars($endingNode ?? 'No ending reached yet.') ?></span>
        </div>
        <div class="overview-row">
            <strong>Score:</strong>
            <span><?= htmlspecialchars((string) $score) ?></span>
        </div>
    </div>
    <!-- Display game run history -->
    <div class="ending-stats-overview ending-overview-history">
        <h2>Run History</h2>
        <?php if (!empty($runHistory)): ?>
            <?php foreach ($runHistory as $run): ?>
                <div class="overview-row">
                    <strong><?= htmlspecialchars((string) ($run['username'] ?? 'Explorer')) ?></strong>
                    <span>
                        Score: <?= htmlspecialchars((string) ($run['score'] ?? 0)) ?>
                        | Ending: <?= htmlspecialchars((string) ($run['ending'] ?? 'Unknown')) ?>
                    </span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No completed runs yet.</p>
        <?php endif; ?>
    </div>




</main>

<!-- Start new game run button -->
<?php if (!empty($endingNode) && !empty($endingNodeText)): ?>
    <div class="new-run-button">
        <form action="game.php" method="post">
            <button class="choice-buttons" type="submit" name="reset" value="reset">Start a new run</button>
        </form>
    </div>
<?php endif; ?>


<?php renderBottom(); ?>