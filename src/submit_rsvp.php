<?php
session_start();

// 1. Check if user is authenticated
if (!isset($_SESSION['guest_id'])) {
    // Not authenticated or session expired, redirect to login
    $_SESSION['auth_error'] = "Your session has expired. Please log in again to RSVP.";
    header('Location: rsvp_login.php');
    exit;
}
$guest_id_from_session = (int)$_SESSION['guest_id'];

// 2. Include Secure Database Configuration & Connect
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

// 3. Ensure it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: guest_portal.php'); // Redirect if not POST
    exit;
}

// 4. Double-check if already RSVP'd (additional safeguard)
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


// 5. Retrieve and Process Form Data
// Guest 1
$guest_1_attending_raw = isset($_POST['guest_1_attending']) ? $_POST['guest_1_attending'] : null;
$guest_1_attending = ($guest_1_attending_raw === 'yes'); // true if 'yes', false otherwise

$email_1 = isset($_POST['email_1']) ? trim($_POST['email_1']) : null;
$phone_number_1 = isset($_POST['phone_number_1']) ? trim($_POST['phone_number_1']) : null;

// Guest 2 (process only if guest 2 exists based on session data)
$guest_2_exists_in_session = !empty($_SESSION['first_name_2']); // Or however you track this
$guest_2_attending = null; // Default to null if guest 2 doesn't exist

$email_2 = isset($_POST['email_2']) ? trim($_POST['email_2']) : null;
$phone_number_2 = isset($_POST['phone_number_2']) ? trim($_POST['phone_number_2']) : null;

if ($guest_2_exists_in_session) {
    $guest_2_attending_raw = isset($_POST['guest_2_attending']) ? $_POST['guest_2_attending'] : null;
    $guest_2_attending = ($guest_2_attending_raw === 'yes');
}

// Plus Ones
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

// Other fields
$needs_transportation_raw = isset($_POST['needs_transportation']) ? $_POST['needs_transportation'] : null;
$needs_transportation = ($needs_transportation_raw === 'yes'); // true if 'yes', false otherwise
$dietary_restrictions = isset($_POST['dietary_restrictions']) ? trim($_POST['dietary_restrictions']) : null;


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

    // 7. Success Feedback and Session Update
    $_SESSION['rsvp_success_message'] = "Thank you, " . htmlspecialchars($greeting_name) . "! Your RSVP has been successfully submitted.";
    $_SESSION['has_rsvpd'] = true; // Update session so portal page can hide the form

    // Optional: Clear any temporary form data attempt from session
    if(isset($_SESSION['form_data_attempt'])) unset($_SESSION['form_data_attempt']);

    header('Location: guest_portal.php'); // Redirect back to portal (it will show success msg & no form)
    // Alternatively, redirect to a dedicated thank_you.php page:
    // header('Location: thank_you.php');
    exit;

} catch (PDOException $e) {
    error_log("RSVP Submission DB Error: " . $e->getMessage() . " for guest ID: " . $guest_id_from_session . " with data: " . http_build_query($_POST));
    $_SESSION['rsvp_error_message'] = "We encountered a database problem while submitting your RSVP. Please try again or contact us directly if the issue persists.";
    
    // Optional: Store submitted data in session to re-populate form upon redirect
    // $_SESSION['form_data_attempt'] = $_POST; 
    
    header('Location: guest_portal.php');
    exit;
}
?>