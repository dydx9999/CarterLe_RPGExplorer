<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPG Explorer - Conclusion</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-32x32.png">
    <link rel="manifest" href="/site.webmanifest">

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
    <main class="site-main">
        <?php if (isset($_SESSION['ending_node'])): ?>
            <h1>
                <?= htmlspecialchars($_SESSION['ending_node']) ?>
            </h1>
        <?php endif ?>
    </main>

    <!-- TODO: ADD ENDING SCREEN PLAYER STATS OVERVIEW -->




</body>

</html>