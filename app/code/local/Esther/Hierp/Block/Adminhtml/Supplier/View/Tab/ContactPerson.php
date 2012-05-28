<?php

class Esther_Hierp_Block_Adminhtml_Supplier_View_Tab_ContactPerson extends Mage_Adminhtml_Block_Widget_Grid implements Mage_Adminhtml_Block_Widget_Tab_Interface {
	
	public function __construct() {
		parent::__construct ();
		$this->setId ( 'contactPersonGrid' );
		$this->setDefaultSort ( 'created_time' );
		$this->setSaveParametersInSession ( true );
        
        $this->setPagerVisibility(false);
        $this->setFilterVisibility(false);
	}
	
	protected function _prepareCollection() {
		$supplier=Mage::registry('current_supplier');
		if($supplier)
			$collection = Mage::getModel ( 'hierp/contactPerson' )->getCollection ()->addFilter('supplier',$supplier->getName());
		else
			$collection = Mage::getModel ( 'hierp/contactPerson' )->getCollection ();
		$this->setCollection ( $collection );
		return parent::_prepareCollection ();
	}
	
	protected function _prepareColumns() {
		$this->addColumn ( 'id', array ('header' => Mage::helper ( 'hierp' )->__ ( 'ID' ), 'align' => 'right', 'width' => '50px', 'index' => 'id' ) );
		
		$this->addColumn ( 'supplier', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Supplier' ), 'align' => 'right', 'width' => '200px', 'index' => 'supplier' ) );
		$this->addColumn ( 'name', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Name' ), 'align' => 'left', 'index' => 'name' ) );
		
		$this->addColumn ( 'phone1', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Phone1' ), 'width' => '150px', 'index' => 'phone1' ) );
		$this->addColumn ( 'phone2', array ('header' => Mage::helper ( 'hierp' )->__ ( 'Phone2' ), 'width' => '150px', 'index' => 'phone2' ) );
		
		return parent::_prepareColumns ();
	}
    

	
	public function getRowUrl($row) {
		return $this->getUrl ( 'hierp/adminhtml_contactPerson/edit', array ('id' => $row->getId () ) );
	}
	
  /**
     * ######################## TAB settings #################################
     */
    public function getTabLabel()
    {
        return Mage::helper('hierp')->__('Contact Person');
    }

    public function getTabTitle()
    {
        return Mage::helper('hierp')->__('Contact Person');
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