<?php

require "csvdatafile.php";

class AmazonUtil {

    var $Rows;
    var $childRows;
    var $parentRows;
    var $options;
    var $itks;
    var $attributes;
    var $children;

    public function init() {
        $this->options = array();
        $this->parentRows = array();
        $this->childRows = array();
        $this->children = array();

        $this->attributes = array(
            'hand' => array(
                'code' => 'hand', //attribute code
                'label' => 'Hand', //attribute label
                'id' => 129, //attribute id
                'field' => 'Hand'       //field name used in CSV
            ),
            'flex' => array(
                'code' => 'flex',
                'label' => 'Flex',
                'id' => 132,
                'field' => 'GolfFlex'
            ),
            'shaft' => array(
                'code' => 'shaft',
                'label' => 'Shaft',
                'id' => 131,
                'field' => 'ShaftMaterial'
            ),
            'head' => array(
                'code' => 'head',
                'label' => 'Head',
                'id' => 130,
                'field' => 'GolfLoft'
            ),
            'size' => array(
                'code' => 'size',
                'label' => 'Size',
                'id' => 143,
                'field' => 'Size'
            ),
            'sizeName' => array(
                'code' => 'size',
                'label' => 'Size',
                'id' => 143,
                'field' => 'SizeName'
            ),
            'color' => array(
                'code' => 'color',
                'label' => 'Color',
                'id' => 80,
                'field' => 'Color'
            ),
            'brand' => array(
                'code' => 'brand',
                'id' => 121
            )
        );

        $this->attributeCodes = array();
        foreach ($this->attributes as $attribute) {
            $this->attributeCodes[$attribute['id']] = $attribute['code'];
        }


        $this->itks = array(
            'golf-club-iron-sets' => array(
                'category' => 66,
                'attributeset' => 9,
                'attributes' => array('hand', 'flex', 'shaft')
            ),
            'golf-drivers' => array(
                'category' => 63,
                'attributeset' => 10,
                'attributes' => array('hand', 'flex', 'shaft', 'head')
            ),
            'golf-hybrid-clubs' => array(
                'category' => 65,
                'attributeset' => 10,
                'attributes' => array('hand', 'flex', 'shaft', 'head')
            ),
            'golf-fairway-woods' => array(
                'category' => 64,
                'attributeset' => 10,
                'attributes' => array('hand', 'flex', 'shaft', 'head')
            ),
            'golf-hybrid-club-sets' => array(
                'category' => 65,
                'attributeset' => 10,
                'attributes' => array('hand', 'flex', 'shaft')
            ),
            'golf-shoes' => array(
                'category' => 75,
                'attributeset' => 9,
                'attributes' => array('color', 'size')
            ),
            'golf-cart-bags' => array(
                'category' => 57,
                'attributeset' => 9,
                'attributes' => array('color')
            ),
            'golf-carry-bags' => array(
                'category' => 59,
                'attributeset' => 9,
                'attributes' => array('color')
            ),
            'golf-cart-bags' => array(
                'category' => 57,
                'attributeset' => 9,
                'attributes' => array('color')
            ),
            'golf-travel-covers' => array(
                'category' => 191,
                'attributeset' => 9,
                'attributes' => array('color')
            ),
            'golf-club-head-covers' => array(
                'category' => 43,
                'attributeset' => 9,
                'attributes' => array('color')
            ),
            'golf-umbrellas' => array(
                'category' => 31,
                'attributeset' => 9,
                'attributes' => array('color')
            ),
            'golf-shoe-bags' => array(
                'category' => 193,
                'attributeset' => 9,
                'attributes' => array('color')
            ),
            'golf-towels' => array(
                'category' => 30,
                'attributeset' => 9,
                'attributes' => array('color')
            ),
            'golf-gloves' => array(
                'category' => 206,
                'attributeset' => 9,
                'attributes' => array('hand', 'sizeName', 'color')
            ),
            'golf-jackets' => array(
                'category' => 50,
                'attributeset' => 9,
                'attributes' => array('color', 'sizeName')
            ),
            'golf-pants' => array(
                'category' => 51,
                'attributeset' => 9,
                'attributes' => array('color', 'sizeName')
            ),
            'golf-apparel' => array(
                'category' => 13,
                'attributeset' => 9,
                'attributes' => array('color', 'sizeName')
            )
        );
    }

