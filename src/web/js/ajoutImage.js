let compteurImage = $(".photo").length;

$("#ajoutImage").click(function () {
    if (compteurImage < 4){
        $("#divAjoutImage").append('<input type="file" class="form-control-file photo" id="photo' + compteurImage +'" name="photo' + compteurImage +'">');
        compteurImage++;
    }
})