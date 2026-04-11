<?php
require_once 'common.php';
requireLogin();

?>
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