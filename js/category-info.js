$(document).ready(function (e) {
    $(document).on('click', '.btn-read-more', function () {
        var id = $(this).data('id');
        $('#id_post').val(id);
        window.location.href = 'http://localhost/CoffeWebsite/views/frontend/details.php?id_post= '+id+' ';
    });

    $(document).on('click', '#btn-log-out', function () {
        $.ajax({
            url: "index.php",
            type: "post",
            dataType: "text",
            data: {
                destroy: 1
            },
            success: function (result) {
                location.reload();
            },

        });

    });

})