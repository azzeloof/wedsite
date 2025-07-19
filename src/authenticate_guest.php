<?php
session_start();

if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
    $redirect = basename($referer) . '/?login';
} else {
    $redirect = 'what.php/?login';
}

try {
    $secrets_file = __DIR__ . '/../db_secrets.php';
    if (!is_readable($secrets_file)) {
        throw new Exception('db_secrets.php does not exist or is not readable.');
    }
    $db_config = require $secrets_file;

} catch(Exception $e) {
    error_log("Database Configuration Error: " . $e->getMessage());
    $_SESSION['auth_error'] = 'A technical error occurred. This is Adam\'s fault.';
    header('Location: ' . $redirect);
    exit;
}

// --- PDO Database Connection ---
try {
    $pdo = new PDO("mysql:host=" . $db_config['DB_HOST'] . ";dbname=" . $db_config['DB_NAME'] . ";charset=" . $db_config['DB_CHARSET'], $db_config['DB_USER'], $db_config['DB_PASS']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Recommended for security
} catch (PDOException $e) {
    // Log detailed error to a server log file, not to the user.
    error_log("Database Connection Error: " . $e->getMessage());
    $_SESSION['auth_error'] = 'A technical error occurred. This is Adam\'s fault.';
    header('Location: ' . $redirect);
    exit;
}

// --- Process Form Submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted_rsvp_code = isset($_POST['rsvp_code']) ? trim($_POST['rsvp_code']) : '';
    $submitted_last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';

    // Basic validation for empty inputs
    if (empty($submitted_rsvp_code) || empty($submitted_last_name)) {
        $_SESSION['auth_error'] = 'Please enter both your code and last name.';
        header('Location: ' . $redirect);
        exit;
    }

    // Fetch guest details by RSVP code
    $stmt = $pdo->prepare("
        SELECT guest_id, first_name_1, last_name_1, first_name_2, last_name_2, has_rsvpd, plus_ones_allowed
        FROM guests
        WHERE rsvp_code = :rsvp_code
    ");
    $stmt->execute(['rsvp_code' => $submitted_rsvp_code]);
    $invitation_details = $stmt->fetch(PDO::FETCH_ASSOC);

    $authenticated = false;

    if ($invitation_details) {
        // Normalize submitted last name for case-insensitive comparison
        $normalized_submitted_last_name = strtolower($submitted_last_name);

        // Normalize stored last names for comparison
        $normalized_db_last_name_1 = strtolower(trim($invitation_details['last_name_1']));
        $normalized_db_last_name_2 = null;
        if (!empty($invitation_details['last_name_2'])) {
            $normalized_db_last_name_2 = strtolower(trim($invitation_details['last_name_2']));
        }

        // Check if submitted last name matches either stored last name
        if ($normalized_db_last_name_1 === $normalized_submitted_last_name ||
            ($normalized_db_last_name_2 !== null && $normalized_db_last_name_2 === $normalized_submitted_last_name)) {
    
            // Authentication successful, store details in session
            $_SESSION['guest_id'] = $invitation_details['guest_id'];
            $_SESSION['rsvp_code'] = $submitted_rsvp_code; // Could be useful
            $_SESSION['first_name_1'] = $invitation_details['first_name_1'];
            $_SESSION['last_name_1'] = $invitation_details['last_name_1'];
            $_SESSION['first_name_2'] = $invitation_details['first_name_2'];
            $_SESSION['last_name_2'] = $invitation_details['last_name_2'];
            $_SESSION['plus_ones_allowed'] = $invitation_details['plus_ones_allowed'];
                
            // Clear any previous auth errors
            unset($_SESSION['auth_error']);
                
            header('Location: guest_portal.php'); // Redirect to the main RSVP form
            exit;
        } else {
            // Code was correct, but last name didn't match records for that code
            $_SESSION['auth_error'] = 'The code is valid, but the last name does not match our records for that code. Please check your invitation.';
            header('Location: ' . $redirect);
            exit;
        }
    } else {
        // RSVP code not found in the database
        $_SESSION['auth_error'] = 'Invalid code or last name. Please check your invitation and try again.';
        header('Location: ' . $redirect);
        exit;
    }
} else {
    // If accessed directly via GET or other methods, redirect to login
    header('Location: ' . $redirect);
    exit;
}
?>