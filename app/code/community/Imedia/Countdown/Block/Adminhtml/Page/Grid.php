<?php
class Imedia_Countdown_Block_Adminhtml_Page_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setDefaultSort('id');
        $this->setId('imedia_countdown_page_grid');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    protected function _getCollectionClass()
    {
        return 'imedia_countdown/page_collection';
    }

    protected function _prepareCollection()
    {
       
		$collection = Mage::getResourceModel($this->_getCollectionClass());
		$this->setCollection($collection);
	    return parent::_prepareCollection();
    
	}

    protected function _prepareColumns()
    {
       
		$this->addColumn('id',array(
                'header'=> Mage::helper('imedia_countdown')->__('ID'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'id'
            )
        );
		
		
		
		 $this->addColumn('product_name', array(
          'header'    => Mage::helper('imedia_countdown')->__('Product Name'),
          'align'     =>'left',
          'index'     => 'product_name',
      ));
	  
	  $this->addColumn('sku', array(
          'header'    => Mage::helper('imedia_countdown')->__('Sku'),
          'align'     =>'left',
          'index'     => 'sku',
      ));
	  
	  $this->addColumn('start_time', array(
          'header'    => Mage::helper('imedia_countdown')->__('Start Time'),
          'align'     =>'left',
          'index'     => 'start_time',
      ));
	  
	  $this->addColumn('end_time', array(
          'header'    => Mage::helper('imedia_countdown')->__('End Time'),
          'align'     =>'left',
          'index'     => 'end_time',
      ));
	  
	  
	  $this->addColumn('status', array(
          'header'    => Mage::helper('imedia_countdown')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    => Mage::helper('imedia_countdown')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('imedia_countdown')->__('View'),
                        'url'     => array(
                            'base'=>'*/*/edit',
                            'params'=>array('store'=>$this->getRequest()->getParam('store'))
                        ),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
            ));

        return parent::_prepareColumns();
    }
    protected function _prepareMassAction()
    {
			$this->setMassactionIdField('id');
			$this->getMassactionBlock()->setFormFieldName('id');
			$statuses = Mage::getSingleton('imedia_countdown/status')->getOptionArray();
			array_unshift($statuses, array('label'=>'', 'value'=>''));
			$this->getMassactionBlock()->addItem('status', array(
			'label'=> Mage::helper('imedia_countdown')->__('Change status'),
			'url' => $this->getUrl('*/*/massStatus',
			array('_current'=>true)),
			'additional' => array(
			'visibility' => array(
			'name' => 'status',
			'type' => 'select',
			'class' => 'required-entry',
			'label' => Mage::helper('imedia_countdown')->__('Status'),
			'values'=> $statuses
			))
			));
		
        return $this;
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    }