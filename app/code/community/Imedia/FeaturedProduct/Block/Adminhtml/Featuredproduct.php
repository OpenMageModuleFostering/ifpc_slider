<?php
/**
 * Grid container block
 * 
 */
class Imedia_FeaturedProduct_Block_Adminhtml_Featuredproduct extends Mage_Adminhtml_Block_Widget_Grid_Container
{       
  public function __construct()
  {
    $this->_controller = 'adminhtml_featuredproduct';
    $this->_blockGroup = 'imedia_featuredproduct';
    $this->_headerText = Mage::helper('imedia_featuredproduct')->__('Manage Featured Products');
    
    parent::__construct();
    
    $this->_removeButton('add');
  }
}