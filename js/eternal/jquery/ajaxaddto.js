jQuery.noConflict();
	function setAjaxData(data,iframe,type){
		if(data.status == 'ERROR'){
			alert(data.message);
		}else{
			if(jQuery('.block-minicart .block-content')){
                jQuery('.block-minicart .block-content').replaceWith(data.minicart);
                jQuery('[data-hover="dropdown"]').dropdownHover(); // bootstrap dropdown hover                 
            }
	        jQuery.fancybox.close();
			if(type!='item'){
				jQuery('#after-loading-success-message').show();
			}
		}
	}
	function setLocationAjax(url,id,type){
		if (url.indexOf('?'))
		{
			url = url.split("?")[0];
		}
		url += 'isAjax/1';
		url = url.replace("checkout/cart","ajaxcart/index");
		jQuery('#loading-mask').show();

		try {
			jQuery.ajax( {
				url : url,
				dataType : 'json',
				success : function(data) {
					jQuery('#loading-mask').hide();
         			setAjaxData(data,false,type);				
				}
			});
		} catch (e) {
		}
	}

    function showOptions(id){
		initFancybox();
        jQuery('#fancybox'+id).trigger('click');
    }
	
	function initFancybox(){
		jQuery.noConflict();
		jQuery(document).ready(function(){
		jQuery('.fancybox').fancybox({
				hideOnContentClick : true,
				width: 382,
				autoDimensions: true,
				height: 'auto',
				padding: [35, 5, 15, 5],
				type : 'iframe',
				showTitle: false,
				onComplete: function(){
					jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
						jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height()+100);
						jQuery.fancybox.resize();
					});

				}
			}
		);
		});   	
	}
	function ajaxCompare(url,id){
	    url = url.replace("catalog/product_compare/add","ajaxcart/whishlist/compare");
	    url += 'isAjax/1/';
	    jQuery('#loading-mask').show();

	    jQuery.ajax( {
		    url : url,
		    dataType : 'json',
		    success : function(data) {
			    jQuery('#loading-mask').hide();
			    if(data.status == 'ERROR'){
				    alert(data.message);
			    }else{
				    alert(data.message);
				    if(jQuery('.block-compare').length){
                        jQuery('.block-compare').replaceWith(data.sidebar);
                    }else{
                        if(jQuery('.col-right').length){
                    	    jQuery('.col-right').prepend(data.sidebar);
                        }
                    }
			    }
		    }
	    });
    }
    function ajaxWishlist(url,id){
	    url = url.replace("wishlist/index","ajaxcart/whishlist");
	    url += 'isAjax/1/';
	    jQuery('#loading-mask').show();
	    jQuery.ajax( {
		    url : url,
		    dataType : 'json',
		    success : function(data) {
			    jQuery('#loading-mask').hide();
			    if(data.status == 'ERROR'){
				    alert(data.message);
			    }else{
				    alert(data.message);
				    if(jQuery('.toplinks.links')){
                        jQuery('.toplinks.links').replaceWith(data.toplink);
                    }
			    }
		    }
	    });
    }
    function deleteAction(deleteUrl,itemId,msg){
	    var result =  confirm(msg);
	    if(result==true){
		    setLocationAjax(deleteUrl,itemId,'item')
	    }else{
		    return false;
	    }
    }