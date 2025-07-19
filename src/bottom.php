        
        <?php $footer_text_class = ($pg == '') ? 'text-white-50' : 'text-black-50'; ?>

        <footer class="mt-auto text-center <?php echo $footer_text_class ?>">
            <p>Copyright 2025, Adam Zeloof and Sara Adkins • <a href="https://github.com/azzeloof/wedsite" target="blank" class="<?php echo $footer_text_class ?>"><i class="bi bi-github"></i></a></p>
        </footer>
    </div>
    <?php include("guest_login.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        (function() {
            'use strict'

            const form = document.querySelector('.needs-validation');
            if (!form) return;

            const guest1Email = document.getElementById('email_1');
            const guest1Phone = document.getElementById('phone_number_1');
            const contactGroup = document.querySelector('[data-contact-group="guest_1_contact"]');

            function validateGuest1Contact() {
                const emailValue = guest1Email.value.trim();
                const phoneValue = guest1Phone.value.trim();

                if (emailValue === '' && phoneValue === '') {
                    guest1Email.setCustomValidity("Invalid");
                    guest1Phone.setCustomValidity("Invalid");
                    contactGroup.classList.add('is-invalid');
                    return false;
                } else {
                    guest1Email.setCustomValidity("");
                    guest1Phone.setCustomValidity("");
                    contactGroup.classList.remove('is-invalid');
                    return true;
                }
            }

            if (guest1Email && guest1Phone) {
                guest1Email.addEventListener('input', validateGuest1Contact);
                guest1Phone.addEventListener('input', validateGuest1Contact);
            }

            form.addEventListener('submit', function(event) {
                const isContactValid = validateGuest1Contact();

                if (!form.checkValidity() || !isContactValid) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');

                if (!isContactValid) {
                    contactGroup.classList.add('is-invalid');
                }

            }, false)
        })()
    </script>

    </body>

    </html>