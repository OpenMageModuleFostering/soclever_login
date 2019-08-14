<?php
class Soclever_Socialloginsc_Model_Observer
{
    
     
      public function writejs(Varien_Event_Observer $observer)
      {
         
          $site_id=Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid');
          $api_secret=Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_appsecret');
          $api_key=Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_appid');
          
           
         
         $valid_data=file_get_contents("https://www.socleversocial.com/dashboard/mage_login_activate_sc.php?site_id=".$site_id."&api_key=".$api_key."&api_secret=".$api_secret."&csplatform=magentologin&type=preview");
         if($valid_data!='0')
         {
            Mage::getModel('core/config')->saveConfig('socialloginsc_options/apisettings/scsl_validated',"1");
            Mage::getModel('core/config')->saveConfig('socialloginsc_options/apisettings/valid_networks',$valid_data);
            
         }
         else
         {
           Mage::getModel('core/config')->saveConfig('socialloginsc_options/apisettings/scsl_validated',"0");
         }
         
         
     }
   
}


?>