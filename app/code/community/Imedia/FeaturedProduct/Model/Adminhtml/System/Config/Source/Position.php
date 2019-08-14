<?php
/**
 * Featured products position source model
 */
class Imedia_FeaturedProduct_Model_Adminhtml_System_Config_Source_Position
{
    public function toOptionArray($isMultiselect = false)
    {
        $options = array(
            array('value'=>'home_page', 'label'=>Mage::helper('imedia_featuredproduct')->__('Home Page')),
            array('value'=>'left_sidebar', 'label'=>Mage::helper('imedia_featuredproduct')->__('Left Sidebar')),
            array('value'=>'right_sidebar', 'label'=>Mage::helper('imedia_featuredproduct')->__('Right Sidebar')),
            array('value'=>'category_page', 'label'=>Mage::helper('imedia_featuredproduct')->__('Category Page')),
        );
        
        if(!$isMultiselect){
 
            array_unshift($options, array('value'=>'', 'label'=>Mage::helper('imedia_featuredproduct')->__('--Please Select--')));
 
        }
        return $options;
    }
}