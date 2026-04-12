<?php
require_once 'common.php'
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPG Explorer - Landing</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-32x32.png">
    <link rel="manifest" href="/site.webmanifest">
</head>

<body>
    <header class="site-header">
        <a class="brand" href="index.php">RPG Explorer</a>

    </header>

    <main id="index-main">
        <h1>Welcome, Explorer!</h1>

        <div class="welcome-buttons">
            <a class="choice-buttons" href="login.php">Login</a>
            <a class="choice-buttons" href="register.php">Sign Up</a>
        </div>


    </main>

    <?php renderBottom(); ?>