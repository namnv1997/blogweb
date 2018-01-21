$(document).ready(function () {
    $(document).on('click', '#btn-login', function () {
        $.ajax({
            url: "login.php",
            type: "post",
            dataType: "text",
            data: {
                login_query: 1,
                username: $('#username').val(),
                password: $('#password').val()
            },
            success: function (result) {
                if (result[0] == true) {
                    $('#modalLogin').modal('show');
                    setTimeout(function () {
                        window.location.href = '../index.php';
                    }, 3000);
                }else {
                    $.alert({
                        title: 'Something wrong',
                        content: 'Check your username or password',
                    });
                }
            }
        });
    });
});