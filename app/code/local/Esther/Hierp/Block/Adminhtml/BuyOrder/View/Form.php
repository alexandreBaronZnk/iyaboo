<?php
class Esther_Hierp_Block_Adminhtml_BuyOrder_View_Form extends Mage_Adminhtml_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('hierp/buyorder/view/form.phtml');
    }
}
