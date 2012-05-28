<?php

class Esther_Hierp_Block_Adminhtml_BuyOrder_Grid extends Mage_Adminhtml_Block_Widget_Grid {
	public function __construct() {
		parent::__construct ();
		$this->setId ( 'buyOrderGrid' );
		$this->setDefaultSort ( 'created_time' );
		$this->setSaveParametersInSession ( true );
	}
	
	protected function _prepareCollection() {
		$supplier=Mage::registry('current_supplier_id');
		if($supplier)
			$collection = Mage::getModel ( 'hierp/buyOrder' )->getCollection ()->addFilter('supplier',$supplier);
		else
			$collection = Mage::getModel ( 'hierp/buyOrder' )->getCollection ();
		$this->setCollection ( $collection );
		return parent::_prepareCollection ();
	}
	
	protected function _prepareColumns() {
		$this->addColumn ( 'id', array ('header' => Mage::helper ( 'hierp' )->__ ( 'ID' ), 'align' => 'right', 'width' => '50px', 'index' => 'id' ) );
		
		$this->addColumn ( 'supplier', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Supplier' ), 'align' => 'right', 'width' => '200px', 'index' => 'supplier' ) );
		$this->addColumn ( 'dept', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Dept' ), 'align' => 'left', 'index' => 'dept' ) );
		
		$this->addColumn ( 'organizer', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Organizer' ), 'width' => '150px', 'index' => 'organizer' ) );
		
		$this->addColumn ( 'date', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Creation Date' ), 'width' => '150px', 'index' => 'date' ) );
		
		return parent::_prepareColumns ();
	}
	
	public function getRowUrl($row) {
		return $this->getUrl ( '*/*/view', array ('id' => $row->getId () ) );
	}

}

