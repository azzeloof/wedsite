        
        <?php ($pg=='') ? $footer_text_class='text-white-50' : $footer_text_class='text-black-50';?>

        <footer class="mt-auto text-center <?php echo $footer_text_class ?>">
            <p>Copyright 2025, Adam Zeloof and Sara Adkins • <a href="https://github.com/azzeloof/wedsite" target="blank" class="<?php echo $footer_text_class ?>"><i class="bi bi-github"></i></a></p>
        </footer>
    </div>
    <?php include("guest_login.php");?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
(function () {
  'use strict'

  const form = document.querySelector('.needs-validation');
  if (!form) return;

  // --- The "Email or Phone" Validation Logic ---
  const guest1Email = document.getElementById('email_1');
  const guest1Phone = document.getElementById('phone_number_1');
  const contactGroup = document.querySelector('[data-contact-group="guest_1_contact"]');

  function validateGuest1Contact() {
    const emailValue = guest1Email.value.trim();
    const phoneValue = guest1Phone.value.trim();

    if (emailValue === '' && phoneValue === '') {
      // If BOTH are empty, mark them as invalid for feedback
      guest1Email.setCustomValidity("Invalid");
      guest1Phone.setCustomValidity("Invalid");
      contactGroup.classList.add('is-invalid');
      return false;
    } else {
      // If at least ONE has a value, they are valid
      guest1Email.setCustomValidity("");
      guest1Phone.setCustomValidity("");
      contactGroup.classList.remove('is-invalid');
      return true;
    }
  }
  
  // Validate on input to give real-time feedback
  if(guest1Email && guest1Phone) {
    guest1Email.addEventListener('input', validateGuest1Contact);
    guest1Phone.addEventListener('input', validateGuest1Contact);
  }

  // --- Form Submission Logic ---
  form.addEventListener('submit', function (event) {
    // Run our custom contact validation first
    const isContactValid = validateGuest1Contact();

    // Now, check the validity of the rest of the form AND our custom check
    if (!form.checkValidity() || !isContactValid) {
      event.preventDefault();
      event.stopPropagation();
    }

    form.classList.add('was-validated');

    // Manually trigger validation feedback for the contact group if it's invalid
    if (!isContactValid) {
        contactGroup.classList.add('is-invalid');
    }

  }, false)
})()
</script>

</body>
</html>