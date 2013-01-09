


-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 28, 2012 at 08:23 PM
-- Server version: 5.5.28
-- PHP Version: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

DROP SCHEMA IF EXISTS `summarize`;
CREATE SCHEMA IF NOT EXISTS `summarize` ;
USE `summarize` ;

--
-- Database: `codemy23_summarize`
--
--
-- RELATIONS FOR TABLE `address`:
--   `created_by`
--       `member_info` -> `id`
--   `updated_by`
--       `member_info` -> `id`
--


DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `addr_line1` varchar(100) collate utf8_unicode_ci default NULL,
  `addr_line2` varchar(100) collate utf8_unicode_ci default NULL,
  `city` varchar(100) collate utf8_unicode_ci default NULL,
  `county` varchar(100) collate utf8_unicode_ci default NULL,
  `state` varchar(100) collate utf8_unicode_ci default NULL,
  `zip_code` varchar(25) collate utf8_unicode_ci default NULL,
  `country` varchar(100) collate utf8_unicode_ci default NULL,
  `created_at` datetime default NULL,
  `updated_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `version_id` int(11) unsigned NOT NULL,
  `created_by` bigint(20) unsigned default NULL,
  `updated_by` bigint(20) unsigned default NULL,
  `record_status` tinyint(2) unsigned default NULL COMMENT 'Status of record, 0-Delete, 1-Active',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `school`;
CREATE TABLE IF NOT EXISTS `school` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `public_id` varchar(256) collate utf8_unicode_ci default NULL COMMENT 'public id exposed publicly',
  `name` varchar(256) collate utf8_unicode_ci default NULL COMMENT 'school name',
  `address_id` bigint(20) unsigned default NULL,
  `created_at` datetime default NULL,
  `updated_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `version_id` int(11) unsigned NOT NULL,
  `created_by` bigint(20) unsigned default NULL,
  `updated_by` bigint(20) unsigned default NULL,
  `record_status` tinyint(2) unsigned default NULL COMMENT 'Status of record, 0-Delete, 1-Active',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `employer`;
CREATE TABLE IF NOT EXISTS `employer` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `public_id` varchar(256) collate utf8_unicode_ci default NULL COMMENT 'public id exposed publicly',
  `name` varchar(256) collate utf8_unicode_ci default NULL COMMENT 'company name',
  `address_id` bigint(20) unsigned default NULL,
  `created_at` datetime default NULL,
  `updated_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `version_id` int(11) unsigned NOT NULL,
  `created_by` bigint(20) unsigned default NULL,
  `updated_by` bigint(20) unsigned default NULL,
  `record_status` tinyint(2) unsigned default NULL COMMENT 'Status of record, 0-Delete, 1-Active',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `member_address`;
CREATE TABLE IF NOT EXISTS `member_employer` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `member_id` bigint(20) unsigned NOT NULL,
  `address_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime default NULL,
  `updated_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `version_id` int(11) unsigned NOT NULL,
  `created_by` bigint(20) unsigned default NULL,
  `updated_by` bigint(20) unsigned default NULL,
  `record_status` tinyint(2) unsigned default NULL COMMENT 'Status of record, 0-Delete, 1-Active',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `member_school`;
CREATE TABLE IF NOT EXISTS `member_school` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `member_id` bigint(20) unsigned NOT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime default NULL,
  `updated_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `version_id` int(11) unsigned NOT NULL,
  `created_by` bigint(20) unsigned default NULL,
  `updated_by` bigint(20) unsigned default NULL,
  `record_status` tinyint(2) unsigned default NULL COMMENT 'Status of record, 0-Delete, 1-Active',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `member_employer`;
CREATE TABLE IF NOT EXISTS `member_employer` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `member_id` bigint(20) unsigned NOT NULL,
  `employer_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime default NULL,
  `updated_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `version_id` int(11) unsigned NOT NULL,
  `created_by` bigint(20) unsigned default NULL,
  `updated_by` bigint(20) unsigned default NULL,
  `record_status` tinyint(2) unsigned default NULL COMMENT 'Status of record, 0-Delete, 1-Active',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--  used for more static / profile data 


