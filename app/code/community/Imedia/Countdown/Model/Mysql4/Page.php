<?php
class Imedia_Countdown_Model_Mysql4_Page extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('imedia_countdown/page', 'id');
    }
}