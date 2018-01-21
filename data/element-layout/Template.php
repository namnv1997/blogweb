<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> <?php echo $title; ?> </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/CoffeWebsite/Styles/template_style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

    <script>
        $(function() {
            $(function() {
                var pull        = $('#pull');
                menu        = $('nav ul');
                menuHeight  = menu.height();

                $(pull).on('click', function(e) {
                    e.preventDefault();
                    menu.slideToggle();
                });
            });

            $(window).resize(function(){
                var w = $(window).width();
                if(w > 320 && menu.is(':hidden')) {
                    menu.removeAttr('style');
                }
            });
        });


    </script>

</head>
<body class="bgr-silver">
<div id="wrapper">
    <div id="banner">
        <img src="http://localhost/CoffeWebsite/data/Images/banner.jpg">
    </div>

    <?php
    if (!isset($_SESSION['name'])) {
        $nav_plus = '<ul class="nav navbar-nav navbar-right" id="ul-frontend">
                        <li><a href="http://localhost/CoffeWebsite/views/frontend/signup.php"><span class="glyphicon glyphicon-frontend"></span> Sign Up</a></li>
                        <li><a href="http://localhost/CoffeWebsite/views/frontend/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                       </ul>';
    } else {
        $nav_plus = '<ul class="nav navbar-nav navbar-right padding-br-20">
                         <span class="span-hi">Hi ' . $_SESSION['name'] . ' </span>
                            <a href="http://localhost/CoffeWebsite/profileController.php?user_id=' . $_SESSION['id'] . '">
                            <span class="glyphicon glyphicon-frontend span-frontend"title="profile" aria-hidden="true">
                            </span>
                            </a>
                         <span class="glyphicon glyphicon-log-out span-log-out" id="btn-log-out" title="Log out" aria-hidden="true"></span>
                       </ul>';
    };

    include $_SERVER['DOCUMENT_ROOT'] . '/CoffeWebsite/data/element-layout/navigation.html';
    include $_SERVER['DOCUMENT_ROOT'] . '/CoffeWebsite/data/element-layout/content.php';


    if ($show_same_topic) {
        include $_SERVER['DOCUMENT_ROOT'] . '/CoffeWebsite/data/slider/slider.html';
    }

    include $_SERVER['DOCUMENT_ROOT'] . '/CoffeWebsite/data/element-layout/loading-modal.html';
    include $_SERVER['DOCUMENT_ROOT'] . '/CoffeWebsite/data/element-layout/footer.html';

    ?>
</div>

</body>
</html>