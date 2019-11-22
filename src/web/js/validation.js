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

function checkEmpty(selector, event){
    if ($(selector).val() === ""){
        $(selector).next().append("<strong>Saisie vide</strong><br>").show();
        event.preventDefault();
        return true;
    }else {
        $(selector).next().html("").hide();
        return false;
    }
}

function samePassword(event){
    if (!checkEmpty(password) && !checkEmpty(confirmPassword) && password.val() !== confirmPassword.val()){
        confirmAlert.append("<strong>Les mots de passe ne correspondent pas.</strong>").show();
        event.preventDefault();
    }
}

confirmPassword.blur(function () {
    samePassword();
});


$("form").submit(function (event) {
    confirmAlert.append("<strong>Les mots de passe ne correspondent pas.</strong>");
    $(".alert").empty();
    $(".toCheck").each(function () {
        checkEmpty(this, event);
    });
    samePassword(event);
    checkMail($("#mail"), event);
});
