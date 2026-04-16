<?php
require_once 'common.php';
require_once __DIR__ . '/common.php';
require_once __DIR__ . '/story-nodes.php';
require_once __DIR__ . '/game-engine.php';

requireLogin();

$currentNodeId = $_SESSION['node'] ?? 'awakening';
$classTemplates = rpgGetClassTemplates();
$classDescriptions = rpgGetClassDescriptions();

// Form Handling 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reset'])) {
        rpgResetRunState();
        header('Location: game.php');
        exit;
    }

    $class = (string) ($_POST['class'] ?? '');
    if (rpgSelectHeroClass($class, $classTemplates)) {
        // Class assignment applied by game engine.
    } elseif (isset($_POST['choice_label'])) {
        $choiceLabel = (string) $_POST['choice_label'];
        if (
            rpgApplyStoryChoice($currentNodeId, $choiceLabel, $storyNodes)
            && rpgFinalizeEndingIfReached($storyNodes, $endingNodes)
        ) {
            header('Location: conclusion.php');
            exit;
        }
    }
}

$runHistory = $_SESSION['scores'] ?? [];

if (!is_array($runHistory)) {
    $runHistory = [];
}

// Prepare leaderboard data from session scores
$runHistory = normalizeScores($runHistory);

// Sort global leaderboard highest to lowest by score
usort($runHistory, static function (array $a, array $b): int {
    $scoreCompare = ((int) ($b['score'] ?? 0)) <=> ((int) ($a['score'] ?? 0));
    if ($scoreCompare !== 0) {
        return $scoreCompare;
    }

    return strcmp((string) ($a['username'] ?? ''), (string) ($b['username'] ?? ''));
});

// Keep sidebar leaderboard compact
$recentRunHistory = array_slice($runHistory, 0, 5);
// Initialize session variables 
$hero = $_SESSION['hero'] ?? null;
$hasSelectedClass = !empty($hero['class']) && isset($classTemplates[$hero['class']]);
$currentNodeId = $_SESSION['node'] ?? 'awakening';
$currentNode = $storyNodes[$currentNodeId] ?? $storyNodes['awakening'];
?>

