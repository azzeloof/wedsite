<?php
session_start();

// Check if the user is authenticated. If not, redirect to login page.
if (!isset($_SESSION['guest_id'])) {
    // Optional: Set a message for the login page
    // $_SESSION['login_message'] = "Please log in to access the guest portal.";
    header('Location: guest_login.php');
    exit;
}

// --- Include Secure Database Configuration & Connect ---
$db_config = require_once __DIR__ . '/../db_secrets.php'; // Adjust path if needed
$pdo = null; 
try {
    $dsn = "mysql:host=" . ($db_config['DB_HOST'] ?? 'localhost') . ";dbname=" . ($db_config['DB_NAME'] ?? '') . ";charset=" . ($db_config['DB_CHARSET'] ?? 'utf8mb4');
    $pdo_options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $db_config['DB_USER'] ?? '', $db_config['DB_PASS'] ?? '', $pdo_options);
} catch (PDOException $e) {
    error_log("Guest Portal DB Connection Error: " . $e->getMessage());
    $db_connection_error = "Could not connect to the database to retrieve RSVP details. Please try again later or contact us.";
}

// Retrieve guest information from session for personalization
$guest_id_from_session = $_SESSION['guest_id']; // For submitting the RSVP & fetching data
$first_name_1_session = isset($_SESSION['first_name_1']) ? htmlspecialchars($_SESSION['first_name_1']) : 'Guest';
$last_name_1_session = isset($_SESSION['last_name_1']) ? htmlspecialchars($_SESSION['last_name_1']) : '';
$first_name_2_session = isset($_SESSION['first_name_2']) ? htmlspecialchars($_SESSION['first_name_2']) : null;
$last_name_2_session = isset($_SESSION['last_name_2']) ? htmlspecialchars($_SESSION['last_name_2']) : null;
$plus_ones_allowed_session = isset($_SESSION['plus_ones_allowed']) ? (int)$_SESSION['plus_ones_allowed'] : 0;

// Create a greeting name
$greeting_name = $first_name_1_session;
if ($first_name_2_session) {
    $greeting_name .= " & " . $first_name_2_session;
}

// Fetch current RSVP data from database for this guest
$guest_data_from_db = null;
$db_has_rsvpd = false; // Default to false
if ($pdo) { 
    try {
        $stmt = $pdo->prepare("SELECT * FROM guests WHERE guest_id = :guest_id");
        $stmt->execute(['guest_id' => $guest_id_from_session]);
        $guest_data_from_db = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($guest_data_from_db) {
            $db_has_rsvpd = (bool)$guest_data_from_db['has_rsvpd'];
            $_SESSION['has_rsvpd'] = $db_has_rsvpd; // Keep session in sync
        } else {
            error_log("Guest ID " . $guest_id_from_session . " from session not found in DB for guest_portal.php.");
            // This is an anomaly; consider how to handle. For now, will show active form.
        }
    } catch (PDOException $e) {
        error_log("Guest Portal DB Fetch Error: " . $e->getMessage());
        $db_fetch_error = "Could not retrieve your current RSVP details. Please refresh or contact us if the problem persists.";
    }
}

// Handle session messages from submit_rsvp.php or other pages
$rsvp_success_message = null;
if (isset($_SESSION['rsvp_success_message'])) {
    $rsvp_success_message = $_SESSION['rsvp_success_message'];
    unset($_SESSION['rsvp_success_message']);
}

$rsvp_error_message = null; 
if (isset($_SESSION['rsvp_error_message'])) {
    $rsvp_error_message = $_SESSION['rsvp_error_message'];
    unset($_SESSION['rsvp_error_message']);
}

?>

<?php $pg='login'; include("top.php");?>

