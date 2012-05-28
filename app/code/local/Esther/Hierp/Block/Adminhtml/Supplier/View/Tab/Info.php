<?php

class Esther_Hierp_Block_Adminhtml_Supplier_View_Tab_Info extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface {

    protected function _construct() {
        parent::_construct();
        $this->setTemplate('hierp/supplier/view/tab/info.phtml');
    }

    public function getSupplier() {
        return Mage::registry('current_supplier');
    }

    public function getSupplierEditLink($id, $label='') {
        if (empty($label)) {
            $label = $this->__('Edit');
        } $url = $this->getUrl('*/adminhtml_supplier/edit', array('id' => $id));
        return '<a href="' . $url . '">' . $label . '</a>';
    }

    /**
     * ######################## TAB settings #################################
     */
    public function getTabLabel() {
        return Mage::helper('hierp')->__('Information');
    }

    public function getTabTitle() {
        return Mage::helper('hierp')->__('Supplier Information');
    }

    public function canShowTab() {
        return true;
    }

    public function isHidden() {
        return false;
    }

}