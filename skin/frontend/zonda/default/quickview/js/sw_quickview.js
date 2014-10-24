jQuery.noConflict();

jQuery(function($) {
    var myhref;
//base function    
    //get IE version
    function ieVersion(){
        var rv = -1; // Return value assumes failure.
        if (navigator.appName == 'Microsoft Internet Explorer'){
            var ua = navigator.userAgent;
            var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
            if (re.exec(ua) != null)
                rv = parseFloat( RegExp.$1 );
        }
        return rv;
    }

    //read href attr in a tag
    function readHref(){
        var mypath = arguments[0];
        var patt = /\/[^\/]{0,}$/ig;
        if(mypath[mypath.length-1]=="/"){
            mypath = mypath.substring(0,mypath.length-1);
            return (mypath.match(patt)+"/");
        }
        return mypath.match(patt);
    }

    //string trim
    function strTrim(){
        return arguments[0].replace(/^\s+|\s+$/g,"");
    }

	function zonda_refresh_qv_elements(){
		jQuery('.quickview-main select').each(function() {
			var id = jQuery(this).attr('id');
			if (jQuery(this).css('display') == 'none') {
				jQuery(this).selectbox('detach');
				jQuery(this).hide();
			} else {
				jQuery(this).selectbox('attach');
			}
		});
	}
    function _qsJnit(){
        var mypath = 'quickview/index/view';
        if (EM.Quickview.BASE_URL.indexOf('index.php') == -1){
            mypath = 'index.php/' + mypath;
        }
        var baseUrl = EM.Quickview.BASE_URL + mypath;

        $('.sw-product-quickview').each(function(){
            var reloadurl = baseUrl;
            var prodHref = readHref($(this).attr('href'))[0];
            prodHref[0] == "\/" ? prodHref = prodHref.substring(1,prodHref.length) : prodHref;
            prodHref=strTrim(prodHref);
            reloadurl = baseUrl+"/path/"+prodHref;
            version = ieVersion();
            if(version < 8.0 && version > -1){
                reloadurl = baseUrl+"/path"+prodHref;
            }
            $(this).attr('href', reloadurl);
        });
        $('.sw-product-quickview').click(function(){
            $(this).parent().parent().append('<div class="sw-qv-loading"></div>');            
        });
        
        $('.sw-product-quickview').fancybox({
            'type'              : 'ajax',            
            'autoSize'          : false,
            'titleShow'         : false,
            'autoScale'         : false,
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'scrolling'         : 'auto',
            'padding'           : 0,
            'margin'            : 0,                        
            'autoDimensions'    : false,
            'maxWidth'          : '90%',
            'width'             : EM.Quickview.QS_FRM_WIDTH,
            'maxHeight'         : EM.Quickview.QS_FRM_HEIGHT,
            'centerOnScroll'    : true,            
            'height'            : 'auto',
            'loadingIcon'       : true,
            'afterLoad'         : function() {                                    
                $('#fancybox-content').height('auto');                
                $('.fancybox-overlay').addClass('loading-success');
                $('.sw-qv-loading').remove();				
            },
            'afterShow'        : function() {                 
                 jQuery('.quickview-main select').each(function(){
					jQuery(this).selectbox();
				});
				jQuery('.quickview-main select').change(function(e){
					id = jQuery(this).attr('id');
					if (id && id != global_select)
						eternalEvent(jQuery(this).attr('id'), 'change');
					zonda_refresh_qv_elements(); 
				});
            },
            'onCancel'          : function() {
                $('.sw-qv-loading').remove();
            },
            'onClosed'          : function() {
                $('.sw-qv-loading').remove();                
            },
            'helpers'             : {
				title: null,
                overlay : {
                    locked  : false // try changing to true and scrolling around the page                    
                }
            }  
        });
        
    }

    //end base function
    _qsJnit();
});


