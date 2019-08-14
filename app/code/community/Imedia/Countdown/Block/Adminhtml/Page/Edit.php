<?php
class Imedia_Countdown_Block_Adminhtml_Page_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
public function __construct()
{
    $this->_blockGroup = 'imedia_countdown';
    $this->_controller = 'adminhtml_page';

    parent::__construct();

   
}

/**
 * Get Header text
 *
 * @return string
 */
public function getHeaderText()
{
    if (Mage::registry('imedia_countdown')->getId()) {
        return Mage::helper('imedia_countdown')->__('Edit Countdown');
    }
    else {
        return Mage::helper('imedia_countdown')->__('New Countdown');
    }
}
}