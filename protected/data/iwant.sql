-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 06, 2015 at 04:37 PM
-- Server version: 5.1.40
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `iwant`
--

-- --------------------------------------------------------

--
-- Table structure for table `desire`
--

CREATE TABLE IF NOT EXISTS `desire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `paid` int(11) NOT NULL,
  `giver_id` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `publish` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `desire`
--

INSERT INTO `desire` (`id`, `user_id`, `title`, `text`, `paid`, `giver_id`, `img`, `publish`) VALUES
(1, 1, 'droog', 'There are a few things you need to do:\r\n\r\nDo not insert anything in the attribute data-content; check to see if it’s empty because any content here will override the image in the script.\r\nCreate a variable which holds the image.\r\nWhen you specify the content in the script use the variable name from step 2.\r\nAdd “html: true”; this will assure that the browser will display the image. Without this it will display the code you use for the image.', 0, 0, '', 1),
(2, 1, 'droog2', 'There are a few things you need to do:\r\n\r\nDo not insert anything in the attribute data-content; check to see if it’s empty because any content here will override the image in the script.\r\nCreate a variable which holds the image.\r\nWhen you specify the content in the script use the variable name from step 2.\r\nAdd “html: true”; this will assure that the browser will display the image. Without this it will display the code you use for the image.', 0, 3, '', 1),
(3, 2, 'kartm', '', 0, 0, '', 1),
(4, 2, 'kartm1', '', 0, 4, '', 1),
(5, 2, 'kartm2', '', 0, 1, 'images/cache/dfe271fd61f34ba085922c2bf733fc7d.jpg', 1),
(6, 3, 'wag', '', 0, 0, 'images/cache/2c7d01bcdf26253a2a5a97288bc3e24e.png', 1),
(7, 3, 'wag1', '', 0, 1, 'images/cache/379349d36dde5edb170c9de19d9d2f81.jpg', 1),
(8, 4, 'tus', '', 0, 0, 'images/cache/29a676a137ff9a16451409d1612c60a1.jpg', 1),
(9, 4, 'tus1', '', 0, 0, '', 1),
(10, 4, 'tus2', '', 0, 2, '', 1),
(11, 4, 'tus3', '', 0, 0, 'images/cache/cdcbe6eb7ab40c23064c59c3fc6bab6b.jpg', 1),
(12, 1, 'droog3', '', 0, 2, 'images/cache/577e3e347dc03debe207907887a6b922.jpg', 1),
(13, 4, 'tus4', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 0, 1, '', 1),
(14, 4, 'tus5', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 0, 2, 'images/cache/986613167bce65200c0784b4190a36c0.jpg', 1),
(15, 4, 'tus6', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 0, 0, 'images/cache/3b249a562259bea81e6bd2f59cbe4c91.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_id`) VALUES
(1, 44320505),
(2, 58436768),
(3, 10733133),
(4, 16623751);
