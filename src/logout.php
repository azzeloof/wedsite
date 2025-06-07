<?php
session_start(); // Initialize the session.

// 1. Unset all of the session variables.
$_SESSION = array();

// 2. If it's desired to kill the session, also delete the session cookie.
// This will destroy the session, and not just the session data!
// Note: This requires session.use_cookies to be enabled in php.ini (it usually is).
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, // Set cookie to expire in the past
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Finally, destroy the session.
session_destroy();

// 4. Redirect to the login page.
// Assumes rsvp_login.php is in the same directory.
header('Location: guest_login.php');
exit; // Ensure no further code is executed after redirection.
?>