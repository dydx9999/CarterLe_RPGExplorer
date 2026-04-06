<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
;
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class = $_POST['class'] ?? '';

    if ($class === '') {
        $errors[] = 'You have not selected a class.';
    }
    if (empty($errors)) {
        $_SESSION['class'] = $class;
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
            <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!
            </h1>
            <h2>Character class selection for: <?= htmlspecialchars($_SESSION['username']) ?></h2>
            <form action="game.php" method="post">
                <fieldset>
                    <legend>Choose your class:</legend>
                    <label for="class"><input type="radio" name="class" id="class" value="Warrior"
                            checked>Warrior</label>
                    <label for="class"><input type="radio" name="class" id="class" value="Mage">Mage</label>
                    <label for="class"><input type="radio" name="class" id="class" value="Asssassin">Assassin</label>
                </fieldset>
                <button type="submit">Submit</button>
            </form>
        </main>
    </div>
</body>

</html>