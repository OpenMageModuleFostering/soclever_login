<?php
class Soclever_Socialloginsc_Block_Help extends Mage_Adminhtml_Block_System_Config_Form_Fieldset {
    public function render(Varien_Data_Form_Element_Abstract $element) {
        $html = $this->_getHeaderHtml($element);
        $html.= $this->_getFieldHtml($element);
        $html .= $this->_getFooterHtml($element);
        return $html;
    }
    protected function _getFieldHtml($fieldset) {
        $content = '<ul style="float:left; margin-right:43px">
			<li>1. <a target="_blank" href="https://www.socleversocial.com/dashboard/login.php">Login</a> to your SoClever account. Or <a target="_blank" href="https://www.socleversocial.com/pricing/">Register</a> for free account to generate API Keys.  </li>
			<li>2. Go to <a target="_blank" href="https://www.socleversocial.com/dashboard/billing_profile_setting.php">Site Settings</a> . Your API key, API secret and site ID will be displayed on this page.</li>
			<li>3. Configure your API details on API settings tab on your magento Admin Panel.</li>
			<li>4. To be able to enable Social Login for your site, please create Social Apps on social networks. For more information on how to create Apps for your website please visit our help section on <a target="_blank" href="http://developers.socleversocial.com/category/social-network-set-up/">Social Network Set Up</a>.</li>
			<li>5. Please configure your Social Apps API details on SoClever <a target="_blank" href="https://www.socleversocial.com/dashboard/authorization_setting.php">Authorization page</a>.</li>
			<li>6. Once you configure Authorization Page, social network buttons will be unlocked to use at <a target="_blank" href="https://www.socleversocial.com/dashboard/social_login_setting.php">Login Settings Page</a>. Please select social networks you want to use for social login and save settings.</li>
			<li>7. Refresh your admin panel to configure button size, padding gap and buttons style.</li>
			<li>Feel free to <a target="_blank" href="https://www.socleversocial.com/contact-us/">contact us</a> for any assistance you may require.</li>
			</ul>
		';
        return $content;
    }
}