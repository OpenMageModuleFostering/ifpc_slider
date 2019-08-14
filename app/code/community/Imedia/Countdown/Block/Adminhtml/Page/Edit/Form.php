<?php
class Imedia_Countdown_Block_Adminhtml_Page_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('imedia_countdown_page_form');
        $this->setTitle(Mage::helper('imedia_countdown')->__('Countdown'));
    }

    /**
     * Setup form fields for inserts/updates
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('imedia_countdown');
		
		
		$inquiryCollections = Mage::getModel('imedia_countdown/page')->getCollection()
									->addFieldToFilter('id', $model->getData('id'))
									->getFirstItem();
										
		$active = $inquiryCollections->getIsActive();

		
		$form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action'    =>$this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post'
        ));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('imedia_countdown')->__('Countdown'),
            'class' => 'fieldset-wide',
        ));
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',				
            ));
        }
		$fieldset->addField('product_name', 'label', array(
			'label'     => 'Product Name',
			'disabled'  => true,
			'readonly' => true,
			'name'      => 'product_name',
        ));
		$fieldset->addField('sku', 'label', array(
			'label'     => 'Sku',
			'disabled'  => true,
			'readonly' => true,
			'name'      => 'sku',
		));
	  
		$fieldset->addField('start_time', 'date', array(
			'name'     =>    'start_time', 
			'time'      =>    true,
			'class'     => 'required-entry',
			'required'  => true,        
			'format'    =>    Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
			'label'     =>    'From:',
			'image'     =>    $this->getSkinUrl('images/grid-cal.gif')
		));
	  
		$fieldset->addField('end_time', 'date', array(
			'name'     =>    'end_time',
			'time'      =>    true,
			'class'     =>    'required-entry',
			'required'  =>    true,        
			'format'    =>    Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
			'label'     =>    'To:',
			'image'     =>    $this->getSkinUrl('images/grid-cal.gif')
		));
		
      $fieldset->addField('status', 'select', array(
          'label'     => 'Status',
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => 'Enabled',
              ),

              array(
                  'value'     => 2,
                  'label'     => 'Disabled',
              ),
          ),
      ));
		$form_data = $model->getData();
		$form->setValues($form_data);
		$form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}