    public function loadCSV($file) {
        $this->init();
        $csv = new csvDataFile($file);
        $this->Rows = $csv->getRows();
        foreach ($this->Rows as $Row) {
            if (strtoupper($Row['Parentage']) == 'PARENT')
                $this->parentRows[] = $Row;
            else if (strtoupper($Row['Parentage']) == 'CHILD') {
                $this->childRows[] = $Row;
                $this->children[$Row['ParentSKU']][] = $Row['SKU'];
            }
        }
        if (count($this->parentRows) < 1) {
            echo "<br>" . "There are %s parent items" . count($this->parentRows);
            echo "<br>" . "There are %s child items" . count($this->childRows);
            
            echo "<br> Please make sure the uploaded file is CSV file and have the correct field headers. <br>";
        }
    }

    public function getIndexValue($attributeId, $label) {

        if (!$this->options[$attributeId]) {
            $this->options[$attributeId] = array();

            if ($attributeId == 80) {   // 80 is color's id, special handling
                $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'color');
                if ($attribute->usesSource()) {
                    $attributeOptions = $attribute->getSource()->getAllOptions(false);
                }
            } else {
                $attribute = Mage::getModel('eav/entity_attribute')->load($attributeId);
                $attributeOptions = $attribute->getSource()->getAllOptions();
            }

            foreach ($attributeOptions as $attributeOption) {
                $this->options[$attributeId][strtoupper(trim($attributeOption['label']))] = $attributeOption['value'];
            }
        }

