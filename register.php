<?php
session_start();
$errors = [];
$username = '';
$password = '';
$validUsername = false;
$validPassword = false;

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
        $newUserID = bin2hex(random_bytes(8));
        session_regenerate_id(true);
        $_SESSION['user_id'] = $newUserID;
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
    <title>RPG Explorer - Register</title>
    <link rel="stylesheet" href="styles.css">
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
        <h1>User Registration</h1>
        <div class="signup-container">
            <form class="signup-form" action="register.php" method="post">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="3-20 chars: letters, numbers, _" size="34"
                    required><br>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password"
                    placeholder="8+ chars: upper, lower, number, symbol" size="34" required><br>
                <div>
                    <input class="signup-submit" type="submit" value="Sign up">
                </div>
            </form>
        </div>
        <?php if (!empty($errors)): ?>
            <div class=" form-errors">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </main>
</body>

</html>