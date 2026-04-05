<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPG Explorer - Register</title>
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
        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="3-20 chars: letters, numbers, _" size="28"
                required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="8+ chars: upper, lower, number, symbol"
                size="34" required><br>
            <input type="submit" value="Sign up">
        </form>

    </main>
</body>

</html>