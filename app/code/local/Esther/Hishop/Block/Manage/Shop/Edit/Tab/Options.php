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

class Esther_Hishop_Block_Manage_Shop_Edit_Tab_Options extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('shop_form', array('legend'=>Mage::helper('hishop')->__('Meta Data')));
		
		$fieldset->addField('created_time', 'text', array(
			  'label'     => Mage::helper('hishop')->__('Shop Date'),
			  'name'      => 'created_time',
			  'style' => 'width: 520px;',
			  'after_element_html' => '<span class="hint">(eg: YYYY-MM-DD HH:MM:SS Leave blank to use current date)</span>',
		));
		
		if ( Mage::registry('shop_data') ) 
			{
				$form->setValues(Mage::registry('shop_data')->getData());
			}
			return parent::_prepareForm();
		}
	}
