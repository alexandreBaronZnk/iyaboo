<?php

class MyNamespace_MyTest_Block_Adminhtml_MyTest_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('mytest_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('mytest')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('mytest')->__('Item Information'),
          'title'     => Mage::helper('mytest')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('mytest/adminhtml_mytest_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}