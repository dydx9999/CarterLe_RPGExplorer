<?php
require_once 'common.php';
session_start();
// Initialize register form state
$errors = [];
$username = '';
$password = '';
$validUsername = false;
$validPassword = false;

// Regex validation patterns
$usernamePattern = '/^[A-Za-z0-9_]{3,20}$/';
$passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,64}$/';

// Handle registration form submission
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
        // Start authenticated session for newly registered user
        $newUserID = bin2hex(random_bytes(8));
        session_regenerate_id(true);
        $_SESSION['user_id'] = $newUserID;
        $_SESSION['username'] = $username;
        header('Location: game.php');
        exit;
    }
}
// Render register page shell
renderTopGuest('RPG Explorer - Register')
    ?>
<main class="site-main">
    <section class="auth-page" aria-labelledby="register-title">
        <div class="auth-card">
            <div class="auth-header">
                <h1 id="register-title">Join the Realm</h1>
                <p>Create your adventurer credentials to start a new story.</p>
            </div>

            <!-- Validation errors -->
            <?php if (!empty($errors)): ?>
                <div class="form-errors" role="alert" aria-live="polite">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Registration form -->
            <form class="auth-form" action="register.php" method="post">
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
                <button class="auth-submit" type="submit">Sign up</button>
            </form>

            <!-- Auth page footer links -->
            <div class="auth-footer">
                <p>Already have an account?</p>
                <a href="login.php">Log in</a>
            </div>
        </div>
    </section>
</main>

<?php renderBottom(); ?>