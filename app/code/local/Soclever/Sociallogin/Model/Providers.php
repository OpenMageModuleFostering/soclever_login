<?php

class Soclever_Sociallogin_Model_Providers
{
    public function getbuttonstyles()
    {
        $buttonstylesarray=array("ic"=>"Icons","fc"=>"Full Logos - Colored","fg"=>"Full Logos - Grey");       
        return $buttonstylesarray;
        
    }
    public function getsizes()
    {
       
        $buttonsizearray=array("30"=>"30px","40"=>"40px","50"=>"50px","60"=>"60px","65"=>"65px");       
        return $buttonsizearray;
    }
public function getloginproviders()
    {
        return array(
            array('value'=>0, 'label'=>'None'),
            array('value'=>2, 'label'=>'Facebook'),
            array('value'=>4, 'label'=>'Google+'),
            array('value'=>7, 'label'=>'LinkedIN'),            
            array('value'=>15, 'label'=>'Yahoo!'),
            array('value'=>16, 'label'=>'Paypal'),
                                   
        );
        /*$providers=array("2"=>"Facebook","4"=>"Google+","7"=>"LinkedIN","13"=>"Twitter","17"=>"Pinterest");
        return $providers;*/
    }
public function showpoweredby()
    {
        $showpoweredby=array();
        $showpoweredby=array("1"=>"Yes","0"=>"No");
        return $showpoweredby;
        
    }
   

}


?>