(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        let forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        let validation = Array.prototype.filter.call(forms, function(form) {

            let confirmPassword = document.getElementById('confirmPassword');
            let password = document.getElementById("password");
            let confirmAlert = $("#confirmAlert");
            function validatePassword() {
                if (password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity("Les mots de passe doivent être identiques.");
                    confirmAlert.text("Les mots de passe doivent être identiques.").show();
                    event.preventDefault();
                } else {
                    confirmPassword.setCustomValidity("");
                    confirmAlert.text("").hide();
                }
            }

            password.onchange = validatePassword;
            confirmPassword.onkeyup = validatePassword;

            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();