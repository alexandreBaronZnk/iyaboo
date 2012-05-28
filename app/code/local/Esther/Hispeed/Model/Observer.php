<?php
class Esther_Hispeed_Model_Observer
{
	private $_request = null;

	const CUSTOM_CACHE_LIFETIME = 3600;
	//the non-CMS Block you want to cache
	private $cacheableBlocks = array('Block_Class_A', 'Block_Class_B');

	public function customBlockCache(Varien_Event_Observer $observer){
		try {
			$event = $observer->getEvent();
			$block = $event->getBlock();
			$class = get_class($block);
			if (('Mage_Cms_Block_Block' == $class) && $block->getBlockId()) {
				$block->setData('cache_lifetime', self::CUSTOM_CACHE_LIFETIME);
				$block->setData('cache_key', 'cms_block_' . $block->getBlockId());
				$block->setData('cache_tags', array(Mage_Core_Model_Store::CACHE_TAG, $block->getBlockId()));
			} elseif (('Mage_Cms_Block_Page' == $class) && $block->getPage()->getIdentifier()) {
				$block->setData('cache_lifetime', self::CUSTOM_CACHE_LIFETIME);
				$block->setData('cache_key', 'cms_page_' . $block->getPage()->getIdentifier());
				$block->setData('cache_tags', array(Mage_Core_Model_Store::CACHE_TAG,
				$block->getPage()->getIdentifier()));
			} elseif (in_array($class, $this->cacheableBlocks)) {
				$block->setData('cache_lifetime', self::CUSTOM_CACHE_LIFETIME);
				$block->setData('cache_key', 'block_' . $class);
				$block->setData('cache_tags', array(Mage_Core_Model_Store::CACHE_TAG, $class));
			}
		} catch (Exception $e) {
			Mage::logException(e);
		}
	}

	public function __construct()
	{
	}

	private function getSecureKey()
	{
		return Mage::getStoreConfig('hispeed/purgeall_key/key');
	}

	public function getCookie()
	{
		return Mage::app()->getCookie();
	}

	public function customerLoginAction($observer)
	{
		Mage::log('login in event');
		$customerSession = Mage::getSingleton('customer/session');
		$this->getCookie()->set('customer', $customerSession->getCustomer()->getName());
	}

	public function customerLogoutAction($observer)
	{
		Mage::log('login out event');
		$this->getCookie()->delete('customer');
	}


	public function cartUpdateAction($observer)
	{
		Mage::log('cart update ---------');
		$frontend = $this->getCookie()->get('frontend');

		if($frontend)
		{
			Mage::log($frontend . 'cart update');

			Mage::app()->saveCache('update' , $frontend . Mage::app()->FPC_TOPCART,array(),3600);
		}

	}

	public function quoteHasItems()
	{
		$quote = Mage::getSingleton('checkout/session')->getQuote();
		if ($quote instanceof Mage_Sales_Model_Quote && $quote->hasItems()) {
			return true;
		}
	}

	public function customerIsLogged()
	{
		$customerSession = Mage::getSingleton('customer/session');
		if ($customerSession instanceof Mage_Customer_Model_Session  &&
		$customerSession->isLoggedIn()) {
			//$this->getCookie()->set('customer', $customerSession->getCustomer()->getName());
			return true;
		}
	}

	public function purgeAll()
	{
		try {
			$url = Mage::getBaseUrl().'hispeed/index/purgeall/key/'.$this->getSecureKey().'/';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PURGE');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			$responseBody = curl_exec($ch);
			curl_close ($ch);
		} catch (Exception $e) {
			Mage::log($e->getFile().' '.$e->getLine().' '.$e->getMessage());
		}
	}
}
