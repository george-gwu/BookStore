-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.73


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema bookstore
--

CREATE DATABASE IF NOT EXISTS bookstore;
USE bookstore;

DROP TABLE IF EXISTS `bookstore`.`categories`;
CREATE TABLE  `bookstore`.`categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
INSERT INTO `bookstore`.`categories` (`id`,`categoryName`) VALUES 
 (2,'Testing124');

DROP TABLE IF EXISTS `bookstore`.`customers`;
CREATE TABLE  `bookstore`.`customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `roleType` int(1) unsigned NOT NULL DEFAULT '0',
  `email` varchar(128) NOT NULL COMMENT 'username',
  `firstName` varchar(128) NOT NULL,
  `lastName` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `shippingAddress1` varchar(128) DEFAULT NULL,
  `shippingAddress2` varchar(128) DEFAULT NULL,
  `shippingCity` varchar(64) DEFAULT NULL,
  `shippingState` varchar(2) DEFAULT NULL,
  `shippingCountry` varchar(4) DEFAULT NULL,
  `shippingZipcode` varchar(16) DEFAULT NULL,
  `billingAddress1` varchar(128) DEFAULT NULL,
  `billingAddress2` varchar(128) DEFAULT NULL,
  `billingCity` varchar(64) DEFAULT NULL,
  `billingState` varchar(2) DEFAULT NULL,
  `billingCountry` varchar(4) DEFAULT NULL,
  `billingZipcode` varchar(16) DEFAULT NULL,
  `encryptedCardName` varchar(255) DEFAULT NULL,
  `encryptedCardNumber` varchar(255) DEFAULT NULL,
  `encryptedCardExpiration` varchar(255) DEFAULT NULL,
  `encryptedCardSecurityCode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
INSERT INTO `bookstore`.`customers` (`id`,`roleType`,`email`,`firstName`,`lastName`,`password`,`shippingAddress1`,`shippingAddress2`,`shippingCity`,`shippingState`,`shippingCountry`,`shippingZipcode`,`billingAddress1`,`billingAddress2`,`billingCity`,`billingState`,`billingCountry`,`billingZipcode`,`encryptedCardName`,`encryptedCardNumber`,`encryptedCardExpiration`,`encryptedCardSecurityCode`) VALUES 
 (1,9,'gschmick@gmail.com','George','Schmick','3e519932e7efd1250a78e9b2b4569cf0c0d68b80d9bf7e285d501a75c6222e20',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

DROP TABLE IF EXISTS `bookstore`.`events`;
CREATE TABLE  `bookstore`.`events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eventType` int(1) unsigned NOT NULL,
  `eventDate` datetime NOT NULL,
  `eventDescription` varchar(128) NOT NULL,
  `customerID` int(10) unsigned NOT NULL,
  `cardHolderName` varchar(128) NOT NULL,
  `cardNumber` varchar(64) NOT NULL COMMENT 'encrypted? TBD.',
  `customerIP` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bookstore`.`hotlist`;
CREATE TABLE  `bookstore`.`hotlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cardNumber` varchar(32) NOT NULL COMMENT 'unencrypted - not sensitive since on list',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cardNumber_UNIQUE` (`cardNumber`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bookstore`.`inventory`;
CREATE TABLE  `bookstore`.`inventory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `itemName` varchar(128) NOT NULL,
  `itemDescription` text NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `quantity` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bookstore`.`orders`;
CREATE TABLE  `bookstore`.`orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cartData` text NOT NULL,
  `customerID` int(10) unsigned NOT NULL,
  `orderDate` datetime NOT NULL,
  `orderFilePath` varchar(255) NOT NULL COMMENT 'Order Processing Location on File System',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bookstore`.`reviews`;
CREATE TABLE  `bookstore`.`reviews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `itemID` int(10) unsigned NOT NULL,
  `review` text NOT NULL,
  `rating` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bookstore`.`sessions`;
CREATE TABLE  `bookstore`.`sessions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customerID` int(10) unsigned NOT NULL,
  `loginDate` datetime NOT NULL,
  `cartData` text NOT NULL COMMENT 'JSON-encoded',
  PRIMARY KEY (`id`),
  KEY `customerID_idx` (`customerID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
