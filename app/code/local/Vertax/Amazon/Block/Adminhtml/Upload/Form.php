<?php

class Vertax_Amazon_Block_Adminhtml_Upload_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {

        $form = new Varien_Data_Form(array(
                    'id' => 'edit_form',
                    'action' => $this->getUrl('amazon/adminhtml_amazonbackend/uploadAndImport'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'
                        )
        );
        $form->setUseContainer(true);
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('amazon')->__('Upload a CSV file and Import')));

        $fieldset->addField('fileinputname', 'file', array(
            'label' => Mage::helper('amazon')->__('File'),
            'required' => true,
            'name' => 'fileinputname',
        ));

        $this->setForm($form);

        return parent::_prepareForm();
    }

}
