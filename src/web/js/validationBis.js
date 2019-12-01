let confirmPassword = $("#confirmPassword");
let confirmAlert = $("#confirmAlert");
let password = $("#password");
let mail = $("#mail");

// $(function () {
//     $('[data-toggle="popover"]').popover();
// });
//
// function checkEmpty(selector){
//     if ($(selector).val() === ""){
//         $(selector).next().html("<strong>Saisie vide</strong><br>").show();
//         return true;
//     }else {
//         $(selector).next().html("").hide();
//         return false;
//     }
// }

function samePassword(){
    if (password.val() !== confirmPassword.val()){
        confirmAlert.text("Les mots de passe doivent être identiques.").show();
        $("form").checkValidity() === false;
        return false;
    }else {
        confirmAlert.text("").hide();
        return true;
    }
}

// function checkMail(selector) {
//     if (!$(selector).val().match(/[a-zA-Z\d]+@[a-zA-Z\d]+\.[a-z\d]+/)){
//         $(selector).next().append("<strong>Format de mail incorrect</strong>").show();
//         $(selector).popover({content: "Format de mail incorrect"});
//         return false;
//     }else {
//         $(selector).next().html("").hide();
//         return true;
//     }
// }
//
// // Check empty on blur on all input
// $(".toCheck").blur(function () {
//     checkEmpty(this);
// });

// Check same password when leaving password form group
confirmPassword.blur(function () {
    samePassword();
});

// Check mail format on blur
// mail.blur(function () {
//     checkMail(mail);
// });

// Check when submitting form
// $("#signup").submit(function (event) {
//     $(".toCheck").each(function () {
//         if (checkEmpty(this)) {
//             event.preventDefault();
//         }
//     });
//     if (!samePassword()){
//         event.preventDefault();
//     }
//     if (!checkMail(mail)){
//         event.preventDefault();
//     }
// });
//
// $("#addAnnonce").submit(function event() {
//     $(".toCheck").each(function () {
//         if (checkEmpty(this)) {
//             event.preventDefault();
//         }
//     });
// });

