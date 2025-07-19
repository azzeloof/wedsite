<?php

session_start();
$errors = [];

if (empty($_POST['guest_1_attending'])) {
    $errors[] = "Please select an attendance option for Guest 1.";
}

if (empty($_POST['email_1']) && empty($_POST['phone_number_1'])) {
    $errors[] = "Please provide an email or phone number for Guest 1.";
}

if (isset($_SESSION['first_name_2']) && !empty($_SESSION['first_name_2'])) {
    if (empty($_POST['guest_2_attending'])) {
        $errors[] = "Please select an attendance option for Guest 2.";
    }
}

if (empty($_POST['needs_transportation'])) {
    $errors[] = "Please select a transportation option.";
}

if (!empty($errors)) {
    // Join all error messages into a single string.
    $_SESSION['rsvp_error_message'] = implode('<br>', $errors);
    header('Location: guest_portal.php');
    exit;
}

if (!isset($_SESSION['guest_id'])) {
    // Not authenticated or session expired, redirect to login
    $_SESSION['auth_error'] = "Your session has expired. Please log in again to RSVP.";
    header('Location: rsvp_login.php');
    exit;
}
$guest_id_from_session = (int)$_SESSION['guest_id'];

$db_config = require_once __DIR__ . '/../db_secrets.php';

try {
    $dsn = "mysql:host=" . $db_config['DB_HOST'] . ";dbname=" . $db_config['DB_NAME'] . ";charset=" . $db_config['DB_CHARSET'];
    $pdo_options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $db_config['DB_USER'], $db_config['DB_PASS'], $pdo_options);
} catch (PDOException $e) {
    error_log("RSVP DB Connection Error: " . $e->getMessage());
    $_SESSION['rsvp_error_message'] = 'A technical error occurred with the database. Please try again later.';
    header('Location: guest_portal.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: guest_portal.php'); // Redirect if not POST
    exit;
}

try {
    $checkStmt = $pdo->prepare("SELECT has_rsvpd FROM guests WHERE guest_id = :guest_id");
    $checkStmt->execute(['guest_id' => $guest_id_from_session]);
    $current_status = $checkStmt->fetch();

    if ($current_status && $current_status['has_rsvpd']) {
        $_SESSION['rsvp_error_message'] = "Your RSVP has already been recorded. If you need to make changes, please contact us directly.";
        // Update session variable to reflect this, so portal page hides the form
        $_SESSION['has_rsvpd'] = true; 
        header('Location: guest_portal.php');
        exit;
    }
} catch (PDOException $e) {
    error_log("RSVP Check Error: " . $e->getMessage());
    $_SESSION['rsvp_error_message'] = 'Could not verify current RSVP status. Please try again.';
    header('Location: guest_portal.php');
    exit;
}

$missing_data = false;
if (isset($_POST['guest_1_attending'])) {
    $guest_1_attending_raw = $_POST['guest_1_attending'];
    $guest_1_attending = ($guest_1_attending_raw === 'yes') ? 1 : 0; // true if 'yes', false otherwise
} else {
    $guest_1_attending_raw = null;
    $guest_1_attending = null;
    $missing_data = true;
}

if (isset($_POST['email_1'])) {
    $email_1 = trim($_POST['email_1']);
} else {
    $email_1 = null;
    $missing_data = true;
}

if (isset($_POST['phone_number_1'])) {
    $phone_number_1 = trim($_POST['phone_number_1']);
} else {
    $phone_number_1 = null;
    $missing_data = true;
}

$guest_2_exists_in_session = !empty($_SESSION['first_name_2']);
$guest_2_attending = null; // Default to null if guest 2 doesn't exist

if ($guest_2_exists_in_session) {
    if (isset($_POST['guest_2_attending'])) {
        $guest_2_attending_raw = $_POST['guest_2_attending'];
        $guest_2_attending = ($guest_2_attending_raw === 'yes') ? 1 : 0; // true if 'yes', false otherwise
    } else {
        $guest_2_attending_raw = null;
        $guest_2_attending = null;
        $missing_data = true;
    }
}

