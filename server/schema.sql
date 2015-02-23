-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Generation Time: Feb 23, 2015 at 12:51 PM
-- Server version: 5.1.56
-- PHP Version: 5.4.37

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `twitch_games`
--

CREATE TABLE IF NOT EXISTS `twitch_games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `twitch_id` int(11) NOT NULL,
  `giantbomb_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=152 ;

-- --------------------------------------------------------

--
-- Table structure for table `twitch_topgames`
--

CREATE TABLE IF NOT EXISTS `twitch_topgames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `twitch_id` int(11) NOT NULL,
  `viewers` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17681 ;
