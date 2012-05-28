<?php
class Esther_Hierp_Block_Adminhtml_ContactPerson extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_contactPerson';
		$this->_blockGroup = 'hierp';
		$this->_headerText = Mage::helper('hierp')->__('Contact Person');
        	parent::__construct();
	}

    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
}
