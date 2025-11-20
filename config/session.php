<?php
// Session helpers: start session and provide login/logout utilities

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Ensure BASE_PATH exists so redirects use the project folder (override if needed)
if (!defined('BASE_PATH')) {
    define('BASE_PATH', '/thefacebook');
}

/**
 * Devuelve true si el usuario está autenticado.
 */
function isLoggedIn() {
    return !empty($_SESSION['user_id']);
}

/**
 * Devuelve el id del usuario logueado o null.
 */
function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Registra al usuario en la sesión.
 */
function loginUser($userId, $email = null) {
    $_SESSION['user_id'] = $userId;
    if ($email !== null) {
        $_SESSION['user_email'] = $email;
    }
}

/**
 * Destruye la sesión y redirige a la página de login.
 */
function logoutUserAndRedirect() {
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

    header('Location: ' . BASE_PATH . '/login.php');
    exit();
}
?>
