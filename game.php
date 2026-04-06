<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$player = $_SESSION['player'] ?? null;

$classTemplates = [
    'warrior' => [
        'stats' => ['hp' => 140, 'atk' => 18, 'def' => 14, 'mana' => 20],
        'items' => ['Iron Sword', 'Wooden Shield']
    ],
    'mage' => [
        'stats' => ['hp' => 80, 'atk' => 22, 'def' => 6, 'mana' => 120],
        'items' => ['Wooden Staff', 'Basic Spellbook']

    ],
    'assassin' => [
        'stats' => ['hp' => 100, 'atk' => 16, 'def' => 9, 'mana' => 40],
        'items' => ['Daggers', 'Stealth Cloak']
    ]

];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class = $_POST['class'] ?? '';

    if (isset($classTemplates[$class])) {
        $_SESSION['player'] = [
            'class' => $class,
            'stats' => $classTemplates[$class]['stats'],
            'items' => $classTemplates[$class]['items'],
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
</head>

<body>
    <header class="site-header">
        <a class="brand" href="index.php">RPG Explorer</a>
    </header>
    <div>
        <main class="site-main">
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
                        <label for="class"><input type="radio" name="class" id="class" value="warrior"
                                checked>Warrior</label>
                        <label for="class"><input type="radio" name="class" id="class" value="mage">Mage</label>
                        <label for="class"><input type="radio" name="class" id="class" value="assassin">Assassin</label>
                    </fieldset>
                    <button type="submit">Submit</button>
                </form>
            </section>

        </main>
    </div>
</body>

</html>