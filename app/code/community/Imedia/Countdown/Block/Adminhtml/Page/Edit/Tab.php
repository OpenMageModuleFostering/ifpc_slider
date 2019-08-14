<?php
class Imedia_Countdown_Block_Adminhtml_Page_Edit_Tab extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('imedia_countdown')->__('Countdown'));
    }
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('imedia_countdown')->__('Countdown'),
            'title'     => Mage::helper('imedia_countdown')->__('Countdown'),
        ));

        return parent::_beforeToHtml();
    }
}