DROP TABLE IF EXISTS `member_info`;
CREATE TABLE IF NOT EXISTS `member_info` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `member_id` bigint(20) unsigned NOT NULL,
  `image_id` bigint(20) unsigned default NULL,
  `login` varchar(100) default NULL COMMENT 'login name for the member',
  `email` varchar(100) default NULL COMMENT 'email for the member',
  `phone` varchar(20) default NULL COMMENT 'phone number with the country code and area code',
  `first_name` varchar(45) collate utf8_unicode_ci default NULL,
  `last_name` varchar(45) collate utf8_unicode_ci default NULL,
  `status_update` varchar(256) collate utf8_unicode_ci default NULL COMMENT 'Member status',
  `short_bio` varchar(256) collate utf8_unicode_ci default NULL COMMENT 'Member status',
  `middle_initial` varchar(45) collate utf8_unicode_ci default NULL,
  `ref_secret_question1_id` bigint(20) unsigned default NULL,
  `ref_secret_question2_id` bigint(20) unsigned default NULL,
  `ref_secret_question3_id` bigint(20) unsigned default NULL,
  `secret_answer1_hash` varchar(128) collate utf8_unicode_ci default NULL,
  `secret_answer2_hash` varchar(128) collate utf8_unicode_ci default NULL,
  `secret_answer3_hash` varchar(128) collate utf8_unicode_ci default NULL,
  `dob` date default NULL,
  `points` tinyint(4) unsigned default NULL COMMENT 'Could go into different table for the historical purpose',
  `cell_phone` varchar(15) collate utf8_unicode_ci default NULL,
  `land_line` varchar(15) collate utf8_unicode_ci default NULL,
  `gender` varchar(2) collate utf8_unicode_ci default NULL,
  `display_name` varchar(45) collate utf8_unicode_ci default NULL,
  `version_id` int(11) unsigned NOT NULL,
  `created_by` bigint(20) unsigned default NULL,
  `created_at` datetime default NULL,
  `updated_by` bigint(20) unsigned default NULL,
  `record_status` tinyint(2) unsigned default NULL COMMENT 'Status of record, 0-Delete, 1-Active',
  `updated_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `member_info_email_UNIQUE` (`email`),
  UNIQUE KEY `member_info_login_UNIQUE` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


-- Used for Login

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `public_id` varchar(256) default NULL COMMENT 'public id exposed publicly',
  `login` varchar(100) default NULL COMMENT 'login name for the member',
  `email` varchar(100) default NULL COMMENT 'email for the member',
  `crypted_password` varchar(128) default NULL COMMENT 'crypted password',
  `persistence_token` varchar(128) NOT NULL,
  `single_access_token` varchar(128) NOT NULL,
  `perishable_token` varchar(128) NOT NULL,
  `login_type` tinyint(2) unsigned default NULL COMMENT 'Login type: null - tastetablet, 1 tastetablet site or 2, facebook, 3 twitter',
  `login_count` int(11) unsigned NOT NULL default '0',
  `failed_login_count` int(11) unsigned default '0',
  `last_request_at` datetime default NULL,
  `current_login_at` datetime default NULL,
  `last_login_at` datetime default NULL,
  `current_login_ip` varchar(128) default NULL,
  `last_login_ip` varchar(128) default NULL,
  `active_token_id` int(11) unsigned default NULL,
  `version_id` int(11) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `created_by` bigint(20) unsigned default NULL,
  `updated_by` bigint(20) unsigned default NULL,
  `record_status` tinyint(2) unsigned NOT NULL COMMENT 'Status of record, 0-Delete, 1-Active',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `member_email_UNIQUE` (`email`),
  UNIQUE KEY `member_login_UNIQUE` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- each login session for tracking purposes

DROP TABLE IF EXISTS `member_session`;
CREATE TABLE IF NOT EXISTS `member_session` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `member_id` bigint(20) unsigned NOT NULL,
  `session_id` varchar(1024) NOT NULL,
  `session_create_time` datetime NOT NULL,
  `session_ip` bigint(20) unsigned default NULL,
  `version_id` int(11) unsigned NOT NULL,
  `created_by` bigint(20) unsigned default NULL,
  `updated_by` bigint(20) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

DROP TABLE IF EXISTS `reference_question`;
CREATE TABLE IF NOT EXISTS `reference_question` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `secret_question` varchar(256) collate utf8_unicode_ci default NULL,
  `created_at` datetime default NULL,
  `updated_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `version_id` int(11) unsigned NOT NULL,
  `created_by` bigint(20) unsigned default NULL,
  `updated_by` bigint(20) unsigned default NULL,
  `record_status` tinyint(2) unsigned default NULL COMMENT 'Status of record, 0-Delete, 1-Active',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `report_spam`;
