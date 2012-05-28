<?php


ini_set('memory_limit', '128M');

require_once '/opt/src/iyaboo/app/Mage.php';
require_once '/opt/src/iyaboo/out1/AmazonImport.php';

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$attributeAPI = new Mage_Catalog_Model_Product_Attribute_Api();
$attributes = $attributeAPI->items(63);    //63 is a attribute set id

echo '----------- all attributes ----------' . "\n";
print_r($attributes);

echo '----------- attribute id 951 ----------' . "\n";
print_r($attributeAPI->options(951));      //951 is a attribute id


$attributeSetName = Mage::getModel('eav/entity_attribute_set')->load(63)->getAttributeSetName();
echo '----------- attribute set name ----------' . "\n";
print $attributeSetName . "\n";


$attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product','golf_flex');
$attribute = Mage::getModel('eav/entity_attribute')->load($attributeId);

$attributeOptions = $attribute ->getSource()->getAllOptions();
echo '----------- attribute id 951 options ----------' . "\n";
print_r($attributeOptions);


echo '--------Amazon Import' . "\r\n";
$amazon = new AmazonImport();
echo $amazon->getIndexValue(951, 'left');

?>
