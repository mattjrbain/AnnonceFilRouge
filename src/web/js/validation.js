let confirmPassword = $("#confirmPassword");
let confirmAlert = $("#confirmAlert");
let password = $("#password");

function checkMail(selector, event) {
    if (!$(selector).val().match(/[a-zA-Z\d]+@[a-zA-Z\d]+\.[a-z\d]+/)){
        $(selector).next().append("<strong>Format de mail incorrect</strong>").show();
        event.preventDefault();
    }else {
        $(selector).next().html("").hide();
    }
}

// function checkEmpty(selector, event){
//     if ($(selector).val() === ""){
//         $(selector).next().append("<strong>Saisie vide</strong><br>").show();
//         event.preventDefault();
//         return true;
//     }else {
//         $(selector).next().html("").hide();
//         return false;
//     }
// }

// function samePassword(event){
//     if (password.val() !== "" && confirmPassword.val() !== "" && password.val() !== confirmPassword.val()){
//         confirmAlert.append("<strong>Les mots de passe ne correspondent pas.</strong>").show();
//         event.preventDefault();
//     }
// }

confirmPassword.blur(function () {
    samePassword();
});

// $(".toCheck").each().blur(function () {
//     checkEmpty(this);
// });

$("#signup").submit(function (event) {
    $(".alert").empty();
    $(".toCheck").each(function () {
        checkEmpty(this);
    });
    samePassword();
    checkMail($("#mail"), event);
});
