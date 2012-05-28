<?php 
class Esther_Hishop_Model_Mysql4_Shop extends Mage_Core_Model_Mysql4_Abstract 
{
    protected function _construct()
    {
        $this->_init('hishop/shop','shop_id');
    }   
}
?>