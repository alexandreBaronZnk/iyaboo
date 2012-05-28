<?php
 
class Esther_Hierp_Block_Adminhtml_BuyOrder_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        if (Mage::getSingleton('adminhtml/session')->getBuyOrderData())
        {
            $data = Mage::getSingleton('adminhtml/session')->getBuyOrderlData();
            Mage::getSingleton('adminhtml/session')->getBuyOrderData(null);
        }
        elseif (Mage::registry('buyOrder_data'))
        {
            $data = Mage::registry('buyOrder_data')->getData();
        }
        else
        {
            $data = array();
        }
 
        $form = new Varien_Data_Form(array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data',
        ));
 
        $form->setUseContainer(true);
 
        $this->setForm($form);
        
         $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('hierp')->__('BuyOrder Information')));
 
        $fieldset->addField('supplier', 'text', array(
             'label'     => Mage::helper('hierp')->__('Supplier'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'supplier',
        ));
 
        $fieldset->addField('dept', 'text', array(
             'label'     => Mage::helper('hierp')->__('Dept'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'dept',
        ));
        $fieldset->addField('organizer', 'text', array(
             'label'     => Mage::helper('hierp')->__('Organizer'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'organizer',
        ));
        
 
        $form->setValues($data);
 
        return parent::_prepareForm();
    }
}
