<?php
class Esther_Hierp_Block_Adminhtml_Supplier_View extends Mage_Adminhtml_Block_Widget_Form_Container
{
      public function __construct()
    {
        $this->_objectId    = 'supplier_id';
		$this->_controller = 'adminhtml_supplier';
		$this->_blockGroup = 'hierp';
        $this->_mode        = 'view';

        parent::__construct();

        $this->_removeButton('delete');
        $this->_removeButton('reset');
        $this->_removeButton('save');
        $this->setId('hierp_supplier_view');
        
        $this->_addButton('contactPerson', array(
                'label'     => Mage::helper('hierp')->__('Contact Person'),
                'onclick'   => 'setLocation(\'' . $this->getContactPersonUrl() . '\')',
                'class'     => ''
            ));
        
          $this->_addButton('buyOrder', array(
                'label'     => Mage::helper('hierp')->__('Buy Order'),
                'onclick'   => 'setLocation(\'' . $this->getBuyOrderUrl() . '\')',
                'class'     => ''
            ));
        
        $supplier = $this->getSupplier();
    }
    
     public function getContactPersonUrl()
    {
        return $this->getUrl('*/adminhtml_contactPerson/',array ('filter' => base64_encode ( 'supplier=' . urlencode ( $this->getSupplierId() ) ) ));
    }
    
     public function getBuyOrderUrl()
    {
        return $this->getUrl('*/adminhtml_buyOrder/',array ('filter' => base64_encode ( 'supplier=' . urlencode ( $this->getSupplierId() ) ) ));
    }

    
    public function getSupplier()
    {
        return Mage::registry('current_supplier');
    }

 
    public function getSupplierId()
    {
        return $this->getSupplier()->getId();
    }

    public function getHeaderText()
    {
        if ($supplierId = $this->getSupplier()->getId()) {
            $supplierId = '[' . $supplierId . '] ';
        } else {
            $supplierId = '';
        }
        return Mage::helper('hierp')->__('Supplier # %s ', $this->getSupplier()->getName());
    }



}
