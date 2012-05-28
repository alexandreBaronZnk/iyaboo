<?php

class Esther_Hierp_Block_Adminhtml_ContactPerson_Grid extends Mage_Adminhtml_Block_Widget_Grid {
	public function __construct() {
		parent::__construct ();
		$this->setId ( 'contactPersonGrid' );
		$this->setDefaultSort ( 'created_time' );
		$this->setSaveParametersInSession ( true );
	}
	
	protected function _prepareCollection() {
		$supplierId=Mage::registry('current_supplier_id');
		if($supplierId)
			$collection = Mage::getModel ( 'hierp/contactPerson' )->getCollection ()->addFilter('supplier',$supplierId);
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
		
        $this->addColumn('edit',
			array(
				'header'    =>  Mage::helper('hierp')->__(' '),
				'width'     => '60',
				'type'      => 'action',
				'getter'    => 'getId',
				'actions'   => array(
					array(
						'caption'   => Mage::helper('hierp')->__('Edit'),
						'url'       => array('base'=> '*/*/edit'),
						'field'     => 'id'
					)
				),
				'filter'    => false,
				'sortable'  => false,
		));
        
		return parent::_prepareColumns ();
	}
    
          protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('contactPerson');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('hierp')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('hierp')->__('Are you sure?')
        ));

        return $this;
    }
    
	
	public function getRowUrl($row) {
		return $this->getUrl ( '*/adminhtml_supplier/edit', array ('id' => $row->getSupplier () ) );
	}

}

