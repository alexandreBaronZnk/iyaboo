<?php

class Esther_Hishop_Manage_UserController extends Mage_Adminhtml_Controller_Action {
	
	public function preDispatch() {
		parent::preDispatch ();
	}
	
	protected function _initAction() {
		$this->loadLayout ();
		return $this;
	}
	
	public function indexAction() {
		//取ID参数，并保存在SESSION里面，之后创建新用户时需要
		$shop_id = $this->getRequest ()->getParam ( 'shop_id' );
		Mage::getSingleton ( 'adminhtml/session' )->setData ( 'shop_id', $shop_id );
		$this->_initAction ()->renderLayout ();
	}
	
	public function newAction() {
		$this->_title ( $this->__ ( 'Hishop' ) )->_title ( $this->__ ( 'Shops' ) )->_title ( $this->__ ( 'Users' ) );
		$id = $this->getRequest ()->getParam ( 'user_id' );
		$model = Mage::getModel ( 'hishop/user' );
		if ($id) {
			$model->load ( $id );
			if (! $model->getId ()) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $this->__ ( 'This user no longer exists.' ) );
				$this->_redirect ( '*/*/' );
				return;
			}
		}
		$this->_title ( $model->getId () ? $model->getName () : $this->__ ( 'New User' ) );
		// Restore previously entered form data from session
		$data = Mage::getSingleton ( 'adminhtml/session' )->getUserData ( true );
		if (! empty ( $data )) {
			$model->setData ( $data );
		}
		Mage::register ( 'user_data', $model );
		$this->loadLayout ();
		$this->_addContent ( $this->getLayout ()->createBlock ( 'hishop/manage_user_edit' ) );
		$this->renderLayout ();
	}
	
	public function editAction() {
		$user_id = $this->getRequest ()->getParam ( 'user_id' );
		$model = Mage::getModel ( 'hishop/user' )->load ( $user_id );
		$admin_user_model = Mage::getModel ( 'admin/user' );
		
		if ($model->getId () || $user_id == 0) {
			if ($model->getAdminUserid ()) {
				$admin_user_model = $admin_user_model->load ( $model->getAdminUserid () );
			}
			$data = Mage::getSingleton ( 'adminhtml/session' )->getFormData ( true );
			if (! empty ( $data )) {
				$admin_user_model->setData ( $data );
			}
			
			Mage::register ( 'user_data', $admin_user_model );
			$this->loadLayout ();
			$this->_addContent ( $this->getLayout ()->createBlock ( 'hishop/manage_user_edit' ) );
			$this->renderLayout ();
		} else {
			Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'hishop' )->__ ( 'User does not exist' ) );
			$this->_redirect ( '*/*/' );
		}
	}
	
	public function saveAction() {
		if ($data = $this->getRequest ()->getPost ()) {
			$user_id = $this->getRequest ()->getParam ( 'user_id' );
			$model = Mage::getModel ( 'admin/user' )->load ( $user_id );
			if (! $model->getId () && $id) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'hishop' )->__ ( 'This user no longer exists.' ) );
				$this->_redirect ( '*/*/' );
				return;
			}
			$model->setData ( $data );
			if ($model->hasNewPassword () && $model->getNewPassword () === '') {
				$model->unsNewPassword ();
			}
			if ($model->hasPasswordConfirmation () && $model->getPasswordConfirmation () === '') {
				$model->unsPasswordConfirmation ();
			}
			$result = $model->validate ();
			if (is_array ( $result )) {
				Mage::getSingleton ( 'adminhtml/session' )->setUserData ( $data );
				foreach ( $result as $message ) {
					Mage::getSingleton ( 'adminhtml/session' )->addError ( $message );
				}
				$this->_redirect ( '*/*/edit', array ('_current' => true ) );
				return $this;
			}
			try {
				$model->save ();
				//专为自营店铺创建的角色-Shop Owner，ID为5
				$model->setRoleIds ( array ('5' ) )->setRoleUserId ( $model->getUserId () )->saveRelations ();
				//保存用户名与店铺－StoreGroup的对应关系
				$shop_user_collection = Mage::getModel ( 'hishop/user' )->getCollection ();
				$shop_user_collection->getSelect ()->where ( 'admin_userid=?', $model->getId () );
				$shop_user = $shop_user_collection->getFirstItem ();
				
				if ($shop_user->getId () == '') {
					$shop_user->setId ( null );
					$shop_user->setData ( array ('admin_userid' => $model->getId (), 'user_name' => $model->getUsername (), 'store_group' => Mage::getSingleton ( 'adminhtml/session' )->getData ( 'shop_id' ) ) );
				} else {
					$shop_user->addData ( array ('admin_userid' => $model->getId (), 'user_name' => $model->getUsername (), 'store_group' => Mage::getSingleton ( 'adminhtml/session' )->getData ( 'shop_id' ) ) );
				}
				$shop_user->save ();
				
				Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( $this->__ ( 'The user has been saved.' ) );
				Mage::getSingleton ( 'adminhtml/session' )->setUserData ( false );
				$this->_redirect ( '*/*/index', array ('shop_id' => Mage::getSingleton ( 'adminhtml/session' )->getData ( 'hishop_shop_id' ) ) );
				return;
			} catch ( Mage_Core_Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
				Mage::getSingleton ( 'adminhtml/session' )->setUserData ( $data );
				$this->_redirect ( '*/*/edit', array ('user_id' => $model->getUserId () ) );
				return;
			}
		}
		$this->_redirect ( '*/*/' );
	}
	
	public function deleteAction() {
		$user_id = $this->getRequest ()->getParam ( 'user_id' );
		if ($user_id) {
			$this->delteUser ( $user_id );
			Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( $this->__ ( 'The user has been deleted.' ) );
			$this->_redirect ( '*/*/' );
			return;
		}
		
		Mage::getSingleton ( 'adminhtml/session' )->addError ( $this->__ ( 'Unable to find a user to delete.' ) );
		$this->_redirect ( '*/*/' );
	}
	
	protected function deleteUser($id) {
		$currentUser = Mage::getSingleton ( 'admin/session' )->getUser ();
		if ($id) {
			if ($currentUser->getId () == $id) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $this->__ ( 'You cannot delete your own account.' ) );
				$this->_redirect ( '*/*/edit', array ('user_id' => $id ) );
				return;
			}
			try {
				//删除对应的店铺用户信息
				$shop_user = Mage::getModel ( 'hishop/user' )->load ( $id );
				Mage::log ( $shop_user->debug () );
				$model = Mage::getModel ( 'admin/user' );
				if ($shop_user->getAdminUserid () > 0) {
					$model->setId ( $shop_user->getAdminUserid () );
					$model->delete ();
				}
				$shop_user->delete ();
				
				return;
			} catch ( Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
				$this->_redirect ( '*/*/edit', array ('user_id' => $this->getRequest ()->getParam ( 'user_id' ) ) );
				return;
			}
		}
	}
	
	public function massDeleteAction() {
		$userIds = $this->getRequest ()->getParam ( 'user' );
		if (! is_array ( $userIds )) {
			Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'adminhtml' )->__ ( 'Please select user(s)' ) );
		} else {
			try {
				foreach ( $userIds as $userId ) {
					$this->deleteUser ( $userId );
				}
				Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'adminhtml' )->__ ( 'Total of %d record(s) were successfully deleted', count ( $userIds ) ) );
			} catch ( Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
			}
		}
		$this->_redirect ( '*/*/index' );
	}
}
?>