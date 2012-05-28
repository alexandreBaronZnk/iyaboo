<?php

class Esther_Hierp_Block_Adminhtml_Supplier_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('supplierGrid');
		$this->setDefaultSort('created_time');
		$this->setSaveParametersInSession(true);
	}
	
	protected function _prepareCollection()
	{
		$collection = Mage::getModel('hierp/supplier')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('id', array(
		  'header'    => Mage::helper('hierp')->__('ID'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'id',
		));
		
		$this->addColumn('name', array(
		  'header'    => Mage::helper('hierp')->__('Name'),
		  'align'     =>'left',
		  'index'     => 'name',
		));
		
		$this->addColumn('address', array(
		  'header'    => Mage::helper('hierp')->__('Adress'),
		  'align'     => 'left',
		  'index'     => 'address',
		));
		
		$this->addColumn('phone', array(
			'header'    => Mage::helper('hierp')->__('Phone'),
			'width'     => '150px',
			'index'     => 'phone',
		));
		
		return parent::_prepareColumns();
	}

	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/view', array('id' => $row->getId()));
	}
	
}

