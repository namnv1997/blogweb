function paginationCallDataComment(page, max) {
    if (page == 1) {
        $(".previous-li-comment").css('display', 'none');
        $(".next-li-comment").css('display', 'inline');
    } else if (page == max) {
        $(".next-li-comment").css('display', 'none');
        $(".previous-li-comment").css('display', 'inline');
    } else {
        $(".previous-li-comment").css('display', 'inline');
        $(".next-li-comment").css('display', 'inline');
    }
    $.ajax({
        url: "app/controllers/admin/CommentController.php?fnc=changePaginationComment",
        type: "post",
        dataType: "json",
        data: {
            comment_pagination: page
        },
        success: function (result) {
            var html = '';
            $('#comment_display').empty();

            $.each(result, function (i, item) {
                if (item.status== 0){
                    var $stt = 'Disable';
                    var $btn_option = '<div class="column-table text-center" style="width: 200px;"> ' +
                                        '<button class="btn btn-primary cmt-option" value="1" data-id="'+item.cmt_id+'" >Enable</button> </div>';
                }else{
                    var $stt = 'Enable';
                    var $btn_option = '<div class="column-table text-center "  style="width: 200px;"> ' +
                                        '<button class="btn btn-danger cmt-option" value="0" data-id="'+item.cmt_id+'">Disable</button></div>';
                }

                html += '<div class="row-table">';
                html += '<div class="column-table text-center" style="width:60px;">' + item.cmt_id + '</div>';
                html += '<div class="column-table text-center" style="width:60px;">' + item.user_id + '</div>';
                html += '<div class="column-table text-center" style="width:60px;">' + item.post_id + '</div>';
                html += '<div class="column-table text-center" style="width:550px;">' + item.comment + '</div>';
                html += '<div class="column-table text-center" style="width: 80px;">' +$stt+ '</div>';
                html += $btn_option;
                html += '</div>';
            });
            $('#comment_display').append(html);
        }
    });

}

$(document).ready(function () {
    $(document).on('click', '.comment-previous', function () {
        var page = $('.active-me-comment').data('page') - 1;
        var max = $('.active-me-comment').data('max-page');

        var un_active = "pagi-comment-" + (Number(page) + Number(1));
        var active = "pagi-comment-" + Number(page);
        $('#' + un_active + '').removeClass("active-me-comment");
        $('#' + active + '').addClass("active-me-comment");
        paginationCallDataComment(page, max);

    });

    $(document).on('click', '.cmt-option', function () {
       var stt= $(this).val();
       var cmt_id = $(this).data('id');

        $.ajax({
            url: "app/controllers/admin/CommentController.php?fnc=confirmComment",
            type: "post",
            dataType: "text",
            data: {
                cmt_id: cmt_id,
                status: stt
            },
            success: function (result) {
                location.reload();
            }
        });

    });

    $(document).on('click', '.comment-next', function () {
        var page = Number($('.active-me-comment').data('page')) + Number(1);
        var max = $('.active-me-comment').data('max-page');

        var un_active = "pagi-comment-" + (Number(page) - Number(1));
        var active = "pagi-comment-" + Number(page);
        $('#' + un_active + '').removeClass("active-me-comment");
        $('#' + active + '').addClass("active-me-comment");

        paginationCallDataComment(page, max);
    });


    $(".pagination-comment li a").click(function () {
        var page = $(this).data('page');
        var max = $(this).data('max-page');

        $(".pagination-comment li a").removeClass("active-me-comment");
        $(this).addClass("active-me-comment");

        paginationCallDataComment(page, max);
    });
});
