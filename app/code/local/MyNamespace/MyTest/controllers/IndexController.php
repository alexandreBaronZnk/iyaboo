<?php
class MyNamespace_MyTest_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/mytest?id=15 
    	 *  or
    	 * http://site.com/mytest/id/15 	
    	 */
    	/* 
		$mytest_id = $this->getRequest()->getParam('id');

  		if($mytest_id != null && $mytest_id != '')	{
			$mytest = Mage::getModel('mytest/mytest')->load($mytest_id)->getData();
		} else {
			$mytest = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($mytest == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$mytestTable = $resource->getTableName('mytest');
			
			$select = $read->select()
			   ->from($mytestTable,array('mytest_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$mytest = $read->fetchRow($select);
		}
		Mage::register('mytest', $mytest);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}