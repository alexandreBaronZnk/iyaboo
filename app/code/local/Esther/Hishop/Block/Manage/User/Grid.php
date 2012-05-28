<?php
/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/LICENSE-L.txt
 *
 * @category   AW
 * @package    AW_Blog
 * @copyright  Copyright (c) 2009-2010 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/LICENSE-L.txt
 */

class Esther_Hishop_Block_Manage_User_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('userGrid');
		$this->setDefaultSort('created_time');
		$this->setSaveParametersInSession(true);
	}
	
	protected function _prepareCollection()
	{
		$collection = Mage::getModel('hishop/user')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('store_group', array(
		  'header'    => Mage::helper('hishop')->__('Store Group'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'store_group',
		));
		
		$this->addColumn('user_name', array(
		  'header'    => Mage::helper('hishop')->__('User Name'),
		  'align'     =>'left',
		  'index'     => 'user_name',
		));

		return parent::_prepareColumns();
	}

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('user_id');
        $this->getMassactionBlock()->setFormFieldName('user');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('hishop')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('hishop')->__('Are you sure?')
        ));

        return $this;
    }

	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array('user_id' => $row->getId()));
	}

}
