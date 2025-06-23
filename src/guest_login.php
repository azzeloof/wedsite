
<?php $pg='login'; include("top.php");?>
<?php session_start(); ?>
<body class="d-flex h-100 text-bg-light">
    <div class="d-flex w-100 h-100 py-3 px-4 mx-auto flex-column">
        <?php include("menu.php");?>
        <div class="container my-5">
            <div class="row">
                <div class="row py-3">
                    <h1>Guest Login</h1>
                    <p>Enter your last name and login code (from the invitation you received) to unlock the RSVP form, along with extra info.</p>
                    <p>If you are unable to log in, just reach out to Adam or Sara. Adam wrote this RSVP handler system himself so it probably doesn't work very well.</p>
                </div>
                <div>

                    <?php
                        if (isset($_SESSION['auth_error'])) {
                            echo '<p style="color:red;">' . htmlspecialchars($_SESSION['auth_error']) . '</p>';
                            unset($_SESSION['auth_error']); // Clear error after displaying
                        }
                    ?>
                    <form action="authenticate_guest.php" method="POST">
                        <label for="rsvp_code">Your Code:</label><br>
                        <input type="text" id="rsvp_code" name="rsvp_code" required><br><br>
                            
                        <label for="last_name">Your Last Name:</label><br>
                        <input type="text" id="last_name" name="last_name" required><br><br>
                            
                        <input type="submit" value="Enter Guest Portal">
                    </form>
                </div>
            </div>
        </div>

<?php include("bottom.php");?>