<?php
class Soclever_Socialloginsc_Block_Scslshow extends Mage_Core_Block_Template
{
	protected function _construct(){
        parent::_construct();
	$this->setTemplate('socialloginsc/scsl_buttons.phtml');
	}
public function setPlace($place) {
		$this->place = $place;
		return $this;
	}
	
	/*public function _prepareLayout(){
		return parent::_prepareLayout();
    }*/
}

?>