<body class="d-flex h-100 text-bg-light">
    <div class="d-flex w-100 h-100 py-3 px-4 mx-auto flex-column">
        <?php include("menu.php");?>
        <div class="container my-5">
            <div class="row my-3 align-items-center"> <div class="col"> <h2>Guest Portal - Welcome, <?php echo $greeting_name; ?>!</h2>
                </div>
                <div class="col-auto"> <a href="logout.php" class="btn btn-outline-secondary">Logout</a>
                </div>
            </div>

            <?php if (isset($db_connection_error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($db_connection_error); ?></div>
            <?php endif; ?>
            <?php if (isset($db_fetch_error)): ?>
                <div class="alert alert-warning"><?php echo htmlspecialchars($db_fetch_error); ?></div>
            <?php endif; ?>

            <?php if ($rsvp_success_message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($rsvp_success_message); ?></div>
            <?php endif; ?>
            <?php if ($rsvp_error_message): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($rsvp_error_message); ?></div>
            <?php endif; ?>

            <div class="row my-3 portal-section" id="event-info">
                <h2>Event Information</h2>
                <?php 
                    if (file_exists(__DIR__ . '/../event_info.php')) {
                        include(__DIR__ . '/../event_info.php'); 
                    } else {
                        echo "<p><em>Event details will appear here. (event_info.php not found)</em></p>";
                    }
                ?>
            </div>
            <hr>
            <h3>RSVP</h3>
            <div class="row my-3 portal-section" id="rsvp-section"> 
                <?php if ($db_has_rsvpd && $guest_data_from_db): ?>
                    <p>Your RSVP has been Recorded</p>
                    <p>Thank you! Below are the details you submitted. If you need to make any changes, please reach out to Adam or Sara.</p>
                    <form> <fieldset disabled> 
                <?php else: ?>
                    <p>Kindly RSVP by July 11th, 2025</p>
                    <p>Form submissions are final- if you need to amend your response, you'll have to reach out to Adam or Sara.</p>
                    <form action="submit_rsvp.php" method="POST">
                    <fieldset>
                <?php endif; ?>
                    <h5>Guest Info</h5>
                    <input type="hidden" name="guest_id" value="<?php echo $guest_id_from_session; ?>">
                    <div class="row mx-1 my-3">
                        <h6><?php echo $first_name_1_session . ' ' . $last_name_1_session; ?></h6>
                        <div class="row">
                            <div class="col-auto">
                                <div class="radio-group my-2">
                                    <label class="me-2"><input type="radio" name="guest_1_attending" value="yes" <?php echo ($guest_data_from_db['guest_1_attending'] ?? false) ? 'checked' : ''; ?>> Yes, will attend</label>
                                    <label><input type="radio" name="guest_1_attending" value="no" <?php echo ($guest_data_from_db['guest_1_attending'] === 0 || $guest_data_from_db['guest_1_attending'] === false) ? 'checked' : ''; ?>> No, cannot attend</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto">
                                        <input type="email" class="form-control" name="email_1" placeholder="Email address" value="<?php echo $guest_data_from_db['email_1'];?>">
                                    </div>
                                    <div class="col-auto">
                                        <input type="tel" class="form-control" name="phone_number_1" placeholder="Phone number" value="<?php echo $guest_data_from_db['phone_number_1'];?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($first_name_2_session): // If a second named guest exists on the invitation ?>
                    <div class="row mx-1 my-3">
                        <h6><?php echo $first_name_2_session . ' ' . $last_name_2_session; ?></h6>
                        <div class="row">
                            <div class="col-auto">
                                <div class="radio-group my-2">
                                    <label class="me-2"><input type="radio" name="guest_2_attending" value="yes" <?php echo ($guest_data_from_db['guest_2_attending'] ?? false) ? 'checked' : ''; ?>> Yes, will attend</label>
                                    <label><input type="radio" name="guest_2_attending" value="no" <?php echo ($guest_data_from_db['guest_2_attending'] === 0 || $guest_data_from_db['guest_2_attending'] === false) ? 'checked' : ''; ?>> No, cannot attend</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto">
                                        <input type="email" class="form-control" name="email_2" placeholder="Email address" value="<?php echo $guest_data_from_db['email_2'];?>">
                                    </div>
                                    <div class="col-auto">
                                        <input type="tel" class="form-control" name="phone_number_2" placeholder="Phone number" value="<?php echo $guest_data_from_db['phone_number_2'];?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if ($plus_ones_allowed_session > 0): ?>
                    <h5>Additional Guest(s)</h5>
                    <p>Your invitation allows for <?php echo $plus_ones_allowed_session; ?> additional guest(s).</p>
                    <div class="mb-3">
                        <select name="plus_ones_attending_count" id="plus_ones_attending_count" class="form-select" style="width: auto;">
                            <?php for ($i = 0; $i <= $plus_ones_allowed_session; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo (isset($guest_data_from_db['plus_ones_attending']) && $guest_data_from_db['plus_ones_attending'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?> guest(s)</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    <h5>Transportation</h5>
                    <p>Will your party need transportation to and from the hotel (only on the day of the wedding)? Only available if you are staying at the hotel listed above and are planning on staying for the full duration of the reception.</p>
                    <div class="mb-3">
                        <div class="radio-group my-2">
                            <label class="me-2"><input type="radio" name="needs_transportation" value="yes" <?php echo ($guest_data_from_db['needs_transportation'] ?? false) ? 'checked' : ''; ?>> Yes</label>
                            <label><input type="radio" name="needs_transportation" value="no" <?php echo ($guest_data_from_db['needs_transportation'] === 0 || $guest_data_from_db['needs_transportation'] === false) ? 'checked' : ''; ?>> No</label>
                        </div>
                    </div>
                    <h5>Dietary Restrictions and Allergies</h5>
                    <div class="mb-3">
                        <textarea <?php if ($db_has_rsvpd && $guest_data_from_db): ?> disabled <?php endif; ?> name="dietary_restrictions" id="dietary_restrictions" rows="4" class="form-control" placeholder="e.g., gluten-free, nut allergy, etc."><?php echo htmlspecialchars($guest_data_from_db['dietary_restrictions'] ?? ''); ?></textarea>
                    </div>
                    <br>
                    <input type="submit" value="Submit RSVP" <?php if ($db_has_rsvpd && $guest_data_from_db): ?> class="btn btn-secondary" <?php else: ?> class="btn btn-primary" <?php endif; ?> <?php if ($db_has_rsvpd && $guest_data_from_db): ?> disabled <?php endif; ?>>
                    </fieldset>
                </form>
                    </div></div>
        <?php include("bottom.php");?>
