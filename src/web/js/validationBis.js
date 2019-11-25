let confirmPassword = $("#confirmPassword");
let confirmAlert = $("#confirmAlert");
let password = $("#password");
let mail = $("#mail");

function checkEmpty(selector){
    if ($(selector).val() === ""){
        $(selector).next().html("<strong>Saisie vide</strong><br>").show();
        return true;
    }else {
        $(selector).next().html("").hide();
        return false;
    }
}

function samePassword(){
    if (password.val() !== confirmPassword.val()){
        confirmAlert.append("<strong>Les mots de passe ne correspondent pas.</strong>").show();
        return false;
    }else return true;
}

function checkMail(selector) {
    if (!$(selector).val().match(/[a-zA-Z\d]+@[a-zA-Z\d]+\.[a-z\d]+/)){
        $(selector).next().append("<strong>Format de mail incorrect</strong>").show();
        return false;
    }else {
        $(selector).next().html("").hide();
        return true;
    }
}

// Check empty on blur on all input
$(".toCheck").blur(function () {
    checkEmpty(this);
});

// Check same password when leaving password form group
confirmPassword.blur(function () {
    samePassword();
});

// Check mail format on blur
mail.blur(function () {
    checkMail(mail);
});

// Check when submitting form
$("#signup").submit(function (event) {
    $(".toCheck").each(function () {
        if (checkEmpty(this)) {
            event.preventDefault();
        }
    });
    if (!samePassword()){
        event.preventDefault();
    }
    if (!checkMail(mail)){
        event.preventDefault();
    }
});

$("#addAnnonce").submit(function event() {
    $(".toCheck").each(function () {
        if (checkEmpty(this)) {
            event.preventDefault();
        }
    });
});

