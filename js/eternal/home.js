jQuery(document).ready(function(){
    jQuery('.tp-bgimg.defaultimg').height(jQuery(window).height());
})

jQuery(window).resize(function(){
    jQuery('.tp-bgimg.defaultimg').height(jQuery(window).height());
})
