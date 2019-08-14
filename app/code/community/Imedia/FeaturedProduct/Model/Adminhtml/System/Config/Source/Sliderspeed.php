<?php
/**
 * Featured products position source model
 */
class Imedia_FeaturedProduct_Model_Adminhtml_System_Config_Source_sliderspeed
{
    public function toOptionArray($isMultiselect = false)
    {
        $options = array(
            array('value'=>'home_page', 'label'=>Mage::helper('imedia_featuredproduct')->__('true')),
            array('value'=>'left_sidebar', 'label'=>Mage::helper('imedia_featuredproduct')->__('false')),
        );
        
        if(!$isMultiselect){
 
            array_unshift($options, array('value'=>'', 'label'=>Mage::helper('imedia_featuredproduct')->__('--Please Select--')));
 
        }
        return $options;
    }
}