<?php
class Soclever_Socialloginsc_IndexController extends Mage_Core_Controller_Front_Action
{
 public function indexAction()
{  
  $this->loadLayout();     
  $this->renderLayout();
 }

public function getAction()
{
        $type = $this->getRequest()->getParam('t');
 
        switch ($type) {
            case 'image':
                return $this->_image();
                break;
            default:
                $this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
                $this->getResponse()->setHeader('Status','404 File not found');
                break;
        }
 }
    
 private function _image()
 {
        $file = $this->getRequest()->getParam('f');
        $type = $this->getRequest()->getParam('t');
 
        $helper = Mage::helper('socialloginsc');
        
        $icon = new Varien_Image($helper->getExtPubDir($helper::DIR_IMAGE).DS.$file);
            $this->getResponse()->setHeader('Content-Type', $icon->getMimeType());
            $this->getResponse()->setBody($icon->display());
       
        
 }
    
 protected function getSession(){
		return Mage::getSingleton('customer/session');
 }


public function liloginAction()
{
    
    

if(isset($_GET['lc']) && $_GET['lc']!='')
{
    setcookie('lc',$_GET['lc'],time()+100,'/');
    setcookie('lch',$_GET['lch'],time()-100,'/');

}
 if(isset($_GET['lch']) && $_GET['lch']!='')
{
    setcookie('lch',$_GET['lch'],time()+100,'/');
    setcookie('lc',$_GET['lc'],time()-100,'/');

}  


$helper = Mage::helper('socialloginsc');
$file_headers = get_headers("https://www.socleversocial.com/dashboard/scon.php");
if(strpos($file_headers[0], '200') !== false)
{
  $soclever_on=1;
  $get_fb=$helper->get_cscurl("https://www.socleversocial.com/dashboard/get_fb_data.php?siteid=".Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid')."&is_li=1");
  $appData=explode("~",$get_fb);
  $api_key=$appData[0];
  $secret_key=$appData[1];
  
}
else
{
    $soclever_on=0;
    $api_key=Mage::getStoreConfig('socialloginsc_options/displaysettings/socialloginscgpappid');
    $secret_key=Mage::getStoreConfig('socialloginsc_options/displaysettings/socialloginscgpsecretkey');;
}

$state="SCS02102013";
$redirect_uri=urlencode("".Mage::getBaseUrl()."soclever_socialloginsc/index/lilogin");

$scope="r_basicprofile r_emailaddress";
$code = $_REQUEST["code"];   

if(empty($code)) 
{
 $dialog_url = "https://www.linkedin.com/uas/oauth2/authorization?response_type=code&client_id=".$api_key."&state=".$state."&redirect_uri=".$redirect_uri."&scope=".urlencode($scope)."";
 echo("<script>top.location.href='".$dialog_url."'</script>");
}
else { 
    
    $token_url = "https://www.linkedin.com/uas/oauth2/accessToken?grant_type=authorization_code&client_id="
        .$api_key. "&redirect_uri=".$redirect_uri."&client_secret="
        .$secret_key. "&code=".$code;

	$ch = curl_init();
                    	
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	//Get Access Token
	curl_setopt($ch, CURLOPT_URL,$token_url);
	$access_token = curl_exec($ch);
  
	curl_close($ch);
	
    $acce_token=json_decode($access_token);
    $graph_url = "https://api.linkedin.com/v1/people/~:(id,num-connections,picture-url,email-address,first-name,last-name,headline,industry,location,date-of-birth,phone-numbers,main-address,public-profile-url,positions,summary,specialties,current-share)?format=json";
    
    
	$ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $graph_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(    
    'Connection: Keep-Alive',
    'Authorization: Bearer '.$acce_token->access_token.''
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    $temp_user = curl_exec($ch);
    curl_close($ch);
    
    
    $fbuser=json_decode($temp_user);
    
    if($soclever_on == 1){
            
            
            
            
            $resPonse=$helper->get_cscurl("https://www.socleversocial.com/dashboard/track_register_new.php?is_li=1&is_from=2&to_share=0&siteid=".Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid')."&other=".urlencode($temp_user));
            
            $fb_data=json_decode($resPonse);
            
            $this->no_analytics_login($fb_data->email,$fb_data->first_name,$fb_data->last_name,'2',$fb_data->member_id);
          
            
            
            
            } else {
            
            
            $this->no_analytics_login($fbuser->emailAddress,$fbuser->firstName,$fbuser->lastName,'2','0');
            
            
            } 

       
    
    
	
    
    
}        

}


public function gploginAction()
{

if(isset($_GET['lc']) && $_GET['lc']!='')
{
    setcookie('lc',$_GET['lc'],time()+100,'/');
    setcookie('lch',$_GET['lch'],time()-100,'/');

}
 if(isset($_GET['lch']) && $_GET['lch']!='')
{
    setcookie('lch',$_GET['lch'],time()+100,'/');
    setcookie('lc',$_GET['lc'],time()-100,'/');

}  


$helper = Mage::helper('socialloginsc');
$file_headers = get_headers("https://www.socleversocial.com/dashboard/scon.php");
if(strpos($file_headers[0], '200') !== false)
{
  $soclever_on=1;
  $get_fb=$helper->get_cscurl("https://www.socleversocial.com/dashboard/get_fb_data.php?siteid=".Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid')."&action=gsecret");
  $appData=explode("~~",$get_fb);
  
}
else
{
    $soclever_on=0;
    $appData[0]=Mage::getStoreConfig('socialloginsc_options/displaysettings/socialloginscgpappid');
    $appData[1]=Mage::getStoreConfig('socialloginsc_options/displaysettings/socialloginscgpsecretkey');;
}


$oauth2_client_id=$appData[0];
$oauth2_secret=$appData[1];
$oauth2_redirect = Mage::getBaseUrl().'soclever_socialloginsc/index/gplogin';

$oauth2_server_url = 'https://accounts.google.com/o/oauth2/auth';
$scope_array=array(
               'https://www.googleapis.com/auth/plus.login',
              'https://www.googleapis.com/auth/plus.me',
              'https://www.googleapis.com/auth/userinfo.email',
              'https://www.googleapis.com/auth/userinfo.profile',
              
          );
$query_params = array(
           'response_type' => 'code',
           'client_id' => $oauth2_client_id,
           'redirect_uri' => $oauth2_redirect,
           'scope' =>'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.login'
           );

$forward_url = $oauth2_server_url . '?' . http_build_query($query_params);


$code = $_REQUEST["code"];
if(empty($code))
{
    echo("<script>top.location.href='".$forward_url."'</script>");

}
$params = array(
        "code" => $code,
        "client_id" => $oauth2_client_id,
        "client_secret" => $oauth2_secret,
        "redirect_uri" => $oauth2_redirect,
        "grant_type" => "authorization_code"
    );
    $token_url = "https://www.googleapis.com//oauth2/v3/token";
    
  $postData = '';
   
   foreach($params as $k => $v) 
   { 
      $postData .= $k . '='.$v.'&'; 
   }
   rtrim($postData, '&');
 
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$token_url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false); 
    curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
 
    $output=curl_exec($ch);
 
    curl_close($ch);
    $acc_token=json_decode($output);

   $url='https://www.googleapis.com/plus/v1/people/me';
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
    $curlheader[0] = "Authorization: Bearer " . $acc_token->access_token;
    curl_setopt($curl, CURLOPT_HTTPHEADER, $curlheader);
 
    $json_response = curl_exec($curl);
   
    curl_close($curl);
         
    $responseObj = json_decode($json_response);

        
        if($soclever_on == 1){
            
            
            
            
            $resPonse=$helper->get_cscurl("https://www.socleversocial.com/dashboard/track_register_new.php?is_gp=1&siteid=".Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid')."&other=".urlencode($json_response));
            
            $fb_data=json_decode($resPonse);
            
            $this->no_analytics_login($fb_data->email,$fb_data->first_name,$fb_data->last_name,'3',$fb_data->member_id);
          
            
            
            
            } else {
            
            
            
            $this->no_analytics_login($responseObj->emails[0]->value,$responseObj->name->givenName,$responseObj->name->familyName,'3','0');
            
            
            } 

       


}

 public function fbloginAction()
{

if(isset($_GET['lc']) && $_GET['lc']!='')
{
    setcookie('lc',$_GET['lc'],time()+100,'/');
    setcookie('lch',$_GET['lch'],time()-100,'/');

}
 if(isset($_GET['lch']) && $_GET['lch']!='')
{
    setcookie('lch',$_GET['lch'],time()+100,'/');
    setcookie('lc',$_GET['lc'],time()-100,'/');

}  
$helper = Mage::helper('socialloginsc');
$file_headers = get_headers("https://www.socleversocial.com/dashboard/scon.php");
if(strpos($file_headers[0], '200') !== false)
{
  $soclever_on=1;
  $get_fb=$helper->get_cscurl("https://www.socleversocial.com/dashboard/get_fb_data.php?siteid=".Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid')."");

  $my_Api=explode("~",$get_fb);
  $app_id =$my_Api[0];

  $app_secret =$my_Api[1];
   
}  
else
{
 $soclever_on=0;
$app_id =Mage::getStoreConfig('socialloginsc_options/displaysettings/socialloginscfbappid');

$app_secret =Mage::getStoreConfig('socialloginsc_options/displaysettings/socialloginscfbsecretkey');
 
    
}
   
   
   
   
  
   $my_url="".Mage::getBaseUrl()."soclever_socialloginsc/index/fblogin";  
   $code = $_REQUEST["code"];
   if(isset($_REQUEST['error'])){
    if(isset($_REQUEST['error_reason']) && $_REQUEST['error_reason']=='user_denied'){
        
        echo $_REQUEST['error'];
        echo"<br/><a href='".Mage::getBaseUrl()."'>Go to site</a>";
       exit;
  }
}
 
 if(empty($code)) {
        $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
            . $app_id . "&redirect_uri=" . urlencode($my_url)."&scope=email,user_birthday,user_relationships,user_location,user_hometown,user_friends,user_likes&display=popup";

        echo("<script>top.location.href='".$dialog_url."'</script>");
    }

    $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
        . $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret="
        . $app_secret . "&code=" . $code;

	$ch = curl_init();
                    	
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	//Get Access Token
	curl_setopt($ch, CURLOPT_URL,$token_url);
	$access_token = curl_exec($ch);
  
	curl_close($ch);
	
	
    $graph_url = "https://graph.facebook.com/v2.2/me?" . $access_token."&fields=id,name,first_name,last_name,timezone,email,picture,gender,locale,birthday,relationship_status,location,hometown,friends.limit%280%29,likes{id,name}";
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $graph_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $temp_user = curl_exec($ch);
    curl_close($ch);
	$fbuser_old = $temp_user;
    
    if($soclever_on == 1){
            
            
              $resPonse=$helper->get_cscurl("https://www.socleversocial.com/dashboard/track_register_new.php?app_id=".$app_id."&is_fb=1&friend_data=".$fbuser->friends->summary->total_count."&siteid=".Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid')."&other=".urlencode($fbuser_old));
            $fb_data=json_decode($resPonse);
            
            $this->no_analytics_login($fb_data->email,$fb_data->first_name,$fb_data->last_name,'7',$fb_data->member_id);
          
            
            
            
            } else {
            
            
            $fb_data=json_decode($fbuser_old);
            $this->no_analytics_login($fb_data->email,$fb_data->first_name,$fb_data->last_name,'7','0');
            
            
            } 
       
    
    	
	
   
    
		   
	  
}   

public function paypalloginAction()
{
    
if(isset($_GET['lc']) && $_GET['lc']!='')
{
    setcookie('lc',$_GET['lc'],time()+100,'/');
    setcookie('lch',$_GET['lch'],time()-100,'/');

}
 if(isset($_GET['lch']) && $_GET['lch']!='')
{
    setcookie('lch',$_GET['lch'],time()+100,'/');
    setcookie('lc',$_GET['lc'],time()-100,'/');

} 
$helper = Mage::helper('socialloginsc');
$file_headers = get_headers("https://www.socleversocial.com/dashboard/scon.php");
if(strpos($file_headers[0], '200') !== false)
{
  $soclever_on=1;
  $get_fb=$helper->get_cscurl("https://www.socleversocial.com/dashboard/get_fb_data.php?siteid=".Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid')."&is_pp=1");

  $my_Api=explode("~",$get_fb);
  $client_id =$my_Api[0];

  $client_secret =$my_Api[1];
   
}  
else
{
$soclever_on=0;
$client_id=Mage::getStoreConfig('socialloginsc_options/displaysettings/socialloginscppappid');

$client_secret=Mage::getStoreConfig('socialloginsc_options/displaysettings/socialloginscppsecretkey');
 
    
}            
    

$scopes = 'email profile address phone https://uri.paypal.com/services/paypalattributes https://uri.paypal.com/services/paypalattributes ';  //e.g. openid email profile https://uri.paypal.com/services/paypalattributes

$app_return_url ="".Mage::getBaseUrl()."soclever_socialloginsc/index/paypallogin";  // Redirect url



$nonce = time() . rand();

$code = $_REQUEST["code"];

if(empty($code)) {
    #IF the code paramater is not available, load the auth url.
    $state = md5(uniqid(rand(), TRUE)); // CSRF protection
    $paypal_auth_url = "https://www.paypal.com/webapps/auth/protocol/openidconnect/v1/authorize?"
            ."client_id=".$client_id
            ."&response_type=code"
            ."&scope=".$scopes
            ."&nonce=".$nonce
            ."&state=".$state
            ."&redirect_uri=".$app_return_url;


   echo("<script>top.location.href='".$paypal_auth_url."'</script>");    
    
}else{
    /* GET Access TOKEN */
    $token_url = "https://www.paypal.com/webapps/auth/protocol/openidconnect/v1/tokenservice?";    
    $token_url .= "client_id=".$client_id
            ."&client_secret=".$client_secret
            ."&response_type=access_token"
            ."&grant_type=authorization_code"
            ."&code=".$code;
           
            
            $profile_new=json_decode($helper->get_cscurl($token_url));
          



if($profile_new->access_token)
{
    $clientSite=$row_valid['site_url'];
    $profile_url = "https://www.paypal.com/webapps/auth/protocol/openidconnect/v1/userinfo?"
            ."schema=openid"
            ."&access_token=".$profile_new->access_token;
            
            $send_data=$helper->get_cscurl($profile_url);
           
            
            
           if($soclever_on == 1){
            
            
              $resPonse=$helper->get_cscurl("https://www.socleversocial.com/dashboard/track_register_new.php?is_pp=1&siteid=".Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid')."&other=".urlencode($send_data));
            $fb_data=json_decode($resPonse);
            
            $this->no_analytics_login($fb_data->email,$fb_data->first_name,$fb_data->last_name,'7',$fb_data->member_id);
          
            
            
            
            } else {
            
            
            $fb_data=json_decode($send_data);
            $this->no_analytics_login($fb_data->email,$fb_data->given_name,$fb_data->family_name,'7','0');
            
            
            } 
       
            
            
            
}


}
}


public function no_analytics_login($fb_dataemail,$fb_datafirst_name,$fb_datalast_name,$is_from,$member_id)
{
    
 
$resource   = Mage::getSingleton('core/resource');  
$customer = Mage::getModel("customer/customer");
$websiteId = Mage::app()->getWebsite()->getId();

$helper = Mage::helper('socialloginsc');

 if ($websiteId) {
        $customer->setWebsiteId($websiteId);
    }
    $customer->loadByEmail($fb_dataemail);
    if ($customer->getId()) {
    $is_new='0';
    $username=$fb_dataemail;  
    $customer_id=$customer->getId();
  }
  else
  {
    $is_new='1';
    $store = Mage::app()->getStore();
    
    //$customer->website_id = $websiteId;
    $customer->setStore($store);       
    $password=rand("111111","9999999");
    $customer->firstname = $fb_datafirst_name;
    $customer->lastname = $fb_datalast_name;
    $customer->email = $fb_dataemail;
    $customer->password_hash = md5($password);
    $customer->save();
    $customer_id=$customer->getId();
    $username=$fb_dataemail;
    
  }
  
  Mage::getModel('core/session', array('name' => 'frontend'));
  $customer->setCustomerActivated(true);
  $customer->setData('password',$password);
  $customer->save();              
   if($is_new=='1' && Mage::getStoreConfig('socialloginsc_options/displaysettings/socialloginregemail')=='1')
  {
    $customer->sendNewAccountEmail();
     
  }

  $this->getSession()->loginById($customer->getId());
  
  if(Mage::getSingleton('customer/session')->isLoggedIn())
  {
    
  Mage::getSingleton('core/session')->setSessionVariable($is_from);
    
  if($member_id!='0')
  {  
   Mage::getSingleton('core/session')->setSocleverMemberId($member_id);
   $helper->get_cscurl("https://www.socleversocial.com/dashboard/track_register_new.php?is_from=".$is_from."&siteUid=".$customer->getId()."&is_new=".$is_new."&member_id=".$member_id."&siteid=".Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid')."&action=notifycs");
  }  
 
 $redirect_location=($_COOKIE['lc']=='c')?Mage::getBaseUrl()."checkout/onepage/":Mage::getBaseUrl()."customer/account/";
  if(isset($_COOKIE['lch']) && $_COOKIE['lch']!='')
  {
    $redirect_location=$_COOKIE['lch'];
  }   
  
  $isIosChrome = (strpos($_SERVER['HTTP_USER_AGENT'], 'CriOS') !== false) ? true : false;
  
   if(!$isIosChrome) { ?>    
  
  <script type="text/javascript">
  
  setTimeout(function(){
    
    opener.location.href="<?php echo $redirect_location;?>";
    this.close();
    
    },1000);
  </script>
  <?php
  }
  else
  {
    
  ?>
  
   <script type="text/javascript">    
    window.location.href="<?php echo $redirect_location; ?>";
    </script>
  
  <?php  
    
  }
        
  }  
    
}

   
public function yahoologinAction()
{
    if(isset($_GET['lc']) && $_GET['lc']!='')
{
    setcookie('lc',$_GET['lc'],time()+100,'/');
    setcookie('lch',$_GET['lch'],time()-100,'/');

}
 if(isset($_GET['lch']) && $_GET['lch']!='')
{
    setcookie('lch',$_GET['lch'],time()+100,'/');
    setcookie('lc',$_GET['lc'],time()-100,'/');

}
    
    require 'openid.php';
    
    $file_headers = get_headers("https://www.socleversocial.com/dashboard/scon.php");
if(strpos($file_headers[0], '200') !== false)
{
  $soclever_on=1;
 }
 else
 {
    $soclever_on=0;
 } 
 
try
{
   
    
    $openid = new LightOpenID($_SERVER['HTTP_HOST']);
     
    
    if(!$openid->mode)
    {
         
        //do the login
        if(isset($_GET['login']))
        {
            //The google openid url
            $openid->identity = 'https://me.yahoo.com';
             
            //Get additional google account information about the user , name , email , country
            $openid->required = array('contact/email','person/guid','dob','birthDate','namePerson' , 'person/gender' , 'pref/language' , 'media/image/default','birthDate/birthday');
             
            //start discovery
            
            
            header('Location: ' . $openid->authUrl());
        }
        
         
    }
     
    else if($openid->mode == 'cancel')
    {
        echo 'User has canceled authentication!';
       
    }
     
    
    else
    {
        if($openid->validate())
        {
            
            $d = $openid->getAttributes();
            
            
            if($soclever_on == 1){
            
            
           
          
            $helper=Mage::helper('socialloginsc');
            $resPonse=$helper->get_cscurl("https://www.socleversocial.com/dashboard/track_register_new.php?is_yh=1&is_from=5&siteid=".Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid')."&other=".urlencode(json_encode($d)));
            
            $fb_data=json_decode($resPonse);
            
            $this->no_analytics_login($fb_data->email,$fb_data->first_name,$fb_data->last_name,'5',$fb_data->member_id);
          
            
            
            
            } else {
            
            
            $name_Arr=explode(" ",$d['contact/email']);
            $this->no_analytics_login($d['contact/email'] ,$name_Arr[0],$name_Arr[1],'5','0');
            
            
            } 

            
        }
        else
        {
            
        }
    }
}
 
catch(ErrorException $e)
{
    echo $e->getMessage();

    
}    
	
}

public function scsl_general_login($response,$is_from,$email,$soclever_on)
{
    
    
    $site_id=Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid');
    $helper = Mage::helper('socialloginsc');
     if($is_from=='4' || $is_from=='11')
     {
      $action=($is_from=='4')?'trk_tw':'trk_vk';  
      
      
      if($soclever_on=='1')
      {
      $tw_login=$helper->get_cscurl("https://www.socleversocial.com/dashboard/track_twitter.php?action=".$action."&siteid=".$site_id."&email=".urlencode($email)."&tw_data=".urlencode($response)."");
      if($tw_login)
      {
        $loginl_data=json_decode($tw_login);
        
        $this->no_analytics_login($email,$loginl_data->first_name,$loginl_data->last_name,$is_from,$loginl_data->member_id);
        
        
        
      }
      }
      else
      {
        $loginl_data=explode("~~~",$response);
        
        $fname_arr=explode(" ",$loginl_data[0]);
        $this->no_analytics_login($email,$fname_arr[0],$fname_arr[1],$is_from,'0');
        
      }
    }
}

public function msloginAction()
{
    $helper = Mage::helper('socialloginsc');
$file_headers = get_headers("https://www.socleversocial.com/dashboard/scon.php");
if(strpos($file_headers[0], '200') !== false)
{
  $soclever_on=1;
  $get_fb=$helper->get_cscurl("https://www.socleversocial.com/dashboard/get_fb_data.php?siteid=".Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid')."&is_ms=1");
  $appData=explode("~",$get_fb);
  $my_Api[0]=$appData[0];
  $my_Api[1]=$appData[1];
  
}
else
{
    $soclever_on=0;
    $my_Api[0]=Mage::getStoreConfig('socialloginsc_options/displaysettings/socialloginscmsappid');
    $my_Api[1]=Mage::getStoreConfig('socialloginsc_options/displaysettings/socialloginscmssecretkey');
}



require('http.php');    
require('oauth_client.php');
$client = new oauth_client_class;
    $client->server = 'Microsoft';
    $client->redirect_uri = ''.Mage::getBaseUrl().'soclever_socialloginsc/index/mslogin';
    
    
    $client->client_id = $my_Api[0]; 
    $application_line = __LINE__;
    $client->client_secret = $my_Api[1];
    
    

    if(strlen($client->client_id) == 0
    || strlen($client->client_secret) == 0)
        die('Microsoft failed.');

    /* API permissions
     */
    $client->scope = 'wl.basic wl.emails wl.birthday';
    if(($success = $client->Initialize()))
    {
        if(($success = $client->Process()))
        {
            if(strlen($client->authorization_error))
            {
                $client->error = $client->authorization_error;
                exit($client->error);
                $success = false;
            }
            elseif(strlen($client->access_token))
            {
                $success = $client->CallAPI(
                    'https://apis.live.net/v5.0/me',
                    'GET', array(), array('FailOnAccessError'=>true), $user);
            }
        }
        $success = $client->Finalize($success);
    }
    if($client->exit)
    {
        exit('Microsoft Login Failed');
    }    
    if($success)
    {

            $your_data=json_encode($user);
            
            
            
            if($soclever_on == 1){
            
            
            
            $resPonse=$helper->get_cscurl("https://www.socleversocial.com/dashboard/track_register_new.php?is_ms=1&&siteid=".Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid')."&other=".urlencode($your_data));
            $fb_data=json_decode($resPonse);
            
            $this->no_analytics_login($fb_data->email,$fb_data->first_name,$fb_data->last_name,'8',$fb_data->member_id);
          
            
            
            
            } else {
            
            
            $content=json_decode($your_data);
            $this->no_analytics_login($content->emails->account,$content->first_name,$content->last_name,'8','0');
            
            
            }
            
            
            
            
    }


    
}    

public function twloginAction()
{
$site_id=Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid');
if(isset($_GET['lc']) && $_GET['lc']!='')
{
    setcookie('lc',$_GET['lc'],time()+100,'/');
    setcookie('lch',$_GET['lch'],time()-100,'/');

}
 if(isset($_GET['lch']) && $_GET['lch']!='')
{
    setcookie('lch',$_GET['lch'],time()+100,'/');
    setcookie('lc',$_GET['lc'],time()-100,'/');

}

$helper = Mage::helper('socialloginsc');
$file_headers = get_headers("https://www.socleversocial.com/dashboard/scon.php");
if(strpos($file_headers[0], '200') !== false)
{
  $soclever_on=1;
  $get_fb=$helper->get_cscurl("https://www.socleversocial.com/dashboard/get_fb_data.php?siteid=".Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid')."&is_tw=1");
  $appData=explode("~",$get_fb);
  $my_Api[0]=$appData[0];
  $my_Api[1]=$appData[1];
  
}
else
{
    $soclever_on=0;
    $my_Api[0]=Mage::getStoreConfig('socialloginsc_options/displaysettings/socialloginsctwappid');
    $my_Api[1]=Mage::getStoreConfig('socialloginsc_options/displaysettings/socialloginsctwsecretkey');
}


if(isset($_POST['submit']) && $_POST['submit']=='Login' )
{
    $this->scsl_general_login($_POST['response_str'],'4',$_POST['email'],$soclever_on);
    
    exit;
}


    if($my_Api[0]!='0')
    {
       
require('http.php');    
require('oauth_client.php');
$client = new oauth_client_class;
    $client->server = 'Twitter';
    $client->redirect_uri = ''.Mage::getBaseUrl().'soclever_socialloginsc/index/twlogin';
    
    $client->client_id = $my_Api[0]; 
    $application_line = __LINE__;
    $client->client_secret = $my_Api[1];
    
    

    if(strlen($client->client_id) == 0
    || strlen($client->client_secret) == 0)
        die('twitter failed.');

    /* API permissions
     */
    $client->scope = 'wl.basic wl.emails wl.birthday';
    if(($success = $client->Initialize()))
    {
        if(($success = $client->Process()))
        {
            if(strlen($client->authorization_error))
            {
                $client->error = $client->authorization_error;
                exit($client->error);
                $success = false;
            }
            elseif(strlen($client->access_token))
            {
                $success = $client->CallAPI(
                     'https://api.twitter.com/'. '1.1/account/'. 'verify_credentials.json',
                    'GET', array(), array('FailOnAccessError'=>true), $user);
            }
        }
        $success = $client->Finalize($success);
    }
    if($client->exit)
    {
        exit('Twitter Login Failed');
    }    
    if($success)
    {
      
        $your_data=json_encode($user);
        $content=json_decode($your_data);
        
        
  $twitter_arr=array();
  $twitter_arr['full_name']=$content->name;
  $twitter_arr['profile_id']=$content->id;
  $twitter_arr['screen_name']=$content->screen_name;
  $twitter_arr['location']=$content->location;
  $twitter_arr['description']=$content->description;
  $twitter_arr['following_count']=$content->friends_count;
  $twitter_arr['follower_count']=$content->followers_count;
  $twitter_arr['tweet_count']=$content->statuses_count;
  $twitter_arr['is_verified']=$content->verified;
  $twitter_arr['lang']=$content->lang;
  $twitter_arr['profile_pic']=$content->profile_image_url;
  $twitter_arr['time_zone']=$content->time_zone;
  


        $chk_twitter=$helper->get_cscurl("https://www.socleversocial.com/dashboard/track_twitter.php?site_id=".$site_id."&twitter_id=".$twitter_arr['profile_id']."&action=chk_tw");
        //$chk_twitter='1';
        if($chk_twitter=='0' || $soclever_on=='0')
        {
         ?>
         <style>
         #container_demo{
	     text-align: left;
	     margin: 0;
	       padding: 0;
	      margin: 0 auto;
	 font-family: "Trebuchet MS","Myriad Pro",Arial,sans-serif;
    }

                #wrapper{
                	
                	right: 0px;
                	height: 400px;	
                	margin: 0px auto;	
                	
                	position: relative;	
                }
                #wrapper a{
                	color: rgb(95, 155, 198);
                	text-decoration: underline;
                }
                
                #wrapper h1{
                	font-size: 48px;
                	color: rgb(6, 106, 117);
                	padding: 2px 0 10px 0;
                	font-family: 'FranchiseRegular','Arial Narrow',Arial,sans-serif;
                	font-weight: bold;
                	text-align: center;
                	padding-bottom: 30px;
                }
                
                #wrapper h1{
                    background: -webkit-repeating-linear-gradient(-45deg, 
                	rgb(18, 83, 93) , 
                	rgb(18, 83, 93) 20px, 
                	rgb(64, 111, 118) 20px, 
                	rgb(64, 111, 118) 40px, 
                	rgb(18, 83, 93) 40px);
                	-webkit-text-fill-color: transparent;
                	-webkit-background-clip: text;
                }
                #wrapper h1:after{
                	content: ' ';
                	display: block;
                	width: 100%;
                	height: 2px;
                	margin-top: 10px;
                	background: -moz-linear-gradient(left, rgba(147,184,189,0) 0%, rgba(147,184,189,0.8) 20%, rgba(147,184,189,1) 53%, rgba(147,184,189,0.8) 79%, rgba(147,184,189,0) 100%); 
                	background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(147,184,189,0)), color-stop(20%,rgba(147,184,189,0.8)), color-stop(53%,rgba(147,184,189,1)), color-stop(79%,rgba(147,184,189,0.8)), color-stop(100%,rgba(147,184,189,0))); 
                	background: -webkit-linear-gradient(left, rgba(147,184,189,0) 0%,rgba(147,184,189,0.8) 20%,rgba(147,184,189,1) 53%,rgba(147,184,189,0.8) 79%,rgba(147,184,189,0) 100%); 
                	background: -o-linear-gradient(left, rgba(147,184,189,0) 0%,rgba(147,184,189,0.8) 20%,rgba(147,184,189,1) 53%,rgba(147,184,189,0.8) 79%,rgba(147,184,189,0) 100%); 
                	background: -ms-linear-gradient(left, rgba(147,184,189,0) 0%,rgba(147,184,189,0.8) 20%,rgba(147,184,189,1) 53%,rgba(147,184,189,0.8) 79%,rgba(147,184,189,0) 100%); 
                	background: linear-gradient(left, rgba(147,184,189,0) 0%,rgba(147,184,189,0.8) 20%,rgba(147,184,189,1) 53%,rgba(147,184,189,0.8) 79%,rgba(147,184,189,0) 100%); 
                }
                
                #wrapper p{
                	margin-bottom:15px;
                }
                #wrapper p:first-child{
                	margin: 0px;
                }
                #wrapper label{
                	color: rgb(64, 92, 96);
                	position: relative;
                }
                ::-webkit-input-placeholder  { 
                	color: rgb(190, 188, 188); 
                	font-style: italic;
                }
                input:-moz-placeholder,
                textarea:-moz-placeholder{ 
                	color: rgb(190, 188, 188);
                	font-style: italic;
                } 
                input {
                  outline: none;
                }
                
                
                #wrapper input:not([type="checkbox"]){
                	width: 92%;
                	margin-top: 4px;
                	padding: 10px 5px 10px 32px;	
                	border: 1px solid rgb(178, 178, 178);
                	-webkit-appearance: textfield;
                	-webkit-box-sizing: content-box;
                	  -moz-box-sizing : content-box;
                	       box-sizing : content-box;
                	-webkit-border-radius: 3px;
                	   -moz-border-radius: 3px;
                	        border-radius: 3px;
                	-webkit-box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
                	   -moz-box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
                	        box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
                	-webkit-transition: all 0.2s linear;
                	   -moz-transition: all 0.2s linear;
                	     -o-transition: all 0.2s linear;
                	        transition: all 0.2s linear;
                }
                
                /*styling both submit buttons */
                #wrapper p.button input{
                	width: 30%;
                	cursor: pointer;	
                	background: rgb(61, 157, 179);
                	padding: 8px 5px;
                	font-family: 'BebasNeueRegular','Arial Narrow',Arial,sans-serif;
                	color: #fff;
                	font-size: 24px;	
                	border: 1px solid rgb(28, 108, 122);	
                	margin-bottom: 10px;	
                	text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);
                	-webkit-border-radius: 3px;
                	   -moz-border-radius: 3px;
                	        border-radius: 3px;	
                	-webkit-box-shadow: 0px 1px 6px 4px rgba(0, 0, 0, 0.07) inset,
                	        0px 0px 0px 3px rgb(254, 254, 254),
                	        0px 5px 3px 3px rgb(210, 210, 210);
                	   -moz-box-shadow:0px 1px 6px 4px rgba(0, 0, 0, 0.07) inset,
                	        0px 0px 0px 3px rgb(254, 254, 254),
                	        0px 5px 3px 3px rgb(210, 210, 210);
                	        box-shadow:0px 1px 6px 4px rgba(0, 0, 0, 0.07) inset,
                	        0px 0px 0px 3px rgb(254, 254, 254),
                	        0px 5px 3px 3px rgb(210, 210, 210);
                	-webkit-transition: all 0.2s linear;
                	   -moz-transition: all 0.2s linear;
                	     -o-transition: all 0.2s linear;
                	        transition: all 0.2s linear;
                }
                #wrapper p.button input:hover{
                	background: rgb(74, 179, 198);
                }
                #wrapper p.button input:active,
                #wrapper p.button input:focus{
                	background: rgb(40, 137, 154);
                	position: relative;
                	top: 1px;
                	border: 1px solid rgb(12, 76, 87);	
                	-webkit-box-shadow: 0px 1px 6px 4px rgba(0, 0, 0, 0.2) inset;
                	   -moz-box-shadow: 0px 1px 6px 4px rgba(0, 0, 0, 0.2) inset;
                	        box-shadow: 0px 1px 6px 4px rgba(0, 0, 0, 0.2) inset;
                }
                p.login.button,
                p.signin.button{
                	text-align: right;
                	margin: 5px 0;
                }
                
                
                
                
                #login{
                	position: absolute;
                	top: 0px;
                	width: 88%;	
                	padding: 18px 6% 60px 6%;
                	margin: 0 0 35px 0;
                	background: rgb(247, 247, 247);
                	border: 1px solid rgba(147, 184, 189,0.8);
                	-webkit-box-shadow: 0pt 2px 5px rgba(105, 108, 109,  0.7),	0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
                	   -moz-box-shadow: 0pt 2px 5px rgba(105, 108, 109,  0.7),	0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
                	        box-shadow: 0pt 2px 5px rgba(105, 108, 109,  0.7),	0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
                	-webkit-box-shadow: 5px;
                	-moz-border-radius: 5px;
                		 border-radius: 5px;
                }
                
