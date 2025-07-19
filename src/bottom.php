        
        <?php ($pg=='') ? $footer_text_class='text-white-50' : $footer_text_class='text-black-50';?>

        <footer class="mt-auto text-center <?php echo $footer_text_class ?>">
            <p>Copyright 2025, Adam Zeloof and Sara Adkins • <a href="https://github.com/azzeloof/wedsite" target="blank" class="<?php echo $footer_text_class ?>"><i class="bi bi-github"></i></a></p>
        </footer>
    </div>
    <?php include("guest_login.php");?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <?php ($pg=='') ? $footer_text_class='text-white-50' : $footer_text_class='text-black-50';?>

        <footer class="mt-auto text-center <?php echo $footer_text_class ?>">
            <p>Copyright 2025, Adam Zeloof and Sara Adkins • <a href="https://github.com/azzeloof/wedsite" target="blank" class="<?php echo $footer_text_class ?>"><i class="bi bi-github"></i></a></p>
        </footer>
    </div>
    <?php include("guest_login.php");?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
            })
        })()
    </script>
</body>
</html>
