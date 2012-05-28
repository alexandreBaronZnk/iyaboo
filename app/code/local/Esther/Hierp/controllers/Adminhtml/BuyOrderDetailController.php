<?php
class Esther_Hierp_Adminhtml_BuyOrderDetailController extends Mage_Adminhtml_Controller_Action {
	public function preDispatch() {
		parent::preDispatch ();
	}

	public function indexAction()
	{
		$this->loadLayout();
		$this->renderLayout();
	

	}

	public function newAction()
	{
		//$this->_forward('edit');
		$model = Mage::getModel('hierp/buyOrderDetail');
		Mage::register('buyOrderDetail_data', $model);
		
		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		$this->renderLayout();
	}

	public function editAction()
	{
		
		$id = $this->getRequest()->getParam('id', null);
		$model = Mage::getModel('hierp/buyOrderDetail');
		if ($id) {
			$model->load((int) $id);
			if ($model->getId()) {
				$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
				if ($data) {
					$model->setData($data)->setId($id);
				}
			} else {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('hierp')->__('BuyOrderDetail does not exist'));
				$this->_redirect('*/*/');
			}
		}
		Mage::register('buyOrderDetail_data', $model);

		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		$this->renderLayout();

	}

	public function saveAction()
	{
		if ($data = $this->getRequest()->getPost())
		{
			$model = Mage::getModel('hierp/buyOrderDetail');
			$id = $this->getRequest()->getParam('id');
			if ($id) {
				$model->load($id);
			}
			$model->setData($data);

			Mage::getSingleton('adminhtml/session')->setFormData($data);
			try {
				if ($id) {
					$model->setId($id);
				}
				$model->save();

				if (!$model->getId()) {
					Mage::throwException(Mage::helper('hierp')->__('Error saving BuyOrderDetail'));
				}

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('hierp')->__('BuyOrderDetail was successfully saved.'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				// The following line decides if it is a "save" or "save and continue"
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
				} else {
					$this->_redirect('*/*/');
				}

			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				if ($model && $model->getId()) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
				} else {
					$this->_redirect('*/*/');
				}
			}

			return;
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('hierp')->__('No data found to save'));
		$this->_redirect('*/*/');
	}

	public function deleteAction()
	{
		if ($id = $this->getRequest()->getParam('id')) {
			try {
				$model = Mage::getModel('hierp/buyOrderDetail');
				$model->setId($id);
				$model->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('hierp')->__('The BuyOrderDetail has been deleted.'));
				$this->_redirect('*/*/');
				return;
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to find the BuyOrderDetail to delete.'));
		$this->_redirect('*/*/');
	}

}
?>
