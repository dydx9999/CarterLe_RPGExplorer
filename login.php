<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPGExplorer - Login</title>
</head>

<body>
    <header class="site-header">
        <a class="brand" href="index.php">Quest Explorer</a>
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
            <input type="text" name="username" id="username"><br>
            <label for=" password">Password:</label>
            <input type="password" name="password" id="password"><br>
            <input type="submit" value="Log In">
        </form>
</body>

</html>