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

class Esther_Hishop_Block_Manage_User extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'manage_user';
		$this->_blockGroup = 'hishop';
		$this->_headerText = Mage::helper('hishop')->__('User');
		parent::__construct();
		$this->setTemplate('hishop/users.phtml');
	}

    protected function _prepareLayout()
    {
        $this->setChild('add_new_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('hishop')->__('Add User'),
                    'onclick'   => "setLocation('".$this->getUrl('*/*/new')."')",
                    'class'   => 'add'
                    ))
                );

        $this->setChild('grid', $this->getLayout()->createBlock('hishop/manage_user_grid', 'user.grid'));
        return parent::_prepareLayout();
    }

    public function getAddNewButtonHtml()
    {
        return $this->getChildHtml('add_new_button');
    }

    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }
}
