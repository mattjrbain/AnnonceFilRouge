// Exercice 1


// $("button").click(function () {
//     $(this).next().next().slideToggle();
// });

// Exercice 2
$("button").click(function () {
    $("button").not(this).next().next().hide();
    $(this).next().next().show();
});

// Exercice 3

let mail = $("#mail");
$("form").submit(function (event) {
    checkEmpty($("#nomId"), event);
    checkEmpty($("#pass"), event);
    checkMail(mail, event);
    checkPhone($("#phone"), event);
});

function checkEmpty(selector, event){
    if ($(selector).val() === ""){
        $(selector).next().text("Pas bien c'est vide.").show();
        event.preventDefault();
    }else {
        $(selector).next().html("").hide();
    }
}

function checkNumeric(selector, event){
    if (!$.isNumeric(selector).val()){
        $(selector).next().html("Pas bien c'est pas des chiffres.").show();
        event.preventDefault();
    }else {
        $(selector).next().html("").hide();
    }
}

function checkMail(selector, event) {
    if (!$(selector).val().match(/[a-zA-Z\d]+@[a-zA-Z\d]+\.[a-z\d]+/)){
        $(selector).next().html("Pas bien c'est pas mail ou c est vide").show();
        event.preventDefault();
    }else {
        $(selector).next().html("").hide();
    }
}
function checkPhone(selector, event) {
    if (!$(selector).val().match(/\d{10}/)){
        $(selector).next().html("Pas bien c'est pas numéro ou c est vide").show();
        event.preventDefault();
    }else {
        $(selector).next().html("").hide();
    }
}

//Exercice 4

