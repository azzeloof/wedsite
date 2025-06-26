<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-bg-light text-start">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Guest Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <p>Enter your last name and login code (from the invitation you received) to unlock the RSVP form, along with extra info.</p>
                    <p>If you are unable to log in, just reach out to Adam or Sara. Adam wrote this RSVP handler system himself so it probably doesn't work very well.</p>
                    <div>

                        <?php
                            if (isset($_SESSION['auth_error'])) {
                                echo '<p style="color:red;">' . htmlspecialchars($_SESSION['auth_error']) . '</p>';
                                unset($_SESSION['auth_error']); // Clear error after displaying
                            }
                        ?>
                        <form action="/authenticate_guest.php" method="POST">
                            <label for="rsvp_code">Your Code:</label><br>
                            <input type="text" id="rsvp_code" name="rsvp_code" required><br><br>
                                
                            <label for="last_name">Your Last Name:</label><br>
                            <input type="text" id="last_name" name="last_name" required><br><br>
                                
                            <input class="btn btn-primary" type="submit" value="Enter Guest Portal">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
