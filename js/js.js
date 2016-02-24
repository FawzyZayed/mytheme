$(document).ready(function(){
    var rtl = $('body').data('dir');
    $('#slider').owlCarousel({
        loop:true,
        rtl:rtl,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        margin:0,
        items:1,
        nav:true,
        dots:false,
        autoplay:true,
        navText:['<i class="uk-icon-angle-right"></i>','<i class="uk-icon-angle-left"></i>'],
        autoplayTimeout:6000

    });
});