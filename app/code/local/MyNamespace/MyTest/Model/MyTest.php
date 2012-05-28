<?php

class MyNamespace_MyTest_Model_MyTest extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mytest/mytest');
    }
}