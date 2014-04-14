<?php

defined('PHPFOX') or exit('NO DICE!');
class AdsOnFeed_Service_Process extends Phpfox_Service 
{
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('adsonfeed');	
	}
    public function add($aVals)
	{			
		$aVals['html_code'] = str_replace(Phpfox::getPhrase('ad_image_placement'), '', $aVals['html_code']);
		$aSql = array(
			'type_id' => (int) $aVals['type_id'],
			'name' => $this->preParse()->clean($aVals['name'], 150),
			'url_link' => ($aVals['type_id'] == 2 ? $aVals['url_link'] : null),
			'html_code' => (empty($aVals['html_code']) ? null : $aVals['html_code']),
            'time_stamp' => PHPFOX_TIME,
            'user_id' => Phpfox::getUserId()
		);
		if ($aVals['type_id'] == 2)
		{
			$aImage = Phpfox::getLib('file')->load('image', array('jpg', 'gif', 'png'));
			
			if ($aImage === false)
			{
				return false;
			}			
		}
		
		$iId = $this->database()->insert($this->_sTable, $aSql);
		
		if ($aVals['type_id'] == 2)
		{
			if ($sFileName = Phpfox::getLib('file')->upload('image', Phpfox::getParam('ad.dir_image'), $iId))
			{
				$this->database()->update($this->_sTable, array('image_path' => $sFileName, 'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID')), 'ad_id = ' . (int) $iId);		
			}		
		}
		return $iId;
	}
    public function update($iId, $aVals)
	{
		$aSql = array(
			'name' => $this->preParse()->clean($aVals['name'], 150),
			'url_link' => ($aVals['type_id'] == 2 ? $aVals['url_link'] : null),
			'html_code' => (empty($aVals['html_code']) ? null : $aVals['html_code']),
            'type_id' => !isset($aVals['type_id']) ? 1 : $aVals['type_id'],
		);

		if (empty($aSql['url_link']))
		{
			unset($aSql['url_link']);
		}
		if ($aVals['type_id'] == 2 && !empty($_FILES['image']['name']))
		{			
			$aImage = Phpfox::getLib('file')->load('image', array('jpg', 'gif', 'png'));
			
			if ($aImage === false)
			{
				return false;
			}		
			
			$aAd = Phpfox::getService('adsonfeed')->getForEdit($iId);

			if (!empty($aAd['image_path']) && file_exists(Phpfox::getParam('ad.dir_image') . sprintf($aAd['image_path'], '')))
			{
				Phpfox::getLib('file')->unlink(Phpfox::getParam('ad.dir_image') . sprintf($aAd['image_path'], ''));
			}
			
			if ($sFileName = Phpfox::getLib('file')->upload('image', Phpfox::getParam('ad.dir_image'), $iId))
			{
				$this->database()->update($this->_sTable, array('image_path' => $sFileName, 'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID')), 'ad_id = ' . (int) $iId);		
			}	
		}		
		
		$this->database()->update($this->_sTable, $aSql, 'ad_id =' . (int) $iId);
		
		return true;
	}
	public function delete($iId)
	{
		$aAd = $this->database()->select('*')
			->from($this->_sTable)
			->where('ad_id = ' . (int) $iId)
			->execute('getRow');
			
		if (!isset($aAd['ad_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('adsonfeed.unable_to_find_the_ad_you_want_to_delete'));
		}
		$this->database()->delete($this->_sTable, 'ad_id = ' . $aAd['ad_id']);
		
		return true;
	}

}
?>