<?php
 
class Esther_Hierp_Block_Adminhtml_ContactPerson_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        if (Mage::getSingleton('adminhtml/session')->getContactPersonData())
        {
            $data = Mage::getSingleton('adminhtml/session')->getContactPersonlData();
            Mage::getSingleton('adminhtml/session')->getContactPersonData(null);
        }
        elseif (Mage::registry('contactPerson_data'))
        {
            $data = Mage::registry('contactPerson_data')->getData();
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
        
         $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('hierp')->__('ContactPerson Information')));
 
        $fieldset->addField('name', 'text', array(
             'label'     => Mage::helper('hierp')->__('Name'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'name',
             'note'     => Mage::helper('hierp')->__('The name of the ContactPerson.'),
        ));
 
        $fieldset->addField('supplier', 'text', array(
             'label'     => Mage::helper('hierp')->__('Supplier'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'supplier',
        ));
 
        $fieldset->addField('phone1', 'text', array(
             'label'     => Mage::helper('hierp')->__('Phone1'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'phone1',
        ));
        $fieldset->addField('phone2', 'text', array(
             'label'     => Mage::helper('hierp')->__('Phone2'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'phone2',
        ));
 
        $form->setValues($data);
 
        return parent::_prepareForm();
    }
}
