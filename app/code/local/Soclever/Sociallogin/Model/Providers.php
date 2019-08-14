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
   

}


?>