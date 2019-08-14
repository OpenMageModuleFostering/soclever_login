<?php
class Soclever_Socialloginsc_Helper_Data extends Mage_Core_Helper_Abstract
{
    
    const DIR_IMAGE = 'image';
    
    public function getExtPubDir($type)
    {
        return __DIR__.DS.'..'.DS.DS.'others'.DS.$type;
    }
 
    public function get_cscurl($url)
    {
    $return_value=file_get_contents($url);    
    if($return_value)
    {
     return $return_value;    
    }
    else
    {        
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);  
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);    
    curl_setopt($ch, CURLOPT_SSLVERSION,4);
    $result_response = curl_exec($ch);
    /*if($result_response === false)
    {
        echo 'Curl error: ' . curl_error($ch);
        exit;
    }*/
    $actual_return=$result_response;
    curl_close($ch);
    return $actual_return;
    }
    }
        
}
?>