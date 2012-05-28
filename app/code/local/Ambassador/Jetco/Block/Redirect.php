<?php

class Ambassador_Jetco_Block_Redirect extends Mage_Core_Block_Abstract {
      protected function _toHtml ()
    {
        $standard = Mage::getModel('jetco/payment');
        $form = new Varien_Data_Form();
        $form->setAction($standard->getJetcoUrl())
            ->setId('jetco_checkout')
            ->setName('jetco_checkout')
            ->setMethod('POST')
            ->setUseContainer(true);
            
        foreach ($standard->setOrder($this->getOrder())->getStandardCheckoutFormFields() as $field => $value) {
            $form->addField($field, 'hidden', array(
            	'name' => $field,
            	'value' => urldecode($value)
            ));
        }
        $formHTML = $form->toHtml();

        $html = '<html><body>';
        $html .= $this->__('You will be redirected to JETCO in a few seconds.');
        $html .= $formHTML;
        $html .= '<script type="text/javascript">document.getElementById("jetco_checkout").submit();</script>';
        $html .= '</body></html>';
        return $html;
        //return '';
    }

}