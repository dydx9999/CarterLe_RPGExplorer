<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPG Explorer - Leaderboard</title>
</head>

<body>
    <header class="site-header">
        <a class="brand" href="index.php">RPG Explorer</a>
    </header>



</body>

</html>