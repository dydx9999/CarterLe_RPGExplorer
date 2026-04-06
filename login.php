<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: game.php');
    exit;
}

$errors = [];
$username = '';
$password = '';

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
</head>

<body>
    <header class="site-header">
        <a class="brand" href="index.php">RPG Explorer</a>
        <nav>
            <ul>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </header>
    <main class="site-main">
        <h1>User Login</h1>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="3-20 chars: letters, numbers, _" size="28"
                value="<?= htmlspecialchars($username) ?>" required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="8+ chars: upper, lower, number, symbol"
                size="34" required><br>
            <input type="submit" value="Log in">
            <p>Don't have an account?</p><a href="register.php">Sign up</a>
        </form>
        <?php if (!empty($errors)): ?>
            <div class="form-errors">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>