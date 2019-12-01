// window.addEventListener("load", function (event) {
//     let confirmPassword = document.getElementById('confirmPassword');
//     let password = document.getElementById("password");
//     let confirmAlert = $("#confirmAlert");
//     function validatePassword() {
//         if (password.value !== confirmPassword.value) {
//             confirmPassword.setCustomValidity("Les mots de passe doivent être identiques.");
//             confirmAlert.text("Les mots de passe doivent être identiques.").show();
//             event.preventDefault();
//         } else {
//             confirmPassword.setCustomValidity("");
//             confirmAlert.text("").hide();
//         }
//     }
//
//     password.onchange = validatePassword;
//     confirmPassword.onkeyup = validatePassword;
//
// });

// $(document).ready(function (event) {
//     let confirmPassword = $("#confirmPassword");
//     let password = $("#password");
//
//     function validatePassword() {
//         if (password.val() !== confirmPassword.val()) {
//             confirmPassword.setCustomValidity("Les mots de passe doivent être identiques.");
//             event.preventDefault();
//         } else {
//             confirmPassword.setCustomValidity("");
//         }
//     }
//     password.change(function () {
//         validatePassword();
//     });
//     password.change(function () {
//         validatePassword();
//     });
//
//     // confirmPassword.onchange = validatePassword;
// });

