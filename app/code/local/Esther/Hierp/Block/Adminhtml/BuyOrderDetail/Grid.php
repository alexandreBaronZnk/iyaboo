<?php

class Esther_Hierp_Block_Adminhtml_BuyOrderDetail_Grid extends Mage_Adminhtml_Block_Widget_Grid {
	public function __construct() {
		parent::__construct ();
		$this->setId ( 'buyOrderDetailGrid' );
        $this->setUseAjax(true);
		$this->setDefaultSort ( 'created_time' );
		$this->setSaveParametersInSession ( true );
	}
	
	protected function _prepareCollection() {
		$collection = Mage::getModel ( 'hierp/buyOrderDetail' )->getCollection ();
		$this->setCollection ( $collection );
		return parent::_prepareCollection ();
	}
	
	protected function _prepareColumns() {
		
		$this->addColumn ( 'buyorder', array ('header' => Mage::helper ( 'hierp' )->__ ( 'BuyOrder' ), 'align' => 'right', 'width' => '100px', 'index' => 'buyorder' ) );
		$this->addColumn ( 'product', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Product' ), 'align' => 'left', 'index' => 'product' ) );
		
		$this->addColumn ( 'quantity', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Quantity' ), 'width' => '150px', 'index' => 'quantity' ) );
		$this->addColumn ( 'cost', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Cost' ), 'width' => '150px', 'index' => 'cost' ) );
		$this->addColumn ( 'comments', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Comments' ), 'width' => '500px', 'index' => 'comments' ) );
		
		return parent::_prepareColumns ();
	}
	
	public function getRowUrl($row) {
		return $this->getUrl ( '*/*/edit', array ('id' => $row->getId () ) );
	}

}

