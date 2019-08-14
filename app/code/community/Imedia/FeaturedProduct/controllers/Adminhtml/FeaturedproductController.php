<?php
/**
 * Admin manage featured product controller
 */
class Imedia_FeaturedProduct_Adminhtml_FeaturedproductController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->_title($this->__('Featured Product'));
        
        $this->loadLayout()
            ->_setActiveMenu('catalog/featured_product')
            ->_addBreadcrumb(Mage::helper('imedia_featuredproduct')->__('Featured Product')
                    , Mage::helper('imedia_featuredproduct')->__('Featured Product'));
        return $this;
    }
    
    /**
     * Index action method
     */
    public function indexAction() 
    {
        $this->_initAction();
        $this->renderLayout();
    }
    
    /**
     * Used for Ajax Based Grid
     *
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('imedia_featuredproduct/adminhtml_featuredproduct_grid')->toHtml()
        );
    }
    
    /**
     * Unset featured product
     *
     */
    public function massUnsetFeaturedAction()
    {
        //get selected store ids
        $productIds = (array)$this->getRequest()->getParam('product');
        $storeId    = (int)$this->getRequest()->getParam('store', 0);
		
		$collectiontodel = Mage::getModel('imedia_countdown/page');
		foreach($productIds as $product_current){
		    $collection1 = Mage::getModel('catalog/product')->load($product_current);
			$sku  = $collection1->getSku();
			
			$collection3 = Mage::getModel('imedia_countdown/page')->getCollection();
			$collection3->addFieldToFilter('sku',$sku);
			foreach ($collection3 as $productd)
				{
	                $delid= $productd->getId().'</br>';			
					$collectiontodel->setId($delid)->delete();
				}
			
		}

		
		if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('imedia_countdown/page');
				$model->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('imedia_countdown')->__('Countdown was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
		
          
        if (!is_array($productIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select product(s)'));
        } else{
            try {
                //$this->_validateMassStatus($productIds, $status);
                Mage::getSingleton('catalog/product_action')
                    ->updateAttributes($productIds, array('is_featured_product' => $isFeaturedProduct), $storeId);

                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been updated.', count($productIds))
                );
            }
            catch (Mage_Core_Model_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()
                    ->addException($e, $this->__('An error occurred while unmarking featued product(s).'));
            }
        }
        

        $this->_redirect('*/page/index', array('store'=> $storeId));
    }
    
    /**
     * Set featured product
     *
     */
    public function massSetFeaturedAction()
    {
        //get selected store ids
        $productIds = (array)$this->getRequest()->getParam('product');
        $storeId    = (int)$this->getRequest()->getParam('store', 0);
		$collection2 = Mage::getModel('imedia_countdown/page');
		
		
		foreach($productIds as $product_current){
		
			$collection1 = Mage::getModel('catalog/product')->load($product_current);
			$name = $collection1->getName();
			$sku  = $collection1->getSku();
	
			$collection123 = Mage::getModel('imedia_countdown/page')->getCollection();
			$collection123->addFieldToFilter('sku',$sku);
			$checksku = $collection123->getSize();
			if($checksku == 0)
			  {
					$data = array('product_name'=>$name,'sku'=>$sku);
					$collection2->setData($data);
					$collection2->save();
			  }		
		}
		

        $isFeaturedProduct = 1;
        
        if (!is_array($productIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select product(s)'));
        } else{
            try {
                //$this->_validateMassStatus($productIds, $status);
                Mage::getSingleton('catalog/product_action')
                    ->updateAttributes($productIds, array('is_featured_product' => $isFeaturedProduct), $storeId);

                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been updated.', count($productIds))
                );
            }
            catch (Mage_Core_Model_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()
                    ->addException($e, $this->__('An error occurred while unmarking featured product(s).'));
            }
        }
        $this->_redirect('*/page/index', array('store'=> $storeId));
    }
}