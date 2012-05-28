<?php

class Ambassador_Jetco_PaymentController extends Mage_Core_Controller_Front_Action {

    protected $_order;

    public function getOrder() {
        if ($this->_order == null) {
            $order_id = $this->getRequest()->getParam('order_id');

            if (empty($order_id)) {
                $session = Mage::getSingleton('checkout/session');
                $this->_order = Mage::getModel('sales/order');
                $this->_order->loadByIncrementId($session->getLastRealOrderId());
            } else {
                $this->_order = Mage::getModel('sales/order');
                $this->_order->loadByIncrementId($order_id);
            }
        }

        return $this->_order;
    }

    public function responseAction() {
        $paymentModel = Mage::getModel('jetco/payment');
        $url = $paymentModel->getConfigData('decrypt_url');

        $DR = Mage::getSingleton('core/app')->getRequest()->getParam('String1');

        $response = '';

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'String1=' . urlencode($DR));
            $response = curl_exec($ch);

            curl_close($ch);
        } catch (Exception $e) {
            Mage::log($e->getFile() . ' ' . $e->getLine() . ' ' . $e->getMessage());
        }

        $result = json_decode($response);

        if ($result) {
            if ($result->{"status"} == "AP") {
                $order = $this->getOrder();
                if (($order->getRealOrderId() == $result->{"invoiceNumber"}) && ( intval($order->getGrandTotal()) == intval($result->{"amount"}))) {
                    $order->setData('state', Mage_Sales_Model_Order::STATE_PROCESSING);
                    $order->setStatus('processing');
                    $order->sendNewOrderEmail();
                    $order->addStatusToHistory($order->getStatus(), Mage::helper('jetco')->__('Customer successfully paid from jetco'));
                    $order->save();

                    if ($order->canInvoice()) {
                        $invoiceId = Mage::getModel('sales/order_invoice_api')->create($order->getIncrementId(), array());

                        $invoice = Mage::getModel('sales/order_invoice')->loadByIncrementId($invoiceId);

                        $invoice->capture()->save();
                    }

                    $this->_redirect('checkout/onepage/success');
                }
            } else {

                $this->_redirect('checkout/onepage/failure');
            }
        }
    }

    public function redirectAction() {
        $session = Mage::getSingleton('checkout/session');
        $session->setjetcoPaymentQuoteId($session->getQuoteId());
        $order = $this->getOrder();

        if (!$order->getId()) {
            $this->norouteAction();
            return;
        }

        $order->addStatusToHistory(
                $order->getStatus(), Mage::helper('jetco')->__('Customer will be redirected to JETCO payment page')
        );

        $order->save();
        $this->getResponse()->setBody(
                $this->getLayout()
                        ->createBlock('jetco/redirect')
                        ->setOrder($order)
                        ->toHtml());
        $session->unsQuoteId();
    }

}
