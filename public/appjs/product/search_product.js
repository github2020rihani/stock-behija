$(document).ready(function () {
    $("#btn_searchProduct").click(function () {
        var desic = $('.desic').val();
        var category = ($('.category').val());

        console.log(desic, category)
        //appel ajax
        $.ajax({
            // url: Routing.generate('searchProduct')
            url: "serch/critere",
            dataType: 'json',
            data: { desic: desic, category: category },
            success: function (data) {
                console.log(data);
                $('.showtables').html('');
                $('.showtables').html(data.result);

            }, error() {
                alert('error')

            }
        })





    })
})

