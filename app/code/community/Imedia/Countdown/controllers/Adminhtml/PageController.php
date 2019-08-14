<?php
class Imedia_Countdown_Adminhtml_PageController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_initAction()->renderLayout();
    }


    /**
     * Initialize action
     * @return Mage_Adminhtml_Controller_Action
     */
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('imedia_countdown_page')
            ->_title(Mage::helper('imedia_countdown')->__('Countdown'))
            ->_addBreadcrumb(Mage::helper('imedia_countdown')->__('Countdown'))
            ->_addBreadcrumb(Mage::helper('imedia_countdown')->__('Countdown'));

        return $this;
    }
    public function newAction()
    {
        $this->_forward('edit');
    }
	
	
	 public function gridAction()
    {
        $this->loadLayout()
		    ->_setActiveMenu('catalog/featured_product')
            ->_addBreadcrumb('Featured Product','Featured Product');;
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('imedia_countdown/adminhtml_featuredproduct_grid')->toHtml()
        );
    }
	

    public function editAction()
    {
        $this->_initAction();

        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('imedia_countdown/page');

        if ($id) {
            // Load record
            $model->load($id);
           
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('imedia_countdown')->__('This Countdown no longer exists.'));
                $this->_redirect('*/*/');

                return;
            }
        }

        $data = Mage::getSingleton('adminhtml/session')->getMenuData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('imedia_countdown', $model);

        $this->_initAction()
             ->_addContent($this->getLayout()->createBlock('imedia_countdown/adminhtml_page_edit')->setData('action', $this->getUrl('*/*/save')))
             ->_addLeft($this->getLayout()->createBlock('imedia_countdown/adminhtml_page_edit_tab'))
             ->renderLayout();
    }
    public function deleteAction()
    {
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
        $this->_redirect('*/*/');
    }
    public function saveAction()
    {
        if ($postData = $this->getRequest()->getPost()) {
            
			$model = Mage::getSingleton('imedia_countdown/page');
         	
			try {
				$model->setData($postData);
				$model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('imedia_countdown')->__('The Status has been saved.'));
                $this->_redirect('*/*/');

                return;
            }
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('imedia_countdown')->__('An error occurred while saving this status.'));
            }

            Mage::getSingleton('adminhtml/session')->setEnquiryData($postData);
            $this->_redirectReferer();
        }
    }
   
    public function massDeleteAction()
    {
        $adListingIds = $this->getRequest()->getParam('id');
        if(!is_array($adListingIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('imedia_countdown')->__('Please select Any Listing(s).'));
        } else {
            try {
                $model = Mage::getSingleton('imedia_countdown/page');
				
                foreach ($adListingIds as $adId) {
				
					$model->load($adId)->delete();
				
				}
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('imedia_countdown')->__('Total of %d record(s) were deleted.', count($adListingIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }
	
    public function messageAction()
    {
        $data = Mage::getModel('imedia_countdown/page')->load($this->getRequest()->getParam('id'));
        echo $data->getContent();
    }
	
	
	 public function massStatusAction()
    {
        $productcountdownIds = $this->getRequest()->getParam('id');
        if(!is_array($productcountdownIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($productcountdownIds as $productcountdownId) {
                    $productcountdown = Mage::getSingleton('imedia_countdown/page')
                        ->load($productcountdownId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($productcountdownIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
	
	
	
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('imedia_countdown_page');
    }
   
}