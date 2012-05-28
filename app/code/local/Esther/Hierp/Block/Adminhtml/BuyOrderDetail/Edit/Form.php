<?php
 
class Esther_Hierp_Block_Adminhtml_BuyOrderDetail_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        if (Mage::getSingleton('adminhtml/session')->getBuyOrderDetailData())
        {
            $data = Mage::getSingleton('adminhtml/session')->getBuyOrderDetaillData();
            Mage::getSingleton('adminhtml/session')->getBuyOrderDetailData(null);
        }
        elseif (Mage::registry('buyOrderDetail_data'))
        {
            $data = Mage::registry('buyOrderDetail_data')->getData();
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
        
         $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('hierp')->__('BuyOrderDetail Information')));
 
   
 
        $fieldset->addField('buyorder', 'text', array(
             'label'     => Mage::helper('hierp')->__('BuyOrder'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'buyorder',
        ));
 
        $fieldset->addField('product', 'text', array(
             'label'     => Mage::helper('hierp')->__('Product'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'product',
        ));
        $fieldset->addField('quantity', 'text', array(
             'label'     => Mage::helper('hierp')->__('Quantity'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'quantity',
        ));
        $fieldset->addField('cost', 'text', array(
             'label'     => Mage::helper('hierp')->__('Cost'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'cost',
        ));
 
        $fieldset->addField('comments', 'text', array(
             'label'     => Mage::helper('hierp')->__('Comments'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'comments',
        ));
        $form->setValues($data);
 
        return parent::_prepareForm();
    }
}
