<?php
class Esther_Hishop_Manage_ShopController extends Mage_Adminhtml_Controller_Action {
	public function preDispatch() {
		parent::preDispatch ();
	}
	
	protected function _initAction() {
		$this->loadLayout ()->_setActiveMenu ( 'hishop/shops' );
		
		return $this;
	}
	
	public function indexAction() {
		$this->_initAction ()->renderLayout ();
	}
	
	public function storeAction() {
		$id = $this->getRequest ()->getParam ( 'shop_id' );
		$model = Mage::getModel ( 'hishop/shop' )->load ( $id );
		$store_group_id = $model->getStoreGroup ();
		
		if ($store_group_id == NULL) {
			$store_group = Mage::getModel ( 'core/store_group' );
			$data = array ('website_id' => 1, 'name' => $this->__ ( 'Selfshop' ) . '-' . $model->getTitle (), 'root_category_id' => 3 );
			$store_group->setData ( $data );
			$store_group->save ();
			Mage::dispatchEvent ( 'store_group_save', array ('group' => $store_group ) );
			
			$model->setStoreGroup ( $store_group->getGroupId () );
			$model->save ();
			
			$store_group_id = $store_group->getId ();
			
			$storeModel = Mage::getModel ( 'core/store' );
			$data = array ('group_id' => $store_group->getGroupId (), 'name' => $this->__ ( 'Selfshop' ) . '-' . $model->getTitle () . '-中文', 'code' => 'hishop_' . $store_group->getGroupId () . '_chinese', 'is_active' => 1, 'sort_order' => 0, 'is_default' => '1' );
			$storeModel->setId ( null );
			$storeModel->setData ( $data );
			$storeModel->setWebsiteId ( $store_group->getWebsiteId () );
			
			$storeModel->save ();
			
			Mage::app ()->reinitStores ();
			Mage::dispatchEvent ( $eventName, array ('store' => $storeModel ) );
			
			Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'hishop' )->__ ( 'Shop store group and default store view were successfully created' ) );
			Mage::getSingleton ( 'adminhtml/session' )->setFormData ( false );
		}
		
		$store_group = Mage::getModel ( 'core/store_group' )->load ( $store_group_id );
		
		$this->_redirect ( 'adminhtml/system_store', array ('filter' => base64_encode ( 'group_title=' . urlencode ( $store_group->getName () ) ) ) );
	}
	
	public function editAction() {
		$id = $this->getRequest ()->getParam ( 'id' );
		$model = Mage::getModel ( 'hishop/shop' )->load ( $id );
		
		if ($model->getId () || $id == 0) {
			$data = Mage::getSingleton ( 'adminhtml/session' )->getFormData ( true );
			if (! empty ( $data )) {
				$model->setData ( $data );
			}
			
			Mage::register ( 'shop_data', $model );
			
			$this->loadLayout ();
			$this->_setActiveMenu ( 'hishop/shops' );
			
			$this->_addContent ( $this->getLayout ()->createBlock ( 'hishop/manage_shop_edit' ) )->_addLeft ( $this->getLayout ()->createBlock ( 'hishop/manage_shop_edit_tabs' ) );
			
			$this->renderLayout ();
		} else {
			Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'hishop' )->__ ( 'Shop does not exist' ) );
			$this->_redirect ( '*/*/' );
		}
	}
	
	public function newAction() {
		$id = $this->getRequest ()->getParam ( 'id' );
		$model = Mage::getModel ( 'hishop/shop' )->load ( $id );
		
		$data = Mage::getSingleton ( 'adminhtml/session' )->getFormData ( true );
		if (! empty ( $data )) {
			$model->setData ( $data );
		}
		
		Mage::register ( 'shop_data', $model );
		
		$this->loadLayout ();
		$this->_setActiveMenu ( 'hishop/shops' );
		
		$this->_addContent ( $this->getLayout ()->createBlock ( 'hishop/manage_shop_edit' ) )->_addLeft ( $this->getLayout ()->createBlock ( 'hishop/manage_shop_edit_tabs' ) );
		
		$this->renderLayout ();
	}
	
	public function saveAction() {
		if ($data = $this->getRequest ()->getPost ()) {
			$model = Mage::getModel ( 'hishop/shop' );
			
			$model->setData ( $data )->setId ( $this->getRequest ()->getParam ( 'id' ) );
			
			try {
				if ($this->getRequest ()->getParam ( 'created_time' ) == NULL) {
					$model->setCreatedTime ( now () )->setUpdateTime ( now () );
				} else {
					$model->setUpdateTime ( now () );
				}
				$model->save ();
				
				Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'hishop' )->__ ( 'Shop was successfully saved' ) );
				Mage::getSingleton ( 'adminhtml/session' )->setFormData ( false );
				
				if ($this->getRequest ()->getParam ( 'back' )) {
					$this->_redirect ( '*/*/edit', array ('id' => $model->getId () ) );
					return;
				}
				$this->_redirect ( '*/*/' );
				return;
			} catch ( Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
				Mage::getSingleton ( 'adminhtml/session' )->setFormData ( $data );
				$this->_redirect ( '*/*/edit', array ('id' => $this->getRequest ()->getParam ( 'id' ) ) );
				return;
			}
		}
		Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'hishop' )->__ ( 'Unable to find shop to save' ) );
		$this->_redirect ( '*/*/' );
	}
	
	protected function deleteShop($id) {
		$model = Mage::getModel ( 'hishop/shop' )->load ( $id );
		$store_group_id = $model->getStoreGroup ();
		
		$store_group = Mage::getModel ( 'core/store_group' );
		$store_group->setId ( $store_group_id )->delete ();
		$model->delete ();
	
	}
	
	public function deleteAction() {
		$id = $this->getRequest ()->getParam ( 'id' );
		if ($id > 0) {
			try {
				$this->deleteShop ( $id );
				Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'adminhtml' )->__ ( 'Shop and related store group/view were successfully deleted' ) );
				$this->_redirect ( '*/*/' );
			} catch ( Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
				$this->_redirect ( '*/*/edit', array ('id' => $this->getRequest ()->getParam ( 'id' ) ) );
			}
		}
		$this->_redirect ( '*/*/' );
	}
	
	public function massDeleteAction() {
		$shopIds = $this->getRequest ()->getParam ( 'shop' );
		if (! is_array ( $shopIds )) {
			Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'adminhtml' )->__ ( 'Please select shop(s)' ) );
		} else {
			try {
				foreach ( $shopIds as $shopId ) {
					$this->deleteShop ( $shopId );
				
				}
				Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'adminhtml' )->__ ( 'Total of %d record(s) were successfully deleted', count ( $shopIds ) ) );
			} catch ( Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
			}
		}
		$this->_redirect ( '*/*/index' );
	}
	
	public function massStatusAction() {
		$shopIds = $this->getRequest ()->getParam ( 'shop' );
		if (! is_array ( $shopIds )) {
			Mage::getSingleton ( 'adminhtml/session' )->addError ( $this->__ ( 'Please select shop(s)' ) );
		} else {
			try {
				foreach ( $shopIds as $shopId ) {
					$blog = Mage::getModel ( 'hishop/shop' )->load ( $shopId )->setStatus ( $this->getRequest ()->getParam ( 'status' ) )->setIsMassupdate ( true )->save ();
				
				}
				$this->_getSession ()->addSuccess ( $this->__ ( 'Total of %d record(s) were successfully updated', count ( $shopIds ) ) );
			} catch ( Exception $e ) {
				$this->_getSession ()->addError ( $e->getMessage () );
			}
		}
		$this->_redirect ( '*/*/index' );
	}
}
?>