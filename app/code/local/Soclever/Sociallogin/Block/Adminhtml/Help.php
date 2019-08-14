<?php
class Soclever_Sociallogin_Block_Adminhtml_Help extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
         
      $fileContent="<h1>Help is coming...Keep Visiting...Thanks....<a href='https://www.socleversocial.com' target='_blank'>Socleversocial.com</a></h1>";
      return $fileContent;
      
        
      }
        
   
    
}
?>