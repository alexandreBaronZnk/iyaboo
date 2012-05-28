<?php

class Ambassador_Jetco_Model_Payment extends Mage_Payment_Model_Method_Abstract {

    protected $_code = 'jetco';
    protected $_isInitializeNeeded = true;
    protected $_canUseInternal = false;
    protected $_canUseForMultishipping = false;

    /**
     * Return Order place redirect url
     *
     * @return string
     */
    public function getOrderPlaceRedirectUrl() {
        return Mage::getUrl('jetco/payment/redirect', array('_secure' => true));
    }

    public function getJetcoUrl() {
        $url = $this->getConfigData('submit_url');
        return $url;
    }

    public function getGatewayUrl() {
        $url = $this->getConfigData('gateway_url');
        return $url;
    }

    public function getReturnUrl() {
        $url = $this->getConfigData('return_url');
        return $url;
    }

    public function capture(Varien_Object $payment, $amount) {
        $payment->setStatus(self::STATUS_APPROVED)
                ->setLastTransId($this->getTransactionId());

        return $this;
    }

    /**
     *  Return Standard Checkout Form Fields for request to JETCO
     *
     *  @return	  array Array of hidden form fields
     */
    public function getStandardCheckoutFormFields() {
        $session = Mage::getSingleton('checkout/session');
        $order = $this->getOrder();

        if (!($order instanceof Mage_Sales_Model_Order)) {
            Mage::throwException($this->_getHelper()->__('Cannot retrieve order object'));
        }

        $parameter = array(
            'service' => 'AUTH',
            'merchantID' => $this->getConfigData('merchant_id'),
            'gatewayURL' => $this->getGatewayUrl(),
            'returnURL' => $this->getReturnUrl(),
            '_input_charset' => 'utf-8',
            'invoiceNumber' => $order->getRealOrderId(),
            'amount' => sprintf('%.2f', $order->getGrandTotal()),
        );

        $parameter = $this->para_filter($parameter);
        //$security_code = $this->getConfigData('security_code');
        //$sign_type = 'MD5';
        $sort_array = array();
        $arg = "";
        $sort_array = $this->arg_sort($parameter); //$parameter


        while (list ($key, $val) = each($sort_array)) {
            $arg.=$key . "=" . $this->charset_encode($val, $parameter['_input_charset']) . "&";
        }


        $prestr = substr($arg, 0, count($arg) - 2);
        //$mysign = $this->sign($prestr.$security_code);
        $fields = array();
        $sort_array = array();
        $arg = "";
        $sort_array = $this->arg_sort($parameter);

        while (list ($key, $val) = each($sort_array)) {
            $fields[$key] = urlencode($this->charset_encode($val, 'utf-8'));
        }

        //$fields['sign'] = $mysign;
        //$fields['sign_type'] = $sign_type;

        return $fields;
    }

    public function sign($prestr) {

        $mysign = md5($prestr);
        return $mysign;
    }

    public function para_filter($parameter) {
        $para = array();

        while (list ($key, $val) = each($parameter)) {
            if ($key == "sign" || $key == "sign_type" || $val == "")
                continue;
            else
                $para[$key] = $parameter[$key];
        }

        return $para;
    }

    public function arg_sort($array) {
        ksort($array);
        reset($array);
        return $array;
    }

    public function charset_encode($input, $_output_charset, $_input_charset ="GBK") {
        $output = "";

        if ($_input_charset == $_output_charset || $input == null) {
            $output = $input;
        } elseif (function_exists("mb_convert_encoding")) {
            $output = mb_convert_encoding($input, $_output_charset, $_input_charset);
        } elseif (function_exists("iconv")) {
            $output = iconv($_input_charset, $_output_charset, $input);
        } else {
            die("sorry, you have no libs support for charset change.");
        }

        return $output;
    }

    /**
     * Return authorized languages by Alipay
     *
     * @param	none
     * @return	array
     */
    protected function _getAuthorizedLanguages() {
        $languages = array();

        foreach (Mage::getConfig()->getNode('global/payment/jetco/languages')->asArray() as $data) {
            $languages[$data['code']] = $data['name'];
        }

        return $languages;
    }

    /**
     * Return language code to send to Alipay
     *
     * @param	none
     * @return	String
     */
    protected function _getLanguageCode() {
        // Store language
        $language = strtoupper(substr(Mage::getStoreConfig('general/locale/code'), 0, 2));

        // Authorized Languages
        $authorized_languages = $this->_getAuthorizedLanguages();

        if (count($authorized_languages) === 1) {
            $codes = array_keys($authorized_languages);
            return $codes[0];
        }

        if (array_key_exists($language, $authorized_languages)) {
            return $language;
        }

        // By default we use language selected in store admin
        return $this->getConfigData('language');
    }

}