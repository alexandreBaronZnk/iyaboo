<?php

echo "Started ".date("d/m/y h:i:s")."\r\n";

define('MAGENTO', realpath('/home/golf/public_html'));
//define('MAGENTO', realpath('/opt/src/iyaboo'));
//ini_set('memory_limit', '128M');

require_once MAGENTO . '/app/Mage.php';

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$sql = ""; $undoSql = "";
for ($i=0; $i<=8; $i++) {
$sql .= "UPDATE index_process SET mode = 'manual' WHERE index_process.process_id =$i LIMIT 1;";
$undoSql .= "UPDATE index_process SET mode = 'real_time' WHERE index_process.process_id =$i LIMIT 1;";
}
 
//$mysqli = Mage::getSingleton('core/resource')->getConnection('core_write');
//$mysqli->query($sql);

$GLOBALS['_beginTime'] = microtime(TRUE);

require "AmazonUtil.php";

$util = new AmazonUtil();
$util->loadCSV('amazon-9-14.csv');

$util->createProducts();

$GLOBALS['_endTime'] = microtime(TRUE);
$loadTime = $GLOBALS['_endTime'] - $GLOBALS['_beginTime'];

echo $loadTime;

echo "Ended ".date("d/m/y h:i:s")."\r\n";
//$mysqli->query($undoSql);
//exit();

?>
