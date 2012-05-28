<?php
class Esther_Hierp_Block_Adminhtml_Supplier extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_supplier';
		$this->_blockGroup = 'hierp';
		$this->_headerText = Mage::helper('hierp')->__('Supplier');
		parent::__construct();
	}

    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
}
