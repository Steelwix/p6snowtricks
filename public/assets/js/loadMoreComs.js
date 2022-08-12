$(function () {
    $(".col-md-4").slice(0, 10).show();
    $("body").on('click touchstart', '.load-more', function (e) {
        e.preventDefault();
        $(".col-md-4:hidden").slice(0, 10).slideDown();
        if ($(".col-md-4:hidden").length == 0) {
            $(".load-more").css('visibility', 'hidden');
        }
        $('html,body').animate({
            scrollTop: $(this).offset().top
        }, 1000);
    });
});
