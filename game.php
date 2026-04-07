<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$hero = $_SESSION['hero'] ?? null;

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

            <!-- Hero Inventory -->
            <section class="hero-inventory">
                <h2>Inventory</h2>
                <?php if (!empty($hero['items']) && !empty($hero)):
                    ?>
                    <ul>
                        <?php foreach ($hero['items'] as $item): ?>
                            <li><?= htmlspecialchars($item) ?></li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </section>

            <!-- User Story Choice Form -->
        </main>
    </div>
</body>

</html>