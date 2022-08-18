let trickMedias = document.getElementsByClassName('trick-card');
console.log(trickMedias);


const swidth = window.innerWidth;
console.log(swidth);
if (swidth < 766) {
    $(function () {
        $(".trick-media-display").slice(0, 0).show();
        $("body").on('click touchstart', '.show-media', function (e) {
            e.preventDefault();
            $(".trick-media-display:hidden").slice(0, 15).slideDown();
            if ($(".trick-media-display:hidden").length == 0) {
                $(".show-media").css('visibility', 'hidden');
            }
            $('html,body').animate({
                scrollTop: $(this).offset().top
            }, 1000);
        });
    });
}
else {
    $(function () {
        $(".trick-media-display").slice(0, 100).show();
        $("body").on('click touchstart', '.show-media', function (e) {
            e.preventDefault();
            $(".trick-media-display:hidden").slice(0, 15).slideDown();
            if ($(".trick-media-display:hidden").length == 0) {
                $(".show-media").css('visibility', 'hidden');
            }
            $('html,body').animate({
                scrollTop: $(this).offset().top
            }, 1000);
        });
    });
}





