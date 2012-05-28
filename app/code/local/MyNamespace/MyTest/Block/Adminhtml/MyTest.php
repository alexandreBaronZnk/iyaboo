<?php
class MyNamespace_MyTest_Block_Adminhtml_MyTest extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_mytest';
    $this->_blockGroup = 'mytest';
    $this->_headerText = Mage::helper('mytest')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('mytest')->__('Add Item');
    parent::__construct();
  }
}