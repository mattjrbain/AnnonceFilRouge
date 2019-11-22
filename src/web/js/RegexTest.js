let form = document.getElementById('form');
form.addEventListener("submit", function (event) {
    let num = document.getElementById('phone').value;
    let phoneMess = document.getElementById('phoneMess');
    let regex = RegExp('^\\d{10}$');
    if(regex.test(num)){
        phoneMess.textContent = ' glop';
        event.preventDefault();
    }else {
        phoneMess.textContent = 'pas Glop';
        event.preventDefault();

    }


    let codePos = document.getElementById('code').value;


});

