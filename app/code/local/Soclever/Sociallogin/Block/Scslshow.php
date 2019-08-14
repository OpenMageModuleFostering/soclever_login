<?php
class Soclever_Sociallogin_Block_Scslshow extends Mage_Core_Block_Template
{
	protected function _construct(){
        parent::_construct();
	$this->setTemplate('sociallogin/scsl_buttons.phtml');
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