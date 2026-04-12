<?php
require_once 'common.php';
session_start();
// Redirect user to game.php if already signed in
if (isset($_SESSION['user_id'])) {
    header('Location: game.php');
    exit;
}

$errors = [];
$username = '';
$password = '';
// Regex Input Checks 
$usernamePattern = '/^[A-Za-z0-9_]{3,20}$/';
$passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,64}$/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = 'Username and password are required.';
    } else {
        $validUsername = preg_match($usernamePattern, $username) === 1;
        $validPassword = preg_match($passwordPattern, $password) === 1;

        if (!$validUsername) {
            $errors[] = 'Username must be 3-20 characters and use only letters, numbers, or underscore.';
        }

        if (!$validPassword) {
            $errors[] = 'Password must be 8+ chars with upper, lower, number, and symbol.';
        }
    }

    if (empty($errors)) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = bin2hex(random_bytes(8));
        $_SESSION['username'] = $username;

        header('Location: game.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPG Explorer - Login</title>
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
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </header>
    <main class="site-main">
        <section class="auth-page" aria-labelledby="login-title">
            <div class="auth-card">
                <div class="auth-header">
                    <h1 id="login-title">Enter the Realm</h1>
                    <p>Use your adventurer credentials to continue your story.</p>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="form-errors" role="alert" aria-live="polite">
                        <?php foreach ($errors as $error): ?>
                            <p><?= htmlspecialchars($error) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form class="auth-form" action="login.php" method="post">
                    <div class="auth-field">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" placeholder="3-20 chars: letters, numbers, _"
                            value="<?= htmlspecialchars($username) ?>" required>
                    </div>
                    <div class="auth-field">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password"
                            placeholder="8+ chars: upper, lower, number, symbol" required>
                    </div>
                    <button class="auth-submit" type="submit">Log in</button>
                </form>

                <div class="auth-footer">
                    <p>Don&apos;t have an account?</p>
                    <a href="register.php">Sign up</a>
                </div>
            </div>
        </section>
    </main>
    <?php renderBottom(); ?>