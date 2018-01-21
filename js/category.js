function paginationCallData(page, max) {
    if (page == 1) {
        $(".previous").css('display', 'none');
        $(".next").css('display', 'inline');
    } else if (page == max) {
        $(".next").css('display', 'none');
        $(".previous").css('display', 'inline');
    } else {
        $(".previous").css('display', 'inline');
        $(".next").css('display', 'inline');
    }
    $.ajax({
        url: "app/controllers/admin/CategoryController.php?fnc=changePaginationCategory",
        type: "post",
        dataType: "json",
        data: {
            category_pagination: page
        },
        success: function (result) {
            var html = '';
            $('#category_display').empty();

            $.each(result, function (i, item) {
                html += '<div class="row-table" data-id="' + item.id + '" data-name="' + item.name + '">';
                html += '<div class="column-table " style="min-width: 30px;">' + item.id + '</div>';
                html += '<div class="column-table minw250">' + item.name + '</div>';
                html += '<button type="button" class="btn btn-primary btnUD edit-category" data-toggle="modal" ' +
                    'data-target=".edit-category-modal">&nbsp Edit &nbsp </button>';
                html += '<button class="btn btn-danger btnUD delete-category" data-toggle="modal" ' +
                    'data-target=".delete-category-modal">Delete</button>';
                html += '</div>';
            });
            $('#category_display').append(html);
        }
    });

}

$(document).ready(function () {
        $(document).on('click', '.category-previous', function () {
            var page = $('.active-me').data('page') - 1;
            var max = $('.active-me').data('max-page');

            var un_active = "pagi-" + (Number(page) + Number(1));
            var active = "pagi-" + Number(page);
            $('#' + un_active + '').removeClass("active-me");
            $('#' + active + '').addClass("active-me");
            paginationCallData(page, max);

        });

        $(document).on('click', '.category-next', function () {
            var page = Number($('.active-me').data('page')) + Number(1);
            var max = $('.active-me').data('max-page');

            var un_active = "pagi-" + (Number(page) - Number(1));
            var active = "pagi-" + Number(page);
            $('#' + un_active + '').removeClass("active-me");
            $('#' + active + '').addClass("active-me");

            paginationCallData(page, max);
        });


        $(".pagination-category li a").click(function () {
            var page = $(this).data('page');
            var max = $(this).data('max-page');

            $(".pagination-category li a").removeClass("active-me");
            $(this).addClass("active-me");

            paginationCallData(page, max);
        });

        $("#btn_add_cate").click(function () {
            var $name_category = $('#category_name').val().trim();

            if (!$name_category) {
                $.alert({
                    title: 'Warning!',
                    content: 'Please input Category Name',
                });

            } else {
                $.ajax({
                    url: "app/controllers/admin/CategoryController.php?fnc=getNameCategory",
                    type: "post",
                    dataType: "text",
                    data: {
                        name_request: $name_category
                    },
                    success: function (result) {
//                            result la mang category tra ve
                        var res = result.split(",");
                        var isExist = false;

//                            check xem category nhap co ton tai hay khong
                        res.forEach(function (element) {
                            if ($name_category == element) {
                                isExist = true;
                            }
                        });
//                            xu li ket qua
                        if (isExist == true) {
                            $.alert({
                                title: 'Warning!',
                                content: $name_category + ' is exist',
                            });
                        } else {
                            $('#add_category').submit();
                        }

                    }
                });

            }
            return false;
        });


        <!-- edit  click button -->

        $(document).on('click', ".edit-category", function () {
            $('#category_name_edit').val('');
            var id = $(this).closest("div").data("id");
            $("#btn_edit_cate").click(function () {

                var $name_category_edit = $('#category_name_edit').val().trim();
                if (!$name_category_edit) {
                    $.alert({
                        title: 'Warning!',
                        content: 'Please input Category Name',
                    });
                } else {
                    $('#category_id_edit').val(id);
                    $.ajax({
                        url: "app/controllers/admin/CategoryController.php?fnc=getNameCategory",
                        type: "post",
                        dataType: "text",
                        data: {
                            name_request: $name_category_edit
                        },
                        success: function (result) {
//                            result la mang category tra ve
                            var res = result.split(",");
                            var isExist = false;
                            console.log(res);

//                            check xem category nhap co ton tai hay khong
                            res.forEach(function (element) {
                                if ($name_category_edit == element) {
                                    isExist = true;
                                }
                            });
//                            xu li ket qua
                            if (isExist == true) {
                                $.alert({
                                    title: 'Warning!',
                                    content: $name_category_edit + ' is exist',
                                });
                            } else {
                                $('#edit_category').submit();
                            }

                        }
                    });
                }
                return false;
            });

        });

        $(document).on('click', "#btn_edit_cancel", function () {
            $('.edit-category-modal').modal('toggle');
        });


        //
        <!-- delete  click button -->

        $(document).on('click', ".delete-category", function () {
            var name = $(this).closest("div").data("name");
            var id = $(this).closest("div").data("id");
            $("#tip_delete").text('Delete category: ' + name + "?");

            $("#tip_delete").css("display", "block");

            $("#btn_delete_cate").click(function () {
                $('#category_id_delete').val(id);
                $('#delete_category').submit();

                return false;
            });

        });

    }
);