<?php
class Esther_Hierp_Block_Adminhtml_BuyOrder_View_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('hierp_buyOrder_view_tabs');
        $this->setDestElementId('hierp_buyOrder_view');
        $this->setTitle(Mage::helper('hierp')->__('BuyOrder View'));
        $this->setAjax(true);
    }

}
