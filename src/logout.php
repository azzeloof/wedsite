<?php
session_start();

$_SESSION = array();
// Note: This requires session.use_cookies to be enabled in php.ini (it usually is).
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, // Set cookie to expire in the past
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
header('Location: index.php');
exit;
?>