<?php 
class Esther_Hishop_Model_Mysql4_User extends Mage_Core_Model_Mysql4_Abstract 
{
    protected function _construct()
    {
        $this->_init('hishop/user','user_id');
    }   
}
?>