$email_2 = isset($_POST['email_2']) ? trim($_POST['email_2']) : null;
$phone_number_2 = isset($_POST['phone_number_2']) ? trim($_POST['phone_number_2']) : null;


$plus_ones_allowed_from_session = isset($_SESSION['plus_ones_allowed']) ? (int)$_SESSION['plus_ones_allowed'] : 0;
$plus_ones_attending_count = 0;
if ($plus_ones_allowed_from_session > 0) {
    $plus_ones_attending_count = isset($_POST['plus_ones_attending_count']) ? (int)$_POST['plus_ones_attending_count'] : 0;
    // Validate against allowed number
    if ($plus_ones_attending_count < 0 || $plus_ones_attending_count > $plus_ones_allowed_from_session) {
        $_SESSION['rsvp_error_message'] = "The number of additional guests selected is not valid.";
        // Consider storing POST data in session to repopulate form: $_SESSION['form_data_attempt'] = $_POST;
        header('Location: guest_portal.php');
        exit;
    }
}


if (isset($_POST['needs_transportation'])) {
    $needs_transportation_raw = $_POST['needs_transportation'];
    $needs_transportation = ($needs_transportation_raw === 'yes') ? 1 : 0; // true if 'yes', false otherwise
} else {
    $needs_transportation_raw = null;
    $needs_transportation = null;
    $missing_data = true;
}


$dietary_restrictions = isset($_POST['dietary_restrictions']) ? trim($_POST['dietary_restrictions']) : null;

if ($missing_data) {
    $_SESSION['rsvp_error_message'] = "Please fill out all required fields.";
    header('Location: guest_portal.php');
    exit;
}

// 6. Update Database
try {
    $updateSql = "UPDATE guests SET
                    guest_1_attending = :guest_1_attending,
                    guest_2_attending = :guest_2_attending,
                    plus_ones_attending = :plus_ones_attending,
                    email_1 = :email_1,
                    phone_number_1 = :phone_number_1,
                    email_2 = :email_2,
                    phone_number_2 = :phone_number_2,
                    needs_transportation = :needs_transportation,
                    dietary_restrictions = :dietary_restrictions,
                    has_rsvpd = TRUE,
                    submission_timestamp = NOW()
                  WHERE guest_id = :guest_id";
    
    $stmt = $pdo->prepare($updateSql);
    
    $stmt->execute([
        'guest_1_attending' => $guest_1_attending,
        'guest_2_attending' => $guest_2_attending, // Will be null if guest 2 doesn't exist or not attending
        'email_1' => $email_1,
        'phone_number_1' => $phone_number_1,
        'email_2' => $email_2,
        'phone_number_2' => $phone_number_2,
        'needs_transportation' => $needs_transportation,
        'plus_ones_attending' => $plus_ones_attending_count,
        'dietary_restrictions' => $dietary_restrictions,
        'guest_id' => $guest_id_from_session
    ]);

    $greeting_name = $_SESSION['first_name_1'];
    if ($_SESSION['first_name_2']) {
        $greeting_name .= " & " . $_SESSION['first_name_2'];
    }

    $_SESSION['rsvp_success_message'] = "Thank you, " . $greeting_name . "! Your RSVP has been successfully submitted.";
    $_SESSION['has_rsvpd'] = true; // Update session so portal page can hide the form

    if(isset($_SESSION['form_data_attempt'])) unset($_SESSION['form_data_attempt']);

    header('Location: guest_portal.php'); // Redirect back to portal (it will show success msg & no form)
    exit;

} catch (PDOException $e) {
    error_log("RSVP Submission DB Error: " . $e->getMessage() . " for guest ID: " . $guest_id_from_session . " with data: " . http_build_query($_POST));
    $_SESSION['rsvp_error_message'] = "We encountered a database problem while submitting your RSVP. Please make sure everything is filled out and try again, or contact us directly if the issue persists.";
    
    header('Location: guest_portal.php');
    exit;
}
?>