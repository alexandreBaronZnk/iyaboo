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

class Esther_Hishop_Block_Manage_Shop_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('shopGrid');
		$this->setDefaultSort('created_time');
		$this->setSaveParametersInSession(true);
	}
	
	protected function _prepareCollection()
	{
		$collection = Mage::getModel('hishop/shop')->getCollection();
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
		
		$this->addColumn('title', array(
		  'header'    => Mage::helper('hishop')->__('Title'),
		  'align'     =>'left',
		  'index'     => 'title',
		));
		
		$this->addColumn('company', array(
		  'header'    => Mage::helper('hishop')->__('Company'),
		  'align'     => 'left',
		  'index'     => 'company',
		));
		
		$this->addColumn('contact', array(
			'header'    => Mage::helper('hishop')->__('Contact'),
			'width'     => '150px',
			'index'     => 'contact',
		));
		
		$this->addColumn('status', array(
		  'header'    => Mage::helper('hishop')->__('Status'),
		  'align'     => 'left',
		  'width'     => '80px',
		  'index'     => 'status',
		  'type'      => 'options',
		  'options'   => array(
			  1 => Mage::helper('hishop')->__('Enabled'),
			  2 => Mage::helper('hishop')->__('Disabled'),
			  3 => Mage::helper('hishop')->__('Hidden'),
		  ),
		));
		
		$this->addColumn('Store',
			array(
				'header'    =>  Mage::helper('hishop')->__(' '),
				'width'     => '60',
				'type'      => 'action',
				'getter'    => 'getId',
				'actions'   => array(
					array(
						'caption'   => Mage::helper('hishop')->__('Store'),
						'url'       => array('base'=> '*/*/store'),
						'field'     => 'shop_id'
					)
				),
				'filter'    => false,
				'sortable'  => false,
		));
		
		$this->addColumn('User',
			array(
				'header'    =>  Mage::helper('hishop')->__(' '),
				'width'     => '60',
				'type'      => 'action',
				'getter'    => 'getId',
				'actions'   => array(
					array(
						'caption'   => Mage::helper('hishop')->__('User'),
						'url'       => array('base'=> '*/manage_user'),
						'field'     => 'shop_id'
					)
				),
				'filter'    => false,
				'sortable'  => false,
		));
		
		return parent::_prepareColumns();
	}

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('post_id');
        $this->getMassactionBlock()->setFormFieldName('shop');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('hishop')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('hishop')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('hishop/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('hishop')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('hishop')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}

}
