<?php

class Vertax_Amazon_Block_Adminhtml_Upload extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'amazon';
        //$this->_controller = 'adminhtml_amazonbackend';

        $this->_updateButton('save', 'label', Mage::helper('amazon')->__('Upload and Import'));
    }

    protected function _prepareLayout() {

        $this->setChild('form', $this->getLayout()->createBlock('amazon/adminhtml_upload_form'));

        return parent::_prepareLayout();
    }

    public function getHeaderText() {

        return Mage::helper('amazon')->__('Upload and Import');
    }

}