<?php rendertop('RPG Explorer - Story Mode'); ?>
<!-- Site Main -->
<main id="main" class="site-main">
    <?php if (!$hasSelectedClass): ?>
        <!-- User welcome header -->
        <section class="user-welcome">
            <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!
            </h1>
        </section>

        <!-- Class Selection Form -->
        <section class="class-selection">
            <h2>Character class selection for: <?= htmlspecialchars($_SESSION['username']) ?></h2>

            <form action="game.php" method="post">
                <fieldset class="class-cards">
                    <legend>Choose your class:</legend>
                    <?php foreach ($classTemplates as $className => $template): ?>
                        <label class="class-card" for="class-<?= htmlspecialchars($className) ?>">
                            <input type="radio" name="class" id="class-<?= htmlspecialchars($className) ?>"
                                value="<?= htmlspecialchars($className) ?>" <?= $className === 'warrior' ?>>
                            <span class="class-card-body">
                                <span class="class-card-title"><?= ucfirst(htmlspecialchars($className)) ?></span>
                                <span class="class-card-description">
                                    <?= htmlspecialchars($classDescriptions[$className] ?? '') ?>
                                </span>
                                <span class="class-card-metrics">
                                    <span>&#x2764;&#xfe0f; <?= (int) ($template['stats']['hp'] ?? 0) ?></span>
                                    <span>&#9876; <?= (int) ($template['stats']['atk'] ?? 0) ?></span>
                                    <span>&#128737; <?= (int) ($template['stats']['def'] ?? 0) ?></span>
                                    <span>&#128167; <?= (int) ($template['stats']['mana'] ?? 0) ?></span>
                                </span>
                            </span>
                        </label>
                    <?php endforeach; ?>
                </fieldset>
                <div class="class-submit">
                    <button type="submit">Confirm selection</button>
                </div>
            </form>
        </section>
    <?php endif; ?>
    <!-- Display current story node title as header -->
    <?php if (isset($hero['class'])): ?>
        <div class="story-header typewriter">
            <h1>
                <?php if (isset($_SESSION['node']) && $_SESSION['node'] === 'awakening'): ?>
                    <?= htmlspecialchars($_SESSION['node']) ?>
                <?php elseif (isset($_SESSION['node'])): ?>
                    <?= htmlspecialchars(string: $_SESSION['node']) ?>
                <?php endif ?>
            </h1>
        </div>
        <section class="game-overview">
            <!-- Main game overview -->
            <div class="overview-main">
                <!-- Player HUD -->
                <section class="player-hud">
                    <!-- Player Stats Row -->
                    <div class="stats-row">

                        <?php if (!empty($hero) && !empty($hero['stats']) && is_array($hero['stats'])): ?>
                            <span><strong>
                                    <?= htmlspecialchars($_SESSION['username']) ?>
                                    <?php if ($hasSelectedClass): ?>
                                        (<?= ucfirst(htmlspecialchars($hero['class'])) ?>)
                                    <?php endif; ?></strong></span>
                            <span class="hp-stat"><strong>&#x2764;&#xfe0f; HP:
                                    <?= htmlspecialchars($hero['stats']['hp']) ?>
                            </span></strong>
                            <span><strong>&#9876; Attack:
                                    <?= htmlspecialchars($hero['stats']['atk']) ?>
                            </span></strong>
                            <span><strong>&#128737; Defense:
                                    <?= htmlspecialchars($hero['stats']['def']) ?>
                            </span></strong>
                            <span><strong>Score:
                                    <?= htmlspecialchars($hero['score']) ?>
                            </span></strong>
                        <?php else: ?>
                            <p>No stats found. Please select a class first.</p>
                        <?php endif ?>
                    </div>
                    <!-- Class-specific HUD avatar rendering -->
                    <div class="class-avatar">
                        <?php if (isset($hero['class']) && $hero['class'] === 'warrior'): ?>
                            <img src="assets/warrior-avatar.png" alt="Warrior avatar">
                        <?php endif; ?>
                        <?php if (isset($hero['class']) && $hero['class'] === 'mage'): ?>
                            <img src="assets/mage-avatar.png" alt="Mage avatar">
                        <?php endif; ?>
                        <?php if (isset($hero['class']) && $hero['class'] === 'rogue'): ?>
                            <img src="assets/rogue-avatar.png" alt="Rogue avatar">
                        <?php endif; ?>
                    </div>
                </section>
            </div>
            <!-- Render current story node banner -->
            <?php if (isset($currentNode)): ?> <img class="story-banner"
                    src="assets/<?= htmlspecialchars($currentNodeId) ?>.jpg">
            <?php endif; ?>

            <!-- Hero Inventory -->
            <div class="overview-side">

                <aside class="overview-inventory hero-inventory">
                    <h3>Inventory</h3>
                    <?php if (!empty($hero['items']) && !empty($hero) && is_array($hero['items'])): ?>
                        <ul class="inventory-items">
                            <?php foreach ($hero['items'] as $item): ?>
                                <li><?= htmlspecialchars($item); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No items yet. Pick a class first.</p>
                    <?php endif; ?>
                </aside>
                <!-- Leaderboard Sidebar View -->
                <aside class="player-leaderboard">
                    <h3>Leaderboard</h3>
                    <div class="leaderboard-current-score">
                        <span>Current Session Score</span>
                        <strong><?= htmlspecialchars((string) ($hero['score'] ?? 0)) ?></strong>
                    </div>
                    <h4 class="leaderboard-history-title">Global Leaderboard</h4>
                    <?php if (!empty($recentRunHistory)): ?>
                        <ul class="leaderboard-items">
                            <?php foreach ($recentRunHistory as $run): ?>
                                <li class="leaderboard-run-item">
                                    <div class="leaderboard-run-topline">
                                        <strong><?= htmlspecialchars((string) ($run['username'] ?? 'Explorer')) ?></strong>
                                        <span>Score: <?= htmlspecialchars((string) ($run['score'] ?? 0)) ?></span>
                                    </div>
                                    <p>Ending: <?= htmlspecialchars((string) ($run['ending'] ?? 'Unknown')) ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="leaderboard-empty">No completed runs yet.</p>
                    <?php endif; ?>
                </aside>
            </div>


            <!-- Player Choice Input Form -->
            <?php if (isset($hero['class'])): ?>
                <section class="player-choice-input">
                    <h3>
                        <?= htmlspecialchars($currentNode['text']) ?>
                    </h3>
                    <form class="story-choice-form" method="post">
                        <?php if (!empty($currentNode['choices'])): ?>
                            <?php $choiceIndex = 0; ?>
                            <?php foreach ($currentNode['choices'] as $choiceLabel => $choiceData): ?>
                                <button class="choice-buttons story-choice-button" type="submit" name="choice_label"
                                    value="<?= htmlspecialchars($choiceLabel) ?>"
                                    style="--choice-delay: <?= (int) ($choiceIndex * 120) ?>ms;">
                                    <?= htmlspecialchars($choiceLabel) ?>
                                </button>
                                <?php $choiceIndex++; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </form>
                <?php endif ?>
            </section>

        </section>



    <?php endif ?>
</main>




<?php renderBottom(); ?>