<?php 
class Esther_Hierp_Model_Mysql4_Supplier extends Mage_Core_Model_Mysql4_Abstract 
{
    protected function _construct()
    {
        $this->_init('hierp/supplier','id');
    }   
}
?>