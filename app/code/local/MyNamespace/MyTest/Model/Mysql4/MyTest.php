<?php

class MyNamespace_MyTest_Model_Mysql4_MyTest extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the mytest_id refers to the key field in your database table.
        $this->_init('mytest/mytest', 'mytest_id');
    }
}