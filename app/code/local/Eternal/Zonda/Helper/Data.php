<?php
class Eternal_Zonda_Helper_Data extends Mage_Core_Helper_Abstract{
    // texture path
    protected $_texturePath;
    
    // background image path
    protected $_backgroundImagePath;
    
    public function __construct()
    {
        $this->_texturePath = 'wysiwyg/eternal/zonda/_textures/';        
    }
    
    // get config for theme setting
    public function getConfig($optionName) 
    {
        if (Mage::registry('zonda_css_generate_store')) {
            $store_code = Mage::registry('zonda_css_generate_store');
            $store_id = Mage::getModel('core/store')->load($store_code)->getId();
        } else {
            $store_id = NULL;
        }
        return Mage::getStoreConfig('zonda_setting/' . $optionName, $store_id);
    }
    
    // get config group for theme setting section
    public function getConfigGroup($storeId = NULL)
    {
        if (!$storeId) {
            $store_code = Mage::registry('zonda_css_generate_store');
            $storeId = Mage::getModel('core/store')->load($store_code)->getId();
        }

        if ($storeId)
            return Mage::getStoreConfig('zonda_setting', $storeId);
        else
            return Mage::getStoreConfig('zonda_setting');
    }    
    
    // get config for theme design
    public function getConfigDesign($optionName)
    {
        if (Mage::registry('zonda_css_generate_store')) {
            $store_code = Mage::registry('zonda_css_generate_store');
            $store_id = Mage::getModel('core/store')->load($store_code)->getId();
        } else {
            $store_id = NULL;
        }
        return Mage::getStoreConfig('zonda_design/' . $optionName, $store_id);
    }
    
    // get config group for theme design section
    public function getConfigGroupDesign($storeId = NULL)
    {
        if (!$storeId) {
            $store_code = Mage::registry('zonda_css_generate_store');
            $storeId = Mage::getModel('core/store')->load($store_code)->getId();
        }

        if ($storeId)
            return Mage::getStoreConfig('zonda_design', $storeId);
        else
            return Mage::getStoreConfig('zonda_design');
    }
    
    // get config for theme import, export
    public function getConfigData($optionName, $storeId = NULL)
    {
        if ($storeId)
            return Mage::getStoreConfig('zonda_data/' . $optionName, $storeId);
        else
            return Mage::getStoreConfig('zonda_data/' . $optionName);
    }
    
