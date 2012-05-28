<?php
class Esther_Hierp_Adminhtml_BuyOrderController extends Mage_Adminhtml_Controller_Action {
	public function preDispatch() {
		parent::preDispatch ();
	}

	public function indexAction()
	{
		$supplier = $this->getRequest ()->getParam ( 'supplier' );
		Mage::register( 'current_supplier_id', $supplier );
		$this->loadLayout();
		$this->renderLayout();
	

	}

        public function viewAction() {
        $id = $this->getRequest()->getParam('id', null);
        $model = Mage::getModel('hierp/buyOrder');
        if ($id)
            $model->load((int) $id);
        Mage::register('current_buyOrder', $model);
        
        $orderdetail = Mage::getModel('hierp/buyOrderDetail');
        if ($id)
            $orderdetail->load((int) $id);
                    
        Mage::register('current_buyOrderDetail', $orderdetail);
        
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }
        
	public function newAction()
	{
		$model = Mage::getModel('hierp/buyOrder');
		Mage::register('buyOrder_data', $model);
		
		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		$this->renderLayout();
	}
    
    public function productGridAction()
	{
		$this->loadLayout(false);
		//$this->renderLayout();
        
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('hierp/adminhtml_buyOrder_products')->toHtml()
        );
	}

	public function editAction()
	{
		
		$id = $this->getRequest()->getParam('id', null);
		$model = Mage::getModel('hierp/buyOrder');
		if ($id) {
			$model->load((int) $id);
			if ($model->getId()) {
				$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
				if ($data) {
					$model->setData($data)->setId($id);
				}
			} else {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('hierp')->__('BuyOrder does not exist'));
				$this->_redirect('*/*/');
			}
		}
		Mage::register('buyOrder_data', $model);

		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		$this->renderLayout();

	}

	public function saveAction()
	{
		if ($data = $this->getRequest()->getPost())
		{
			$model = Mage::getModel('hierp/buyOrder');
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
					Mage::throwException(Mage::helper('hierp')->__('Error saving BuyOrder'));
				}

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('hierp')->__('BuyOrder was successfully saved.'));
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
				$model = Mage::getModel('hierp/buyOrder');
				$model->setId($id);
				$model->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('hierp')->__('The BuyOrder has been deleted.'));
				$this->_redirect('*/*/');
				return;
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to find the BuyOrder to delete.'));
		$this->_redirect('*/*/');
	}

}
?>
