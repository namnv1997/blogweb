$(document).ready(function () {

    $(document).on('click', '#scroll-top', function () {
        var body = $("html, body");
        body.stop().animate({scrollTop: 0}, 500, 'swing', function () {
        });
    });

    $('#itemslider').carousel({interval: 3000});

    $('.carousel-showmanymoveone .item').each(function () {
        var itemToClone = $(this);

        for (var i = 1; i < 6; i++) {
            itemToClone = itemToClone.next();

            if (!itemToClone.length) {
                itemToClone = $(this).siblings(':first');
            }

            itemToClone.children(':first-child').clone()
                .addClass("cloneditem-" + (i))
                .appendTo($(this));
        }
    });
});


window.onscroll = function () {
    scrollFunction()
};

function scrollFunction() {
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
        $("#scroll-top").css("display", "block");
    } else {
        $("#scroll-top").css("display", "none");
    }
}