    // get jquery url
    public function getJqueryUrl()
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS) . 'eternal/jquery/jquery-1.8.2.min.js';
    }
    
    public function getJqueryNoConflictUrl()
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS) . 'eternal/jquery/jquery-noconflict.js';
    }
    
    // get bootstrap js
    public function getBootstrapJsFile() {
        return 'eternal/bootstrap/' . $this->getBootstrapVersion() . '/bootstrap.min.js';
    }
    
    //get bootstrap css
    public function getBootstrapCssFile() {
        $bootstrap_version = $this->getBootstrapVersion();
        if ((int)(substr($bootstrap_version, 0, 1)) < 3)
            return 'css/bootstrap/' . $this->getBootstrapVersion() . '/css/bootstrap.css';
        return 'css/bootstrap/' . $this->getBootstrapVersion() . '/css/bootstrap.min.css';
    }
    
    //get bootstrap css
    public function getBootstrapThemeCssFile() {
        $bootstrap_version = $this->getBootstrapVersion();
        if ((int)(substr($bootstrap_version, 0, 1)) < 3)
            return 'css/empty.css';
        return 'css/bootstrap/' . $this->getBootstrapVersion() . '/css/bootstrap-theme.min.css';
    }
    
    //get bootstrap css
    public function getBootstrapResponsiveCssFile() {
        $bootstrap_version = $this->getBootstrapVersion();
        if ((int)(substr($bootstrap_version, 0, 1)) < 3) {
            if ($this->isResponsive())
                return 'css/bootstrap/' . $this->getBootstrapVersion() . '/css/bootstrap-responsive.css';
            return 'css/empty.css';
        }
        if ( !$this->isResponsive() ) 
            return 'css/bootstrap/' . $this->getBootstrapVersion() . '/css/non-responsive.css';
        return 'css/empty.css';
    }
    
    // get twitter bootstrap version
    public function getBootstrapVersion()
    {
        $version = $this->getConfig('general/bootstrap_version');    
        if ($version)
            return $version;
        return '2.3.2';
    }
    
    // get bootstrap base url
    public function getBootstrapUrl() 
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS) . 'eternal/bootstrap/' . $this->getBootstrapVersion();
    }
    
    // get class for bootstrap version
    public function getBootstrapClass() {
        $bootstrap_version = $this->getBootstrapVersion();
        if ((int)(substr($bootstrap_version, 0, 1)) >= 3)
            return 'bv3';
        return '';
    }
    
    // get bootstrap container class
    public function getContainerClass() {
        $bootstrap_version = $this->getBootstrapVersion();
        if ((int)(substr($bootstrap_version, 0, 1)) >= 3)
            return 'container';
        if ($this->isFluid())
            return 'container-fluid';
        return 'container';
    }
    
    // get bootstrap row class
    public function getRowClass() {
        $bootstrap_version = $this->getBootstrapVersion();
        if ((int)(substr($bootstrap_version, 0, 1)) >= 3)
            return 'row';
        return 'row-fluid';
    }
    
    // get bootstrap span class
    public function getSpanClass() {
        $bootstrap_version = $this->getBootstrapVersion();
        if ((int)(substr($bootstrap_version, 0, 1)) >= 3)
            if ($this->isResponsive())
                return 'col-sm-';
            else
                return 'col-xs-';
        return 'span';
    }
    
    // get bootstrap offset class
    public function getOffsetClass() {
        $bootstrap_version = $this->getBootstrapVersion();
        if ((int)(substr($bootstrap_version, 0, 1)) >= 3)
            return 'col-md-offset-';
        return 'offset';
    }
    
    // check responsive
    public function isResponsive()
    {
        if ($this->getConfig('general/active_responsive'))
            return true;
        return false;
    }
    
    // check fluid layout
    public function isFluid()
    {
        if ($this->getConfig('general/bootstrap_layout') == 'fixed')
            return false;
        return true;
    }
    
    // get favicon
    public function getFavicon() 
    {
        $icon = $this->getConfig('general/favicon');
        if ($icon)
            return Mage::getBaseUrl('media') . 'favicon/' . $icon;
        return Mage::getBaseUrl('media') . 'favicon/favicon.ico';
    }

    // get logo
    public function getLogo() 
    {
        $icon = $this->getConfig('header/logo');
        if ($icon)
            return Mage::getBaseUrl('media') . 'eternal/zonda/' . $icon;
        return false;
    }
    //get sticky header logo image 
     public function getLogoBg() 
    {
        $bg_img = $this->getConfig('header/logo_bgimg');
        if ($bg_img)
            return Mage::getBaseUrl('media') . 'eternal/zonda/' . $bg_img;
        return false;
    }   
    // get apple iphone icon
    public function getIphoneIcon() 
    {
        $icon = $this->getConfig('general/icon_iphone');
        if ($icon)
            return Mage::getBaseUrl('media') . 'eternal/zonda/' . $icon;
        return Mage::getBaseUrl('media') . 'eternal/zonda/apple-touch-icon.png';
    }
    
    // get apple ipad icon
    public function getIpadIcon() 
    {
        $icon = $this->getConfig('general/icon_ipad');
        if ($icon)
            return Mage::getBaseUrl('media') . 'eternal/zonda/' . $icon;
        return Mage::getBaseUrl('media') . 'eternal/zonda/apple-touch-icon-72x72.png';
    }
    
    // get apple iphone retina icon
    public function getIphoneRetinaIcon()
    {
        $icon = $this->getConfig('general/icon_iphone_retina');
        if ($icon)
            return Mage::getBaseUrl('media') . 'eternal/zonda/' . $icon;
        return Mage::getBaseUrl('media') . 'eternal/zonda/apple-touch-icon-114x114.png';
    }
    
    // get apple ipad retina icon
    public function getIpadRetinaIcon()
    {
        $icon = $this->getConfig('general/icon_ipad_retina');
        if ($icon)
            return Mage::getBaseUrl('media') . 'eternal/zonda/' . $icon;
        return Mage::getBaseUrl('media') . 'eternal/zonda/apple-touch-icon-144x144.png';
    }
    
    // get googlemap maker
    public function getGmapMaker()
    {
        $icon = $this->getConfig('contactus/gmap_maker');
        if ($icon)
            return Mage::getBaseUrl('media') . 'eternal/zonda/icon/' . $icon;
        return false;
    }
    
    // get footer twitter icon
    public function getTwitterIcon()
    {
        $icon = $this->getConfigDesign('twitter/icon');
        if ($icon)
            return Mage::getBaseUrl('media') . 'eternal/zonda/icon/' . $icon;
        return Mage::getBaseUrl('media') . 'eternal/zonda/icon/icon_twitter.png';
    }
    
    // get texture path
    public function getTexturePath() 
    {
        return $this->_texturePath;        
    }
    
    // get texture url
    public function getTextureUrl() 
    {
        $texture = $this->getConfigDesign('general/body_bg_texture');
        if ($texture)
            return Mage::getBaseUrl('media') . $this->getTexturePath() . $texture . '.png';
    }
    
    // get background image url
    public function getBackgroundImageUrl() 
    {
        $image = $this->getConfigDesign('general/body_bg_image');
        if ($image)
            return Mage::getBaseUrl('media') . 'eternal/zonda/background/' . $image;
    }
    
    // get header texture url
    public function getHeaderTextureUrl() 
    {
        $texture = $this->getConfigDesign('header/header_bg_texture');        
        if ($texture != '0')            
            return Mage::getBaseUrl('media') . $this->getTexturePath() . $texture . '.png';
    }
    
    // get minicart texture url
    public function getMinicartTextureUrl()
    {
        $texture = $this->getConfigDesign('header/mc_dropdown_bg_texture');
        if ($texture)
            return Mage::getBaseUrl('media') . $this->getTexturePath() . $texture . '.png';
    }    
    
    // get main menu texture url
    public function getMenuTextureUrl() 
    {
        $texture = $this->getConfigDesign('top_menu/texture');
        if ($texture)
            return Mage::getBaseUrl('media') . $this->getTexturePath() . $texture . '.png';
    }
    
    // get footer texture url
    public function getFooterTextureUrl() 
    {
        $texture = $this->getConfigDesign('footer/texture');
        if ($texture)
            return Mage::getBaseUrl('media') . $this->getTexturePath() . $texture . '.png';
    }
    
    //get footer top texture url
    public function getFooterTopTextureUrl()
    {
        $texture = $this->getConfigDesign('footer/top_texture');
        if ($texture)
            return Mage::getBaseUrl('media') . $this->getTexturePath() . $texture . '.png';
    }
    // get breadcrumbs texture url
    public function getBreadcrumbsTextureUrl() 
    {
        $texture = $this->getConfigDesign('breadcrumbs/texture');
        if ($texture)
            return Mage::getBaseUrl('media') . $this->getTexturePath() . $texture . '.png';
    }
    
    // get attributes to show in layer navigation
    public function getShowAttributes() {
        $attributes = $this->getConfig('navigation/show_attributes');
        return explode(',', $attributes);
    }
    
    // get header fixed
    public function isHeaderFixed() {
        return $this->getConfig('header/fixed');
    }
    
        // want to add facebook script after body tag
    public function enabledFacebook()
    {
        if ($this->getConfig('facebook/enable'))
            return true;
        return false;
    }
    
    // get facebook config
    public function getFacebookConfig() 
    {
        return Mage::getStoreConfig('zonda_setting/facebook');
    }
    
    // get twitter config
    public function getTwitterConfig() 
    {
        return Mage::getStoreConfig('zonda_setting/twitter');
    }
    
    // get google map config
    public function getGMapConfig()
    {
        return Mage::getStoreConfig('zonda_setting/gmap');
    } 
    
    // get category banner texture url
    public function getCategoryBannerTextureUrl() 
    {
        $texture = $this->getConfigDesign('category/texture');
        if ($texture)
            return Mage::getBaseUrl('media') . $this->getTexturePath() . $texture . '.png';
    }
    
    // get slider texture url
    public function getSliderTextureUrl() 
    {
        $texture = $this->getConfigDesign('home_slider/texture');
        if ($texture)
            return Mage::getBaseUrl('media') . $this->getTexturePath() . $texture . '.png';
    }
    
    // get image for product
    public function getImage($product, $imgWidth, $imgHeight, $imgVersion='small_image', $file=NULL) 
    {
        $url = '';
        if ($imgHeight <= 0)
        {
            $url = Mage::helper('catalog/image')
                ->init($product, $imgVersion, $file)
                //->constrainOnly(true)
                ->keepAspectRatio(true)
                //->setQuality(100)
                ->keepFrame(false)
                ->resize($imgWidth);
        }
        else
        {
            $url = Mage::helper('catalog/image')
                ->init($product, $imgVersion, $file)
                ->resize($imgWidth, $imgHeight);
        }
        return $url;
    }
    
    // get hover image for product
    public function getHoverImageHtml($product, $imgWidth, $imgHeight, $imgVersion='small_image') 
    {
        $product->load('media_gallery');
        $order = $this->getConfig('category/image_order');
        if ($gallery = $product->getMediaGalleryImages())
        {
            if ($hoverImage = $gallery->getItemByColumnValue('position', $order))
            {
                $url = '';
                if ($imgHeight <= 0)
                {
                    $url = Mage::helper('catalog/image')
                        ->init($product, $imgVersion, $hoverImage->getFile())
                        ->constrainOnly(true)
                        ->keepAspectRatio(true)
                        ->keepFrame(false)
                        ->resize($imgWidth);
                }
                else
                {
                    $url = Mage::helper('catalog/image')
                        ->init($product, $imgVersion, $hoverImage->getFile())
                        ->resize($imgWidth, $imgHeight);
                }
                return '<img class="hover-image" src="' . $url . '" alt="' . $product->getName() . '" />';
            }
        }
        
        return '';
    }
    
    // get slider background image url
    function fetch_fb_fans($fb_id, $limit = 10){
        $ret = array();
        $matches = array();
        $url = 'https://www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/' . $fb_id . '&connections=' . $limit;
        $html = '';
        $like_html = $this->file_get_contents_curl($url, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20100101 Firefox/15.0.1');
        $doc = new DOMDocument('1.0', 'utf-8');
        @$doc->loadHTML($like_html);
        $peopleList = array();
        $i = 0;

        foreach ($doc->getElementsByTagName('ul')->item(0)->childNodes as $child) {
            $raw = $doc->saveXML($child);
            $li = preg_replace("/<li[^>]+\>/i", "", $raw);
            $peopleList[$i] = preg_replace("/<\/li>/i", "", $li);
            $i++;
        }
        
        foreach ($peopleList as $key => $code) {
            $name = $this->getAttribute('title', $code);
            $nm = substr($name, 0, 7);
            //print_r(strlen($nm));echo "\n";
            if (strlen($nm) != strlen($name)) $nm = $nm."...";

            $image = $this->getAttribute('src', $code);
            $link = $this->getAttribute('href', $code);

            $protocols = array("http:","https:"); 
            $img_in_base64 = str_replace($protocols, "", $image);
            
            $html .= '<div class="fb-person">';
            if ($link != "") {
                $html .= "<a href=\"".$link."\" title=\"".$name."\" target=\"_blank\"><img src=\"".$img_in_base64."\" alt=\"\" /></a><p class='fb-person-name'>".$name."</p>";
            } else {
                $html .= "<span title=\"".$name."\"><img src=\"".$img_in_base64."\" alt=\"\" /></span><p class='fb-person-name'>".$name."</p>";
            }
            $html .= '</div>';
        }
        return $html;
    }
    
    private function getAttribute($attrib, $tag){
          //get attribute from html tag
          $re = '/'.$attrib.'=["\']?([^"\' ]*)["\' ]/is';
          preg_match($re, $tag, $match);
          
          if($match){
            return urldecode($match[1]);
          }else {
            return false;
          }
    }
    
    private function file_get_contents_curl($url, $useragent = null) {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_HEADER, 0);
        if ($useragent)
            curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $data = curl_exec($ch);
        curl_close($ch);
        
        return $data;
    }
    
    // get facebook fans
    public function getFBFans() {
        $fb = $this->getFacebookConfig();
        
        if (!$fb['enable'])
            return false;
            
        $limit = $fb['limit'];
        $fb_name = $fb['name'];
        
        // get page info from graph
        $fanpage_data = (array)json_decode($this->file_get_contents_curl('http://graph.facebook.com/' . $fb_name));
        if(empty($fanpage_data['id'])){
            // invalid fanpage name
            return false;
        }
        $result = array();
        $result['profile'] = $fanpage_data;
        $result['fans'] = $this->fetch_fb_fans($fanpage_data['id'], $limit);
        $result['limit'] = $limit;
        return $result;
    }
    
    // get twitter tweets
    public function getTwitterTweets() {
        $tt = $this->getTwitterConfig();
        
        if (!$tt['enable'])
            return false;
            
        try{
            require_once('twitteroauth/twitteroauth.php');
        }
        catch(Exception $o){
            return false;
        }
        
        $twitteruser = $tt['name'];
        $limit = $tt['limit'];
        $consumerkey = $tt['consumer_key'];
        $consumersecret = $tt['consumer_secret'];
        $accesstoken = $tt['access_token'];
        $accesstokensecret = $tt['access_token_secret'];
        
        $connection = new TwitterOAuth($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);

        $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$limit);
        
        return $tweets;
    }
    
    //get Google Map
    public function getGMap() {
        $gmap = $this->getGMapConfig();
        if (!$gmap['gmap_enable'])
            return false; 
         $gmap_address = urlencode($gmap['gmap_address']);   
         $gmap_url = "http://maps.googleapis.com/maps/api/geocode/json?address=$gmap_address&sensor=false";
    
        $ch = curl_init();
            
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $gmap_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $raw = curl_exec($ch);
        $gmap_data = json_decode($raw);
        if ($gmap_data->results) {
            $lat_lng['lat'] = $gmap_data->results[0]->geometry->location->lat;
            $lat_lng['lng'] = $gmap_data->results[0]->geometry->location->lng;
            return $lat_lng;
        }
        return false;
    }
    
    // get advertising block ids
    public function getAdsBlockIds() {
        $blockIdsString = $this->getConfig('sidebar/ads_blocks');
        $blockIds = explode(",", str_replace(" ", "", $blockIdsString));
        return $blockIds;
    } 
}
?>
