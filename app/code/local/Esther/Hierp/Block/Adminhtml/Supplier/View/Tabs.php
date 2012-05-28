<?php
class Esther_Hierp_Block_Adminhtml_Supplier_View_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('hierp_supplier_view_tabs');
        $this->setDestElementId('hierp_supplier_view');
        $this->setTitle(Mage::helper('hierp')->__('Supplier View'));
    }

}
