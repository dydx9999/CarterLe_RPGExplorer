<?php
require_once 'common.php';
requireLogin();

$endingNode = $_SESSION['ending_node'] ?? null;
$endingNodeText = $_SESSION['ending_node_text'] ?? null;
$username = $_SESSION['username'] ?? 'Explorer';
$score = $_SESSION['hero']['score'] ?? 0;



?>
<?php rendertop('RPG Explorer - Conclusion'); ?>

<main class="site-main conclusion-main">
    <!-- Display ending type -->
    <div class="ending-header">
        <?php if (!empty($endingNode) && !empty($endingNodeText)): ?>
            <h1>
                <?= htmlspecialchars($endingNode) ?>
            </h1>
            <p>
                <?= htmlspecialchars($endingNodeText) ?>
            </p>
        <?php else: ?>
            <h1>No ending reached yet.</h1>
            <p>Complete a playthrough in story mode to unlock an ending.</p>
        <?php endif ?>

    <!-- TODO: ADD ENDING SCREEN PLAYER STATS OVERVIEW -->




</body>
<!-- Start new game run button -->
<?php if (!empty($endingNode) && !empty($endingNodeText)): ?>
    <div class="new-run-button">
        <form action="game.php" method="post">
            <button class="choice-buttons" type="submit" name="reset" value="reset">Start a new run</button>
        </form>
    </div>
<?php endif; ?>


<?php renderBottom(); ?>