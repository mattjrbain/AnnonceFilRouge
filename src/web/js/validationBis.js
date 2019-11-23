

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
    if (password.val() !== "" && confirmPassword.val() !== "" && password.val() !== confirmPassword.val()){
        confirmAlert.append("<strong>Les mots de passe ne correspondent pas.</strong>").show();
    }
}

// Check empty on blur on all input
$(".toCheck").blur(function () {
    checkEmpty(this);
});

// Check same password when leaving password form group
$(".passGroup").focusout(function () {
    samePassword();
});

$("#signup").submit(function (event) {
    //$(".alert").empty();
    $(".toCheck").each(function () {
        if (checkEmpty(this)) {
            event.preventDefault();
        }
    });

});

