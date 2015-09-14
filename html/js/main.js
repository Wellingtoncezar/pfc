$(document).ready(function(){
    $('#nav-icon3').click(function(){
        $(this).toggleClass('open');

        $('.menu-container').toggleClass('fadeInUp').toggleClass('fadeOutDown').toggle();
        var wall = new freewall("#freewall");
        wall.reset({
            selector: '.brick',
            animate: true,
            cellW: 150,
            cellH: 150,
            delay: 50,
            onResize: function() {
                wall.fitWidth();
                //wall.refresh();
            }
        });
        wall.fitWidth();
    });
});