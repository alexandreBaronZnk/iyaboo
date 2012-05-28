<?php
 
class Esther_Hierp_Block_Adminhtml_Supplier_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        if (Mage::getSingleton('adminhtml/session')->getSupplierData())
        {
            $data = Mage::getSingleton('adminhtml/session')->getSupplierlData();
            Mage::getSingleton('adminhtml/session')->getSupplierData(null);
        }
        elseif (Mage::registry('supplier_data'))
        {
            $data = Mage::registry('supplier_data')->getData();
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
        
         $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('hierp')->__('Supplier Information')));
 
        $fieldset->addField('name', 'text', array(
             'label'     => Mage::helper('hierp')->__('Name'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'name',
             'note'     => Mage::helper('hierp')->__('The name of the supplier.'),
        ));
 
        $fieldset->addField('address', 'text', array(
             'label'     => Mage::helper('hierp')->__('Address'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'address',
        ));
 
        $fieldset->addField('phone', 'text', array(
             'label'     => Mage::helper('hierp')->__('Phone'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'phone',
        ));
 
        $form->setValues($data);
 
        return parent::_prepareForm();
    }
}
