<?php

defined('PHPFOX') or exit('NO DICE!');

class AdsonFeed_Component_Controller_AdminCP_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		$this->template()
                ->setBreadCrumb(Phpfox::getPhrase('adsonfeed.add_new_ads'))
                ->setHeader(array(
                    'ad.js' => 'module_adsonfeed'
                ))
            ;
        $bIsEdit = false;
        if (($iId = $this->request()->getInt('id')) && ($aAds = phpfox::getService('adsonfeed')->getForEdit($iId)))
        {
            $bIsEdit = true;   
            $this->template()->assign(array(
                    'aForms' => $aAds
                ));
        }
        $aVals = $this->request()->getArray('val');
        $aValidation = array(
			'name' => Phpfox::getPhrase('adsonfeed.provide_a_name_for_this_campaign')
		);
        if (is_array($aVals) && count($aVals) > 0)
		{
			if (isset($aVals['type_id']))
			{
				if ($aVals['type_id'] == 2)
				{
					$aValidation['url_link'] = Phpfox::getPhrase('adsonfeed.provide_a_link_for_your_banner');
				}
			}
		}
        $oValidator = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => $aValidation));
        if (is_array($aVals) && count($aVals) > 0)
		{
			if ($aVals['type_id'] == 1 && empty($aVals['html_code']))
			{
				Phpfox_Error::set(Phpfox::getPhrase('adsonfeed.provide_html_for_your_banner'));	
			}

			if ($oValidator->isValid($aVals))
			{
				if ($bIsEdit)
				{
					if (Phpfox::getService('adsonfeed.process')->update($aVals['id'], $aVals))
					{
						$this->url()->send('admincp.adsonfeed.add', array('id' => $aVals['id']), Phpfox::getPhrase('adsonfeed.ad_successfully_updated'));
					}				
				}
				else 
				{
					if (Phpfox::getService('adsonfeed.process')->add($aVals))
					{
						$this->url()->send('admincp.adsonfeed.add', null, Phpfox::getPhrase('adsonfeed.ad_successfully_added'));
					}
				}
			}
		}
        $this->template()->assign(array(
            'bIsEdit' => $bIsEdit
        ));
	}
}

?>