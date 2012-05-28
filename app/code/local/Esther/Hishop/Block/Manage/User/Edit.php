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

class Esther_Hishop_Block_Manage_User_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'hishop';
        $this->_controller = 'manage_user';
        
        $this->_updateButton('save', 'label', Mage::helper('hishop')->__('Save User'));
        $this->_updateButton('delete', 'label', Mage::helper('hishop')->__('Delete User'));
    }

    public function getHeaderText()
    {
        if( Mage::registry('user_data') && Mage::registry('user_data')->getId() ) {
            return Mage::helper('hishop')->__("Edit User '%s'", $this->htmlEscape(Mage::registry('user_data')->getUsername()));
        } else {
            return Mage::helper('hishop')->__('Add User');
        }
    }
}
