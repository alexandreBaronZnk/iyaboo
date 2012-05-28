
CREATE TABLE IF NOT EXISTS `hishop_user` (
  `user_id` int(50) NOT NULL AUTO_INCREMENT,
  `admin_user` varchar(50) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `store_group` varchar(50) DEFAULT NULL,
  `store` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
)  AUTO_INCREMENT=1 ;


create table if not exists `hishop_shop` (
	`shop_id` int(50) not null auto_increment,
	`store_group` varchar(50) not null,
	`title` varchar(100) not null,
	`company` varchar(100) not null,
	`contact` varchar(50) not null,
	primary key (`shop_id`)
) auto_increment=1;