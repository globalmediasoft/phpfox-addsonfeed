<?php

defined('PHPFOX') or exit('NO DICE!');


class AdsonFeed_Component_Controller_AdminCP_Manage extends Phpfox_Component
{
	public function process()
	{
		$iPage = $this->request()->getInt('page');
		
		if (($iId = $this->request()->getInt('delete')))
		{
			if (Phpfox::getService('adsonfeed.process')->delete($iId))
			{
				$this->url()->send('admincp.adsonfeed', null, Phpfox::getPhrase('adsonfeed.ad_successfully_deleted'));
			}
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if (Phpfox::getService('adsonfeed.process')->updateActivity($aVals))
			{
				$this->url()->send('admincp.adsonfeed', null, Phpfox::getPhrase('adsonfeed.ad_s_successfully_updated'));
			}
		}		
		
		$aPages = array(5, 10, 15, 20);
		$aDisplays = array();
		foreach ($aPages as $iPageCnt)
		{
			$aDisplays[$iPageCnt] = Phpfox::getPhrase('core.per_page', array('total' => $iPageCnt));
		}	

		$aSorts = array(
			'ad_id' => Phpfox::getPhrase('adsonfeed.recently_added')			
		);
		
		$aFilters = array(
            'search' => array(
				'type' => 'input:text',
				'search' => "AND name LIKE '%[VALUE]%'"
			),
			'display' => array(
				'type' => 'select',
				'options' => $aDisplays,
				'default' => '10'
			),
			'sort' => array(
				'type' => 'select',
				'options' => $aSorts,
				'default' => 'ad_id'				
			),
			'sort_by' => array(
				'type' => 'select',
				'options' => array(
					'DESC' => Phpfox::getPhrase('core.descending'),
					'ASC' => Phpfox::getPhrase('core.ascending')
				),
				'default' => 'DESC'
			)
		);		
		
		$oSearch = Phpfox::getLib('search')->set(array(
				'type' => 'campaigns',
				'filters' => $aFilters,
				'search' => 'search'
			)
		);
		
		$iLimit = $oSearch->getDisplay();		 	    
		
		list($iCnt, $aAds) = Phpfox::getService('adsonfeed')->get($oSearch->getConditions(), $oSearch->getSort(), $oSearch->getPage(), $iLimit);
		
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iLimit, 'count' => $oSearch->getSearchTotal($iCnt)));
		
		$this->template()->setTitle(Phpfox::getPhrase('adsonfeed.manage_ad_campaigns'))
			->setBreadcrumb(Phpfox::getPhrase('adsonfeed.manage_ad_campaigns'), $this->url()->makeUrl('admincp.adsonfeed'))
			->assign(array(
					'aAds' => $aAds,
					'bIsSearch' => ($this->request()->get('search-id') ? true : false),
				)
			);
			
	}
}

?>