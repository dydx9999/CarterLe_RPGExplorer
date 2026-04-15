<?php
require_once 'common.php';
requireLogin();

// Clear active session data
session_unset();
session_destroy();

// Expire PHP session cookie if cookie sessions are enabled
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);

}

// Send player back to login screen
header('Location: login.php');
exit;
?>
