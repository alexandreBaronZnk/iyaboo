<?php

ob_end_flush();
echo "Started ".date("d/m/y h:i:s")."\r\n";

define('MAGENTO', realpath('/opt/src/iyaboo'));
ini_set('memory_limit', '128M');

require_once MAGENTO . '/app/Mage.php';

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$GLOBALS['_beginTime'] = microtime(TRUE);

$sql = ""; $undoSql = "";
for ($i=0; $i<=8; $i++) {
$sql .= "UPDATE index_process SET mode = 'manual' WHERE index_process.process_id =$i LIMIT 1;";
$undoSql .= "UPDATE index_process SET mode = 'real_time' WHERE index_process.process_id =$i LIMIT 1;";
}
 
$mysqli = Mage::getSingleton('core/resource')->getConnection('core_write');
$mysqli->query($sql);

$nameArray = array("golf1", "golf2", "golf3", "golf4");
$handArray = array(127, 128, 127, 128);   //hand option values
$flexArray = array(130, 130, 132, 132);    //flex option values


for ($i = 0; $i < 4; $i++) {
    $name = $nameArray[$i];
    $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $name);

    if (!$product)
        //$product->delete();
        $product = Mage::getModel('catalog/product');

    $product->setTypeId('simple');
    $product->setTaxClassId(2); //none
    $product->setWebsiteIds(array(1));  // store id
    $product->setAttributeSetId(63); //Golf Attribute Set
    $product->setData('sku',$name);
    $product->setCategoryIds(array(13));

    $product->setName($name);
    $product->setDescription($name);
    $product->setPrice("129.95");
    $product->setShortDescription($name);
    $product->setWeight(0);
    $product->setStatus(1); //enabled
    $product->setVisibility(1); //nowhere

    $product->setGolfHand($handArray[$i]);
    $product->setGolfFlex($flexArray[$i]);

    try {
        $product->save();
        $productId = $product->getId();
        echo $product->getId() . ", added\n";
    } catch (Exception $e) {
        echo "$name not added\n";
        echo "exception:$e";
    }
}

//3514 3515 3516 3517 are product ids created before.
//951 952 are configurable attributes' ids.
$configurableProductsData = array(
    '4456' => array(
        0 => array(
            'attribute_id' => 951),
        1 => array(
            'attribute_id' => 952
        )
    ),
    '4457' => array(
        0 => array(
            'attribute_id' => 951),
        1 => array(
            'attribute_id' => 952
        )
    ),
    '4458' => array(
        0 => array(
            'attribute_id' => 951),
        1 => array(
            'attribute_id' => 952
        )
    ),
    '4459' => array(
        0 => array(
            'attribute_id' => 951),
        1 => array(
            'attribute_id' => 952
        )
    )
);

$configurableAttributesData = array(
    0 => array(
        'id' => NULL,
        'label' => 'Hand',
        'use_default' => '0',
        'position' => '0',
        'values' => array(
            0 => array(
                'attribute_id' => 951,
                'is_percent' => '',
                'pricing_value' => ''
            ),
            1 => array(
                'attribute_id' => 951,
                'is_percent' => '',
                'pricing_value' => ''
            )
        ),
        'attribute_id' => 951, //get this value from attributes api call
        'attribute_code' => 'golf_hand', //get this value from attributes api call
        'frontend_label' => 'Hand', //optional, will be replaced by the modifed api.php
        'store_label' => 'Hand',
        'html_id' => 'configurable_attribute_0'
    ),
    1 => array(
        'id' => NULL,
        'label' => 'Flex',
        'use_default' => '0',
        'position' => '0',
        'values' => array(
            0 => array(
                'attribute_id' => 952,
                'is_percent' => '',
                'pricing_value' => ''
            ),
            1 => array(
                'attribute_id' => 952,
                'is_percent' => '',
                'pricing_value' => ''
            )
        ),
        'attribute_id' => 952, //get this value from attributes api call
        'attribute_code' => 'golf_flex', //get this value from attributes api call
        'frontend_label' => 'Flex', //optional, will be replaced by the modifed api.php
        'store_label' => 'Flex',
        'html_id' => 'configurable_attribute_0'
    )
);


$name = 'golf_conf';
$product = Mage::getModel('catalog/product')->loadByAttribute('sku', $name);

if ($product)
    $product->delete();

$product = Mage::getModel('catalog/product');

$product->setTypeId('configurable');
$product->setTaxClassId(2); //none
$product->setWebsiteIds(array(1));  // store id
$product->setAttributeSetId(63); //Golf Attribute Set
$product->setSku($name);
if ($product->getId())
    $product->setName($name . 'update');
else
    $product->setName($name);
$product->setDescription($name);
$product->setCategoryIds(array(13));
$product->setPrice("129.95");
$product->setShortDescription($name);
$product->setWeight(0);
$product->setStatus(1); //enabled
$product->setVisibility(4); //nowhere

$product->setConfigurableProductsData($configurableProductsData);
$product->setConfigurableAttributesData($configurableAttributesData);
$product->setCanSaveConfigurableAttributes(true);

try {
    $product->save();
    $productId = $product->getId();
    echo $product->getId() . ", added\n";
} catch (Exception $e) {
    echo "$name not added\n";
    echo "exception:$e";
}

$GLOBALS['_endTime'] = microtime(TRUE);
$loadTime = $GLOBALS['_endTime'] - $GLOBALS['_beginTime'];

echo $loadTime;

echo "Ended ".date("d/m/y h:i:s")."\r\n";
//$mysqli->query($undoSql);
exit();

?>