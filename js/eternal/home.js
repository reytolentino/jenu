jQuery(document).ready(function(){
    jQuery('.tp-bgimg.defaultimg').height(jQuery(window).height());

    jQuery("#custom").fadeIn();
    var slider = jQuery('.bxslider').bxSlider({
        mode: 'vertical',
        slideMargin: 10,
        pager: false,
        nextSelector: "bx-next",
        prevSelector: "bx-prev",
        nextText: "<i class='icon-brand-arrow'>&nbsp;</i>",
        prevText: "<i class='icon-brand-arrow'>&nbsp;</i>"
    });

    jQuery(".bx-prev").click(function(){
        slider.goToPrevSlide();
        return false;
    });

    jQuery(".bx-next").click(function(){
        slider.goToNextSlide();
        return false;
    });
});

jQuery(window).resize(function(){
    jQuery('.tp-bgimg.defaultimg').height(jQuery(window).height());
})
