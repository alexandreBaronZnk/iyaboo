<?php
 
$installer = $this;
 
$installer->startSetup();
 
$installer->run("
 
DROP TABLE IF EXISTS {$this->getTable('hierp_supplier')};
CREATE TABLE {$this->getTable('hierp_supplier')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS {$this->getTable('hierp_contact_person')};
CREATE TABLE {$this->getTable('hierp_contact_person')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `supplier`varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone1` varchar(100) NOT NULL,
  `phone2` varchar(100)  NULL,
  PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS {$this->getTable('hierp_buyorder')};
CREATE TABLE {$this->getTable('hierp_buyorder')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `supplier`varchar(100) NOT NULL,
  `dept` varchar(100) NOT NULL,
  `organizer` varchar(100) NOT NULL,
  `date` timestamp default current_timestamp,
  PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS {$this->getTable('hierp_buyorder_detail')};
CREATE TABLE {$this->getTable('hierp_buyorder_detail')} (
    `id` int(11) unsigned NOT NULL auto_increment,
   `buyorder` int(11) unsigned NOT NULL,
  `product`varchar(500)  NOT NULL,
  `quantity` int(11) unsigned NOT NULL,
  `cost` int(11) unsigned NOT NULL,
`comments` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
 
");
 
$installer->endSetup();