        if (!$this->options[$attributeId][strtoupper(trim($label))]) {
            $attributeCode = $this->attributeCodes[$attributeId];
            echo "<br> missing option for attribute '$attributeCode' : $label" . "<br>";

            //$this->addOptionLabel($attributeId, $label);
            //return $this->getIndexValue($attributeId, $label);
        }
        return $this->options[$attributeId][strtoupper(trim($label))];
    }

    public function addOptionLabel($attributeId, $label) {
        $option['attribute_id'][0] = $attributeId;
        $option['value']['option1'][0] = $label;
        $setup = new Mage_Eav_Model_Entity_Setup('core_setup');
        $setup->addAttributeOption($option);
        $this->options[$attributeId] = false;
    }

    public function getUniqueFiledList($field) {
        $fieldValues = array();
        foreach ($this->Rows as $Row) {
            $fieldValues[] = $Row[$field];
        }
        return array_unique($fieldValues);
    }

    public function createProducts() {
        try {
            foreach ($this->childRows as $Row) {
                //if want to skip existing product, use 'true' for the second parameter
                $this->createSimpleProduct($Row, false);
            }

            foreach ($this->parentRows as $Row) {
                //if want to skip existing product, use 'true' for the second parameter
                $this->createConfigurableProduct($Row, false);
            }
        } catch (Exception $e) {

            Mage::log("exception:$e");
        }
    }

    public function getIdBySku($Sku) {
        $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $Sku);
        return $product->getId();
    }

    public function createSimpleProduct($Row, $skip=true) {

        $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $Row['SKU']);

        if ($product) {
            if ($skip)
                return;
            else
                $product->delete();
        }

        $product = Mage::getModel('catalog/product');

        $stockData = array();
        $stockData['qty'] = $Row['Quantity'];
        $stockData['is_in_stock'] = 1;
        $product->setStockData($stockData);
        $product->setTypeId('simple');
        $product->setTaxClassId(2); //none
        $product->setWebsiteIds(array(1));  // store id
        $product->setAttributeSetId($this->itks[$Row['ItemType']]['attributeset']); //Golf Attribute Set
        $product->setSku($Row['SKU']);
        $product->setCategoryIds(array($this->itks[$Row['ItemType']]['category']));

        $product->setName($Row['ProductName']);
        $product->setBrand($this->getIndexValue($this->attributes['brand']['id'], $Row['Brand']));
        $product->setDescription($Row['ProductName']);
        $product->setShortDescription($Row['ProductName']);
        $product->setPrice($Row['ItemPrice']);
        $product->setWeight($Row['ShippingWeight']);
        $product->setStatus(1); //enabled
        $product->setVisibility(1); //nowhere

        if ($Row['ItemType']) {
            foreach ($this->itks[$Row['ItemType']]['attributes'] as $attribute) {
                $product->setData($this->attributes[$attribute]['code'], $this->getIndexValue($this->attributes[$attribute]['id'], $Row[$this->attributes[$attribute]['field']]));
            }
        }
        try {
            $product->save();
            $productId = $product->getId();
            echo $product->getId() . ", simple product added" . '<br>';
        } catch (Exception $e) {
            echo "$name not added" . '<br>';
            echo "exception:$e" . '<br>';
        }
    }

    public function createConfigurableProduct($Row, $skip=true) {

        $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $Row['SKU']);
        if ($product) {
            if ($skip)
                return;
            else
                $product->delete();
        }

        $product = Mage::getModel('catalog/product');


        $product->setTypeId('configurable');
        $product->setTaxClassId(2); //none
        $product->setWebsiteIds(array(1));  // store id
        $product->setAttributeSetId($this->itks[$Row['ItemType']]['attributeset']); //Golf Attribute Set
        $product->setSku($Row['SKU']);
        $product->setCategoryIds(array($this->itks[$Row['ItemType']]['category']));

        $product->setName($Row['ProductName']);
        $product->setBrand($this->getIndexValue($this->attributes['brand']['id'], $Row['Brand']));
        $product->setDescription($Row['ProductDescription']);
        $product->setShortDescription($Row['ProductDescription']);

        $product->setWeight(0);
        $product->setStatus(1); //enabled
        $product->setVisibility(4); //nowhere
        $product->setStockData(array('is_in_stock' => 1));

        $configurableAttributes = array();
        foreach ($this->itks[$Row['ItemType']]['attributes'] as $attribute) {
            $configurableAttributes[] = array('attribute_id' => $this->attributes[$attribute]['id'], 'is_percent' => '', 'pricing_value' => '');

            $configurableAttributesData[] = array(
                'id' => NULL,
                'label' => $this->attributes[$attribute]['label'],
                'use_default' => '0',
                'position' => '0',
                'values' => array(
                ),
                'attribute_id' => $this->attributes[$attribute]['id'],
                'attribute_code' => $this->attributes[$attribute]['code'],
                'html_id' => 'configurable_attribute_0'
            );
        }

        $priceValues = array();
        foreach ($this->children[$Row['SKU']] as $child) {
            $id = $this->getIdBySku($child);
            $configurableProductsData[$id] = $configurableAttributes;
            $childProduct = Mage::getModel('catalog/product')->load($id);
            $childProduct->setDescription($Row['ProductDescription']);
            $childProduct->setShortDescription($Row['ProductDescription']);
            $priceValue[] = $childProduct->getPrice();
            $childProduct->save();
        }

        $product->setPrice($priceValue[0]);
        $product->setOptionsContainer('container2');
        $product->setConfigurableProductsData($configurableProductsData);
        $product->setConfigurableAttributesData($configurableAttributesData);
        $product->setCanSaveConfigurableAttributes(true);

        try {
            $product->save();

            $productId = $product->getId();
            echo $product->getId() . ", configurable product added" . '<br>';
        } catch (Exception $e) {
            echo "$name not added" . '<br>';
            echo "exception:$e" . '<br>';
        }
    }

}

?>
