<?php

class Esther_Hierp_Block_Adminhtml_Supplier_View_Tab_BuyOrder extends Mage_Adminhtml_Block_Widget_Grid implements Mage_Adminhtml_Block_Widget_Tab_Interface {
	
	public function __construct() {
		parent::__construct ();
		$this->setId ( 'buyOrderGrid' );
		$this->setDefaultSort ( 'created_time' );
		$this->setSaveParametersInSession ( true );
        
        $this->setPagerVisibility(false);
        $this->setFilterVisibility(false);
	}
	
	protected function _prepareCollection() {
		$supplier=Mage::registry('current_supplier');
		if($supplier)
			$collection = Mage::getModel ( 'hierp/buyOrder' )->getCollection ()->addFilter('supplier',$supplier->getName());
		else
			$collection = Mage::getModel ( 'hierp/buyOrder' )->getCollection ();
		$this->setCollection ( $collection );
		return parent::_prepareCollection ();
	}
	
	protected function _prepareColumns() {
		$this->addColumn ( 'id', array ('header' => Mage::helper ( 'hierp' )->__ ( 'ID' ), 'align' => 'right', 'width' => '50px', 'index' => 'id' ) );
		
		$this->addColumn ( 'supplier', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Supplier' ), 'align' => 'right', 'width' => '200px', 'index' => 'supplier' ) );
		$this->addColumn ( 'dept', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Dept' ), 'align' => 'left', 'index' => 'dept' ) );
		
		$this->addColumn ( 'employee', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Employee' ), 'width' => '150px', 'index' => 'employee' ) );
		$this->addColumn ( 'update_time', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Update Time' ), 'width' => '150px', 'index' => 'update_time' ) );
		$this->addColumn ( 'date', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Creation Date' ), 'width' => '150px', 'index' => 'date' ) );
		
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
        return Mage::helper('hierp')->__('Buy Order');
    }

    public function getTabTitle()
    {
        return Mage::helper('hierp')->__('Buy Order');
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