CREATE TABLE IF NOT EXISTS `report_spam` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `reason_id` bigint(20) unsigned NOT NULL COMMENT 'This would contain the product_id, member_id, feedback_id, question_id or answer_id ',
  `reason_type` tinyint(2) unsigned NOT NULL COMMENT 'type of reason id',
  `reason_text` varchar(255) NOT NULL,
  `version_id` int(11) unsigned NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL COMMENT 'originally reportedby',
  `updated_by` bigint(20) unsigned NOT NULL COMMENT 'latest reportedby',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `record_status` tinyint(2) unsigned default NULL COMMENT 'Status of record, 0-Delete, 1-Active',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `public_id` varchar(256) collate utf8_unicode_ci default NULL COMMENT 'public id exposed publicly',
  `tag_name` varchar(256) collate utf8_unicode_ci default NULL,
  `description` varchar(256) collate utf8_unicode_ci default NULL,
  `image_id` bigint(20) unsigned default NULL COMMENT 'Popular image for tag',
  `created_at` datetime default NULL,
  `updated_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `version_id` int(11) unsigned NOT NULL,
  `created_by` bigint(20) unsigned default NULL,
  `updated_by` bigint(20) unsigned default NULL,
  `record_status` tinyint(2) unsigned default NULL COMMENT 'Status of record, 0-Delete, 1-Active, 9-Spam',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Table structure for table `product`
--
DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `public_id` varchar(256) collate utf8_unicode_ci default NULL COMMENT 'public id exposed publicly',
  `image_id` bigint(20) unsigned default NULL,
  `title` varchar(256) collate utf8_unicode_ci default NULL,
  `description` varchar(516) collate utf8_unicode_ci default NULL,
  `created_at` datetime default NULL,
  `updated_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `created_by` bigint(20) unsigned default NULL COMMENT 'member_id',
  `updated_by` bigint(20) unsigned default NULL,
  `record_status` tinyint(2) unsigned default NULL COMMENT 'Status of record, 0-Delete, 1-Active',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `product_info`;
CREATE TABLE IF NOT EXISTS `product_info` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `product_id` bigint(20) unsigned NOT NULL COMMENT 'product_id exposed publicly',
  `product_cost` varchar(516) collate utf8_unicode_ci default NULL,
  `product_url`  varchar(516) collate utf8_unicode_ci default NULL,
  `product_metatext` varchar(255) collate utf8_unicode_ci default NULL,
  `created_at` datetime default NULL,
  `updated_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `created_by` bigint(20) unsigned default NULL,
  `updated_by` bigint(20) unsigned default NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------



DROP TABLE IF EXISTS `product_tag`;
CREATE TABLE IF NOT EXISTS `source_tag` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `tag_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime default NULL,
  `updated_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `created_by` bigint(20) unsigned default NULL,
  `updated_by` bigint(20) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `product_follow` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `member_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime default NULL,
  `follow_status` tinyint(2) unsigned default NULL COMMENT 'Follow status of record, 0-not following, 1-following',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


--
-- Table structure for table `compare`
--

