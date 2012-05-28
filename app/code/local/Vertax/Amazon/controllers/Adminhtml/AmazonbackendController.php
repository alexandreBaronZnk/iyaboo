<?php

class Vertax_Amazon_Adminhtml_AmazonbackendController extends Mage_Adminhtml_Controller_Action {

    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function uploadAndImportAction() {

        if (isset($_FILES['fileinputname']['name']) and (file_exists($_FILES['fileinputname']['tmp_name']))) {
            try {
                $uploader = new Varien_File_Uploader('fileinputname');
                $uploader->setAllowedExtensions(array('CSV', 'csv')); // or pdf or anything


                $uploader->setAllowRenameFiles(false);

                $uploader->setFilesDispersion(false);

                $path = Mage::getBaseDir('media') . '/upload/';

                $uploader->save($path, $_FILES['fileinputname']['name']);

                $data['fileinputname'] = $_FILES['fileinputname']['name'];
                
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        
        require "AmazonUtil.php";

        $util = new AmazonUtil();
        $util->loadCSV($path . '/' . $data['fileinputname']);

        $util->createProducts();
    }

}