<?php
class Esther_Hierp_Adminhtml_ContactPersonController extends Mage_Adminhtml_Controller_Action {
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

	public function newAction()
	{
		//$this->_forward('edit');
		$model = Mage::getModel('hierp/contactPerson');
		Mage::register('contactPerson_data', $model);
		
		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		$this->renderLayout();
	}

	public function editAction()
	{
		
		$id = $this->getRequest()->getParam('id', null);
		$model = Mage::getModel('hierp/contactPerson');
		if ($id) {
			$model->load((int) $id);
			if ($model->getId()) {
				$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
				if ($data) {
					$model->setData($data)->setId($id);
				}
			} else {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('hierp')->__('ContactPerson does not exist'));
				$this->_redirect('*/*/');
			}
		}
		Mage::register('contactPerson_data', $model);

		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		$this->renderLayout();

	}

	public function saveAction()
	{
		if ($data = $this->getRequest()->getPost())
		{
			$model = Mage::getModel('hierp/contactPerson');
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
					Mage::throwException(Mage::helper('hierp')->__('Error saving ContactPerson'));
				}

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('hierp')->__('ContactPerson was successfully saved.'));
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
				$model = Mage::getModel('hierp/contactPerson');
				$model->setId($id);
				$model->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('hierp')->__('The ContactPerson has been deleted.'));
				$this->_redirect('*/*/');
				return;
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to find the ContactPerson to delete.'));
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
		$shopIds = $this->getRequest ()->getParam ( 'contactPerson' );
		if (! is_array ( $shopIds )) {
			Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'adminhtml' )->__ ( 'Please select contact person(s)' ) );
		} else {
			try {
				foreach ( $shopIds as $shopId ) {
					$model = Mage::getModel('hierp/contactPerson');
				$model->setId($shopId);
				$model->delete();
				
				}
				Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'adminhtml' )->__ ( 'Total of %d record(s) were successfully deleted', count ( $shopIds ) ) );
			} catch ( Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
			}
		}
		$this->_redirect ( '*/*/index' );
	}
}
?>
