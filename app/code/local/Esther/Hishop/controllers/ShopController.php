<?php
class Esther_Hishop_ShopController extends Mage_Core_Controller_Front_Action {

	public function applyAction()
	{
		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function postAction()
	{
		if ($this->getRequest()->isPost()){
			$shopModel=Mage::getModel('hishop/shop');
			$data=$this->getRequest()->getPost('shop');
			$shopModel->setData($data);
			$shopModel->setStatus(Mage::getSingleton('hishop/status')->STATUS_DISABLED);
			$shopModel->setCreatedTime(now());
			$shopModel->save();
		}
		$this->_redirect('/index.php');
	}
}
?>