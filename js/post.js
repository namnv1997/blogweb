$(document).ready(function () {
    var uploadfiles = document.querySelector('#uploadfiles');
    uploadfiles.addEventListener('change', function () {
        var files = this.files;
        for (var i = 0; i < files.length; i++) {
            previewImage(this.files[i], "gallery");
        }

    }, false);

    var uploadfiles_edit = document.querySelector('#uploadfiles_edit');
    uploadfiles_edit.addEventListener('change', function () {
        $("#gallery_edit").empty();
        var files = this.files;
        for (var i = 0; i < files.length; i++) {
            previewImage(this.files[i], "gallery_edit");
        }

    }, false);

    $('#teams').multiselect({
        templates: { // Use the Awesome Bootstrap Checkbox structure
            li: '<li><div class="checkbox"><label></label></div></li>'
        }
    });

    $('.multiselect-container div.checkbox').each(function (index) {

        var id = 'multiselect-' + index,
            $input = $(this).find('input');

        // Associate the label and the input
        $(this).find('label').attr('for', id);
        $input.attr('id', id);

        // Remove the input from the label wrapper
        $input.detach();

        // Place the input back in before the label
        $input.prependTo($(this));

        $(this).click(function (e) {
            // Prevents the click from bubbling up and hiding the dropdown
            e.stopPropagation();
        });

    });

    function paginationCallDataPost(page, max) {
        if (page == 1) {
            $(".previous-li-post").css('display', 'none');
            $(".next-li-post").css('display', 'inline');
        } else if (page == max) {
            $(".next-li-post").css('display', 'none');
            $(".previous-li-post").css('display', 'inline');
        } else {
            $(".previous-li-post").css('display', 'inline');
            $(".next-li-post").css('display', 'inline');
        }
        $.ajax({
            url: "app/controllers/admin/PostController.php?fnc=changePaginationPost",
            type: "post",
            dataType: "json",
            data: {
                post_pagination: page
            },
            success: function (result) {
                var html = '';
                $('#post_display').empty();
                $.each(result, function (i, item) {
                    html += '<div class="row-table" >';
                    html += '<div class="column-table text-right" style="width: 40px;" >' + item.id + '</div>';
                    html += '<div class="column-table padding10" style="width:200px;" >' + item.title + '</div>';
                    html += '<div class="column-table padding10 text-summary" style="width:550px;">' + item.summary + '</div>';
                    if (item.status == 1) {
                        html += '<div class="column-table text-center" style="width: 80px;">Enabled</div>';
                    } else {
                        html += '<div class="column-table text-center" style="width: 80px;">Disabled</div>';
                    }
                    html += '<div class="column-table text-center" style="width: 200px;" data-id="' + item.id + '" >';
                    html += '<button type="button" class="btn btn-primary btnUD edit-post"  data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".edit-post-modal"> &nbsp Edit &nbsp </button>';
                    html += '<button class="btn btn-danger btnUD delete-post" data-toggle="modal" data-target=".delete-post-modal">Delete</button>';
                    html += '</div>';
                    html += '</div>';
                });
                $('#post_display').append(html);
            }
        });

    }

    $(document).on('click', '.post-previous', function () {
        var page = $('.active-me-post').data('page') - 1;
        var max = $('.active-me-post').data('max-page');

        var un_active = "post-" + (Number(page) + Number(1));
        var active = "post-" + Number(page);
        $('#' + un_active + '').removeClass("active-me-post");
        $('#' + active + '').addClass("active-me-post");
        paginationCallDataPost(page, max);

    });

    $(document).on('click', '.post-next', function () {
        var page = Number($('.active-me-post').data('page')) + Number(1);
        var max = $('.active-me-post').data('max-page');

        var un_active = "post-" + (Number(page) - Number(1));
        var active = "post-" + Number(page);
        $('#' + un_active + '').removeClass("active-me-post");
        $('#' + active + '').addClass("active-me-post");

        paginationCallDataPost(page, max);
    });

    $(".pagination-post li a ").click(function () {
        var page = $(this).data('page');
        var max = $(this).data('max-page');
        $(".pagination-post li a").removeClass("active-me-post");
        $(this).addClass("active-me-post");
        paginationCallDataPost(page, max);

    });

    $(document).on('click', '.btn_create_new', function () {
        $("#gallery").empty();
        $('#uploadfiles').val('');
    })
    $(document).on('click', '#btn_post', function (e) {

        var $title = $('#title_post').val().trim();
        var $content = $('#content_post').val().trim();
        if (!$title) {
            $.alert({
                title: 'Warning!',
                content: 'Please input title post !',
            });
        } else if (!$content) {
            $.alert({
                title: 'Warning!',
                content: 'Please input content post !',
            });
        } else {
            var listId = [];
            $('#myselect option:selected').each(function () {
                listId.push($(this).val());
//                        lay data value cua options chua cac id cua category
            });

            $status = $('#status_post_select :selected').text();
            if ($status == "Enable") {
                $('#status_post').val(1)
            } else {
                $('#status_post').val(0)
            }
            ;
            $('#id_category_post').val(listId);

            $.ajax({
                url: "app/controllers/admin/PostController.php?fnc=getTitlePost",
                type: "post",
                dataType: "json",
                data: {
                    title_request: $title,
                    id_request: 0
                },
                success: function (result) {
//                            result la mang title tra ve
                    var isExist = false;

                    $.each(result, function (i, item) {

                        if ($title == item.title) {
                            isExist = true;
                        }
                    });

//                            xu li ket qua
                    if (isExist == true) {
                        $.alert({
                            title: 'Warning!',
                            content: $title + ' is exist',
                        });
                    } else {
                        var files = uploadfiles.files;
                        for (var i = 0; i < files.length; i++) {
                            uploadFile(uploadfiles.files[i]);
                        }
                        $('#name_image').val(uploadfiles.files[0].name);
                        $('#post_submit').submit();
                    }
                }
            });

        }
    });


    <!-- edit  click button -->
    $(document).on('click', ".edit-post", function (e) {
        $("#gallery_edit").empty();
        $('select[multiple]').multiselect('reset');
        $('.fr-view').empty();
        var id = $(this).closest("div").data("id");
        $('#edit_id_post').val(id);

        $.ajax({
            url: "app/controllers/admin/PostController.php?fnc=getInfoPost",
            type: "post",
            dataType: "json",
            data: {
                post_id: id
            },
            success: function (result) {
                $.each(result, function (i, item) {
                    var html = '';
                    $('#edit_title_post').val(item.title);
                    $('#edit_content_post').val(item.content);
                    $('#summary_edit_post').val(item.summary);
                    $('.fr-view').append('<div>' + item.content + '</div>');

                    $("div.div-select select").val(item.status);
                    $('#gallery_edit').val(item.image);
                    $("#gallery_edit").append('<img src="' + item.image + '" height="150" width="150">');

                    $(".edit_check").empty();
                    html += '<label for="status_post" class="text-justify control-label"> Category </label>';
                    html += '<select id="myselect"  name="basic[]" multiple="multiple" class="3col active edit_select">';
                    item.list.forEach(function (element) {
                        if (jQuery.inArray(element.id, item.list_active) != -1) {
                            html += '<option value="' + element.id + '" selected>' + element.name + '</option>'
                        } else {
                            html += '<option value="' + element.id + '">' + element.name + '</option>'
                        }

                    });

                    html += '</select>';

                    $(".edit_check").append(html);

                    $('select[multiple].active.3col').multiselect({
                        columns: 3,
                        placeholder: 'Select Category',
                        search: true,
                        searchOptions: {
                            'default': 'Search Category',
                        },
                        selectAll: true
                    });

                });
            }
        });

    });


    $(document).on('click', "#btn_edit_post", function () {
        var $title_edit = $('#edit_title_post').val().trim();
        var $content_edit = $('#edit_content_post').val().trim();
        if (!$title_edit) {
            $.alert({
                title: 'Warning!',
                content: 'Please input title',
            });
        }
        else if (!$content_edit) {
            $.alert({
                title: 'Warning!',
                content: 'Please input content!',
            })
        }
        else {
            var listId = [];


            var $status = $('#edit_status_post_select :selected').text();
            if ($status == "Enable") {
                $('#edit_status_post').val(1)
            } else {
                $('#edit_status_post').val(0)
            }
            ;


            $.ajax({
                url: "app/controllers/admin/PostController.php?fnc=getTitlePost",
                type: "post",
                dataType: "json",
                data: {
                    title_request: $title_edit,
                    id_request: $('#edit_id_post').val()
                },
                success: function (result) {
                    var isExist = false;
                    $.each(result, function (i, item) {
                        //                            check xem category nhap co ton tai hay khong
                        if ($title_edit == item.title) {
                            isExist = true;
                        }
                    })

                    if (isExist == true) {
                        $.alert({
                            title: 'Warning!',
                            content: $title_edit + ' is exist',
                        });
                    } else {
                        $('.edit_select option:selected').each(function () {
                            listId.push($(this).val());
                            // lay data value cua options chua cac id cua category
                        });
                        $('#edit_id_category_post').val(listId);

                        var files = uploadfiles_edit.files;
                        for (var i = 0; i < files.length; i++) {
                            uploadFile(uploadfiles_edit.files[i]);
                        }
                        var name_avai = $('#gallery_edit').val().split("/");
                        //cat chuoi link anh hien tai de lay ten
                        var stt = uploadfiles_edit.files[0];
                        if (stt == undefined) {
                            $('#name_image_edit').val(name_avai[name_avai.length - 1]);
                        } else {
                            $('#name_image_edit').val(uploadfiles_edit.files[0].name);
                        }

                        $('#edit_post_submit').submit();
                    }
                }
            });

        }
        return false;
    });

    $("#btn_edit_close").click(function () {

    });

    <!-- delete  click button -->

    $(document).on('click', ".delete-post", function () {
        var title = $(this).closest("div").data("title");
        var id = $(this).closest("div").data("id");
        $("#tip_delete_post").text('Delete post ?');
        $("#tip_delete_post").css("display", "block");

        $("#btn_delete_post").click(function () {
            $('#post_id_delete').val(id);
            $('#delete_post').submit();

            return false;
        });

    });

});

$(function () {
    $('select[multiple].active.3col').multiselect({
        columns: 3,
        placeholder: 'Select Category',
        search: true,
        searchOptions: {
            'default': 'Search Category',
        },
        selectAll: true
    });

});