                #login{
                	z-index: 22;
                }
                #toregister:target ~ #wrapper #register,
                #tologin:target ~ #wrapper #login{
                	z-index: 22;
                	-webkit-animation-name: fadeInLeft;
                	-moz-animation-name: fadeInLeft;
                	-ms-animation-name: fadeInLeft;
                	-o-animation-name: fadeInLeft;
                	animation-name: fadeInLeft;
                	-webkit-animation-delay: .1s;
                	-moz-animation-delay: .1s;
                	-o-animation-delay: .1s;
                	-ms-animation-delay: .1s;
                	animation-delay: .1s;
                }
                
                .lt8 #wrapper input{
                	padding: 10px 5px 10px 32px;
                    width: 92%;
                }
                
                         </style>
         
         <div class="container">
            
            <div class="codrops-top">
                <div class="clr"></div>
            </div>
            <section>				
                <div id="container_demo" >                    
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form  action="" autocomplete="on" method="post">
                            <input type="hidden" name="response_str" value="<?php echo stripslashes(implode("~~~",$twitter_arr)); ?>" /> 
                                <h1>You are almost done!</h1> 
                                <p> 
                                    <label for="email" class="uname">Your email</label>
                                    <input id="email" name="email" required="required" type="text" placeholder="mymail@mail.com"/>
                                </p>
                                
                                
                                <p class="login button"> 
                                    <input type="submit" value="Login" name="submit" onclick="return chk_submit_email();"  /> 
								</p>
                                
                            </form>
                        </div>

                        
						
                    </div>
                </div>  
            </section>
        </div>
         <script type="text/javascript">
         
         
         function isvalidemail_form(str){
		
		var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-zA-Z]{2,6}(?:\.[a-zA-Z]{2})?)$/i	
		return (filter.test(str));
		}	

        function isWhitespace(charToCheck) {
        	var whitespaceChars = " \t\n\r\f";
        	return (whitespaceChars.indexOf(charToCheck) != -1);
        }
        function chk_submit_email()
        {
            var email=document.getElementById('email').value;
            if(!isWhitespace(email))
            {
                if(!isvalidemail_form(email))
                {
                  alert("Please enter valid email address");
                  return false;  
                }
            }
            else
            {
                alert("Please provide your email address.");
                return false;
            }
            
            
        }
            
         </script>
         <?php 
         exit;  
        }
        else
        {
          $this->scsl_general_login(stripslashes(implode("~~~",$twitter_arr)),'4',$chk_twitter,$soclever_on);  
        }
        
    }
    
    }
    
    
    
      

}




}
?>