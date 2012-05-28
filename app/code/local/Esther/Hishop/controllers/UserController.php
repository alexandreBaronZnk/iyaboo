<?php
class Esther_Hishop_UserController extends Mage_Core_Controller_Front_Action {	
	public function saveAction() {
		$data = array('user_name' => 'dfdfds中文1','role' => '33','store_group' => '1');
//		$storeModel->setId(null);
//		$storeModel->setData($data);
		
		$shop_user = Mage::getModel ( 'hishop/user' );
		
		$shop_user->setId(null);
		//$shop_user->setData($data);
//		$shop_user->setUserId ( '34' );
		$shop_user->setUserName ( 'tesd' );
		$shop_user->setStoreGroup ( '2' );
		$shop_user->setRole ( '5' );
		$shop_user->save ();
		
		$shop_user = Mage::getModel ( 'hishop/user' )->load('34');
		var_dump($shop_user);
	}
}
?>