CREATE TABLE IF NOT EXISTS `compare_products` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `original_product_id` bigint(20) unsigned NOT NULL,
  `compared_product_id` bigint(20) unsigned NOT NULL,
  `compare_name` varchar(100) NOT NULL,
  `member_id` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `created_at` datetime default NULL,
  `compare_id` bigint(20) unsigned NULL,
  `comparision_status` tinyint(2) unsigned default NULL COMMENT 'comparision status of record, 0-comparision done, 1-Active Comparision',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `product_feedback` (
  `feedback_id` bigint(20) unsigned NOT NULL auto_increment,
  `category` varchar(100) NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `comment` varchar(256) NULL,
  `descriptive_comment` varchar(1000) NULL,
  `total_likes` int(11) NOT NULL DEFAULT '0',
  `total_unlikes` int(11) NOT NULL DEFAULT '0',
  `type` varchar(5) NOT NULL,
  `date` datetime NOT NULL,
  `member_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`feedback_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `question_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `member_id` bigint(20) unsigned NOT NULL,
  `question_text` varchar(516) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `answers_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `member_id` bigint(20) unsigned NOT NULL,
  `answer` varchar(1000) NOT NULL,
  `total_likes` int(11) unsigned default '0' COMMENT 'Total number of likes to answers',
  `total_unlikes` int(11) unsigned default '0' COMMENT 'Total number of unlikes to answers',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`answers_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `comment_answers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `answer_id` bigint(20) unsigned NOT NULL,
  `member_id` bigint(20) unsigned NOT NULL,
  `comment` varchar(1000) NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `member_activity` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) unsigned NOT NULL,
  `type` varchar(100) NOT NULL,
  `comment` mediumtext NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `product_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) unsigned NOT NULL,
  `other_member_id` bigint(20) unsigned NOT NULL,
  `other_member_username` varchar(100) NOT NULL,
  `notification_text` varchar(1000) NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `type` tinyint(2) NOT NULL COMMENT 'indicates type of notification like product, message etc',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- -----------------------------------------------------
-- Table `pinplanet`.`profile_view`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `view_details` ;

CREATE  TABLE IF NOT EXISTS `view_details` (
  `id` BIGINT(20) UNSIGNED NOT NULL ,
  `member_id` BIGINT(20) UNSIGNED NULL ,
  `viewed_member_id` BIGINT(20) NULL ,
  `viewed_product_id` BIGINT(20) NULL ,
  `searched_product_id` BIGINT(20) NULL ,
  `created_at` DATETIME NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `message` ;

CREATE  TABLE IF NOT EXISTS `message` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `message_type` TINYINT(2) UNSIGNED NOT NULL COMMENT 'Source type: image_source or external_source, product_source or internal_source or source_comment or magazine or shared source' ,
  `from_member_id` BIGINT(20) UNSIGNED NOT NULL ,
  `subject` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL ,
  `to_member_id` BIGINT(20) UNSIGNED NOT NULL COMMENT 'Anonymous' ,
  `created_at` DATETIME NULL ,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `created_by` BIGINT(20) UNSIGNED NULL ,
  `updated_by` BIGINT(20) UNSIGNED NULL ,
  `record_status` TINYINT(2) UNSIGNED NULL COMMENT 'Status of record, 0-Delete, 1-Active' ,
  `message_id` BIGINT UNSIGNED NOT NULL COMMENT 'message_id is foreign key in message_details table' ,
  `read_status` TINYINT(2) UNSIGNED NULL ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `message_details` ;

CREATE  TABLE IF NOT EXISTS `message_details` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `body` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL ,
  `created_at` DATETIME NULL ,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `version_id` INT(11) UNSIGNED NOT NULL ,
  `created_by` BIGINT(20) UNSIGNED NULL ,
  `updated_by` BIGINT(20) UNSIGNED NULL DEFAULT NULL ,
  `record_status` TINYINT(2) UNSIGNED NULL DEFAULT NULL COMMENT 'Status of record, 0-Delete, 1-Active' ,
  `message_details_id` BIGINT(20) UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- --------------------------------------------------------

DROP TABLE IF EXISTS `point`;
CREATE TABLE IF NOT EXISTS `point` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `point_type` tinyint(2) NOT NULL collate utf8_unicode_ci,
  `point_reason` varchar(516) collate utf8_unicode_ci default NULL,
  `point_value` int(11) default NULL,
  `total_points` int(11) default NULL,
  `member_id` bigint(20) unsigned default NULL,
  `created_at` datetime default NULL,
  `created_by` bigint(20) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--

-- --------------------------------------------------------