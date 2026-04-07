<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Hero class creation templates
$classTemplates = [
    'warrior' => [
        'stats' => ['hp' => 140, 'atk' => 18, 'def' => 14, 'mana' => 20],
        'items' => ['Iron Sword', 'Wooden Shield']
    ],
    'mage' => [
        'stats' => ['hp' => 80, 'atk' => 22, 'def' => 6, 'mana' => 120],
        'items' => ['Wooden Staff', 'Basic Spellbook']

    ],
    'rogue' => [
        'stats' => ['hp' => 100, 'atk' => 16, 'def' => 9, 'mana' => 40],
        'items' => ['Daggers', 'Stealth Cloak']
    ]

];


$currentNodeId = $_SESSION['node'] ?? 'start';
// Story Nodes 
$storyNodes = [
    'start' => [
        'text' => 'Introduction: You awaken to the fiery ruins of your village. In the distance, a loud roar can be heard.',
        'choices' => [
            'Investigate the ruins' => ['next' => 'ruins'],
            'Head towards the mountains' => ['next' => 'mountains'],
        ],
    ]
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class = $_POST['class'] ?? '';

    if (isset($classTemplates[$class])) {
        $score = $_SESSION['score'] ?? 0;
        $_SESSION['hero'] = [
            'class' => $class,
            'stats' => $classTemplates[$class]['stats'],
            'items' => $classTemplates[$class]['items'],
            'score' => $score,
        ];
    }
}
$hero = $_SESSION['hero'] ?? null;
$currentNode = $storyNodes[$currentNodeId] ?? $storyNodes['start'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPG Explorer - Story Mode</title>
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <header class="site-header">
        <a class="brand" href="index.php">RPG Explorer</a>
    </header>
    <div>
        <main class="site-main">
            <!-- User Welcome -->
            <section class="user-welcome">
                <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!
                </h1>
            </section>

            <!-- Class Selection Form -->
            <section class="class-selection">
                <h2>Character class selection for: <?= htmlspecialchars($_SESSION['username']) ?></h2>
                <form action="game.php" method="post">
                    <fieldset>
                        <legend>Choose your class:</legend>
                        <label for="class-warrior"><input type="radio" name="class" id="class-warrior" value="warrior"
                                checked>Warrior</label>
                        <label for="class-mage"><input type="radio" name="class" id="class-mage"
                                value="mage">Mage</label>
                        <label for="class-rogue"><input type="radio" name="class" id="class-rogue"
                                value="rogue">Rogue</label>
                    </fieldset>
                    <button type="submit">Submit</button>
                </form>
            </section>
            <!-- Player HUD -->
            <section class="player-hud">
                <h3><?= htmlspecialchars($_SESSION['username']) ?> (<?= ucfirst(htmlspecialchars($hero['class'])) ?>)
                </h3>
                <div class="stats-row">
                    <?php if (!empty($hero) && !empty($hero['stats']) && is_array($hero['stats'])): ?>
                        <span><strong>HP:</strong>
                            <?= htmlspecialchars($hero['stats']['hp']) ?>
                        </span>
                        <span><strong>Attack:</strong>
                            <?= htmlspecialchars($hero['stats']['atk']) ?>
                        </span>
                        <span><strong>Defense:</strong>
                            <?= htmlspecialchars($hero['stats']['def']) ?>
                        </span>
                        <span><strong>Score:</strong>
                            <?= htmlspecialchars($hero['score']) ?>
                        </span>
                    <?php else: ?>
                        <p>No stats found. Please select a class first.</p>
                    <?php endif ?>
                </div>
            </section>

            <!-- Hero Inventory -->
            <section class="hero-inventory">
                <h3>Inventory</h3>
                <?php if (!empty($hero['items']) && !empty($hero) && is_array($hero['items'])): ?>
                    <ul>
                        <?php foreach ($hero['items'] as $item): ?>
                            <li><?= htmlspecialchars($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No items yet. Pick a class first.</p>
                <?php endif; ?>
            </section>

            <!-- User Story Choice Form -->
            <section class="player-choice-input">
                <h3><?= htmlspecialchars($currentNode['text']) ?></h3>
                <form method="post">
                    <?php if (!empty($currentNode['choices'])): ?>
                        <?php foreach ($currentNode['choices'] as $choiceLabel => $choiceData): ?>
                            <button class="choice-buttons" type="submit" name="choice_label"
                                value="<?= htmlspecialchars($choiceLabel) ?>">
                                <?= htmlspecialchars($choiceLabel) ?>
                            </button>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </form>
            </section>
        </main>
    </div>
</body>

</html>