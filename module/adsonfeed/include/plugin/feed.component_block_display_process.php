<?php
    if(Phpfox::isModule('adsonfeed') && count($aRows) > 0){ 
        $aAdsView = array(0);
        if(PHPFOX_IS_AJAX){
            if((isset($_SESSION['adsonfeeds']) && $_SESSION['adsonfeeds'] != '') )
            {
                $aAdsView = $_SESSION['adsonfeeds'];
            }
        } else {
            unset($_SESSION['adsonfeeds']);
        }
        $aAds = phpfox::getService('adsonfeed')->getAdForFeed($aAdsView);
        if(!$aAds){
            return false;
        }
        if($aAds[0]['type_id'] != 3){
            $_SESSION['adsonfeeds'][] = $aAds[0]['ad_id'];
        }
        //$aRows = array_merge($aAds, $aRows);
        $aRows1 = $aRows2 = array();
        if(count($aRows)){
            $aRows1 = array_slice($aRows, 0, ceil(count($aRows)/2));
            $aRows2 = array_slice($aRows, ceil(count($aRows)/2) + 1, count($aRows));
        }
        $aRows = array_merge($aRows1,$aAds,$aRows2);
    }
?>
<style>
    .custom_js_load_adsonfeed .activity_feed_content_info,
    .custom_js_load_adsonfeed .js_feed_comment_border,
    .custom_js_load_adsonfeed .activity_feed_image{
        display: none;
    }
    .custom_js_load_adsonfeed .activity_feed_content_no_image{
        border: none;
    }
    .custom_js_load_adsonfeed .activity_feed_content{
        margin-bottom: 0;
        margin-left: 0;
    }
</style>
<script>
    $Behavior.hideRecentActivity= function(){
        $('.custom_js_load_adsonfeed').parent().find('.feed_delete_link').hide();
    }
</script>