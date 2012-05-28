<?php
class Esther_Hierp_Block_Adminhtml_BuyOrder_View_Tab_AddProducts extends Esther_Hierp_Block_Adminhtml_BuyOrder_Products implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

  /**
     * ######################## TAB settings #################################
     */
    public function getTabLabel()
    {
        return Mage::helper('hierp')->__('Add Products');
    }

    public function getTabTitle()
    {
        return Mage::helper('hierp')->__('Add Products');
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
