<?php
/**
 * Featured Product Observer
 * 
 */
class Imedia_FeaturedProduct_Model_Observer
{
    /**
     * Stop default redirect and redirect to current url
     *
     */
     public function stopRedirect(Varien_Event_Observer $observer){
        //get the real referrer from server var
        $referrer = Mage::app()->getRequest()->getServer('HTTP_REFERER');
        if ($referrer){
            //set your new redirect
            Mage::app()->getResponse()->setRedirect($referrer);
        }
        return $this;
    }
	
	public function catalog_product_save_after($observer)
    {
            $product = $observer->getProduct();
		    $name = $product->getName();
			$sku  = $product->getSku();
            $featured = $product->getIsFeaturedProduct();
			$collection2 = Mage::getModel('imedia_countdown/page');
			if($featured==1 && $sku){
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
			else{
					$collection3 = Mage::getModel('imedia_countdown/page')->getCollection();
					$collection3->addFieldToFilter('sku',$sku);
					foreach ($collection3 as $productd)
						{
							$delid= $productd->getId().'</br>';
							$collection2->setId($delid)->delete();
						}
			}          
    }
	
	public function catalog_product_delete_before($observer)
	{
	        $product = $observer->getProduct();
		    $name = $product->getName();
			$sku  = $product->getSku();
            $featured = $product->getIsFeaturedProduct();
			$collection2 = Mage::getModel('imedia_countdown/page');
			
			$collection3 = Mage::getModel('imedia_countdown/page')->getCollection();
			$collection3->addFieldToFilter('sku',$sku);
				foreach ($collection3 as $productd)
					{
						$delid= $productd->getId().'</br>';
						$collection2->setId($delid)->delete();
					}
	
	}
	
	
}