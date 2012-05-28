
<?php
/**
 * Luxe
 * MostViewed module
 *
 * @category   Luxe 
 * @package    Luxe_MostViewed
 */

/**
 * Product list
 *
 * @category   Luxe
 * @package    Luxe_MostViewed
 * @author     Yuriy V. Vasiyarov
 */

class Luxe_MostViewed_Block_HotCategory extends Mage_Core_Block_Template {
	protected function _getCategories() {
			
		$categories = Mage::helper ( 'catalog/category' )->getStoreCategories ();
	echo "<div class='menu'>";
		echo "<ul>";
		foreach ( $categories as $_category ) {
			
			echo '<li  class="hide"><a href="' . $_category->getUrlKey () . '.html"><span>' . $_category->getName () . '</span></a>';
			
			if ($_category->hasChildren ()) {
				echo '<ul>';
				
				foreach ( $_category->getChildren () as $subcategory ) {
					if ($subcategory->getIsActive ()) { // check if category is active
						echo '<li class="hide"><a href="' . $_category->getUrlKey () . '/' . $subcategory->getUrlKey () . '.html"><span>' . $subcategory->getName () . '</span></a></li>';
					}
				}
				echo '</ul>';
			}
			echo '</li>';
		}
		echo '</ul>';
	echo '</div>';
	}
}	
?>