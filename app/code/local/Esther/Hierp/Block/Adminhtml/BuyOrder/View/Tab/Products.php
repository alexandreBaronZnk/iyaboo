<?php

class Esther_Hierp_Block_Adminhtml_BuyOrder_View_Tab_Products extends Mage_Adminhtml_Block_Widget_Grid implements Mage_Adminhtml_Block_Widget_Tab_Interface {
	
	public function __construct() {
		parent::__construct ();
		$this->setId ( 'productsGrid' );
		$this->setDefaultSort ( 'created_time' );
		$this->setSaveParametersInSession ( true );
        $this->setUseAjax(true);
        $this->setPagerVisibility(false);
        $this->setFilterVisibility(false);
	}
	
	protected function _prepareCollection() {
		
		$buyOrder=Mage::registry('current_buyOrder');
		if($buyOrder)
			$collection = Mage::getModel ( 'hierp/contactPerson' )->getCollection ()->addFilter('id',$buyOrder->getId());
		else
			$collection = Mage::getModel ( 'hierp/contactPerson' )->getCollection ();
		$this->setCollection ( $collection );
		return parent::_prepareCollection ();
	}
	
	protected function _prepareColumns() {
		$this->addColumn ( 'Sku', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Sku' ), 'align' => 'right', 'width' => '50px', 'index' => 'sku','type'=>'input' ) );
		
		$this->addColumn ( 'Description', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Description' ), 'align' => 'right', 'width' => '200px', 'index' => 'desc' ) );
		$this->addColumn ( 'Name', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Name' ), 'align' => 'left', 'index' => 'name' ) );
		
		$this->addColumn ( 'Supplier', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Supplier' ), 'width' => '150px', 'index' => 'supplier' ) );
		$this->addColumn ( 'Quantity', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Quantity' ), 'width' => '150px', 'index' => 'quantity' ) );
		$this->addColumn ( 'Cost', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Cost' ), 'width' => '150px', 'index' => 'cost' ) );
		
		return parent::_prepareColumns ();
	}
	
	public function getRowUrl($row) {
		return $this->getUrl ( '*/*/edit', array ('id' => $row->getId () ) );
	}
	
  /**
     * ######################## TAB settings #################################
     */
    public function getTabLabel()
    {
        return Mage::helper('hierp')->__('Products');
    }

    public function getTabTitle()
    {
        return Mage::helper('hierp')->__('Products');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}