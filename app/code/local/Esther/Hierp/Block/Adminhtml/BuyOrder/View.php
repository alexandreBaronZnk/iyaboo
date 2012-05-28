<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Sales
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Sales buyorder view block
 *
 * @category   Mage
 * @package    Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Esther_Hierp_Block_Adminhtml_BuyOrder_View extends Mage_Adminhtml_Block_Widget_Form_Container
{
      public function __construct()
    {
        $this->_objectId    = 'buyOrder_id';
	$this->_controller = 'adminhtml_buyOrder';
	$this->_blockGroup = 'hierp';
        $this->_mode        = 'view';

        parent::__construct();

        $this->_removeButton('delete');
        $this->_removeButton('reset');
        //$this->_removeButton('save');
        $this->setId('hierp_buyOrder_view');
        
        $this->_addButton('contactPerson', array(
                'label'     => Mage::helper('hierp')->__('Contact Person'),
                'onclick'   => 'setLocation(\'' . $this->getContactPersonUrl() . '\')',
                'class'     => ''
            ));
        
          $this->_addButton('supplier', array(
                'label'     => Mage::helper('hierp')->__('Supplier'),
                'onclick'   => 'setLocation(\'' . $this->getSupplierUrl() . '\')',
                'class'     => ''
            ));
        
        $buyOrder = $this->getBuyOrder();
    }
    
     public function getContactPersonUrl()
    {
        return $this->getUrl('*/adminhtml_contactPerson/',array ('filter' => base64_encode ( 'buyorder=' . urlencode ( $this->getBuyOrderId() ) ) ));
    }
    
     public function getSupplierUrl()
    {
        return $this->getUrl('*/adminhtml_supplier/',array ('filter' => base64_encode ( 'buyorder=' . urlencode ( $this->getBuyOrderId() ) ) ));
    }

   
    public function getBuyOrder()
    {
        return Mage::registry('current_buyOrder');
    }

   
    public function getBuyOrderId()
    {
        return $this->getBuyOrder()->getId();
    }

    public function getHeaderText()
    {
        if ($buyOrderId = $this->getBuyOrder()->getId()) {
            $buyOrderId = '[' . $buyOrderId . '] ';
        } else {
            $buyOrderId = '';
        }
        return Mage::helper('hierp')->__('BuyOrder # %s ', $this->getBuyOrder()->getId());
    }



}
