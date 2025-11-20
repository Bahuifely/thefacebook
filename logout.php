<?php
require_once 'config/session.php';
require_once 'config/database.php';

// Clear session data and cookies, then redirect to login
$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'] ?? '/',
        $params['domain'] ?? '',
        $params['secure'] ?? false,
        $params['httponly'] ?? false
    );
}

session_unset();
session_destroy();

$base = defined('BASE_PATH') ? BASE_PATH : '';
header('Location: ' . $base . '/login.php');
exit();
?>
