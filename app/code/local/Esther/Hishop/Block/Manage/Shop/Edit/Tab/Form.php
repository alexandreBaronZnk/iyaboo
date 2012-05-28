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

class Esther_Hishop_Block_Manage_Shop_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('shop_form', array('legend'=>Mage::helper('hishop')->__('Shop information')));
		
		$fieldset->addField('title', 'text', array(
		  'label'     => Mage::helper('hishop')->__('Title'),
		  'class'     => 'required-entry',
		  'required'  => true,
		  'name'      => 'title',
		));
		
		$fieldset->addField('company', 'text', array(
		  'label'     => Mage::helper('hishop')->__('Company'),
		  'class'     => 'required-entry',
		  'required'  => true,
		  'name'      => 'company',
		));
	  
		$fieldset->addField('contact', 'text', array(
		  'label'     => Mage::helper('hishop')->__('Contact'),
		  'class'     => 'required-entry',
		  'required'  => true,
		  'name'      => 'contact',
		));
		
		$fieldset->addField('status', 'select', array(
		'label'     => Mage::helper('hishop')->__('Status'),
		'name'      => 'status',
		'values'    => array(
		  array(
			  'value'     => 1,
			  'label'     => Mage::helper('hishop')->__('Enabled'),
		  ),
		
		  array(
			  'value'     => 2,
			  'label'     => Mage::helper('hishop')->__('Disabled'),
		  ),
		  
		  array(
			  'value'     => 3,
			  'label'     => Mage::helper('hishop')->__('Hidden'),
		  ),
		),
		));
		
		if ( Mage::registry('shop_data') ) {
		  $form->setValues(Mage::registry('shop_data')->getData());
		}
		return parent::_prepareForm();
  }
}
