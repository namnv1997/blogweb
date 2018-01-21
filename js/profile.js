$(document).ready(function () {
    $("#edit_profile").click(function () {
        $('li').removeClass('menu-active');
        $('#edit_profile').addClass('menu-active');
        var id = $(this).data('id');
        $('#content-profile').empty();
        $.ajax({
            url: 'profileController.php?fnc=createContentProfile',
            type: "get",
            dataType: "json",
            data: {
                user_id: id
            },
            success: function (result) {
                var html = '';
                $.each(result, function (i, item) {
                    html += '<form> <div class="form-group bottom10">' +
                        '<label for="exampleFormControlInput1">Display name</label>' +
                        '<input type="text" class="form-control" id="display_name" value="' + item.display_name + '">' +
                        '</div>' +
                        '<div class="form-check form-check-inline bottom10">' +
                        '<form  id="check">' +
                        '<input class="form-check-input" type="radio" name="inlineRadioOptions" id="1" value="male" checked>' +
                        '<label class="form-check-label margin-right20" for="inlineRadio1">Male</label>' +
                        '<input class="form-check-input" type="radio" name="inlineRadioOptions" id="2" value="female">' +
                        '</form>' +
                        '<label class="form-check-label" for="inlineRadio2">Female</label>' +
                        '</div>' +

                        '<div class="form-group bottom10">' +
                        '<label for="exampleFormControlInput1">Email</label>' +
                        '<input type="email" class="form-control" id="email" placeholder="enter your email" value="' + item.email + '">' +
                        '</div>' +

                        '<div class="form-group bottom10">' +
                        '<label for="exampleFormControlInput1">Phone number</label>' +
                        '<input type="text" class="form-control" id="phone_number" placeholder="enter phone number" value="' + item.phone_number + '">' +
                        '</div>' +

                        '<div class="form-group">' +
                        '<label for="exampleFormControlTextarea1" >Description</label>' +
                        '<textarea class="form-control" id="description" rows="3" > ' + item.description + ' </textarea>' +
                        '</div>' +
                        '</form>' +
                        '<button class="btn btn-primary pull-right wid70px" id="btn-save" > Save </button>';

                });
                if ($('#content-profile').is(':empty')) {
                    $('#content-profile').append(html);
                }
            }
        });
    });

    $(document).on('click', '#btn-filter', function () {
        var id = $(this).data('id');
        var date_start = $('#date_start').val();
        var date_end = $('#date_end').val();
        var stt = $('#select-stt').val();
        var keywords = $('#keywords').val();
        $('#data-filter').empty();

        $.ajax({
            url: "profileController.php?fnc=createCommentManage",
            type: "post",
            dataType: "json",
            data: {
                user_id: id,
                date_start: date_start,
                date_end: date_end,
                status: stt,
                keywords: keywords
            },
            success: function (result) {
                var html = '';
                html += '<table class="table table-bordered">' +
                    '<thead>' +
                    '<tr>' +
                    '<th class="wid40per">Post</th>' +
                    '<th class="wid40per">Comment</th>' +
                    '<th class="wid20per">Status</th>' +
                    '</tr>' +
                    '</thead>';
                html += '<tbody>';
                $.each(result, function (i, item) {
                    $stt = '';
                    if (item.status == 1) {
                        $stt = '<td class="wid20per text-primary" >Active</td>';
                    } else {
                        $stt = '<td class="wid20per text-danger" >Wait Confirm</td>';
                    }
                    html += ' <tr>' +
                        '<td class="wid40per">' + item.post_title + '</td>' +
                        '<td class="wid40per">' + item.comment + '</td>' +
                        $stt +
                        '</tr>';
                });
                html += '</tbody>' +
                    '</table>';
                $('#data-filter').append(html);
            },

        });

    });

    $(document).on('click', '#comment_manage', function () {
        $('li').removeClass('menu-active');
        $('#comment_manage').addClass('menu-active');
        var id = $(this).data('id');
        $('#content-profile').empty();

        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var date_now = d.getFullYear() + '-' +
            (month < 10 ? '0' : '') + month + '-' +
            (day < 10 ? '0' : '') + day;


        var html = '';
        html += '<h3>Filer</h3><hr>'
        html += '<form class="form-inline">' +
            '<div class="row bottom10">' +
            '<div class="form-group col-md-5">' +
            '<label for="date_start" class="margin-right10 wid20per">Date start</label>' +
            '<input type="date" class="form-control" id="date_start" max="' + date_now + '">' +
            '</div>' +
            '<div class="form-group col-md-5">' +
            '<label for="date_end" class="margin-right10 wid20per">Date end</label>' +
            '<input type="date" class="form-control" id="date_end" max="' + date_now + '">' +
            '</div><br>' +
            '</div>' +
            '<div class="row bottom10">' +
            '<div class="col-md-5 ">' +
            '<label class="margin-right10 wid20per">Status</label>' +
            '<select class="form-control" id="select-stt">' +
            '<option value="0">Wait confirm</option>' +
            '<option value="1">Active</option>' +
            '</select>' +
            '</div>' +
            '<div class="form-group col-md-5">' +
            '<label for="keywords" class="margin-right10 wid20per">Keyword</label>' +
            '<input type="text" class="form-control" id="keywords">' +
            '</div>' +
            '</div>' +
            '</form>' +
            '<div class="text-left"><button class="btn btn-primary wid70px" id="btn-filter" data-id="' + id + '"> Filter</button></div>';
        html += '<hr><div id="data-filter"></div>';
        $('#content-profile').append(html);

    });


    $(document).on('click', '#btn-save', function () {
        var display_name = $('#display_name').val();
        var email = $('#email').val();
        var phone_number = $('#phone_number').val();
        var description = $('#description').val();
        var gender = $('input[name=inlineRadioOptions]:checked').val();
        var name_img = '';
        if (my_file.files[0] != null){
            name_img = my_file.files[0].name;
        }else {
            var link = $('#img-profile').data('name');
            var piece = link.split("/");
            console.log(piece);
            name_img = piece[1];
        }
        $.ajax({
            url: "profileController.php?fnc=updateProfile",
            type: "post",
            dataType: "text",
            data: {
                display_name: display_name,
                email: email,
                phone_number: phone_number,
                description: description,
                gender: gender,
                name_img: name_img
            },
            success: function (result) {
                $.confirm({
                    buttons: {
                        NO: function () {

                        },
                        YES: {
                            text: 'YES', // With spaces and symbols
                            btnClass: 'btn-primary',
                            action: function () {
                                var files = my_file.files;
                                for (var i = 0; i < files.length; i++) {
                                    uploadProfile(my_file.files[i]);
                                }
                                location.reload();
                            }
                        }
                    }
                });
            }

        });
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
                window.location.href = '../index.php';
            },

        });

    });

    $(".img-profile").click(function () {
        $("input[id='my_file']").click();
        var uploadfiles = document.querySelector('#my_file');
        uploadfiles.addEventListener('change', function () {
            $('#img_preview').empty();
            var files = this.files;
            for (var i = 0; i < files.length; i++) {
                previewImage(this.files[i], "img_preview");
            }

        }, false);
    });
});
