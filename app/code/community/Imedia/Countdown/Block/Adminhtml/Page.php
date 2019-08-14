<?php
class Imedia_Countdown_Block_Adminhtml_Page extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup='imedia_countdown';
        $this->_controller='adminhtml_page';
        $this->_headerText= Mage::helper('imedia_countdown')->__('Countdown');
		$this->_addButton('module_controller', array(
        'label' => $this->__('Manage Products'),
        'onclick' => "setLocation('{$this->getUrl('*/featuredproduct/index')}')",
         ));
		
        parent::__construct();
		
		$this->_removeButton('add');
    }
}