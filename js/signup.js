$(document).ready(function () {
    $(document).on('click', '#btn-sign-up', function () {
        var username = $('#username_create').val().trim();
        var password = $('#password_create').val();
        if (username == '') {
            $.alert({
                title: 'Wrong !',
                content: 'User name, password not empty',
            });
        } else {
            $.ajax({
                url: "signup.php",
                type: "post",
                dataType: "text",
                data: {
                    username: username,
                    password: password
                },
                success: function (result) {
                    $.alert({
                        title: 'Register success !',
                        content: 'You can login now. Go to login in 2s',
                    });
                    setTimeout(function () {
                        window.location.href = '../views/frontend/login.php';
                    }, 2000);
                },
            });
        }
    });

    $(document).on('change', '#password_create', function () {
        var password = $('#password_create').val();
        if (password.length < 6) {
            $.alert({
                title: 'Wrong !',
                content: 'password must have more than 6 characters.',
            });
        }
    });

    $(document).on('change', '#cf_password', function () {
        var password = $('#password_create').val();
        var cf_password = $('#cf_password').val();
        if (password != cf_password) {
            $.alert({
                title: 'Wrong !',
                content: 'Password not same.',
            });
        }
    });

    $(document).on('change', '#username_create', function () {
        $.ajax({
            url: "signup.php",
            type: "post",
            dataType: "text",
            data: {
                check_user: $('#username_create').val()
            },
            success: function (result) {
                if (result == 1) {
                    $.alert({
                        title: 'Wrong !',
                        content: 'Username is exist !',
                    });
                    $('#username_create').val('');
                }
            }
        });
    })
});