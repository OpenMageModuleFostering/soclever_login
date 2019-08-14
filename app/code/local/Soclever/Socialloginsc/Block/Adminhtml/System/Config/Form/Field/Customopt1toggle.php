<?php
class Soclever_Socialloginsc_Block_Adminhtml_System_Config_Form_Field_Customopt1toggle extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    /**
     * Get element ID of the dependent field to toggle
     *
     * @param object $element
     * @return String
     */
    protected function _getToggleElementId($element)
    {
        return substr($element->getId(), 0, strrpos($element->getId(), 'mbcustomopt1')) . 'mbcustomopt2';
    }
    /**
     * Get element ID of the dependent field's parent row
     *
     * @param object $element
     * @return String
     */
    protected function _getToggleRowElementId($element)
    {
        return 'row_'.$this->_getToggleElementId($element);
    }
    /**
     * Override method to output our custom HTML with JavaScript
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return String
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
       
        // Get the default HTML for this option
        $html = parent::_getElementHtml($element);
        // Set up additional JavaScript for our toggle action. Note we are using the two helper methods above
        // to get the correct field ID's. They are hard-coded and depend on your option names in system.xml
        $javaScript = "
            <script type=\"text/javascript\">
                Event.observe(window, 'load', function() {
                    enabled=document.getElementById('socialloginsc_options_displaysettings_buttonstyle').value;
                    if (enabled=='custom') {
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstylefb').show();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstylegp').show();                        
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstyleli').show();                        
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstyletw').show();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstyleyh').show();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstylepp').show();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstylems').show();                        
                    } else {
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstylefb').hide();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstylegp').hide();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstyleli').hide();                        
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstyletw').hide();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstyleyh').hide();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstylepp').hide();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstylems').hide();
                        
                    }
                });
                Event.observe('socialloginsc_options_displaysettings_buttonstyle', 'change', function(){
                    enabled=document.getElementById('socialloginsc_options_displaysettings_buttonstyle').value;                    
                    if (enabled=='custom') {
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstylefb').show();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstylegp').show();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstyleli').show();                        
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstyletw').show();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstyleyh').show();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstylepp').show();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstylems').show();                                                
                    } else {
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstylefb').hide();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstylegp').hide();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstyleli').hide();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstyletw').hide();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstyleyh').hide();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstylepp').hide();
                        document.getElementById('row_socialloginsc_options_displaysettings_buttonstylems').hide();
                        
                    }
                });
            </script>";

        $html .= $javaScript;
        return $html;
    }
}

?>