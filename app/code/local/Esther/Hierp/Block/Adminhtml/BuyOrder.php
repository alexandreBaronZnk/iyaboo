<?php
class Esther_Hierp_Block_Adminhtml_BuyOrder extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_buyOrder';
		$this->_blockGroup = 'hierp';
		$this->_headerText = Mage::helper('hierp')->__('BuyOrder');
		parent::__construct();
	}

    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
}
