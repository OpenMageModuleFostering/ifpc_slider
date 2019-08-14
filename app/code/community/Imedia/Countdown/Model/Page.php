<?php
class Imedia_Countdown_Model_Page extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('imedia_countdown/page');
    }
}