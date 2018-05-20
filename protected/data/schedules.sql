-- phpMyAdmin SQL Dump
-- version 2.8.0.1
-- http://www.phpmyadmin.net
-- 
-- Host: custsql-d503.eigbox.net
-- Generation Time: May 20, 2018 at 08:11 AM
-- Server version: 5.6.37
-- PHP Version: 4.4.9

SET FOREIGN_KEY_CHECKS=0;
-- 
-- Database: `schedules`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `category`
-- 

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `category_genre`
-- 

CREATE TABLE `category_genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `genre_id` (`genre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=204 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `channel`
-- 

CREATE TABLE `channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=483 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=483 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `custom_category`
-- 

CREATE TABLE `custom_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `custom_genre`
-- 

CREATE TABLE `custom_genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `genre_id` int(11) DEFAULT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `genre_id` (`genre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=498 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=498 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `genre`
-- 

CREATE TABLE `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=117 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `person`
-- 

CREATE TABLE `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=36574 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=36574 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `schedule`
-- 

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start` datetime NOT NULL,
  `length` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `day_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `channel_id` (`channel_id`),
  KEY `show_id` (`show_id`),
  KEY `channel_id_2` (`channel_id`,`day_date`)
) ENGINE=InnoDB AUTO_INCREMENT=606819 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=606819 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `show`
-- 

CREATE TABLE `show` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `original_title` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(5000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `custom_category_id` int(11) DEFAULT NULL,
  `custom_genre_id` int(11) DEFAULT NULL,
  `season` int(11) DEFAULT NULL,
  `episode` int(11) DEFAULT NULL,
  `imdb_url` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `imdb_rating` int(11) DEFAULT NULL,
  `imdb_rating_count` int(11) DEFAULT NULL,
  `imdb_parsed` datetime DEFAULT NULL,
  `imdb_verified` int(11) NOT NULL DEFAULT '1',
  `trailer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `imdb_rating` (`imdb_rating`),
  KEY `custom_category_id` (`custom_category_id`),
  KEY `custom_genre_id` (`custom_genre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=157402 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=157402 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `show_actor`
-- 

CREATE TABLE `show_actor` (
  `show_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`show_id`,`person_id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `show_director`
-- 

CREATE TABLE `show_director` (
  `show_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`show_id`,`person_id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `subscriber`
-- 

CREATE TABLE `subscriber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `weekly_schedule` tinyint(1) DEFAULT NULL,
  `hash` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `categories` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `channels` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `genres` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `subscribed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=236 ;

-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `custom_category`
-- 
ALTER TABLE `custom_category`
  ADD CONSTRAINT `custom_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

-- 
-- Constraints for table `custom_genre`
-- 
ALTER TABLE `custom_genre`
  ADD CONSTRAINT `custom_genre_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

-- 
-- Constraints for table `schedule`
-- 
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`show_id`) REFERENCES `show` (`id`) ON DELETE CASCADE;

-- 
-- Constraints for table `show_actor`
-- 
ALTER TABLE `show_actor`
  ADD CONSTRAINT `show_actor_ibfk_1` FOREIGN KEY (`show_id`) REFERENCES `show` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `show_actor_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE;

-- 
-- Constraints for table `show_director`
-- 
ALTER TABLE `show_director`
  ADD CONSTRAINT `show_director_ibfk_1` FOREIGN KEY (`show_id`) REFERENCES `show` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `show_director_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE;

SET FOREIGN_KEY_CHECKS=1;
