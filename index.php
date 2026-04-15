<?php
require_once 'common.php';
// Render guest landing page shell
renderTopGuest('RPG Explorer - Landing')
    ?>


<main class="site-main">
    <!-- Landing hero card -->
    <section class="auth-page" aria-labelledby="landing-title">
        <div class="auth-card">
            <div class="auth-header">
                <h1 id="landing-title">Welcome, Explorer!</h1>
                <p>Begin your adventure by logging in or creating a new explorer account.</p>
            </div>

            <!-- Primary guest actions -->
            <div class="welcome-buttons">
                <a class="auth-submit" href="login.php">Log in</a>
                <a class="auth-submit" href="register.php">Sign up</a>
            </div>
        </div>
    </section>
</main>

<?php renderBottom(); ?>
