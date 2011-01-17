-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 25 Dec 2010 om 15:13
-- Serverversie: 5.1.44
-- PHP-Versie: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE `admins`(`id` int(11) NOT NULL AUTO_INCREMENT,`naam` varchar(255) NOT NULL,`wachtwoord` varchar(255) NOT NULL,`email` varchar(255) NOT NULL,`lastvisited` datetime NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `categories` (`id` int(11) NOT NULL AUTO_INCREMENT,`name` varchar(255) NOT NULL,`created` datetime NOT NULL,`position` int(11) NOT NULL,`parent_id` int(11) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `costs` (`id` int(11) NOT NULL AUTO_INCREMENT,`naam` varchar(255) NOT NULL,`prijs` varchar(255) NOT NULL,`hoeveelheid` int(11) NOT NULL,`btw` varchar(4) NOT NULL,`created` datetime NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `extraterms` (`id` int(11) NOT NULL AUTO_INCREMENT,`name` varchar(255) NOT NULL,`created` datetime NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `extravalues` (`id` int(11) NOT NULL AUTO_INCREMENT,`value` varchar(255) NOT NULL,`product_id` int(11) NOT NULL,`extraterm_id` int(11) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `metaterms` (`id` int(11) NOT NULL AUTO_INCREMENT,`name` varchar(255) NOT NULL,`plural` varchar(255) NOT NULL,`multiselect` tinyint(1) NOT NULL DEFAULT '0',`icon` tinyint(1) NOT NULL DEFAULT '0',PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `metavalues` (`id` int(11) NOT NULL AUTO_INCREMENT,`name` varchar(255) NOT NULL,`value` varchar(255) NOT NULL,`icon` varchar(255) NOT NULL,`metaterm_id` int(11) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `metavalues_products` (`id` int(11) NOT NULL AUTO_INCREMENT,`metavalue_id` int(11) NOT NULL,`product_id` int(11) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `options` (`id` int(11) NOT NULL AUTO_INCREMENT,`orders_products_id` int(11) NOT NULL,`value_id` int(11) NOT NULL,`term_id` int(11) NOT NULL,`value` varchar(255) NOT NULL,`value_small` varchar(255) NOT NULL,`term` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `orders` (`id` int(11) NOT NULL AUTO_INCREMENT,`user_id` int(11) NOT NULL,`paid` tinyint(1) NOT NULL DEFAULT '0',`method` varchar(255) NOT NULL,`created` datetime NOT NULL,`paid_on` datetime NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `orders_products` (`id` int(11) NOT NULL AUTO_INCREMENT,`order_id` int(11) NOT NULL,`product_id` int(11) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `photos` (`id` int(11) NOT NULL AUTO_INCREMENT,`name` varchar(255) DEFAULT NULL,`thumb` varchar(255) NOT NULL,`medium` varchar(255) NOT NULL,`large` varchar(255) NOT NULL,`created` datetime NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `photos_products` (`id` int(11) NOT NULL AUTO_INCREMENT,`photo_id` int(11) NOT NULL,`product_id` int(11) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `plugins` (`id` int(11) NOT NULL AUTO_INCREMENT,`name` varchar(255) NOT NULL,`dir` varchar(255) NOT NULL,`creator` varchar(255) NOT NULL,`path` varchar(255) NOT NULL,`settingspath` varchar(255) NOT NULL,`info` varchar(255) NOT NULL,`active` tinyint(1) NOT NULL DEFAULT '0',PRIMARY KEY (`id`),UNIQUE KEY `id` (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `posts` (`id` int(11) NOT NULL AUTO_INCREMENT,`title` varchar(255) NOT NULL,`body` text NOT NULL,`created` datetime NOT NULL,`edited` datetime NOT NULL,`slug` varchar(255) NOT NULL,`pagetitle` varchar(255) NOT NULL,`keywords` varchar(255) NOT NULL,`hidden` tinyint(1) NOT NULL DEFAULT '0',PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `products` (`id` int(11) NOT NULL AUTO_INCREMENT,`image` varchar(255) NOT NULL,`name` varchar(255) NOT NULL,`description` text NOT NULL,`excerpt` text NOT NULL,`deliver` varchar(255) NOT NULL,`created` datetime NOT NULL,`price` varchar(255) NOT NULL,`sendcost` varchar(255) NOT NULL,`vat` varchar(4) NOT NULL DEFAULT '0.19',`position` int(11) NOT NULL,`sale` tinyint(1) NOT NULL DEFAULT '0',`hidden` tinyint(1) NOT NULL DEFAULT '0',`slug` varchar(255) NOT NULL,`pagetitle` varchar(255) NOT NULL,`pagemeta` varchar(255) NOT NULL,`category_id` int(11) NOT NULL,`parent_id` int(11) NOT NULL,`photo_id` int(11) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `settings` (`id` int(11) NOT NULL AUTO_INCREMENT,`key` varchar(255) NOT NULL,`pair` text NOT NULL,`created` datetime NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `settings` VALUES(7, 'GOOGLE_LOGIN', '', '2010-07-21 13:16:36');
INSERT INTO `settings` VALUES(6, 'MEDIUM_SIZE', '250', '2010-07-21 13:16:18');
INSERT INTO `settings` VALUES(5, 'THUMB_SIZE', '70', '2010-07-21 13:16:07');
INSERT INTO `settings` VALUES(4, 'ADVANCED', 'true', '2010-07-21 13:15:50');
INSERT INTO `settings` VALUES(8, 'GOOGLE_PASSWORD', '', '2010-07-21 13:16:48');
INSERT INTO `settings` VALUES(9, 'ANALYTICS_ID', '', '2010-07-21 13:17:07');
INSERT INTO `settings` VALUES(11, 'AMOUNT_ON_PAGE', '10', '2010-07-25 15:46:31');
INSERT INTO `settings` VALUES(16, 'CONTACT_CAPTCHA', 'false', '2010-07-29 10:22:35');
INSERT INTO `settings` VALUES(17, 'SENDCOST_PER_PRODUCT', 'true', '2010-07-30 10:03:01');
INSERT INTO `settings` VALUES(18, 'SENDCOST', '2.95', '2010-07-30 10:03:14');
INSERT INTO `settings` VALUES(19, 'PAY_AFTER', 'true', '2010-08-03 17:25:06');
INSERT INTO `settings` VALUES(20, 'PAY_IDEAL', 'true', '0000-00-00 00:00:00');
INSERT INTO `settings` VALUES(21, 'ACCOUNT_NUMBER', '1234.56.900', '2010-08-06 10:20:04');
INSERT INTO `settings` VALUES(22, 'ACCOUNT_NAME', 'Thinkshop', '2010-08-06 10:20:15');


CREATE TABLE `staticpages` (`id` int(11) NOT NULL AUTO_INCREMENT,`title` varchar(255) NOT NULL,`body` text NOT NULL,`created` datetime NOT NULL,`menu` varchar(255) NOT NULL DEFAULT 'top',`position` int(11) NOT NULL,`hidden` tinyint(1) NOT NULL DEFAULT '0',`slug` varchar(255) NOT NULL,`pagetitle` varchar(255) NOT NULL,`keywords` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

CREATE TABLE `users` (`id` int(11) NOT NULL AUTO_INCREMENT,`firstname` varchar(255) NOT NULL,`lastname` varchar(255) NOT NULL,`gender` varchar(1) NOT NULL,`email` varchar(255) NOT NULL,`password` varchar(255) NOT NULL,`address` varchar(255) NOT NULL,`zipcode` varchar(255) NOT NULL,`city` varchar(255) NOT NULL,`country` varchar(255) NOT NULL,`invoiceaddress` varchar(255) NOT NULL,`invoicezipcode` varchar(255) NOT NULL,`invoicecity` varchar(255) NOT NULL,`invoicecountry` varchar(255) NOT NULL,`created` datetime NOT NULL,`lastvisit` datetime NOT NULL,`activated` tinyint(1) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `videos` (`id` int(11) NOT NULL AUTO_INCREMENT,`title` varchar(255) NOT NULL,`file_id` varchar(255) NOT NULL,`type` varchar(255) NOT NULL,`thumb` varchar(255) NOT NULL,`created` datetime NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `videos_products` (`id` int(11) NOT NULL AUTO_INCREMENT,`video_id` int(11) NOT NULL,`product_id` int(11) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;