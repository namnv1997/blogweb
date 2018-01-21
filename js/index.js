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
var offset = 3;
$(window).scroll(function () {
    if ($(window).scrollTop() == $(document).height() - $(window).height()) {
        $.ajax({
            url: "admin/PostController.php?fnc=getMorePost",
            type: "post",
            dataType: "json",
            data: {
                offset: offset
            },
            success: function (result) {
                var html = '';
                $.each(result, function (i, item) {
                    html += '<div class="div-post row" >' +
                        '<div class="col-md-4">' +
                        '<img src=" ' + item.image + ' " class="imgPost"/>' +
                        '</div>' +
                        '<div class="col-md-8">' +
                        '<p class="title-post"> ' + item.title + ' </p>' +
                        '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>' +
                        '<span class="color808080">' + item.date + '</span>' +
                        '<input type="hidden" id="id_post" name="id_post">' +
                        '<p class="text-summary"> ' + item.summary + '</p>' +
                        '<button type="button" class="btn btn-info btn-read-more margin-top8" data-id="' + item.id +' ">Read More</button>' +
                        '</div>' +
                        '</div>';
                });
                $('#content_area').append(html);
            },
            beforeSend: function () {
                $('#modal-loading').modal('toggle');
            },
            complete: function () {
                $('#modal-loading').modal('hide');
                offset += 3;
            }

        });
    }
});