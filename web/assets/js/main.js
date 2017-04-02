$(document).ready(function(){

    $(document).on("click", ".load-table", function () {
        $('.loading').show();

        var request = {
            url: '/load_countries',
            type: 'GET',
            dataType: 'json'
        }

        $.ajax(request).done(function(data, textStatus, jqXHR){
            $('.loading').hide();
            alert(data.message);

            location.reload();

        }).fail(function(data, textStatus, jqXHR) {
            $('.loading').hide();
            alert("Oops, parece que houve um problema na requisição");
        });
    });

});