<?php

defined('PHPFOX') or exit('NO DICE!');
class AdsOnFeed_Service_Adsonfeed extends Phpfox_Service 
{
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('adsonfeed');	
	}
    public function getForEdit($iId)
	{	
		$aAd = $this->database()->select('*')
			->from($this->_sTable)
			->where('ad_id = ' . (int) $iId)
			->execute('getRow');
		
		if (!isset($aAd['ad_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('adsonfeed.unable_to_find_this_ad'));
		}				
		return $aAd;	
	}
	public function get($aConds, $sSort = 'ad_id DESC', $iPage = '', $iLimit = '')
	{
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where($aConds)
			->execute('getField');	    
	    
		$aAds = $this->database()->select('*')
			->from($this->_sTable)
			->where($aConds)
			->order($sSort)
			->limit($iPage, $iLimit, $iCnt)
			->execute('getRows');
		return array($iCnt, $aAds);
	}
    public function getAdForFeed($aAdsView){
        $sAdsView = implode(',', $aAdsView);
        $aAd = $this->database()->select('a.*, a.ad_id as item_id, ' . Phpfox::getUserField())
			->from($this->_sTable, 'a')
            ->join(Phpfox::getT('user'), 'u', 'u.user_id = a.user_id')
            ->where('a.ad_id NOT IN (' . $sAdsView . ')' )
            ->order('RAND()')
			->execute('getRow');
        if(!$aAd){
            return false;
        }
        $sString = '';
        if($aAd['type_id'] == 1 || $aAd['type_id'] == 3){
            $sString = $aAd['html_code'];
        } else {
            $sImage = Phpfox::getLib('image.helper')->display(array(
							'server_id' => $aAd['server_id'],
							'title' => $aAd['name'],
							'path' => 'ad.url_image',
							'file' => $aAd['image_path'],
							'suffix' => '',
							'max_width' => 400,
							'max_height' => 300
						)
					);
            $sString = '<a href="'.$aAd['url_link'].'" target="_blank">'.$sImage.'</a>';
        }
        return array(array_merge(array(
			'feed_info' => '',
            'feed_title' => '',
			'feed_link' => '',
			'feed_custom_html' => $sString,
			'feed_is_liked' => false,
			'time_stamp' => $aAd['time_stamp'],			
			'enable_like' => false,			
			'custom_data_cache' => $aAd,
            'feed_like_phrase' => true,
            'privacy' => 0,
            'feed_id' => 'custom_adsonfeed',
            'load_ad' => true
		),$aAd));
    }
}
?>