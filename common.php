<?php
function requireLogin(): void
{
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

} ?>

<?php
function renderTop(string $title): void
{
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="styles.css">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-32x32.png">
        <link rel="manifest" href="/site.webmanifest">
        <title>
            <?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>
        </title>
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
        <?php
}

function renderBottom(): void
{
    ?>
        <footer class="site-footer">
            <p>
                ©2026 RPG Explorer.
            </p>
        </footer>
        </div>
    </body>

    </html>
    <?php
}

?>