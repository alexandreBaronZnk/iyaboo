<?php
class MyNamespace_MyTest_Block_MyTest extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getMyTest()     
     { 
        if (!$this->hasData('mytest')) {
            $this->setData('mytest', Mage::registry('mytest'));
        }
        return $this->getData('mytest');
        
    }
}