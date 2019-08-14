<?php
class Soclever_Sociallogin_Block_Adminhtml_Positions extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    
    
    
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        
          $site_id=Mage::getStoreConfig('sociallogin_options/apisettings/scsl_siteid');
          $api_secret=Mage::getStoreConfig('sociallogin_options/apisettings/scsl_appsecret');
          $api_key=Mage::getStoreConfig('sociallogin_options/apisettings/scsl_appid');  
          
          $valid_data=file_get_contents("https://www.socleversocial.com/dashboard/wp_activate.php?site_id=".$site_id."&api_key=".$api_key."&api_secret=".$api_secret."&csplatform=magentologin");
          if($valid_data && $valid_data[0]!='0')
          {
            $selectedButtons=Mage::getStoreConfig('sociallogin_options/displaysettings/buttonstyle');           
            $selectedProviders="https://www.socleversocial.com/dashboard/img/social_icon/social_login_fc_30.png";
            $btn_style=Mage::getStoreConfig('sociallogin_options/displaysettings/buttonstyle');
            $button_size=Mage::getStoreConfig('sociallogin_options/displaysettings/buttonsize');
            $SITE_URL="https://www.socleversocial.com/dashboard/";
            if($btn_style=="ic") {
        $btn_width=$button_size;
    }
    else if($btn_style=="fc" || $btn_style=="fg")
    {
        if($button_size=="30") {$btn_width="78"; }
        if($button_size=="40") {$btn_width="104"; }
        if($button_size=="50") {$btn_width="130"; }
        if($button_size=="60") {$btn_width="156"; }
        if($button_size=="65") {$btn_width="169"; }
    }

         $network=explode(",",$valid_data);
    $imgdiv="";     
    $img='social_login_'.$btn_style.'_'.$button_size.'.png';
         if(in_array('2',$network))
{
    $bg_position=$btn_width;
    $imgdiv .='<div style="float: left; margin-right: 10px;margin-top: 10px; width: '.$btn_width.'px; height: '.$button_size.'px; background-image: url('.$SITE_URL.'img/social_icon/'.$img.'); background-position: -'.$bg_position.'px 0px;"></div>';
    
    
}

if(in_array('4',$network))
{
    $bg_position=((3)*$btn_width);

    $imgdiv .='<div style="float: left; margin-right: 10px;margin-top: 10px; width: '.$btn_width.'px; height: '.$button_size.'px; background-image: url('.$SITE_URL.'img/social_icon/'.$img.'); background-position: -'.$bg_position.'px 0px;"></div>';

  
}

if(in_array('7',$network))
{
    $bg_position=((6)*$btn_width);
    
    $imgdiv .='<div style="float: left; margin-right: 10px;margin-top: 10px; width: '.$btn_width.'px; height: '.$button_size.'px; background-image: url('.$SITE_URL.'img/social_icon/'.$img.'); background-position: -'.$bg_position.'px 0px;"></div>';
    
  
}

if(in_array('13',$network))
{
    $bg_position=((12)*$btn_width);

    $imgdiv .='<div style="float: left; margin-right: 10px;margin-top: 10px; width: '.$btn_width.'px; height: '.$button_size.'px; background-image: url('.$SITE_URL.'img/social_icon/'.$img.'); background-position: -'.$bg_position.'px 0px;"></div>';

  
}

if(in_array('15',$network))
{
    $bg_position=((14)*$btn_width);

    $imgdiv .='<div style="float: left; margin-right: 10px;margin-top: 10px; width: '.$btn_width.'px; height: '.$button_size.'px; background-image: url('.$SITE_URL.'img/social_icon/'.$img.'); background-position: -'.$bg_position.'px 0px;"></div>';
  
}

if(in_array('16',$network))
{
    $bg_position=((15)*$btn_width); //change when image is added 

    $imgdiv .='<div style="float: left; margin-right: 10px;margin-top: 10px; width: '.$btn_width.'px; height: '.$button_size.'px; background-image: url('.$SITE_URL.'img/social_icon/'.$img.'); background-position: -'.$bg_position.'px 0px;"></div>';
  
}

if(in_array('5',$network))
{
    $bg_position=((4)*$btn_width);
    
    $imgdiv .='<div style="float: left; margin-right: 10px;margin-top: 10px; width: '.$btn_width.'px; height: '.$button_size.'px; background-image: url('.$SITE_URL.'img/social_icon/'.$img.'); background-position: -'.$bg_position.'px 0px;"></div>';
    
  
}

            
           
      return '<div style="margin-bottom:20px;width:360px;margin-bottom:10px;float:left;">'.$imgdiv.'</div>';
        
      }
         else
         {
            return "<h1>Please provide valid API setting</h1>";
         }
 
 
            
        
        
        
    }
    
}
?>