<?php

class Esther_Hierp_Block_Adminhtml_BuyOrder_View_Tab_Summary extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface {

    protected function _construct() {
        parent::_construct();
        $this->setTemplate('hierp/buyorder/view/tab/summary.phtml');
    }

    public function getBuyOrder() {
        return Mage::registry('current_buyOrder');
    }

    public function getBuyOrderDetail() {
        
        return Mage::registry('current_buyOrderDetail');
        
    }
    
    public function getBuyOrderEditLink($id, $label='') {
        if (empty($label)) {
            $label = $this->__('Edit');
        } $url = $this->getUrl('*/adminhtml_buyOrder/edit', array('id' => $id));
        return '<a href="' . $url . '">' . $label . '</a>';
    }

    /**
     * ######################## TAB settings #################################
     */
    public function getTabLabel() {
        return Mage::helper('hierp')->__('Order Detail');
    }

    public function getTabTitle() {
        return Mage::helper('hierp')->__('BuyOrder Summary');
    }

    public function canShowTab() {
        return true;
    }

    public function isHidden() {
        return false;
    }

}