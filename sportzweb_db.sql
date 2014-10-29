-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 10, 2013 at 06:48 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.1
-- DROP DATABASE IF EXISTS sportzweb_db;
-- CREATE DATABASE sportzweb_db;
-- USE sportzweb_db;

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `troothing_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'businessman', 'Businessman'),
(3, 'members', 'General User'),
(4, 'publisher', 'Publisher');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `login_attempts`
--


-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `account_status` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6;   
INSERT INTO `account_status` (`id`, `description`) VALUES
(1, 'Active'),
(2, 'Inactive'),
(3, 'Suspended'),
(4, 'Deactivated'),
(5, 'Blocked');
-- -----------------------------------------------------------
--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `last_activity` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `account_status_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_laccount_status1` FOREIGN KEY (`account_status_id`) REFERENCES `account_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `last_activity`, `active`, `first_name`, `last_name`, `middle_name`, `company`, `phone`, `account_status_id`) VALUES
(1, '\0\0', 'administrator', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1373438882, NULL, NULL, 'Admin', 'istrator', NULL, 'ADMIN', '0', 1),
(2, '\0\0', 'alamgir', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'alamgir@apurbatech.com', '', NULL, NULL, NULL, 1268889823, 1392492477, 1392492508, NULL, 'Alamgir', 'Kabir', NULL, 'MEMBER', '0', 1),
(3, '^\0Å ', 'shem haye', '0bab98d35f9c6f04faf2a1c138d0fbaec6586365', '9462e8eee0', 'shem.haye@hotmail.co.uk', '', NULL, NULL, NULL, 1390432470, 1392234941, 1392234943, NULL, 'Shem', 'Haye', NULL, '', '', 1),
(4, '\0\0', 'nazmulhasan', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'bdlions@gmail.com', '', NULL, NULL, NULL, 1268889823, 1373438882, NULL, NULL, 'Nazmul', 'Hasan', NULL, 'MEMBER', '0', 1),
(5, '´”Òæ', 'naz hasan', '3ba317bdfb5b9c086bbf763168c576ad772d47ca', NULL, 'nazmul@csebuet.org', NULL, NULL, NULL, NULL, 1392232350, 1392234925, 1392238353, NULL, 'Naz2', 'Hasan2', NULL, NULL, NULL, 1),
(6, '^Î', 'ted mogul', 'f8501ff2d33ecd41ac88612c70aa310f307779ba', NULL, 'shem@webalactic.com', NULL, NULL, NULL, NULL, 1392232364, 1392232364, 1392249772, NULL, 'Ted', 'Mogul', NULL, NULL, NULL, 1),
(7, '^Î', 'ted mogul1', '66d6a5d150a5389c33735f0317c83c60c71122d7', NULL, 'ted.mogul69@gmail.com', '764836c03fd60c7e9304dc2a10b86d39dd60d078', NULL, NULL, NULL, 1392232479, 1392232479, NULL, NULL, 'Ted', 'Mogul2', NULL, NULL, NULL, 2),
(15, 'z\nù', 'nazmul hasan', 'e1e779efb868e6294efa2f8f67ccb745458a31bb', NULL, 'bdlions@hotmail.com', 'f3d8845d62309c49b28d750bdd3b6ad73a58ae0c', NULL, NULL, NULL, 1392372961, 1392372961, NULL, NULL, 'Nazmul3', 'Has3', NULL, NULL, NULL, 2);


-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 3),
(4, 3, 3),
(5, 4, 2),
(6, 4, 3);

CREATE TABLE IF NOT EXISTS `users_access` (
  `user_id` int(11) unsigned NOT NULL,
  `access_level` text DEFAULT '',
  PRIMARY KEY (`user_id`),
  KEY `fk_users_access_users1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_access`
  ADD CONSTRAINT `fk_users_access_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Table structure for table `gender`
--

CREATE TABLE IF NOT EXISTS `gender` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gender_code` char NOT NULL,
  `gender_name` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`id`, `gender_code`, `gender_name`) VALUES
(1, 'M', "Male"),
(2, 'F', "Female");


CREATE TABLE `countries` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`country_code` varchar(2) NOT NULL default '',
`country_name` varchar(100) NOT NULL default '',
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=240 ;
-- 
-- Dumping data for table `countries`
-- 
INSERT INTO `countries` VALUES (1, 'US', 'United States');
INSERT INTO `countries` VALUES (2, 'CA', 'Canada');
INSERT INTO `countries` VALUES (3, 'AF', 'Afghanistan');
INSERT INTO `countries` VALUES (4, 'AL', 'Albania');
INSERT INTO `countries` VALUES (5, 'DZ', 'Algeria');
INSERT INTO `countries` VALUES (6, 'DS', 'American Samoa');
INSERT INTO `countries` VALUES (7, 'AD', 'Andorra');
INSERT INTO `countries` VALUES (8, 'AO', 'Angola');
INSERT INTO `countries` VALUES (9, 'AI', 'Anguilla');
INSERT INTO `countries` VALUES (10, 'AQ', 'Antarctica');
INSERT INTO `countries` VALUES (11, 'AG', 'Antigua and/or Barbuda');
INSERT INTO `countries` VALUES (12, 'AR', 'Argentina');
INSERT INTO `countries` VALUES (13, 'AM', 'Armenia');
INSERT INTO `countries` VALUES (14, 'AW', 'Aruba');
INSERT INTO `countries` VALUES (15, 'AU', 'Australia');
INSERT INTO `countries` VALUES (16, 'AT', 'Austria');
INSERT INTO `countries` VALUES (17, 'AZ', 'Azerbaijan');
INSERT INTO `countries` VALUES (18, 'BS', 'Bahamas');
INSERT INTO `countries` VALUES (19, 'BH', 'Bahrain');
INSERT INTO `countries` VALUES (20, 'BD', 'Bangladesh');
INSERT INTO `countries` VALUES (21, 'BB', 'Barbados');
INSERT INTO `countries` VALUES (22, 'BY', 'Belarus');
INSERT INTO `countries` VALUES (23, 'BE', 'Belgium');
INSERT INTO `countries` VALUES (24, 'BZ', 'Belize');
INSERT INTO `countries` VALUES (25, 'BJ', 'Benin');
INSERT INTO `countries` VALUES (26, 'BM', 'Bermuda');
INSERT INTO `countries` VALUES (27, 'BT', 'Bhutan');
INSERT INTO `countries` VALUES (28, 'BO', 'Bolivia');
INSERT INTO `countries` VALUES (29, 'BA', 'Bosnia and Herzegovina');
INSERT INTO `countries` VALUES (30, 'BW', 'Botswana');
INSERT INTO `countries` VALUES (31, 'BV', 'Bouvet Island');
INSERT INTO `countries` VALUES (32, 'BR', 'Brazil');
INSERT INTO `countries` VALUES (33, 'IO', 'British lndian Ocean Territory');
INSERT INTO `countries` VALUES (34, 'BN', 'Brunei Darussalam');
INSERT INTO `countries` VALUES (35, 'BG', 'Bulgaria');
INSERT INTO `countries` VALUES (36, 'BF', 'Burkina Faso');
INSERT INTO `countries` VALUES (37, 'BI', 'Burundi');
INSERT INTO `countries` VALUES (38, 'KH', 'Cambodia');
INSERT INTO `countries` VALUES (39, 'CM', 'Cameroon');
INSERT INTO `countries` VALUES (40, 'CV', 'Cape Verde');
INSERT INTO `countries` VALUES (41, 'KY', 'Cayman Islands');
INSERT INTO `countries` VALUES (42, 'CF', 'Central African Republic');
INSERT INTO `countries` VALUES (43, 'TD', 'Chad');
INSERT INTO `countries` VALUES (44, 'CL', 'Chile');
INSERT INTO `countries` VALUES (45, 'CN', 'China');
INSERT INTO `countries` VALUES (46, 'CX', 'Christmas Island');
INSERT INTO `countries` VALUES (47, 'CC', 'Cocos (Keeling) Islands');
INSERT INTO `countries` VALUES (48, 'CO', 'Colombia');
INSERT INTO `countries` VALUES (49, 'KM', 'Comoros');
INSERT INTO `countries` VALUES (50, 'CG', 'Congo');
INSERT INTO `countries` VALUES (51, 'CK', 'Cook Islands');
INSERT INTO `countries` VALUES (52, 'CR', 'Costa Rica');
INSERT INTO `countries` VALUES (53, 'HR', 'Croatia (Hrvatska)');
INSERT INTO `countries` VALUES (54, 'CU', 'Cuba');
INSERT INTO `countries` VALUES (55, 'CY', 'Cyprus');
INSERT INTO `countries` VALUES (56, 'CZ', 'Czech Republic');
INSERT INTO `countries` VALUES (57, 'DK', 'Denmark');
INSERT INTO `countries` VALUES (58, 'DJ', 'Djibouti');
INSERT INTO `countries` VALUES (59, 'DM', 'Dominica');
INSERT INTO `countries` VALUES (60, 'DO', 'Dominican Republic');
INSERT INTO `countries` VALUES (61, 'TP', 'East Timor');
INSERT INTO `countries` VALUES (62, 'EC', 'Ecudaor');
INSERT INTO `countries` VALUES (63, 'EG', 'Egypt');
INSERT INTO `countries` VALUES (64, 'SV', 'El Salvador');
INSERT INTO `countries` VALUES (65, 'GQ', 'Equatorial Guinea');
INSERT INTO `countries` VALUES (66, 'ER', 'Eritrea');
INSERT INTO `countries` VALUES (67, 'EE', 'Estonia');
INSERT INTO `countries` VALUES (68, 'ET', 'Ethiopia');
INSERT INTO `countries` VALUES (69, 'FK', 'Falkland Islands (Malvinas)');
INSERT INTO `countries` VALUES (70, 'FO', 'Faroe Islands');
INSERT INTO `countries` VALUES (71, 'FJ', 'Fiji');
INSERT INTO `countries` VALUES (72, 'FI', 'Finland');
INSERT INTO `countries` VALUES (73, 'FR', 'France');
INSERT INTO `countries` VALUES (74, 'FX', 'France, Metropolitan');
INSERT INTO `countries` VALUES (75, 'GF', 'French Guiana');
INSERT INTO `countries` VALUES (76, 'PF', 'French Polynesia');
INSERT INTO `countries` VALUES (77, 'TF', 'French Southern Territories');
INSERT INTO `countries` VALUES (78, 'GA', 'Gabon');
INSERT INTO `countries` VALUES (79, 'GM', 'Gambia');
INSERT INTO `countries` VALUES (80, 'GE', 'Georgia');
INSERT INTO `countries` VALUES (81, 'DE', 'Germany');
INSERT INTO `countries` VALUES (82, 'GH', 'Ghana');
INSERT INTO `countries` VALUES (83, 'GI', 'Gibraltar');
INSERT INTO `countries` VALUES (84, 'GR', 'Greece');
INSERT INTO `countries` VALUES (85, 'GL', 'Greenland');
INSERT INTO `countries` VALUES (86, 'GD', 'Grenada');
INSERT INTO `countries` VALUES (87, 'GP', 'Guadeloupe');
INSERT INTO `countries` VALUES (88, 'GU', 'Guam');
INSERT INTO `countries` VALUES (89, 'GT', 'Guatemala');
INSERT INTO `countries` VALUES (90, 'GN', 'Guinea');
INSERT INTO `countries` VALUES (91, 'GW', 'Guinea-Bissau');
INSERT INTO `countries` VALUES (92, 'GY', 'Guyana');
INSERT INTO `countries` VALUES (93, 'HT', 'Haiti');
INSERT INTO `countries` VALUES (94, 'HM', 'Heard and Mc Donald Islands');
INSERT INTO `countries` VALUES (95, 'HN', 'Honduras');
INSERT INTO `countries` VALUES (96, 'HK', 'Hong Kong');
INSERT INTO `countries` VALUES (97, 'HU', 'Hungary');
INSERT INTO `countries` VALUES (98, 'IS', 'Iceland');
INSERT INTO `countries` VALUES (99, 'IN', 'India');
INSERT INTO `countries` VALUES (100, 'ID', 'Indonesia');
INSERT INTO `countries` VALUES (101, 'IR', 'Iran (Islamic Republic of)');
INSERT INTO `countries` VALUES (102, 'IQ', 'Iraq');
INSERT INTO `countries` VALUES (103, 'IE', 'Ireland');
INSERT INTO `countries` VALUES (104, 'IL', 'Israel');
INSERT INTO `countries` VALUES (105, 'IT', 'Italy');
INSERT INTO `countries` VALUES (106, 'CI', 'Ivory Coast');
INSERT INTO `countries` VALUES (107, 'JM', 'Jamaica');
INSERT INTO `countries` VALUES (108, 'JP', 'Japan');
INSERT INTO `countries` VALUES (109, 'JO', 'Jordan');
INSERT INTO `countries` VALUES (110, 'KZ', 'Kazakhstan');
INSERT INTO `countries` VALUES (111, 'KE', 'Kenya');
INSERT INTO `countries` VALUES (112, 'KI', 'Kiribati');
INSERT INTO `countries` VALUES (113, 'KP', 'Korea, Democratic People''s Republic of');
INSERT INTO `countries` VALUES (114, 'KR', 'Korea, Republic of');
INSERT INTO `countries` VALUES (115, 'KW', 'Kuwait');
INSERT INTO `countries` VALUES (116, 'KG', 'Kyrgyzstan');
INSERT INTO `countries` VALUES (117, 'LA', 'Lao People''s Democratic Republic');
INSERT INTO `countries` VALUES (118, 'LV', 'Latvia');
INSERT INTO `countries` VALUES (119, 'LB', 'Lebanon');
INSERT INTO `countries` VALUES (120, 'LS', 'Lesotho');
INSERT INTO `countries` VALUES (121, 'LR', 'Liberia');
INSERT INTO `countries` VALUES (122, 'LY', 'Libyan Arab Jamahiriya');
INSERT INTO `countries` VALUES (123, 'LI', 'Liechtenstein');
INSERT INTO `countries` VALUES (124, 'LT', 'Lithuania');
INSERT INTO `countries` VALUES (125, 'LU', 'Luxembourg');
INSERT INTO `countries` VALUES (126, 'MO', 'Macau');
INSERT INTO `countries` VALUES (127, 'MK', 'Macedonia');
INSERT INTO `countries` VALUES (128, 'MG', 'Madagascar');
INSERT INTO `countries` VALUES (129, 'MW', 'Malawi');
INSERT INTO `countries` VALUES (130, 'MY', 'Malaysia');
INSERT INTO `countries` VALUES (131, 'MV', 'Maldives');
INSERT INTO `countries` VALUES (132, 'ML', 'Mali');
INSERT INTO `countries` VALUES (133, 'MT', 'Malta');
INSERT INTO `countries` VALUES (134, 'MH', 'Marshall Islands');
INSERT INTO `countries` VALUES (135, 'MQ', 'Martinique');
INSERT INTO `countries` VALUES (136, 'MR', 'Mauritania');
INSERT INTO `countries` VALUES (137, 'MU', 'Mauritius');
INSERT INTO `countries` VALUES (138, 'TY', 'Mayotte');
INSERT INTO `countries` VALUES (139, 'MX', 'Mexico');
INSERT INTO `countries` VALUES (140, 'FM', 'Micronesia, Federated States of');
INSERT INTO `countries` VALUES (141, 'MD', 'Moldova, Republic of');
INSERT INTO `countries` VALUES (142, 'MC', 'Monaco');
INSERT INTO `countries` VALUES (143, 'MN', 'Mongolia');
INSERT INTO `countries` VALUES (144, 'MS', 'Montserrat');
INSERT INTO `countries` VALUES (145, 'MA', 'Morocco');
INSERT INTO `countries` VALUES (146, 'MZ', 'Mozambique');
INSERT INTO `countries` VALUES (147, 'MM', 'Myanmar');
INSERT INTO `countries` VALUES (148, 'NA', 'Namibia');
INSERT INTO `countries` VALUES (149, 'NR', 'Nauru');
INSERT INTO `countries` VALUES (150, 'NP', 'Nepal');
INSERT INTO `countries` VALUES (151, 'NL', 'Netherlands');
INSERT INTO `countries` VALUES (152, 'AN', 'Netherlands Antilles');
INSERT INTO `countries` VALUES (153, 'NC', 'New Caledonia');
INSERT INTO `countries` VALUES (154, 'NZ', 'New Zealand');
INSERT INTO `countries` VALUES (155, 'NI', 'Nicaragua');
INSERT INTO `countries` VALUES (156, 'NE', 'Niger');
INSERT INTO `countries` VALUES (157, 'NG', 'Nigeria');
INSERT INTO `countries` VALUES (158, 'NU', 'Niue');
INSERT INTO `countries` VALUES (159, 'NF', 'Norfork Island');
INSERT INTO `countries` VALUES (160, 'MP', 'Northern Mariana Islands');
INSERT INTO `countries` VALUES (161, 'NO', 'Norway');
INSERT INTO `countries` VALUES (162, 'OM', 'Oman');
INSERT INTO `countries` VALUES (163, 'PK', 'Pakistan');
INSERT INTO `countries` VALUES (164, 'PW', 'Palau');
INSERT INTO `countries` VALUES (165, 'PA', 'Panama');
INSERT INTO `countries` VALUES (166, 'PG', 'Papua New Guinea');
INSERT INTO `countries` VALUES (167, 'PY', 'Paraguay');
INSERT INTO `countries` VALUES (168, 'PE', 'Peru');
INSERT INTO `countries` VALUES (169, 'PH', 'Philippines');
INSERT INTO `countries` VALUES (170, 'PN', 'Pitcairn');
INSERT INTO `countries` VALUES (171, 'PL', 'Poland');
INSERT INTO `countries` VALUES (172, 'PT', 'Portugal');
INSERT INTO `countries` VALUES (173, 'PR', 'Puerto Rico');
INSERT INTO `countries` VALUES (174, 'QA', 'Qatar');
INSERT INTO `countries` VALUES (175, 'RE', 'Reunion');
INSERT INTO `countries` VALUES (176, 'RO', 'Romania');
INSERT INTO `countries` VALUES (177, 'RU', 'Russian Federation');
INSERT INTO `countries` VALUES (178, 'RW', 'Rwanda');
INSERT INTO `countries` VALUES (179, 'KN', 'Saint Kitts and Nevis');
INSERT INTO `countries` VALUES (180, 'LC', 'Saint Lucia');
INSERT INTO `countries` VALUES (181, 'VC', 'Saint Vincent and the Grenadines');
INSERT INTO `countries` VALUES (182, 'WS', 'Samoa');
INSERT INTO `countries` VALUES (183, 'SM', 'San Marino');
INSERT INTO `countries` VALUES (184, 'ST', 'Sao Tome and Principe');
INSERT INTO `countries` VALUES (185, 'SA', 'Saudi Arabia');
INSERT INTO `countries` VALUES (186, 'SN', 'Senegal');
INSERT INTO `countries` VALUES (187, 'SC', 'Seychelles');
INSERT INTO `countries` VALUES (188, 'SL', 'Sierra Leone');
INSERT INTO `countries` VALUES (189, 'SG', 'Singapore');
INSERT INTO `countries` VALUES (190, 'SK', 'Slovakia');
INSERT INTO `countries` VALUES (191, 'SI', 'Slovenia');
INSERT INTO `countries` VALUES (192, 'SB', 'Solomon Islands');
INSERT INTO `countries` VALUES (193, 'SO', 'Somalia');
INSERT INTO `countries` VALUES (194, 'ZA', 'South Africa');
INSERT INTO `countries` VALUES (195, 'GS', 'South Georgia South Sandwich Islands');
INSERT INTO `countries` VALUES (196, 'ES', 'Spain');
INSERT INTO `countries` VALUES (197, 'LK', 'Sri Lanka');
INSERT INTO `countries` VALUES (198, 'SH', 'St. Helena');
INSERT INTO `countries` VALUES (199, 'PM', 'St. Pierre and Miquelon');
INSERT INTO `countries` VALUES (200, 'SD', 'Sudan');
INSERT INTO `countries` VALUES (201, 'SR', 'Suriname');
INSERT INTO `countries` VALUES (202, 'SJ', 'Svalbarn and Jan Mayen Islands');
INSERT INTO `countries` VALUES (203, 'SZ', 'Swaziland');
INSERT INTO `countries` VALUES (204, 'SE', 'Sweden');
INSERT INTO `countries` VALUES (205, 'CH', 'Switzerland');
INSERT INTO `countries` VALUES (206, 'SY', 'Syrian Arab Republic');
INSERT INTO `countries` VALUES (207, 'TW', 'Taiwan');
INSERT INTO `countries` VALUES (208, 'TJ', 'Tajikistan');
INSERT INTO `countries` VALUES (209, 'TZ', 'Tanzania, United Republic of');
INSERT INTO `countries` VALUES (210, 'TH', 'Thailand');
INSERT INTO `countries` VALUES (211, 'TG', 'Togo');
INSERT INTO `countries` VALUES (212, 'TK', 'Tokelau');
INSERT INTO `countries` VALUES (213, 'TO', 'Tonga');
INSERT INTO `countries` VALUES (214, 'TT', 'Trinidad and Tobago');
INSERT INTO `countries` VALUES (215, 'TN', 'Tunisia');
INSERT INTO `countries` VALUES (216, 'TR', 'Turkey');
INSERT INTO `countries` VALUES (217, 'TM', 'Turkmenistan');
INSERT INTO `countries` VALUES (218, 'TC', 'Turks and Caicos Islands');
INSERT INTO `countries` VALUES (219, 'TV', 'Tuvalu');
INSERT INTO `countries` VALUES (220, 'UG', 'Uganda');
INSERT INTO `countries` VALUES (221, 'UA', 'Ukraine');
INSERT INTO `countries` VALUES (222, 'AE', 'United Arab Emirates');
INSERT INTO `countries` VALUES (223, 'GB', 'United Kingdom');
INSERT INTO `countries` VALUES (224, 'UM', 'United States minor outlying islands');
INSERT INTO `countries` VALUES (225, 'UY', 'Uruguay');
INSERT INTO `countries` VALUES (226, 'UZ', 'Uzbekistan');
INSERT INTO `countries` VALUES (227, 'VU', 'Vanuatu');
INSERT INTO `countries` VALUES (228, 'VA', 'Vatican City State');
INSERT INTO `countries` VALUES (229, 'VE', 'Venezuela');
INSERT INTO `countries` VALUES (230, 'VN', 'Vietnam');
INSERT INTO `countries` VALUES (231, 'VG', 'Virigan Islands (British)');
INSERT INTO `countries` VALUES (232, 'VI', 'Virgin Islands (U.S.)');
INSERT INTO `countries` VALUES (233, 'WF', 'Wallis and Futuna Islands');
INSERT INTO `countries` VALUES (234, 'EH', 'Western Sahara');
INSERT INTO `countries` VALUES (235, 'YE', 'Yemen');
INSERT INTO `countries` VALUES (236, 'YU', 'Yugoslavia');
INSERT INTO `countries` VALUES (237, 'ZR', 'Zaire');
INSERT INTO `countries` VALUES (238, 'ZM', 'Zambia');
INSERT INTO `countries` VALUES (239, 'ZW', 'Zimbabwe');

--
-- Table structure for table `basic_profile`
--

CREATE TABLE IF NOT EXISTS `basic_profile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `clg_or_uni` varchar(30),
  `employer` varchar(20),
  `gender_id` int(11) unsigned,
  `dob` datetime,
  `country_id` int(11) unsigned,
  `photo` varchar(100),
  `fav_team` varchar(30),
  `fav_player` varchar(30),
  `occupation` varchar(30),
  `street_name` varchar(30),
  `home_town` varchar(30),
  `address` varchar(300),
  `post_code` varchar(30),
  `telephone` varchar(30),
  `special_interests` text,
  `about_me` text,
  `skype_name` varchar(50),
  `facebook_name` varchar(50),
  `linkedin_name` varchar(50),
  `twitter_name` varchar(50),
  `application_list` text default '',
  PRIMARY KEY (`id`),
  UNIQUE KEY(`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
--
-- Constraints for table `basic_profile`
--
ALTER TABLE `basic_profile`
  ADD CONSTRAINT `fk_basic_profile_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_basic_profile_country` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_basic_profile_gender` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Dumping data for table `basic_profile`
--
INSERT INTO `basic_profile` (`id`, `user_id`, `clg_or_uni`, `employer`, `gender_id`, `dob`, `country_id`, `photo`, `fav_team`, `fav_player`, `occupation`, `street_name`, `home_town`, `address`, `post_code`, `telephone`, `special_interests`, `about_me`) VALUES
(1, 2, 'Jamalpur RM vidaypith', 'Apurbatech', 1, '2010-01-01 00:00:00', 1, 'Koala4.jpg', NULL, NULL, 'SW Engg', NULL, 'Dhaka', NULL, NULL, NULL, '[{"interest_id":"1","sub_interest_id":"1"},{"interest_id":"1","sub_interest_id":"2"},{"interest_id":"1","sub_interest_id":"3"},{"interest_id":"1","sub_interest_id":"4"},{"interest_id":"1","sub_interest_id":"5"},{"interest_id":"2","sub_interest_id":"3"},{"interest_id":"3","sub_interest_id":"1"},{"interest_id":"3","sub_interest_id":"2"},{"interest_id":"3","sub_interest_id":"3"}]', NULL),
(2, 3, '', '', 1, '1984-08-24 00:00:00', 223, 'London_eye.jpg', NULL, NULL, '', NULL, '', NULL, NULL, NULL, '[{"interest_id":"1","sub_interest_id":"1"},{"interest_id":"1","sub_interest_id":"2"},{"interest_id":"1","sub_interest_id":"4"},{"interest_id":"2","sub_interest_id":"1"},{"interest_id":"2","sub_interest_id":"2"},{"interest_id":"3","sub_interest_id":"1"},{"interest_id":"3","sub_interest_id":"2"}]', NULL),
(3, 4, '', '', 1, '1984-08-24 00:00:00', 223, 'London_eye.jpg', NULL, NULL, '', NULL, '', NULL, NULL, NULL, '[{"interest_id":"1","sub_interest_id":"1"},{"interest_id":"1","sub_interest_id":"2"},{"interest_id":"1","sub_interest_id":"4"},{"interest_id":"2","sub_interest_id":"1"},{"interest_id":"2","sub_interest_id":"2"},{"interest_id":"3","sub_interest_id":"1"},{"interest_id":"3","sub_interest_id":"2"}]', NULL),
(4, 5, 'univ', 'emp', 1, '1987-06-14 00:00:00', 20, 'small2.jpg', NULL, NULL, 'ocu', NULL, 'my town', NULL, NULL, NULL, '[{"interest_id":"2","sub_interest_id":"1"}]', NULL),
(5, 6, '', '', 1, '1984-08-24 00:00:00', 223, '254979_4275577722563_304196965_n.jpg', NULL, NULL, '', NULL, '', NULL, NULL, NULL, '[{"interest_id":"3","sub_interest_id":"1"}]', NULL),
(6, 1, 'Jamalpur RM vidaypith', 'Apurbatech', 1, '2010-01-01 00:00:00', 1, 'Koala4.jpg', NULL, NULL, 'SW Engg', NULL, 'Dhaka', NULL, NULL, NULL, '[{"interest_id":"1","sub_interest_id":"1"},{"interest_id":"1","sub_interest_id":"2"},{"interest_id":"1","sub_interest_id":"3"},{"interest_id":"1","sub_interest_id":"4"},{"interest_id":"1","sub_interest_id":"5"},{"interest_id":"2","sub_interest_id":"3"},{"interest_id":"3","sub_interest_id":"1"},{"interest_id":"3","sub_interest_id":"2"},{"interest_id":"3","sub_interest_id":"3"}]', NULL);

 CREATE TABLE IF NOT EXISTS `special_interests_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  `sub_category_list` text DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
 
INSERT INTO `special_interests_types` (`id`, `description`, `sub_category_list`) VALUES
(1, 'Fitness', '[{"id":1,"description":"Adventures"},{"id":2,"description":"Cardio"},{"id":3,"description":"Challenges"},{"id":4,"description":"Exercise"},{"id":5,"description":"Injuries"},{"id":6,"description":"Muscle"},{"id":7,"description":"Running"},{"id":8,"description":"Workouts"}]'),
(2, 'Health', '[{"id":1,"description":"Diets"},{"id":2,"description":"Disease and Disorders"},{"id":3,"description":"Food and Drink"},{"id":4,"description":"Inspiration"},{"id":5,"description":"Leisure"},{"id":6,"description":"Lifestyles"},{"id":7,"description":"Nutrition"},{"id":8,"description":"Pregnancy"},{"id":9,"description":"Recipes"},{"id":10,"description":"Sleep"},{"id":11,"description":"Social"},{"id":12,"description":"Stress"},{"id":13,"description":"Supplements"},{"id":14,"description":"Symptoms"},{"id":15,"description":"Treatments"},{"id":16,"description":"Weight Loss"},{"id":17,"description":"Wellbeing"}]'),
(3, 'Sports', '[{"id":1,"description":"Animal Sports"},{"id":2,"description":"Athletics"},{"id":3,"description":"Combat Sports"},{"id":4,"description":"Extreme Sports"},{"id":5,"description":"Gymnastics"},{"id":6,"description":"Motor Sports"},{"id":7,"description":"Racket Sports"},{"id":8,"description":"Sport on Wheels"},{"id":9,"description":"Target Sports"},{"id":10,"description":"Team Sports"},{"id":11,"description":"Water Sports"},{"id":12,"description":"Winter Sports"}]');

 CREATE TABLE IF NOT EXISTS `business_profile_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  `sub_type_list` text DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `business_profile_type` (`id`, `description`, `sub_type_list`) VALUES
(1, 'Brand and Product', '[{"id":1,"description":"Fashion or Clothing"}]'),
(2, 'Entertainment', '[{"id":1,"description":"Health"},{"id":2,"description":"Fitness"},{"id":3,"description":"Sports Magazine"}]'),
(3, 'Team, Group or Sports Figure', '[{"id":1,"description":"Athlete"}]'),
(4, 'Local Business or Place', '[{"id":1,"description":"Attraction"}]'),
(5, 'Organization, Company or Institution', '[{"id":1,"description":"Accessories"}]');


CREATE TABLE IF NOT EXISTS `business_profile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `business_profile_type` int(11) unsigned NOT NULL,
  `business_profile_sub_type` int(11) unsigned NOT NULL,
  `business_name` varchar(20) NOT NULL,
  `company_name` varchar(20) NOT NULL,
  `website_address` varchar(20) NOT NULL,
  `business_hour` varchar(20) NOT NULL,
  `business_description` text DEFAULT '',
  `logo` varchar(20) NOT NULL,
  `cover_photo` varchar(20) NOT NULL,
  `business_email` varchar(100) NOT NULL,
  `business_city` varchar(20) NOT NULL,
  `business_country` int(11) unsigned NOT NULL,
  `street_name` varchar(30),
  `address` varchar(300),
  `post_code` varchar(30),
  `latitude` varchar(300) DEFAULT 0,
  `longitude` varchar(300) DEFAULT 0,
  `telephone` varchar(30),
  `registered_company_number` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE `business_profile`
  ADD CONSTRAINT `fk_business_profile_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_business_profile_country` FOREIGN KEY (`business_country`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_business_profile_business_profile_type` FOREIGN KEY (`business_profile_type`) REFERENCES `business_profile_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  

--
-- Dumping data for table `business_profile`
--

INSERT INTO `business_profile` (`id`, `user_id`, `business_profile_type`, `business_profile_sub_type`, `business_name`, `company_name`, `website_address`, `business_hour`, `business_description`, `logo`, `cover_photo`, `business_email`, `business_city`, `business_country`, `street_name`, `address`, `post_code`, `telephone`, `registered_company_number`) VALUES
(1, 2, 1, 1, 'Webalactic', '', 'www.something.com', '12-4', 'Add your business description', 'Jellyfish.jpg', '', 'alamgir@apurbatehc.c', 'Rajshahi', 20, 'Road #5', 'Mohakhali DOHS, Dhaka', '1234', '01712341213', 10),
(2, 4, 1, 1, 'ap prof', '', 'www.something.com', '12-4', 'Add your business description', 'Jellyfish.jpg', '', 'alamgir@apurbatehc.c', 'Rajshahi', 20, 'Road #5', 'Mohakhali DOHS, Dhaka', '1234', '01712341213', 10),
(3, 6, 1, 1, 'Sonuto', '', '', '', 'Clothing supporting Health, Sports and Fitness', '2716_62975439193_915', 'Car_1.jpg', 'shem.haye@hotmail.co.uk', 'Chiswick', 223, '1 Seymour Road', '', 'W4 5ES', '07565533898', 0),
(4, 5, 1, 1, 'sky sports', '', 'www.website.com', '24 hours', 'sports', 'small2.jpg', 'Desert1.jpg', 'email@email.com', 'city', 20, 'street', 'address', '1207', 'tel', 0);

CREATE TABLE IF NOT EXISTS `business_profile_connection` (
  `business_profile_id` int(11) unsigned NOT NULL,
  `connected_user_list` text,  
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`business_profile_id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `business_profile_connection`
  ADD CONSTRAINT `fk_business_profile_connection_business_profile1` FOREIGN KEY (`business_profile_id`) REFERENCES `business_profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `security_question_types` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `security_question_types` (`id`, `description`) VALUES
(1, 'Question Type1'),
(2, 'Question Type2'),
(3, 'Question Type3');
CREATE TABLE IF NOT EXISTS `security_questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  `security_question_types_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `security_questions`
  ADD CONSTRAINT `fk_security_questions_security_question_types1` FOREIGN KEY (`security_question_types_id`) REFERENCES `security_question_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO `security_questions` (`id`, `description`, `security_question_types_id`) VALUES
(1, 'What was the name of your first pet?', 1),
(2, 'What is your favourite film?', 1),
(3, 'What was the make of your first car?', 1),
(4, 'What school did you attend for sixth grade?', 1),
(5, 'What was your childhood nickname?', 1),
(6, 'What is the name of the first school you attended?', 1),
(7, 'What is the name of your favorite childhood teacher?', 1),
(8, 'In what city or town did your mother and father meet?', 1),
(9, 'What is the name of the company of your first job?', 1),
(10, 'In what city or town did your mother and father meet?', 2),
(11, 'What is the name of the company of your first job?', 3);

CREATE TABLE IF NOT EXISTS `security_questions_answers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `security_question_id` int(11) unsigned NOT NULL,
  `answer` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `security_questions_answers`
  ADD CONSTRAINT `fk_security_questions_answers_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_security_questions_answers_security_questions1` FOREIGN KEY (`security_question_id`) REFERENCES `security_questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
INSERT INTO `security_questions_answers` (`id`, `user_id`, `security_question_id`, `answer`) VALUES
(1, 1, 1, 'snowy'),
(2, 1, 4, 'Avatar'),
(3, 1, 7, 'Honda'),
(4, 3, 1, 'chanel'),
(5, 3, 2, 'scarface'),
(6, 3, 3, 'polo');


CREATE TABLE IF NOT EXISTS `collaborator_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(40),
  `description` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `collaborator_types` (`id`, `type`, `description`) VALUES
(1, 'Followers', 'Can collaborate followers in a specific type activites'),
(2, 'Anyone', 'Can collaborate anyone in a specific activites'),
(3, 'Selected Groups', 'Can collaborate only selected group in a specific activites');

CREATE TABLE IF NOT EXISTS `notification_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(100),
  `description` varchar(150),
  `value` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


INSERT INTO `notification_types` (`id`, `type`, `description`, `value`) VALUES
(1, 'START_FOLLOWING', 'Requests or begins to follow you', 1),
(2, 'MENTIONS_POST', 'Mentions you in a post', 2),
(3, 'COMMENTS_ON_CREATED_POST', 'Comments on a post you created', 3),
(4, 'SHARES_CREATED_POST', 'Shares a post you have created', 4),
(5, 'ADDS_IN_GROUP', 'Adds you to a group', 5),
(6, 'SHARES_POST_IN_ASSOCIATED_WITH_GROUP', 'Shares a post in a group you are assocaited with', 6),
(7, 'PHOTO_TAG', 'Tags you in a photo', 7),
(8, 'COMMENTS_ON_ADDED_PHOTO', 'Comments on a photo you have added', 8);

CREATE TABLE IF NOT EXISTS `notification_media_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(10),
  `description` varchar(10),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `notification_media_types` (`id`, `type`, `description`) VALUES
(1, 'mobile', 'notified by cell phone'),
(2, 'email', 'notified by email address');

CREATE TABLE IF NOT EXISTS `collaborate_permission_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(100),
  `description` varchar(200),
  `default_collaborator_type` int(11) unsigned DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

ALTER TABLE `collaborate_permission_types`
  ADD CONSTRAINT `fk_collaborate_permission_types_collaborator_types` FOREIGN KEY (`default_collaborator_type`) REFERENCES `collaborator_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO `collaborate_permission_types` (`id`, `type`, `description`) VALUES
(1, 'VIEW_POST', 'who can see my post?'),
(2, 'COMMENT_ON_POST', 'who can comment on my post?'),
(3, 'POST_ON_PROFILE', 'who can post on my profile?'),
(4, 'CONTACT', 'who can contact with me?'),
(5, 'TAG_ME_IN_PHOTOS', 'who can tag me on photos?'),
(6, 'SEARCH_FOR_ME', 'who can search for me?'),
(7, 'FOLLOWING', 'accept followers');



CREATE TABLE IF NOT EXISTS `collaborate_permission` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `collaborate_permission_type` int(11) unsigned NOT NULL,
  `collaborator_type` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


ALTER TABLE `collaborate_permission`
  ADD CONSTRAINT `fk_collaborate_permission_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_collaborate_permission_collaborate_permission_type` FOREIGN KEY (`collaborate_permission_type`) REFERENCES `collaborate_permission_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_collaborate_permission_collaborator_types` FOREIGN KEY (`collaborator_type`) REFERENCES `collaborator_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
CREATE TABLE IF NOT EXISTS `users_notifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `notifications` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY(`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

ALTER TABLE `users_notifications`
  ADD CONSTRAINT `fk_users_notifications_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

  
-- follower module  
  
CREATE TABLE IF NOT EXISTS `following_acceptance_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) unsigned NOT NULL,
  `description` varchar(200) NOT NULL,
  `value` int(11) unsigned NOT NULL,
  `is_default_type` boolean,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `following_acceptance_types` (`id`, `type`, `description`, `value`, `is_default_type`) VALUES
(1, 'AUTOMATIC', 'Automatically', 1, true),
(2, 'MANUAL', 'After my confirmation', 2, false);

CREATE TABLE IF NOT EXISTS `user_mutual_relation_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) unsigned NOT NULL,
  `description` varchar(200) NOT NULL,
  `value` int(11) unsigned NOT NULL,
  `is_default_type` boolean,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `user_mutual_relation_types` (`id`, `type`, `description`, `value`, `is_default_type`) VALUES
(1, 'PENDING', 'when a user sends request', 1, true),
(2, 'FOLLOWER', 'when a user accepts request', 2, false),
(3, 'BLOCK', 'when a user blocks someone', 3, false),
(4, 'REPORT', 'when a user reports someone', 4, false);

CREATE TABLE IF NOT EXISTS `usres_following_acceptance` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `following_acceptance_type` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY(`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `usres_following_acceptance`
    ADD CONSTRAINT `fk_users_usres_following_acceptance1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_users_usres_following_acceptance2` FOREIGN KEY(`following_acceptance_type`) REFERENCES `following_acceptance_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


CREATE TABLE IF NOT EXISTS `usres_mutual_relations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `relations` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY(`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

ALTER TABLE `usres_mutual_relations`
    ADD CONSTRAINT `fk_users_usres_mutual_relations1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- follower report
CREATE TABLE IF NOT EXISTS `follower_report_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `follower_report_type` (`id`, `description`) VALUES
(1, 'Report shared content'),
(2, 'Report account');
CREATE TABLE IF NOT EXISTS `follower_report_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `report_type_id` int(11) unsigned NOT NULL,
  `created_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `follower_report_list`
    ADD CONSTRAINT `fk_follower_report_list_usres1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_follower_report_list_report_type1` FOREIGN KEY(`report_type_id`) REFERENCES `follower_report_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
	
CREATE TABLE IF NOT EXISTS `attachment_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50),
  `description` varchar(50),
  `order` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `attachment_types` (`id`, `type`, `description`, `order`) VALUES
(1, 'IMAGE', 'images', 1),
(2, 'AUDIO', 'audio files', 2),
(3, 'VIDEO', 'video files', 3),
(4, 'DOC', 'doc files', 4);

CREATE TABLE IF NOT EXISTS `status_place_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50),
  `description` varchar(50),
  `order` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `status_place_types` (`id`, `type`, `description`, `order`) VALUES
(1, 'BASIC_PROFILE', 'in basic profile', 1),
(2, 'BUSINESS_PROFILE', 'in business profile', 2),
(3, 'WALL', 'in user wall', 3);

CREATE TABLE IF NOT EXISTS `users_statuses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `status_in` int(11) unsigned DEFAULT NULL,
  `status_date` int(11) unsigned DEFAULT NULL,
  `update_date` int(11) unsigned DEFAULT NULL,
  `description` text,
  `feedbacks` text,
  `likes` text,
  `reference_list` text,
  `attachments` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

ALTER TABLE `users_statuses`
    ADD CONSTRAINT `fk_users_statuses` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_users_status_place_types` FOREIGN KEY(`status_in`) REFERENCES `status_place_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `status_share_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `status_share_types` (`id`, `description`) VALUES
(1, 'Own'),
(2, 'Follower'),
(3, 'Group');
	
CREATE TABLE IF NOT EXISTS `users_statuses_share` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shared_user_id` int(11) unsigned NOT NULL,  
  `reference_id` int(11) unsigned NOT NULL,
  `reference_type_id` int(11) unsigned NOT NULL,
  `status_in` int(11) unsigned DEFAULT NULL,
  `users_statuses_id` int(11) unsigned NOT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  `description` text,
  `likes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `users_statuses_share`
    ADD CONSTRAINT `fk_users_statuses_share_users1` FOREIGN KEY(`shared_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_users_statuses_share_status_share_types1` FOREIGN KEY(`reference_type_id`) REFERENCES `status_share_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_users_statuses_share_place_types1` FOREIGN KEY(`status_in`) REFERENCES `status_place_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_users_statuses_share_users_statuses1` FOREIGN KEY(`users_statuses_id`) REFERENCES `users_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `users_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `follower_id` int(11) unsigned NOT NULL,
  `status_in` int(11) unsigned DEFAULT NULL,
  `status_date` int(11) unsigned DEFAULT NULL,
  `update_date` int(11) unsigned DEFAULT NULL,
  `description` text,
  `feedbacks` text,
  `reference_list` text,
  `attachments` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
CREATE TABLE IF NOT EXISTS `users_comments_share` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `shared_user_id` int(11) unsigned NOT NULL,
  `status_in` int(11) unsigned DEFAULT NULL,
  `users_statuses_id` int(11) unsigned NOT NULL,
  `status_date` int(11) unsigned DEFAULT NULL,
  `update_date` int(11) unsigned DEFAULT NULL,
  `description` text,
  `feedbacks` text,
  `likes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `users_comments_share`
    ADD CONSTRAINT `fk_users_comments_share1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_users_comments_share2` FOREIGN KEY(`shared_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_users_comments_share_place_types` FOREIGN KEY(`status_in`) REFERENCES `status_place_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_users_comments_share_users_statuses` FOREIGN KEY(`users_statuses_id`) REFERENCES `users_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `users_comments`
    ADD CONSTRAINT `fk_users_users_comments` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_users_users_comments2` FOREIGN KEY(`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_users_status_place_types2` FOREIGN KEY(`status_in`) REFERENCES `status_place_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `users_messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `message` text,
  `from` int(11) unsigned DEFAULT NULL,
  `to` int(11) unsigned DEFAULT NULL,
  `received` boolean default FALSE,
  `send_date` int(11) unsigned DEFAULT NULL,
  `received_date` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `album_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `album_type` int(11) unsigned DEFAULT NULL,
  `description` varchar(200),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `album_types` (`id`, `album_type`, `description`) VALUES
(1, 'BUSINESS_PROFILE', 'in business profile'),
(2, 'BASIC_PROFILE', 'in basic profile');


CREATE TABLE IF NOT EXISTS `users_albums` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50),
  `user_id` int(11) unsigned DEFAULT NULL,
  `update_date` int(11) unsigned NOT NULL,
  `create_date` int(11) unsigned NOT NULL,
  `creation_complete` boolean DEFAULT FALSE,
  `type` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

ALTER TABLE `users_albums`
    ADD CONSTRAINT `fk_users_users_albums1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_album_types_users_albums2` FOREIGN KEY(`type`) REFERENCES `album_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `album_photos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `album_id` int(11) unsigned DEFAULT NULL,
  `description` varchar(200),
  `upload_date` int(11) unsigned,
  `photo` VARCHAR( 50 ) NOT NULL,
  `feedbacks` text,
  `likes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

ALTER TABLE `album_photos`
    ADD CONSTRAINT `fk_users_album_photos1` FOREIGN KEY(`album_id`) REFERENCES `users_albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `users_my_photos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `album_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

ALTER TABLE `users_my_photos`
    ADD CONSTRAINT `fk_users_users_my_photos1` FOREIGN KEY(`album_id`) REFERENCES `users_albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_users_users_my_photos2` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
	
CREATE TABLE IF NOT EXISTS `status_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(200),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `status_category` (`id`, `description`) VALUES
(1, 'user newsfeed'),
(2, 'user profile'),
(3, 'user business profile'),
(4, 'follower profile'),
(5, 'follower business profile');
CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `mapping_id` int(11) unsigned DEFAULT NULL,
  `status_type_id` int(11) unsigned DEFAULT 1,
  `status_category_id` int(11) unsigned NOT NULL,
  `description` text,
  `feedbacks` text,
  `likes` text,
  `reference_list` text,
  `attachments` text,
  `reference_id` int(11) unsigned DEFAULT NULL,
  `shared_type_id` int(11) unsigned DEFAULT NULL,
  `via_user_id` int(11) unsigned DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `statuses`
    ADD CONSTRAINT `fk_users_statuses1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_status_category_statuses1` FOREIGN KEY(`status_category_id`) REFERENCES `status_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

	
-- Applications --------------------
CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200),
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `applications` (`id`, `name`, `title`) VALUES
(1, 'xstream_banter', 'Xstream Banter'),
(2, 'healthy_recipes', 'Healthy Recipes'),
(3, 'service_directory', 'Service Directory'),
(4, 'news', 'News'),
(5, 'blogs', 'Blogs'),
(6, 'bmicalculator', 'BMI Calculator'),
(7, 'photography', 'Photography');

CREATE TABLE IF NOT EXISTS `application_directory` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(500),
  `description` varchar(500),
  `summary` text,
  `img1` varchar(500),
  `img2` varchar(500),
  `img_gallery` text,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `application_directory` (`id`, `title`) VALUES
(1, 'Xstream Banter'),
(2, 'Healthy Recipes'),
(3, 'Service Directory'),
(4, 'News'),
(5, 'Blogs'),
(6, 'BMI Calculator'),
(7, 'Photography'),
(8, 'Score Prediction');

-- modified xstream banter
CREATE TABLE IF NOT EXISTS `app_xb_sports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_xb_sports` (`id`, `title`) VALUES
(1, 'Football'),
(2, 'Baseball'),
(3, 'Formula 1'),
(4, 'Basketball'),
(5, 'Boxing'),
(6, 'Tennis'),
(7, 'Cricket'),
(8, 'Rugby');
CREATE TABLE IF NOT EXISTS `app_xb_teams` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `sports_id` int(11) unsigned NOT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_app_xb_teams_sports1_idx` (`sports_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_xb_teams`
    ADD CONSTRAINT `fk_app_xb_teams_sports1` FOREIGN KEY(`sports_id`) REFERENCES `app_xb_sports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `app_xb_teams` (`id`, `sports_id`, `title`) VALUES
(1, 1, 'Chelsea'),
(2, 1, 'Southampton'),
(3, 1, 'Aston Villa'),
(4, 1, 'Arsenal'),
(5, 1, 'Swansea'),
(6, 1, 'Man City'),
(7, 1, 'Leicester'),
(8, 1, 'West Ham'),
(9, 1, 'Tottenham'),
(10, 1, 'Hull');

CREATE TABLE IF NOT EXISTS `app_xb_tournaments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sports_id` int(11) unsigned NOT NULL,
  `title` varchar(200),
  `season` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_app_xb_tournaments` (`title`, `season`),
  KEY `fk_app_xb_tournaments_sports1_idx` (`sports_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_xb_tournaments`
    ADD CONSTRAINT `fk_app_xb_tournaments_sports1` FOREIGN KEY(`sports_id`) REFERENCES `app_xb_sports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `app_xb_tournaments` (`id`, `sports_id`, `title`, `season`) VALUES
(1, 1, 'Barclays premier league', '2014/15'),
(2, 1, 'Championship', '2014/15'),
(3, 1, 'League one', '2014/15');

CREATE TABLE IF NOT EXISTS `app_xb_matches` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tournament_id` int(11) unsigned NOT NULL,
  `team_id_home` int(11) unsigned NOT NULL,
  `team_id_away` int(11) unsigned NOT NULL,
  `date` varchar(200),
  `time` varchar(200),
  `score_home` varchar(200) default '',
  `score_away` varchar(200) default '',
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_app_xb_matches_tournaments1_idx` (`tournament_id`),
  KEY `fk_app_xb_matches_teams1_idx` (`team_id_home`),
  KEY `fk_app_xb_matches_teams2_idx` (`team_id_away`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_xb_matches`
    ADD CONSTRAINT `fk_app_xb_matches_tournaments1` FOREIGN KEY(`tournament_id`) REFERENCES `app_xb_tournaments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_app_xb_matches_teams1` FOREIGN KEY(`team_id_home`) REFERENCES `app_xb_teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_app_xb_matches_teams2` FOREIGN KEY(`team_id_away`) REFERENCES `app_xb_teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `app_xb_matches` (`id`, `tournament_id`, `team_id_home`, `team_id_away`, `date`, `time`) VALUES
(1, 1, 1, 2, '2014-06-17', '09:00'),
(2, 1, 3, 4, '2014-06-17', '11:00');
CREATE TABLE IF NOT EXISTS `app_xb_chat_rooms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_access_code` varchar(200) DEFAULT '',
  `match_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_app_xb_chat_rooms_matches1_idx` (`match_id`),
  KEY `fk_app_xb_chat_rooms_users1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_xb_chat_rooms`
    ADD CONSTRAINT `fk_app_xb_chat_rooms_matches1` FOREIGN KEY(`match_id`) REFERENCES `app_xb_matches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_app_xb_chat_rooms_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
CREATE TABLE IF NOT EXISTS `app_xb_chat_rooms_map` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `xb_chat_room_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `team_id` int(11) unsigned NOT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_app_xb_chat_rooms_map_rooms1_idx` (`xb_chat_room_id`),
  KEY `fk_app_xb_chat_rooms_map_users1_idx` (`user_id`),
  KEY `fk_app_xb_chat_rooms_map_teams1_idx` (`team_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_xb_chat_rooms_map`
    ADD CONSTRAINT `fk_app_xb_chat_rooms_map_rooms1` FOREIGN KEY(`xb_chat_room_id`) REFERENCES `app_xb_chat_rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_app_xb_chat_rooms_map_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_app_xb_chat_rooms_map_teams1` FOREIGN KEY(`team_id`) REFERENCES `app_xb_teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
CREATE TABLE IF NOT EXISTS `app_xb_chat_messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `xb_chat_room_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `message_list` text,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_xb_chat_messages_rooms1_idx` (`xb_chat_room_id`),
  KEY `app_xb_chat_messages_users1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_xb_chat_messages`
    ADD CONSTRAINT `app_xb_chat_messages_rooms1` FOREIGN KEY(`xb_chat_room_id`) REFERENCES `app_xb_chat_rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_xb_chat_messages_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- -----------Xstream Banter --------------------
CREATE TABLE IF NOT EXISTS `sports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `application_id` int(11) unsigned NOT NULL,
  `name` varchar(200),
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `sports`
    ADD CONSTRAINT `fk_sports_applications1` FOREIGN KEY(`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `sports` (`id`, `application_id`, `name`, `title`) VALUES
(1, 1, 'basketball', 'Basketball'),
(2, 1, 'football', 'Football'),
(3, 1, 'rugby_union', 'Rugby Union');

CREATE TABLE IF NOT EXISTS `tournaments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sports_id` int(11) unsigned NOT NULL,
  `name` varchar(200),
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `tournaments`
    ADD CONSTRAINT `fk_tournaments_sports1` FOREIGN KEY(`sports_id`) REFERENCES `sports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `tournaments` (`id`, `sports_id`, `name`, `title`) VALUES
(1, 2, 'Barclays premier league', 'Barclays premier league'),
(2, 2, 'Championship', 'Championship'),
(3, 2, 'League one', 'League one');

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200),
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `teams` (`id`, `name`, `title`, `created_on`) VALUES
(1, 'Arsenal', 'Arsenal', 1396942586),
(2, 'Aston Villa', 'Aston Villa', 1396942586),
(3, 'Chelsea', 'Chelsea', 1396942586),
(4, 'Hull City', 'Hull City', 1396942586);

CREATE TABLE IF NOT EXISTS `teams_tournaments` (
  `team_id` int(11) unsigned NOT NULL,
  `tournament_id` int(11) unsigned NOT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`team_id`, `tournament_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `teams_tournaments`
    ADD CONSTRAINT `fk_teams_tournaments_teams1` FOREIGN KEY(`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_teams_tournaments_tournaments1` FOREIGN KEY(`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `teams_tournaments` (`team_id`, `tournament_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1);
	
CREATE TABLE IF NOT EXISTS `matches` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tournament_id` int(11) unsigned NOT NULL,
  `team1_id` int(11) unsigned NOT NULL,
  `team2_id` int(11) unsigned NOT NULL,
  `date` varchar(200),
  `time` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `matches`
    ADD CONSTRAINT `fk_matches_tournaments1` FOREIGN KEY(`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_matches_teams1` FOREIGN KEY(`team1_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_matches_teams2` FOREIGN KEY(`team2_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `matches` (`id`, `tournament_id`, `team1_id`, `team2_id`, `date`, `time`) VALUES
(1, 1, 1, 2, '17-06-2014', '09:00'),
(2, 1, 3, 4, '17-06-2014', '11:00');

CREATE TABLE IF NOT EXISTS `xb_chat_rooms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_access_code` varchar(200) DEFAULT '',
  `match_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `xb_chat_rooms`
    ADD CONSTRAINT `fk_xb_chat_rooms_matches1` FOREIGN KEY(`match_id`) REFERENCES `matches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_xb_chat_rooms_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `xb_chat_rooms_map` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `xb_chat_room_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `team_id` int(11) unsigned NOT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `xb_chat_rooms_map`
    ADD CONSTRAINT `fk_xb_chat_rooms_map_xb_chat_rooms1` FOREIGN KEY(`xb_chat_room_id`) REFERENCES `xb_chat_rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_xb_chat_rooms_map_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_xb_chat_rooms_map_teams1` FOREIGN KEY(`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
	
CREATE TABLE IF NOT EXISTS `xb_chat_messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `xb_chat_room_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `message_list` text,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `xb_chat_messages`
    ADD CONSTRAINT `fk_xb_chat_messages_xb_chat_rooms1` FOREIGN KEY(`xb_chat_room_id`) REFERENCES `xb_chat_rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_xb_chat_messages_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
	
-- Healthy Recipes
CREATE TABLE IF NOT EXISTS `recipe_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `recipe_category` (`id`, `description`) VALUES
(1, 'Breakfasts'),
(2, 'Lunches'),
(3, 'Dinners'),
(4, 'Desserts'),
(5, 'Vegetarian'),
(6, 'Quick & Simple');

CREATE TABLE IF NOT EXISTS `recipes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recipe_category_id` int(11) unsigned NOT NULL,
  `title` varchar(500) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `duration` varchar(1500) NOT NULL,
  `ingredients` varchar(2000) NOT NULL,
  `preparation_method` varchar(5000) NOT NULL,
  `main_picture` varchar(1000) DEFAULT '',
  `recommend_desserts` text DEFAULT '',
  `alternative_recipes` text DEFAULT '',
  `shared_text` varchar(2000) NOT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `recipes`
    ADD CONSTRAINT `fk_recipes_recipe_category1` FOREIGN KEY(`recipe_category_id`) REFERENCES `recipe_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO `recipes` (`id`, `recipe_category_id`, `title`, `description`, `duration`, `ingredients`, `preparation_method`, `main_picture`, `recommend_desserts`, `alternative_recipes`, `shared_text`, `created_on`, `modified_on`) VALUES
(1, 1, 'Prawn dim sum', 'James Martin’s dim sum of steamed prawn parcels are served with two types of spicy dip – a great starter for sharing. ', '&amp;lt;p&amp;gt;1-2 hours preparation time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 hours cooking time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 or more to serve&amp;lt;/p&amp;gt;', '&amp;lt;p&amp;gt;450g/1lb chicken breasts, no skin or bone - cut into strips&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 egg white&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;2 tsp cornflour&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;good pinch salt&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;sesame oil 250ml/8fl oz groundnut oil&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3 lemons, juice and zest&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;85ml/2fl oz chicken stock&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp sugar&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp light soy sauce&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;splash of dry sherry&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 clove garlic, crushed&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 red chilli, finely chopped&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tsp cornflour or arrowroot - mixed with water&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;small bunch spring onions&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;shredded seasoning&amp;lt;/p&amp;gt;', '&amp;lt;ol&amp;gt;\r\n	&amp;lt;li&amp;gt;Combine the egg white, cornflour, salt, a little sesame oil and chicken in a bowl - stir to make sure the chicken is well coated. Leave for about 20 minutes.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Heat a wok until very hot, add some groundnut oil and heat until smoking. Remove from the heat and add the chicken - stir quickly to stop it from sticking and cook until the chicken turns white. Drain the chicken over a heatproof bowl, set the chicken to one side, allow the oil to cool and discard.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Wipe the wok clean and make the sauce. Add the stock, lemon juice and zest, sugar, soy and dry sherry together with the garlic and chilli. Bring to the boil and whisk in the cornflour or arrowroot mixture. Simmer gently for a few moments and then add the chicken. Stir fry to make sure the chicken is well coated and heated through properly.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Add a little sesame oil as final seasoning and serve scattered with spring onions.&amp;lt;/li&amp;gt;\r\n&amp;lt;/ol&amp;gt;', 'prawn_dim_sum.jpg\r\n', '["2","8","10"]', '["4"]', '', 1399961022, 1399968555),
(2, 1, 'Test first food', 'test first foodtest first foodtest first food.. ', '&amp;lt;p&amp;gt;1-2 hours preparation time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 hours cooking time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 or more to serve&amp;lt;/p&amp;gt;', '&amp;lt;p&amp;gt;450g/1lb chicken breasts, no skin or bone - cut into strips&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 egg white&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;2 tsp cornflour&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;good pinch salt&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;sesame oil 250ml/8fl oz groundnut oil&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3 lemons, juice and zest&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;85ml/2fl oz chicken stock&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp sugar&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp light soy sauce&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;splash of dry sherry&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 clove garlic, crushed&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 red chilli, finely chopped&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tsp cornflour or arrowroot - mixed with water&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;small bunch spring onions&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;shredded seasoning&amp;lt;/p&amp;gt;', '&amp;lt;ol&amp;gt;\r\n	&amp;lt;li&amp;gt;\r\n	&amp;lt;p&amp;gt;Combine the egg white, cornflour, salt, a little sesame oil and chicken in a bowl - stir to make sure the chicken is well coated. Leave for about 20 minutes.&amp;lt;/p&amp;gt;\r\n	&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;\r\n	&amp;lt;p&amp;gt;Heat a wok until very hot, add some groundnut oil and heat until smoking. Remove from the heat and add the chicken - stir quickly to stop it from sticking and cook until the chicken turns white. Drain the chicken over a heatproof bowl, set the chicken to one side, allow the oil to cool and discard.&amp;lt;/p&amp;gt;\r\n	&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;\r\n	&amp;lt;p&amp;gt;Wipe the wok clean and make the sauce. Add the stock, lemon juice and zest, sugar, soy and dry sherry together with the garlic and chilli. Bring to the boil and whisk in the cornflour or arrowroot mixture. Simmer gently for a few moments and then add the chicken. Stir fry to make sure the chicken is well coated and heated through properly.&amp;lt;/p&amp;gt;\r\n	&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;\r\n	&amp;lt;p&amp;gt;Add a little sesame oil as final seasoning and serve scattered with spring onions.&amp;lt;/p&amp;gt;\r\n	&amp;lt;/li&amp;gt;\r\n&amp;lt;/ol&amp;gt;', 'test_first_food.jpg\r\n', '[""]', '[""]', '', 1399961022, 1399964795),
(3, 2, 'Lemon chicken', 'This homemade version of the Chinese takeaway classic is quick, easy and delicious...', '&amp;lt;p&amp;gt;1-2 hours preparation time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 hours cooking time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 or more to serve&amp;lt;/p&amp;gt;', '&amp;lt;p&amp;gt;450g/1lb chicken breasts, no skin or bone - cut into strips&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 egg white&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;2 tsp cornflour&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;good pinch salt&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;sesame oil 250ml/8fl oz groundnut oil&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3 lemons, juice and zest&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;85ml/2fl oz chicken stock&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp sugar&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp light soy sauce&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;splash of dry sherry&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 clove garlic, crushed&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 red chilli, finely chopped&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tsp cornflour or arrowroot - mixed with water&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;small bunch spring onions&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;shredded seasoning&amp;lt;/p&amp;gt;', '&amp;lt;ol&amp;gt;\r\n	&amp;lt;li&amp;gt;\r\n	&amp;lt;p&amp;gt;Combine the egg white, cornflour, salt, a little sesame oil and chicken in a bowl - stir to make sure the chicken is well coated. Leave for about 20 minutes.&amp;lt;/p&amp;gt;\r\n	&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;\r\n	&amp;lt;p&amp;gt;Heat a wok until very hot, add some groundnut oil and heat until smoking. Remove from the heat and add the chicken - stir quickly to stop it from sticking and cook until the chicken turns white. Drain the chicken over a heatproof bowl, set the chicken to one side, allow the oil to cool and discard.&amp;lt;/p&amp;gt;\r\n	&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;\r\n	&amp;lt;p&amp;gt;Wipe the wok clean and make the sauce. Add the stock, lemon juice and zest, sugar, soy and dry sherry together with the garlic and chilli. Bring to the boil and whisk in the cornflour or arrowroot mixture. Simmer gently for a few moments and then add the chicken. Stir fry to make sure the chicken is well coated and heated through properly.&amp;lt;/p&amp;gt;\r\n	&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;\r\n	&amp;lt;p&amp;gt;Add a little sesame oil as final seasoning and serve scattered with spring onions.&amp;lt;/p&amp;gt;\r\n	&amp;lt;/li&amp;gt;\r\n&amp;lt;/ol&amp;gt;', 'lemon_chicken.jpg\r\n', '[""]', '[""]', '', 1399961022, 1399966615),
(4, 3, 'Jerk Chicken', 'Caribbean jerk chicken full of flavor and a good amount of heat, using habaneros and allspice...', '&amp;lt;p&amp;gt;1-2 hours preparation time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 hours cooking time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 or more to serve&amp;lt;/p&amp;gt;', '&amp;lt;p&amp;gt;450g/1lb chicken breasts, no skin or bone - cut into strips&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 egg white&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;2 tsp cornflour&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;good pinch salt&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;sesame oil 250ml/8fl oz groundnut oil&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3 lemons, juice and zest&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;85ml/2fl oz chicken stock&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp sugar&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp light soy sauce&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;splash of dry sherry&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 clove garlic, crushed&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 red chilli, finely chopped&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tsp cornflour or arrowroot - mixed with water&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;small bunch spring onions&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;shredded seasoning&amp;lt;/p&amp;gt;', '&amp;lt;ol&amp;gt;\r\n	&amp;lt;li&amp;gt;Combine the egg white, cornflour, salt, a little sesame oil and chicken in a bowl - stir to make sure the chicken is well coated. Leave for about 20 minutes.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Heat a wok until very hot, add some groundnut oil and heat until smoking. Remove from the heat and add the chicken - stir quickly to stop it from sticking and cook until the chicken turns white. Drain the chicken over a heatproof bowl, set the chicken to one side, allow the oil to cool and discard.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Wipe the wok clean and make the sauce. Add the stock, lemon juice and zest, sugar, soy and dry sherry together with the garlic and chilli. Bring to the boil and whisk in the cornflour or arrowroot mixture. Simmer gently for a few moments and then add the chicken. Stir fry to make sure the chicken is well coated and heated through properly.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Add a little sesame oil as final seasoning and serve scattered with spring onions.&amp;lt;/li&amp;gt;\r\n&amp;lt;/ol&amp;gt;', 'jerk_chicken.jpg\r\n', '[""]', '[""]', '', 1399961022, 1399966893),
(5, 3, 'Whisky and chilli tiger prawns', 'This is best served as a starter. ..', '&amp;lt;p&amp;gt;1-2 hours preparation time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 hours cooking time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 or more to serve&amp;lt;/p&amp;gt;', '&amp;lt;p&amp;gt;450g/1lb chicken breasts, no skin or bone - cut into strips&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 egg white&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;2 tsp cornflour&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;good pinch salt&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;sesame oil 250ml/8fl oz groundnut oil&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3 lemons, juice and zest&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;85ml/2fl oz chicken stock&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp sugar&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp light soy sauce&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;splash of dry sherry&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 clove garlic, crushed&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 red chilli, finely chopped&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tsp cornflour or arrowroot - mixed with water&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;small bunch spring onions&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;shredded seasoning&amp;lt;/p&amp;gt;', '&amp;lt;ol&amp;gt;\r\n	&amp;lt;li&amp;gt;Combine the egg white, cornflour, salt, a little sesame oil and chicken in a bowl - stir to make sure the chicken is well coated. Leave for about 20 minutes.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Heat a wok until very hot, add some groundnut oil and heat until smoking. Remove from the heat and add the chicken - stir quickly to stop it from sticking and cook until the chicken turns white. Drain the chicken over a heatproof bowl, set the chicken to one side, allow the oil to cool and discard.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Wipe the wok clean and make the sauce. Add the stock, lemon juice and zest, sugar, soy and dry sherry together with the garlic and chilli. Bring to the boil and whisk in the cornflour or arrowroot mixture. Simmer gently for a few moments and then add the chicken. Stir fry to make sure the chicken is well coated and heated through properly.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Add a little sesame oil as final seasoning and serve scattered with spring onions.&amp;lt;/li&amp;gt;\r\n&amp;lt;/ol&amp;gt;', 'whiskey_and_chilli_tiger_prawns.jpg\r\n', '[""]', '[""]', '', 1399961022, 1399967287),
(6, 3, 'Beef Wellington', 'Nothing says ''special occasion'' quite like a traditional beef Wellington. It''s pure pleasure on a plate...', '&amp;lt;p&amp;gt;1-2 hours preparation time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 hours cooking time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 or more to serve&amp;lt;/p&amp;gt;', '&amp;lt;p&amp;gt;450g/1lb chicken breasts, no skin or bone - cut into strips&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 egg white&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;2 tsp cornflour&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;good pinch salt&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;sesame oil 250ml/8fl oz groundnut oil&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3 lemons, juice and zest&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;85ml/2fl oz chicken stock&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp sugar&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp light soy sauce&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;splash of dry sherry&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 clove garlic, crushed&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 red chilli, finely chopped&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tsp cornflour or arrowroot - mixed with water&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;small bunch spring onions&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;shredded seasoning&amp;lt;/p&amp;gt;', '&amp;lt;ol&amp;gt;\r\n	&amp;lt;li&amp;gt;Combine the egg white, cornflour, salt, a little sesame oil and chicken in a bowl - stir to make sure the chicken is well coated. Leave for about 20 minutes.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Heat a wok until very hot, add some groundnut oil and heat until smoking. Remove from the heat and add the chicken - stir quickly to stop it from sticking and cook until the chicken turns white. Drain the chicken over a heatproof bowl, set the chicken to one side, allow the oil to cool and discard.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Wipe the wok clean and make the sauce. Add the stock, lemon juice and zest, sugar, soy and dry sherry together with the garlic and chilli. Bring to the boil and whisk in the cornflour or arrowroot mixture. Simmer gently for a few moments and then add the chicken. Stir fry to make sure the chicken is well coated and heated through properly.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Add a little sesame oil as final seasoning and serve scattered with spring onions.&amp;lt;/li&amp;gt;\r\n&amp;lt;/ol&amp;gt;', 'beef_wellington.jpg\r\n', '[""]', '[""]', '', 1399961022, 1399967565),
(7, 4, 'Sponge Cake', 'i make this cake is very heart..', '&amp;lt;p&amp;gt;1-2 hours preparation time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 hours cooking time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 or more to serve&amp;lt;/p&amp;gt;', '&amp;lt;p&amp;gt;450g/1lb chicken breasts, no skin or bone - cut into strips&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 egg white&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;2 tsp cornflour&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;good pinch salt&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;sesame oil 250ml/8fl oz groundnut oil&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3 lemons, juice and zest&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;85ml/2fl oz chicken stock&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp sugar&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp light soy sauce&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;splash of dry sherry&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 clove garlic, crushed&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 red chilli, finely chopped&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tsp cornflour or arrowroot - mixed with water&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;small bunch spring onions&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;shredded seasoning&amp;lt;/p&amp;gt;', '&amp;lt;ol&amp;gt;\r\n	&amp;lt;li&amp;gt;Combine the egg white, cornflour, salt, a little sesame oil and chicken in a bowl - stir to make sure the chicken is well coated. Leave for about 20 minutes.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Heat a wok until very hot, add some groundnut oil and heat until smoking. Remove from the heat and add the chicken - stir quickly to stop it from sticking and cook until the chicken turns white. Drain the chicken over a heatproof bowl, set the chicken to one side, allow the oil to cool and discard.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Wipe the wok clean and make the sauce. Add the stock, lemon juice and zest, sugar, soy and dry sherry together with the garlic and chilli. Bring to the boil and whisk in the cornflour or arrowroot mixture. Simmer gently for a few moments and then add the chicken. Stir fry to make sure the chicken is well coated and heated through properly.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Add a little sesame oil as final seasoning and serve scattered with spring onions.&amp;lt;/li&amp;gt;\r\n&amp;lt;/ol&amp;gt;', 'sponge_cake.jpg\r\n', '[""]', '[""]', '', 1399961022, 1399967562),
(8, 4, 'Apple Crumble', 'A luscious desert best served with a good dollop of custard. Good for warming you up on cold winter nights. ..', '&amp;lt;p&amp;gt;1-2 hours preparation time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 hours cooking time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 or more to serve&amp;lt;/p&amp;gt;', '&amp;lt;p&amp;gt;450g/1lb chicken breasts, no skin or bone - cut into strips&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 egg white&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;2 tsp cornflour&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;good pinch salt&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;sesame oil 250ml/8fl oz groundnut oil&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3 lemons, juice and zest&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;85ml/2fl oz chicken stock&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp sugar&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp light soy sauce&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;splash of dry sherry&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 clove garlic, crushed&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 red chilli, finely chopped&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tsp cornflour or arrowroot - mixed with water&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;small bunch spring onions&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;shredded seasoning&amp;lt;/p&amp;gt;', '&amp;lt;ol&amp;gt;\r\n	&amp;lt;li&amp;gt;Combine the egg white, cornflour, salt, a little sesame oil and chicken in a bowl - stir to make sure the chicken is well coated. Leave for about 20 minutes.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Heat a wok until very hot, add some groundnut oil and heat until smoking. Remove from the heat and add the chicken - stir quickly to stop it from sticking and cook until the chicken turns white. Drain the chicken over a heatproof bowl, set the chicken to one side, allow the oil to cool and discard.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Wipe the wok clean and make the sauce. Add the stock, lemon juice and zest, sugar, soy and dry sherry together with the garlic and chilli. Bring to the boil and whisk in the cornflour or arrowroot mixture. Simmer gently for a few moments and then add the chicken. Stir fry to make sure the chicken is well coated and heated through properly.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Add a little sesame oil as final seasoning and serve scattered with spring onions.&amp;lt;/li&amp;gt;\r\n&amp;lt;/ol&amp;gt;', 'apple_crumble.jpg\r\n', '[""]', '[""]', '', 1399961022, 1399967561),
(9, 5, 'Vegetable Curry', 'This creamy curry is low-fat, packed with vegetables and on the table in less than half an hour...', '&amp;lt;p&amp;gt;1-2 hours preparation time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 hours cooking time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 or more to serve&amp;lt;/p&amp;gt;', '&amp;lt;p&amp;gt;450g/1lb chicken breasts, no skin or bone - cut into strips&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 egg white&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;2 tsp cornflour&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;good pinch salt&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;sesame oil 250ml/8fl oz groundnut oil&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3 lemons, juice and zest&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;85ml/2fl oz chicken stock&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp sugar&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp light soy sauce&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;splash of dry sherry&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 clove garlic, crushed&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 red chilli, finely chopped&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tsp cornflour or arrowroot - mixed with water&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;small bunch spring onions&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;shredded seasoning&amp;lt;/p&amp;gt;', '&amp;lt;ol&amp;gt;\r\n	&amp;lt;li&amp;gt;Combine the egg white, cornflour, salt, a little sesame oil and chicken in a bowl - stir to make sure the chicken is well coated. Leave for about 20 minutes.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Heat a wok until very hot, add some groundnut oil and heat until smoking. Remove from the heat and add the chicken - stir quickly to stop it from sticking and cook until the chicken turns white. Drain the chicken over a heatproof bowl, set the chicken to one side, allow the oil to cool and discard.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Wipe the wok clean and make the sauce. Add the stock, lemon juice and zest, sugar, soy and dry sherry together with the garlic and chilli. Bring to the boil and whisk in the cornflour or arrowroot mixture. Simmer gently for a few moments and then add the chicken. Stir fry to make sure the chicken is well coated and heated through properly.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Add a little sesame oil as final seasoning and serve scattered with spring onions.&amp;lt;/li&amp;gt;\r\n&amp;lt;/ol&amp;gt;', 'vegetable_curry.jpg\r\n', '[""]', '[""]', '', 1399961022, 1399967559),
(10, 5, 'Caesar salad', 'pour the dressing over the leaves and add the fried bread cubes and parmesan. Toss well and serve at once...', '&amp;lt;p&amp;gt;1-2 hours preparation time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 hours cooking time&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3-4 or more to serve&amp;lt;/p&amp;gt;', '&amp;lt;p&amp;gt;450g/1lb chicken breasts, no skin or bone - cut into strips&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 egg white&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;2 tsp cornflour&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;good pinch salt&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;sesame oil 250ml/8fl oz groundnut oil&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;3 lemons, juice and zest&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;85ml/2fl oz chicken stock&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp sugar&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tbsp light soy sauce&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;splash of dry sherry&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 clove garlic, crushed&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 red chilli, finely chopped&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;1 tsp cornflour or arrowroot - mixed with water&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;small bunch spring onions&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;shredded seasoning&amp;lt;/p&amp;gt;', '&amp;lt;ol&amp;gt;\r\n	&amp;lt;li&amp;gt;Combine the egg white, cornflour, salt, a little sesame oil and chicken in a bowl - stir to make sure the chicken is well coated. Leave for about 20 minutes.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Heat a wok until very hot, add some groundnut oil and heat until smoking. Remove from the heat and add the chicken - stir quickly to stop it from sticking and cook until the chicken turns white. Drain the chicken over a heatproof bowl, set the chicken to one side, allow the oil to cool and discard.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Wipe the wok clean and make the sauce. Add the stock, lemon juice and zest, sugar, soy and dry sherry together with the garlic and chilli. Bring to the boil and whisk in the cornflour or arrowroot mixture. Simmer gently for a few moments and then add the chicken. Stir fry to make sure the chicken is well coated and heated through properly.&amp;lt;/li&amp;gt;\r\n	&amp;lt;li&amp;gt;Add a little sesame oil as final seasoning and serve scattered with spring onions.&amp;lt;/li&amp;gt;\r\n&amp;lt;/ol&amp;gt;', 'caesar_salad.jpg\r\n', '[""]', '[""]', '', 1399961022, 1399967556);

	
CREATE TABLE IF NOT EXISTS `recipe_selection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_view_list` text NOT NULL,
  `recipe_list` text NOT NULL,
  `selected_date` varchar(25) NOT NULL,
  `show_advertise_home_page` boolean DEFAULT TRUE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `recipe_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `recipe_id` int(11) unsigned NOT NULL,
  `comment` varchar(5000) NOT NULL,
  `rate_id` int(11) NOT NULL,
  `liked_user_list` text,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`) 
);

ALTER TABLE `recipe_comments`
    ADD CONSTRAINT `fk_recipe_comments_users1` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_recipe_comments_recipes1` FOREIGN KEY(`recipe_id`) REFERENCES `recipes`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- service directory
CREATE TABLE IF NOT EXISTS `service_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(500) NOT NULL,
  `picture` varchar(200) DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
   PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;
INSERT INTO `service_category` (`description`, `picture`) VALUES
('Chiropractor', 'Chiropractor.png'),
('Dentist', 'Dentist.png'),
('Dermatologist', 'Dermatologist.png'),
('GP Services', 'GP Services.png'),
('Health Club / Gym', 'Health Club  Gym.png'),
('Hospital', 'Hospital.png'),
('Optician', 'Optician.png'),
('Personal Trainer', 'Personal Trainer.png'),
('Pharmacy', 'Pharmacy.png'),
('Physiotherapist', 'Physiotherapist.png'),
('Podiatrist', 'Podiatrist.png'),
('Spa', 'Spa.png'),
('Sports ground', 'Sports ground.png');

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `latitude` varchar(300) DEFAULT 0,
  `longitude` varchar(300) DEFAULT 0,
  `address` varchar(300) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country_id` int(11) unsigned NOT NULL,
  `post_code` varchar(30) NOT NULL, 
  `opening_hours` varchar(300) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `website` varchar(300) DEFAULT NULL,
  `business_profile_id` int(11) unsigned NOT NULL,
  `picture` varchar(300) DEFAULT NULL,
  `service_category_id` int(11) unsigned NOT NULL,
  `shared_text` varchar(2000) NOT NULL,
  `created_on` int (11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1; 

ALTER TABLE `services`
    ADD CONSTRAINT `fk_services_service_category1` FOREIGN KEY(`service_category_id`) REFERENCES `service_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_services_business_profile1` FOREIGN KEY(`business_profile_id`) REFERENCES `business_profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_services_countries1` FOREIGN KEY(`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


CREATE TABLE IF NOT EXISTS `service_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `service_id` int(11) unsigned NOT NULL,
  `comment` varchar(5000) NOT NULL,
  `rate_id` int(11) NOT NULL,
  `liked_user_list` text,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`) 
);

ALTER TABLE `service_comments`
    ADD CONSTRAINT `fk_service_comments_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_service_comments_services1` FOREIGN KEY(`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- news application
CREATE TABLE `news`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `headline` varchar(5000) NOT NULL,
  `summary` varchar(5000) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `picture` text,
  `picture_description` text default '',
  `news_date` varchar(50) DEFAULT NULL,
  `user_liked_list` text,
  `shared_text` varchar(2000) NOT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;
INSERT INTO `news` (`id`, `headline`, `summary`, `description`, `picture`, `news_date`, `user_liked_list`, `shared_text`, `created_on`, `modified_on`) VALUES
(1, 'Wladimir Klitschko beats Italian Francesco Pianeta in Germany', 'Wladimir Klitschko retained his WBA, IBF and WBO world heavyweight titles with a sixth-round stoppage victory against Italian Francesco Pianeta', 'Ukraines Klitschko, 37, was never troubled as he made the 14th defence of his belts in his second stint as champion.', '1.jpg', '2014-04-30\r\n', NULL, '', 1399980517, NULL),
(2, 'Masters 2013: Rory McIlroy', 'Rory McIlroy posted an impressive three-under-par final round of 69 at the Masters to end joint 25th at Augusta on two over', '&amp;lt;p&amp;gt;The world number two, who had a 79 on Saturday, carded four birdies and a bogey in his closing 18 holes.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Adam Scott beat Angel Cabrera in play-off after they finished on nine under.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;I didn&amp;amp;#39;t feel that I played all that differently to what I did on Saturday, yet my score was 10 shots lower. It was a nice round to finish,&amp;amp;quot; said McIlroy.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;He added: &amp;amp;quot;A few mistakes around this course and you can pay a heavy penalty - that&amp;amp;#39;s what happened me on Saturday.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;I&amp;amp;#39;ve not had the best of tournaments but this gives me something to build on for the rest of the season.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;My third round was very disappointing and if I had done better on Saturday I might have had a chance going into Sunday,&amp;amp;quot; added the two-time major champion.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;McIlroy began Sunday&amp;amp;#39;s round brightly with a birdie at the second, but a bogey at the fourth saw him drop back to five over.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Birdies at the eighth, 15th and 16th represented a strong finish for the 23-year-old.&amp;lt;/p&amp;gt;', '131.jpg', '2014-04-30\r\n', NULL, '', 1399980518, 1399986925),
(3, 'Warwickshire v Durham', 'Chris Wright took 6-31 as champions Warwickshire completed an emphatic 318-run win over Durham at Edgbaston.', '&amp;lt;p&amp;gt;Seam bowler Wright picked up three early wickets as the visitors plummeted from their overnight 11-1 to 37-6.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Scott Borthwick (19) and Callum Thorp (12) soon fell to Wright after lunch, but Phil Mustard resisted for over two hours to delay Warwickshire&amp;amp;#39;s victory.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;He was last man out, caught at point by Laurie Evans off Chris Woakes for 28, as Durham were dismissed for just 94.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p id=&quot;story_continues_2&quot;&amp;gt;Having begun the season with a confidence-boosting win over Somerset, the meekness of the north east county&amp;amp;#39;s batting was a disappointment, but they appeared to be caught cold after Mark Stoneman edged Wright to wicketkeeper Tim Ambrose in only the third over of play.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Will Smith (15) was the only batsman in Durham&amp;amp;#39;s top six to reach double figures as Wright, Keith Barker and Woakes, who had Durham skipper Paul Collingwood caught at second slip for five, wreaked havoc.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;A seventh-wicket partnership of 24 between Mustard and first-innings centurion Borthwick was the highest of the innings and it looked like Wright might better his career-best figures of 6-22, achieved while playing for Essex.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;A seventh victim eluded him, however, as skipper Jim Troughton turned to Jeetan Patel&amp;amp;#39;s off-spin and the New Zealander had Graham Onions caught by Will Porterfield for a duck before Woakes (2-13) finished things off in the next over with Mustard&amp;amp;#39;s wicket.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;We were ultimately well beaten,&amp;amp;quot; Durham coach Geoff Cook admitted. &amp;amp;quot;It was still a good wicket but Wright was strong and knocked the stuffing out of a top order still trying to find its feet.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;It would have been nice to see one of those guys see the new ball off to give the others a base. These fellows can all bat, but they have got to be given the time and the support to try and get their game going.&amp;amp;quot;&amp;lt;/p&amp;gt;', '171.jpg', '2014-04-30\r\n', NULL, '', 1399980518, 1399986576),
(4, 'Challenge Cup: Hull FC 62-6 Crusaders', 'Rugby news description', '&amp;lt;p&amp;gt;Hull were dominant in the second period, taking advantage of a tiring Championship One side to put on 56 unanswered points.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Richard Horne scored a brace, while Joe Westerman, Ben Crooks, Tom Lineham and James Cunningham also crossed.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Crusaders&amp;amp;#39; try from Christiaan Roets was converted by Tommy Johnson.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Clive Griffiths&amp;amp;#39; visitors, on the back of a six-game winning run, held firm early on but having coughed up possession with a knock on at the play-the-ball were punished when Horne slipped through to open the scoring.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Westerman added his name to the sheet when he powered over, and Hull again burst over when Crooks gathered Horne&amp;amp;#39;s neat grubber to touch down.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;div class=&quot;audioInStoryC story-feature&quot;&amp;gt;&amp;amp;nbsp;&amp;lt;/div&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Roets built on Andy Moulsdale&amp;amp;#39;s piercing kick to the corner to touch down, but service was resumed when Westerman dummied before feeding Yeaman for the fourth Airlie Birds try of the half.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;The England centre scored again just before the break, and could have had his hat-trick in the second period but was off-side when he finished off Heremaia&amp;amp;#39;s kick.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;However, Peter Gentle&amp;amp;#39;s side showed their ruthless side in the second period, running in six tries without reply to overpower the Crusaders.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Lineham kept himself in touch to force a way over the whitewash under pressure for the sixth try of the game, and as Crusaders tired, replacement hooker Cunningham sneaked from dummy-half to pick up his first try.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Shaul showed neat footwork and pace to grab a hat-trick, while Horne added a second, and with the last play of the game Yeaman made the most of a flowing 100-metre move to pick up his treble and delight the home support.&amp;lt;/p&amp;gt;', '181.jpg', '2014-04-30 \r\n', NULL, '', 1399980518, 1399987359),
(5, 'Why Scotland are better than England...', 'Scotland are indeed a more successful side than England, based on financial resources and playing numbers.', 'This is not a simple matter of matches won or titles secured. I wanted to factor in the vastly differing resources each nation has at their disposal - finances, manpower, rugby expertise - to see which countries are underperforming and which make the best possible use of their precious assets.', '12.jpg', '2014-04-30\r\n', NULL, '', 1399980518, NULL),
(6, '&amp;lt;p&amp;gt;Kobe Bryant&amp;lt;/p&amp;gt;', '&amp;lt;p&amp;gt;Lakers News: Kobe Bryant Will No Longer Play For USA Basketball&amp;lt;/p&amp;gt;', '&amp;lt;p&amp;gt;Kobe Bryant is currently in the Philippines as part of his promotional tour for Lenovo. Bryant met with fans in Pasay City where he discussed numerous topics, including if he&amp;amp;rsquo;ll play in the FIBA World Cup in Madrid, Spain.&amp;lt;/p&amp;gt;', '271.jpg', '2014-05-13', NULL, '', 1399982225, NULL),
(7, 'Wayne Rooney''s ''mind is fine'', says England boss Roy Hodgson', 'England manager Roy Hodgson expects Wayne Rooney to put his club troubles aside to possibly start in Wednesday''s friendly against Scotland.', '&amp;lt;p&amp;gt;There has been intense speculation about Rooney&amp;amp;#39;s future at Manchester United and the 27-year-old has missed most of pre-season with injury.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;nbsp;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;His mind is fine,&amp;amp;quot; said Hodgson. &amp;amp;quot;He can compartmentalise club and country, which I expect from all players.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;Players cannot bring their club problems to England.&amp;amp;quot;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;He added: &amp;amp;quot;If there were any problems with England, they cannot take them back to their clubs. It is two separate identities.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;I expect players, when they come here [to join up with England], to be fully focused on playing for England.&amp;amp;quot;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;nbsp;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Rooney has played just one pre-season game - a behind-closed-doors encounter against Real Betis - for Manchester United in the build-up to the 2013-14 season.&amp;lt;/p&amp;gt;', '01.jpg', '2014-05-13', NULL, '', 1399986175, NULL),
(8, 'Liverpool v Chelsea', 'Liverpool have no reported new injury concerns for Sunday''s visit of Chelsea.', '&amp;lt;p&amp;gt;Stewart Downing is pushing for a recall, while Raheem Sterling, Martin Kelly, Fabio Borini and Joe Allen are all absentees.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Chelsea interim manager Rafa Benitez is expected to make several changes from the side that beat Fulham in midweek as he tries to keep his squad fresh.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Ashley Cole and Gary Cahill may be available after respective hamstring and knee injuries.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;lt;strong&amp;gt;MATCH PREVIEW&amp;lt;/strong&amp;gt;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;However professional Rafa Benitez is, this will surely be a day to test and confuse his emotions.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;His first return to Anfield as a visiting coach comes six days after the anniversary of Hillsborough, five days after his 53rd birthday, and in the knowledge that he&amp;amp;#39;s less than a month away from the final game of his brief, stormy spell in charge of Chelsea.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;The fans of the team he&amp;amp;#39;s trying to beat will sing his name, whilst those of his current club will continue, non-stop, with their familiar chant of &amp;amp;quot;We don&amp;amp;#39;t care about Rafa. He don&amp;amp;#39;t care about us.&amp;amp;quot; It all seems a bit upside down and back to front.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;I don&amp;amp;#39;t think Chelsea will get a result here, but they should be fine regarding Champions League qualification.&amp;amp;quot;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Another curious twist comes a glance across the tunnel to the home dugout. When Benitez was making Liverpool the champions of Europe again in 2005, Brendan Rodgers was less than a year into his role as head of youth - at Chelsea.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;What a rise it&amp;amp;#39;s been for the Ulsterman since then. This game is his 50th as Liverpool chief, and his 200th overall as a manager.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Depending on team selections - actually depending on CHELSEA&amp;amp;#39;s ever-changing team selection - the game could give us some fascinating like-for-like match ups. The last Carragher tussles with Terry at corners; Gerrard in red against Lampard in blue for perhaps the final time; and of course the return of the Kop&amp;amp;#39;s fallen idol Fernando Torres to be judged against its even more beloved Luis Suarez.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Unbeaten in the last five Premier League clashes, Liverpool have lately had the upper hand in a rivalry that&amp;amp;#39;s intensified with so many meetings over the last few seasons.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Most of the players on either side have faced the other more than any other opponents, including Steven Gerrard - which throws up an interesting stat. In 34 games for Liverpool against Chelsea, Gerrard has scored just once. ONE goal - out of 159 that he&amp;amp;#39;s scored for the club in all competitions! Well I found it interesting anyway.&amp;lt;/p&amp;gt;', '31.jpg', '2014-05-13', NULL, '', 1399986414, NULL),
(9, 'Manchester United are Champions', 'Manchester United wrapped up a 20th league title in convincing style after Robin van Persie''s first-half hat-trick sank Aston Villa.', '&amp;lt;p&amp;gt;The Dutch striker has been United&amp;amp;#39;s stellar striker for much of the season before labouring of late after two goals in his previous seven Premier League appearances.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;But the &amp;amp;pound;24m summer signing returned to form in spectacular fashion to secure the silverware with four games to spare.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Defeat for Manchester City at Tottenham on Sunday meant that United knew before kick-off that victory would be enough for them to cross the line.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Despite an improved second-half showing by Villa, now three points above the relegation zone with four games remaining, that outcome never seriously looked in doubt.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;United boss Sir Alex Ferguson has now won the Premier League 13 times but the manner and margin of this triumph, a year after seeing the title wrenched from his grasp by City with the last kick of the season, should give him as much satisfaction as his first success.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;His side were already 13 points clear before kick-off, and there was an air of expectation bordering on euphoria at Old Trafford.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;If there were any nerves too, they went out of the window when Van Persie opened the scoring after 83 seconds.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;A move started by Wayne Rooney ended with Ryan Giggs knocking Antonio Valencia&amp;amp;#39;s cross into the path of the Dutchman, who converted from two yards out.&amp;lt;/p&amp;gt;', '91.jpg', '2014-05-13', NULL, '', 1399986720, NULL),
(10, 'David Beckham: to retire', 'David Beckham is to retire from football at the end of this season after an illustrious 20-year career.', '&amp;lt;p&amp;gt;The former England captain made 115 appearances for his country and 394 for Manchester United, winning six Premier League titles and the Champions League.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Beckham, 38, signed a five-month deal at Paris St-Germain in January.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;I&amp;amp;#39;m thankful to PSG for giving me the opportunity to continue but I feel now is the right time to finish my career, playing at the highest level,&amp;amp;quot; he said.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;PSG have two more games before the end of the season, at home against Brest on Saturday and away to Lorient on 26 May.&amp;lt;/p&amp;gt;', '111.jpg', '2014-05-13', NULL, '', 1399986775, NULL),
(11, 'Lewis Hamilton: Mercedes ''holding on', 'Lewis Hamilton says his Mercedes team are just about hanging on to Formula 1''s front-runners but is hopeful they can compete soon.', '&amp;lt;p id=&quot;story_continues_2&quot;&amp;gt;Mercedes have taken pole for the last two grands prix but are struggling with excessive rear tyre usage in races.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Hamilton said: &amp;amp;quot;I feel like we&amp;amp;#39;re holding on by the skin of our teeth.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;The guys at the factory need to keep pushing because we&amp;amp;#39;re not that far off and if we can just make that next step we can close the gap with them.&amp;amp;quot;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Mercedes have made huge steps forward after ending last season struggling even to score points.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Hamilton was on pole and finished third in China earlier this month, while team-mate Nico Rosberg qualified fastest in Bahrain at the weekend, too.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;But in the race on Sunday, Rosberg slipped back to finish ninth, having to make four pit stops for fresh tyres when most leading runners made only three.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Hamilton struggled in the early stages of the race after starting ninth because of a five-place grid penalty, but came alive in the second half of the race and finished fifth.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;He is third in the championship after the first four races, 27 points behind leader Sebastian Vettel of Red Bull, who is 10 ahead of Lotus&amp;amp;#39;s Kimi Raikkonen.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p id=&quot;story_continues_3&quot;&amp;gt;Hamilton is three points ahead of Ferrari&amp;amp;#39;s Fernando Alonso, who won in China and would be second overall had it not been for team errors in both Malaysia and Bahrain.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Although the Mercedes is competitive in qualifying, Red Bull, Lotus and Ferrari are comfortably the fastest cars in the race, with Mercedes at the head of the next group which includes Force India and McLaren.&amp;lt;/p&amp;gt;', '101.jpg', '2014-05-13', NULL, '', 1399986848, NULL),
(12, 'Rafael Nadal to face Novak Djokovic', 'Tennis news summary', '&amp;lt;p&amp;gt;Nadal withstood a blistering fightback from Jo-Wilfried Tsonga to remain on course for a ninth Monte Carlo title.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;The Spaniard, 26, let a 5-1 lead slip in the second set but finally saw off the Frenchman 6-3 7-6 (7-3) on his fifth match point.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p id=&quot;story_continues_2&quot;&amp;gt;Djokovic swept past the unseeded Fabio Fognini 6-2 6-1 in the second semi.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;The Serb, 25, had struggled with an ankle injury during the early rounds but showed no signs of discomfort as he dismissed Fognini, playing his first Masters semi-final, in just 52 minutes.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Nadal&amp;amp;#39;s unbeaten run in Monte Carlo now stands at 46 matches over 10 years, and he will look to repeat last year&amp;amp;#39;s final win over Djokovic in what will be their first meeting since last year&amp;amp;#39;s French Open final.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;I will have to be at the top of my game. I&amp;amp;#39;m ready for it. I know what I need to do,&amp;amp;quot; said Djokovic.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;I had enough tests already this week so I&amp;amp;#39;m happy I can be fresh.&amp;amp;quot;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;After a bright start to the first semi-final, Tsonga missed three break points in the fourth game and began to struggle, losing his next service game and making 17 unforced errors as the set slipped away.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Nadal, playing his fifth tournament since returning from a seven-month injury break, was in full flow in the early stages of the second, powering into a commanding 5-1 lead.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Tsonga was not done, however, and with the match seemingly gone he resorted to all-out attack, recovering both breaks of serve and saving four match points on his way to a tie-break.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;At 3-3, the match remained in the balance, but errors crept back into the Frenchman&amp;amp;#39;s game at the crucial moment and Nadal wrapped up the win in one hour and 36 minutes.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;I&amp;amp;#39;m going to try to play my best match and try to get a chance to win the final,&amp;amp;quot; said Nadal.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;He&amp;amp;#39;s not the perfect opponent (for my game). But if you don&amp;amp;#39;t feel a special feeling when you are playing the final of Monte Carlo, you&amp;amp;#39;d better go back home, play golf and go fishing.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;He brings you to the limit of your game if you want to have chances to win. I know I have to play better than I did today and yesterday to try to win tomorrow.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;I have to play more aggressive, I&amp;amp;#39;m going to try.&amp;amp;quot;&amp;lt;/p&amp;gt;', '161.jpg', '2014-05-13', NULL, '', 1399987264, NULL),
(13, 'Fulham v Arsenal', 'Football news summary', '&amp;lt;p&amp;gt;The Gunners dominated early on and seemed to have been gifted a path to victory by Steve Sidwell&amp;amp;#39;s 12th-minute dismissal for a lunge on Mikel Arteta.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;But Fulham posed the greater threat and Arsenal were fortunate to lead at half-time through Per Mertesacker&amp;amp;#39;s header.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;They continued to struggle but held on despite Olivier Giroud&amp;amp;#39;s red card for a last-minute lunge on Stanislav Manolev.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;That evened the numbers up for a thrilling period of injury time in which the Cottagers came close to salvaging an unlikely but deserved draw and denting the visitors&amp;amp;#39; chances of finishing in the Champions League places.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;A surging early run from Manolev apart, Fulham had barely got out of their own half before Sidwell&amp;amp;#39;s dismissal for his needless challenge.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Sidwell had only returned to the side after serving a three-match ban and his moment of madness seemed likely to lead to an Arsenal onslaught.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;But following his red card, Fulham were the better side for long spells. They made full use of their pace on the counter-attack and Dimitar Berbatov&amp;amp;#39;s ability to link up play, and they could easily have gone ahead.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Fulham, who have now picked up just one point from their last four matches, already looked intent on sitting deep and frustrating opponents who had failed to break down a resolute Everton defence in midweek.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Sidwell&amp;amp;#39;s sending off ensured they had little option but to play on the break, and although Fulham slipped to a second successive derby defeat in the space of four days, they looked the more likely to score in open play.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p id=&quot;story_continues_2&quot;&amp;gt;Berbatov had a fierce strike beaten away by goalkeeper Wojciech Szczesny after a brilliant 40-yard run and pass by Bryan Ruiz.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;And Alex Kacaniklic, recalled from a loan spell at Burnley to ease an injury crisis, twice caused problems after a threatening run forward.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;The Gunners, who have now won eight of their last 10 league games, looked ponderous and, although dominating possession, were struggling to create chances.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Giroud came closest to breaking the deadlock with a fine low strike across goal that hit the outside of the post after good work by Santi Cazorla.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;They did take the lead just before the break from a Theo Walcott set-piece when Mertesacker headed home from close range after Laurent Koscielny&amp;amp;#39;s mistimed header across goal.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;However that did not relax the visitors, who looked increasingly edgy during a lifeless second half, devoid of clear chances.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Fulham continued to threaten on the counter-attack and Manolev, after one such break, thought he had equalised but was offside when he turned the ball in on the rebound after Szczesny saved Kieran Richardson&amp;amp;#39;s free-kick.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;But despite a sloppy second-half display, Arsenal withstood the late pressure after Giroud&amp;amp;#39;s red card to move two points clear of fourth-placed Chelsea - although they have played two more games than the Blues.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;lt;strong&amp;gt;Fulham manager Martin Jol: &amp;lt;/strong&amp;gt; &amp;amp;quot;&amp;amp;quot;I was annoyed with him [Sidwell], but he says it is not intentional. He will regret that tackle. It was the first foul that spoilt the game.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;I know it was not intentional because he wanted to play. He has just come back from a three-match suspension and now he is out for another four matches again so it was not only disappointing for him, but also for us because we had to play with 10 men for a long time.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;But we fought like lions and had better chances than them. In the first half we did ever so well but conceded a soft goal.&amp;amp;quot;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;lt;strong&amp;gt;Arsenal manager Arsene Wenger: &amp;lt;/strong&amp;gt; &amp;amp;quot;I think the referee could only give a red card [to Sidwell]. We will see [if Arteta is okay]. He played the second-half. I don&amp;amp;#39;t know how much damage is done. It is a kick, a bad kick.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;I don&amp;amp;#39;t know if he has twisted his ankle or not. In these kind of things it is a question of a fraction of a second. If you are fully on your foot at the moment you get it you break your leg. If you ease a', '191.jpg', '2014-05-13', NULL, '', 1399987453, NULL),
(14, 'Bahrain GP: Sebastian Vettel dominates', 'F1 news summary', '&amp;lt;p&amp;gt;The world champion headed Lotus drivers Kimi Raikkonen and Romain Grosjean, who denied Paul di Resta a first career podium in the closing laps.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;The Scot had, like Raikkonen, done one fewer pit stops than the other leading runners but could not hold Grosjean.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Lewis Hamilton took fifth for Mercedes as Fernando Alonso rescued eighth after suffering a DRS overtaking aid failure.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;There were close on-track battles and plenty of overtaking between a number of drivers, including a bad-tempered tussle between McLaren&amp;amp;#39;s Jenson Button and Sergio Perez, but Vettel was in a league of his own.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;[It was a] faultless, seamless race from start to finish,&amp;amp;quot; said Vettel. &amp;amp;quot;I knew it was crucial to get into the lead and look after the tyres, the pace was phenomenal, the car was great. I could push every single lap and look after the tyres.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;I lost out to Fernando at the first corner, but I could get him back. I saved some Kers and could out-accelerate him into Turn Six. Out of Turn four I did the same on Nico, a little bit of Kers and got him into Turn Five.&amp;amp;quot;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;quot;[It was] incredible the pace we had today, we surely did not expect that.&amp;amp;quot;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p id=&quot;story_continues_2&quot;&amp;gt;His win extends his lead over Raikkonen in the championship to 10 points, with Hamilton third a further 13 behind and Alonso fourth, 30 behind Vettel.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;The German held off a challenge from Alonso on the opening lap, losing out through Turns One and Two before re-passing the Ferrari with a brave move around the outside into Turn Five.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;He then passed pole-winner Nico Rosberg&amp;amp;#39;s Mercedes, skilfully around the outside of Turn Five into Turn Six and drove away into a race of his own, making three stops on his way to a third consecutive victory in Bahrain.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Behind him, Raikkonen used a two-stop strategy to move up to from eighth on the grid to take second, while Grosjean, making three stops, passed Di Resta for third with six laps to go.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Behind them there was a Titanic race-long fight involving Mark Webber, Lewis Hamilton, Perez, Alonso, Nico Rosberg and Button, as their strategies brought various combinations of drivers together on track at various points of the race.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;In the closing laps, Webber and Hamilton battled hard for fifth place, with Hamilton passing the Red Bull into Turn One at the start of the final lap to take fifth.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Webber then lost another place to Perez in the course of the last lap as Alonso took eighth ahead of Rosberg and Button.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Alonso - who had been without the use of the DRS since it failed on lap seven - just lost out in a battle with Perez.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Alonso had to make pit stops on laps seven and eight when the DRS stuck open. At the first, Ferrari mechanics banged it shut, but it stuck again as soon as he used it on the next lap and he had to stop again to have it knocked back into place.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;In the circumstances, it was an impressive recovery from Alonso, who passed Perez for seventh with six laps to go, but was unable to fend the McLaren off when Perez came back at him three laps later.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;The Mexican prevailed after passing Alonso into Turn Four and then forcing him off the circuit as the Ferrari driver tried to stay with him around the outside of Turn Five.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Earlier, Perez had angered Button as he hit the back of his team-mate and then banged wheels with him, Button saying on the team radio: &amp;amp;quot;Calm him down, will you?&amp;amp;quot;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Button dropped back out of contention in the closing laps to fall behind Rosberg, whose high tyre degradation meant he had to make four stops to change tyres.&amp;lt;/p&amp;gt;', '41.jpg', '2014-05-13', NULL, '', 1399987575, NULL),
(15, 'Wladimir Klitschko beats Italian Francesco Pianeta in Germany', 'Wladimir Klitschko retained his WBA, IBF and WBO world heavyweight titles with a sixth-round stoppage victory against Italian Francesco Pianeta', '&amp;lt;p&amp;gt;&amp;lt;span style=&quot;font-size: 1.077em; line-height: 1.35; color: #1c1c1c; font-family: arial, sans-serif;&quot;&amp;gt;Ukraine&amp;amp;#39;s Klitschko, 37, was never troubled as he made the 14th defence of his belts in his second stint as champion.&amp;lt;/span&amp;gt;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;Pianeta, who had been unbeaten in his previous 29 professional fights, was floored in the fourth and fifth rounds.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;But Klitschko finished the contest in brutal style in the following round.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;Klitschko has now won 60 of his 63 fights, with his last defeat coming in May 2004 when he suffered a fifth-round stoppage against American Lamon Brewster.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;The 28-year-old Pianeta took a lot of punishment but stayed in the contest for six rounds, although he was hopelessly outclassed in Mannheim, Germany.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;Klitschko, who could now fight unbeaten Russian Alexander Povetkin later this year, floored his opponent with a straight right hand in the fourth and then again a round later when he landed with a left hook.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;But a powerful combination in the sixth sent Pianeta down again and, although he got up, referee Ernest Sharif stopped the contest.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Vitali Klitschko, Wladimir&amp;amp;#39;s brother, holds the WBC title.&amp;lt;/p&amp;gt;', '15.jpg', '2014-05-13', NULL, '', 1399987973, NULL),
(16, 'Wladimir Klitschko beats Italian Francesco Pianeta in Germany', 'Wladimir Klitschko retained his WBA, IBF and WBO world heavyweight titles with a sixth-round stoppage victory against Italian Francesco Pianeta', '&amp;lt;p&amp;gt;&amp;lt;span style=&quot;font-size: 1.077em; line-height: 1.35; color: #1c1c1c; font-family: arial, sans-serif;&quot;&amp;gt;Ukraine&amp;amp;#39;s Klitschko, 37, was never troubled as he made the 14th defence of his belts in his second stint as champion.&amp;lt;/span&amp;gt;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;Pianeta, who had been unbeaten in his previous 29 professional fights, was floored in the fourth and fifth rounds.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;But Klitschko finished the contest in brutal style in the following round.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;Klitschko has now won 60 of his 63 fights, with his last defeat coming in May 2004 when he suffered a fifth-round stoppage against American Lamon Brewster.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;The 28-year-old Pianeta took a lot of punishment but stayed in the contest for six rounds, although he was hopelessly outclassed in Mannheim, Germany.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;Klitschko, who could now fight unbeaten Russian Alexander Povetkin later this year, floored his opponent with a straight right hand in the fourth and then again a round later when he landed with a left hook.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;But a powerful combination in the sixth sent Pianeta down again and, although he got up, referee Ernest Sharif stopped the contest.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Vitali Klitschko, Wladimir&amp;amp;#39;s brother, holds the WBC title.&amp;lt;/p&amp;gt;', '15.jpg', '2014-05-13', NULL, '', 1399987973, NULL),
(17, 'Wladimir Klitschko beats Italian Francesco Pianeta in Germany', 'Wladimir Klitschko retained his WBA, IBF and WBO world heavyweight titles with a sixth-round stoppage victory against Italian Francesco Pianeta', '&amp;lt;p&amp;gt;&amp;lt;span style=&quot;font-size: 1.077em; line-height: 1.35; color: #1c1c1c; font-family: arial, sans-serif;&quot;&amp;gt;Ukraine&amp;amp;#39;s Klitschko, 37, was never troubled as he made the 14th defence of his belts in his second stint as champion.&amp;lt;/span&amp;gt;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;Pianeta, who had been unbeaten in his previous 29 professional fights, was floored in the fourth and fifth rounds.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;But Klitschko finished the contest in brutal style in the following round.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;Klitschko has now won 60 of his 63 fights, with his last defeat coming in May 2004 when he suffered a fifth-round stoppage against American Lamon Brewster.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;The 28-year-old Pianeta took a lot of punishment but stayed in the contest for six rounds, although he was hopelessly outclassed in Mannheim, Germany.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;Klitschko, who could now fight unbeaten Russian Alexander Povetkin later this year, floored his opponent with a straight right hand in the fourth and then again a round later when he landed with a left hook.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p style=&quot;margin: 0px; padding: 0px 0px 12px; color: #1c1c1c; line-height: 1.35; font-size: 1.077em; font-family: arial, sans-serif;&quot;&amp;gt;But a powerful combination in the sixth sent Pianeta down again and, although he got up, referee Ernest Sharif stopped the contest.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Vitali Klitschko, Wladimir&amp;amp;#39;s brother, holds the WBC title.&amp;lt;/p&amp;gt;', '15.jpg', '2014-05-13', NULL, '', 1399987973, NULL);

CREATE TABLE `news_category`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;
INSERT INTO `news_category` (`title`) VALUES
('Football'),
('Baseball'),
('Formula 1'),
('Basketball'),
('Boxing'),
('Tennis'),
('Cricket'),
('Rugby');

CREATE TABLE IF NOT EXISTS `news_category_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_category_id` int(11) unsigned NOT NULL,
  `news_list` text NOT NULL,
  `selected_date` varchar(25) NOT NULL,
  `show_advertise` boolean DEFAULT TRUE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
ALTER TABLE `news_category_configuration`
    ADD CONSTRAINT `fk_ncc_nc1` FOREIGN KEY(`news_category_id`) REFERENCES `news_category`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;


CREATE TABLE `news_sub_category`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `news_category_id` int(11) unsigned NOT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;
INSERT INTO `news_sub_category` (`title`, `news_category_id`) VALUES
('Premier League', 1);
ALTER TABLE `news_sub_category`
    ADD CONSTRAINT `fk_news_sub_category_news_category1` FOREIGN KEY(`news_category_id`) REFERENCES `news_category`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `news_sub_category_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_sub_category_id` int(11) unsigned NOT NULL,
  `news_list` text NOT NULL,
  `selected_date` varchar(25) NOT NULL,
  `show_advertise` boolean DEFAULT TRUE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
ALTER TABLE `news_sub_category_configuration`
    ADD CONSTRAINT `fk_nscc_nsc1` FOREIGN KEY(`news_sub_category_id`) REFERENCES `news_sub_category`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `news_home_page_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_list` text NOT NULL,
  `selected_date` varchar(25) NOT NULL,
  `show_advertise` boolean DEFAULT TRUE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
	
CREATE TABLE `news_comments`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `comment` varchar(1000) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `news_id` int(11) unsigned NOT NULL,
  `rate_id` int(11) unsigned NOT NULL,
  `liked_user_list` text,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`) 
)AUTO_INCREMENT=1;
ALTER TABLE `news_comments`
    ADD CONSTRAINT `fk_news_comments_users1` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_news_comments_news1` FOREIGN KEY(`news_id`) REFERENCES `news`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;


CREATE TABLE `latest_news`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `news_list` text,
  `created_on` int(11) DEFAULT NULL,
  `date`  date NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;

CREATE TABLE `breaking_news`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `news_list` text,
  `created_on` int(11) DEFAULT NULL,
  `date` date NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;

CREATE TABLE `news_home_page`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `news_list` text,
  `date` varchar(50) DEFAULT NULL,
  PRIMARY KEY(`id`) 
)AUTO_INCREMENT=1;

-- blog application
CREATE TABLE `blog_custom_category`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;
INSERT INTO `blog_custom_category` (`title`) VALUES
('Home'),
('Write blog'),
('My blogs');

CREATE TABLE `blog_category`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `blog_list` text,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;
INSERT INTO `blog_category` (`title`) VALUES
('HEALTH'),
('SPORTS'),
('FITNESS'),
('NUTRITION'),
('WEIGHT LOSS'),
('DIETS'),
('STYLE & BEAUTY'),
('TREATMENT'),
('LIFESTYLES'),
('WELLBEING');

CREATE TABLE `blog_status`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;
INSERT INTO `blog_status` (`title`) VALUES
('Pending'),
('Approved'),
('Re-approval'),
('Deletion pending'),
('Modified'),
('Deleted');

CREATE TABLE `blogs`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `blog_category_id` int(11) unsigned DEFAULT NULL,
  `blog_status_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `title` varchar(5000) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `picture` text,
  `picture_description` text default '',
  `order_no` int(11) DEFAULT 99999999,
  `related_posts` text DEFAULT '',
  `reference_id` int(11) unsigned DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;
ALTER TABLE `blogs`
    ADD CONSTRAINT `fk_blogs_blog_status1` FOREIGN KEY(`blog_status_id`) REFERENCES `blog_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_blogs_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `blogs` (`id`, `blog_status_id`, `user_id`, `title`, `description`, `picture`, `related_posts`, `created_on`, `modified_on`) VALUES
(1, 2, 3, '&amp;lt;p&amp;gt;I&amp;amp;#39;m Not Alone&amp;lt;/p&amp;gt;', '&amp;lt;p&amp;gt;One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections. The bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked.&amp;lt;/p&amp;gt;', '1.jpg', '[""]', 1399982767, NULL),
(2, 2, 3, '&amp;lt;p&amp;gt;Cool car wallpapers&amp;lt;/p&amp;gt;', '&amp;lt;p&amp;gt;Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn&amp;amp;rsquo;t listen. She packed her seven versalia, put her initial into the belt and made herself on the way.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;lt;br /&amp;gt;\r\nWhen she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane. Pityful a rethoric question ran over her cheek, then she continued her way.&amp;lt;/p&amp;gt;', '5.jpg', '["42"]', 1399982862, NULL),
(3, 2, 3, '&amp;lt;p&amp;gt;Beatifull girl&amp;lt;/p&amp;gt;', '&amp;lt;p&amp;gt;One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;The bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked.&amp;lt;/p&amp;gt;', '4.jpg', '["43"]', 1399983068, NULL),
(4, 2, 3, '&amp;lt;p&amp;gt;Nutrition&amp;lt;/p&amp;gt;', '&amp;lt;p&amp;gt;Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;lt;br /&amp;gt;\r\nEven the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.&amp;lt;/p&amp;gt;', '1.jpg', '[""]', 1399983353, NULL),
(5, 2, 3, 'My first photoshoot', '&amp;lt;p&amp;gt;One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;The bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked.&amp;lt;/p&amp;gt;', '2.jpg', '[""]', 1399983426, 1399983747),
(6, 2, 3, 'Cutest doggy ever', '&amp;lt;p&amp;gt;When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Pityful a rethoric question ran over her cheek, then she continued her way. On her way she met a copy.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;lt;br /&amp;gt;\r\nThe copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word &amp;amp;ldquo;and&amp;amp;rdquo; and the Little Blind Text should turn around and return to its own, safe country.&amp;lt;/p&amp;gt;', '6.jpg', '[""]', 1399983497, 1399983636),
(7, 2, 3, 'I''m not alone', 'One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin.\r\n\r\nHe lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections.\r\n\r\nThe bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked.', '1.jpg', '[""]', 1399984646, NULL),
(8, 2, 3, 'u are alone', 'He found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections.\r\n\r\nThe bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked.', '5.jpg', '[""]', 1399984646, NULL),
(9, 2, 3, 'Food poisoning', '&amp;lt;p&amp;gt;Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;lt;br /&amp;gt;\r\nEven the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.&amp;lt;/p&amp;gt;', '1.jpg', '[""]', 1399983353, NULL);
CREATE TABLE IF NOT EXISTS `blog_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `blog_id` int(11) unsigned NOT NULL,
  `comment` varchar(5000) NOT NULL,
  `rate_id` int(11) NOT NULL,
  `liked_user_list` text,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`) 
);
ALTER TABLE `blog_comments`
    ADD CONSTRAINT `fk_blog_comments_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_blog_comments_blogs1` FOREIGN KEY(`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
	
CREATE TABLE IF NOT EXISTS `blog_configure_homepage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_list` text NOT NULL,
  `selected_date` varchar(25) NOT NULL,
  `show_advertise_home_page` boolean DEFAULT TRUE,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- BMI Calculator
CREATE TABLE `bmi_questions`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;
INSERT INTO `bmi_questions` (`question`, `answer`) VALUES
('What does BMI mean?', 'BMI stands for Body Mass Index. It gives you an idea of whether you\'re underweight, overweight or an ideal weight for your heifht. It\'s useful to know because when your weight increases (or decreases) outside of the ideal range, health risks may also increase.'),
('How do I calculate my BMI?', 'Select your gender and preferred unit of measurement using the calculator below. Then use the sliders to enter your height and weight. Click on \'calculate\' to work out your BMI and see what your result could mean.'),
('How accurate is the BMI?', 'BMI stands for Body Mass Index. It gives you an idea of whether upu\'re underweight, overweight or an ideal weight for your height. It\'s useful to know because when your weight increases( or decreases) outside of the ideal range, health risks may also increase.');
CREATE TABLE IF NOT EXISTS `bmi_home_page_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_list` text NOT NULL,
  `selected_date` varchar(25) NOT NULL,
  `show_advertise` boolean DEFAULT TRUE,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- Photography Application
CREATE TABLE `photography`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `text1` varchar(500) NOT NULL,
  `text2` varchar(500) NOT NULL,
  `text3` varchar(500) NOT NULL,
  `text4` varchar(500) NOT NULL,
  `text5` varchar(500) NOT NULL,
  `text6` varchar(500) NOT NULL,
  `img` varchar(500) NOT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;
-- score prediction
CREATE TABLE IF NOT EXISTS `app_sp_sports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_sp_sports` (`id`, `title`) VALUES
(1, 'Football'),
(2, 'Baseball'),
(3, 'Formula 1'),
(4, 'Basketball'),
(5, 'Boxing'),
(6, 'Tennis'),
(7, 'Cricket'),
(8, 'Rugby');
CREATE TABLE IF NOT EXISTS `app_sp_teams` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `sports_id` int(11) unsigned NOT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_app_sp_teams_sports1_idx` (`sports_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_sp_teams`
    ADD CONSTRAINT `fk_app_sp_teams_sports1` FOREIGN KEY(`sports_id`) REFERENCES `app_sp_sports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `app_sp_teams` (`id`, `sports_id`, `title`) VALUES
(1, 1, 'Chelsea'),
(2, 1, 'Southampton'),
(3, 1, 'Aston Villa'),
(4, 1, 'Arsenal'),
(5, 1, 'Swansea'),
(6, 1, 'Man City'),
(7, 1, 'Leicester'),
(8, 1, 'West Ham'),
(9, 1, 'Tottenham'),
(10, 1, 'Hull');

CREATE TABLE IF NOT EXISTS `app_sp_tournaments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sports_id` int(11) unsigned NOT NULL,
  `title` varchar(200),
  `season` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_app_sp_tournaments` (`title`, `season`),
  KEY `fk_app_sp_tournaments_sports1_idx` (`sports_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_sp_tournaments`
    ADD CONSTRAINT `fk_app_sp_tournaments_sports1` FOREIGN KEY(`sports_id`) REFERENCES `app_sp_sports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `app_sp_tournaments` (`id`, `sports_id`, `title`, `season`) VALUES
(1, 1, 'Barclays premier league', '2014/15'),
(2, 1, 'Championship', '2014/15'),
(3, 1, 'League one', '2014/15');

CREATE TABLE IF NOT EXISTS `app_sp_match_statuses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_sp_match_statuses` (`id`, `title`) VALUES
(1, 'Upcoming'),
(2, 'Win home'),
(3, 'Win away'),
(4, 'Draw'),
(5, 'Cancel');

CREATE TABLE IF NOT EXISTS `app_sp_matches` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tournament_id` int(11) unsigned NOT NULL,
  `team_id_home` int(11) unsigned NOT NULL,
  `team_id_away` int(11) unsigned NOT NULL,
  `date` varchar(200),
  `time` varchar(200),
  `score_home` varchar(200) default '',
  `score_away` varchar(200) default '',
  `status_id` int(11) unsigned DEFAULT 1,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_app_sp_matches_tournaments1_idx` (`tournament_id`),
  KEY `fk_app_sp_matches_teams1_idx` (`team_id_home`),
  KEY `fk_app_sp_matches_teams2_idx` (`team_id_away`),
  KEY `fk_app_sp_matches_statuses1_idx` (`status_id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_sp_matches`
    ADD CONSTRAINT `fk_app_sp_matches_tournaments1` FOREIGN KEY(`tournament_id`) REFERENCES `app_sp_tournaments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_app_sp_matches_teams1` FOREIGN KEY(`team_id_home`) REFERENCES `app_sp_teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_app_sp_matches_teams2` FOREIGN KEY(`team_id_away`) REFERENCES `app_sp_teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_app_sp_matches_statuses1` FOREIGN KEY(`status_id`) REFERENCES `app_sp_match_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `app_sp_matches` (`id`, `tournament_id`, `team_id_home`, `team_id_away`, `date`, `time`) VALUES
(1, 1, 1, 2, '2014-06-17', '09:00'),
(2, 1, 3, 4, '2014-06-17', '11:00');
CREATE TABLE IF NOT EXISTS `app_sp_match_predictions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `status_id` int(11) unsigned DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_sp_match_predictions_matches1_idx` (`match_id`),
  KEY `app_sp_match_predictions_users1_idx` (`user_id`),
  KEY `app_sp_match_predictions_statuses1_idx` (`status_id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_sp_match_predictions`
	ADD CONSTRAINT `app_sp_match_predictions_matches1` FOREIGN KEY(`match_id`) REFERENCES `app_sp_matches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_sp_match_predictions_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_sp_match_predictions_statuses1` FOREIGN KEY(`status_id`) REFERENCES `app_sp_match_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
CREATE TABLE IF NOT EXISTS `app_sp_configure_homepage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sports_id` int(11) unsigned NOT NULL,
  `selected_date` varchar(25) NOT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_app_sp_configure_homepage_sports1_idx` (`sports_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
ALTER TABLE `app_sp_configure_homepage`
    ADD CONSTRAINT `fk_app_sp_configure_homepage_sports1` FOREIGN KEY(`sports_id`) REFERENCES `app_sp_sports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
-- Visitor log
CREATE TABLE `pages`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;
INSERT INTO `pages` (`title`) VALUES
('Newsfeed'),
('Profile'),
('Message'),
('Photo'),
('Followers');
CREATE TABLE IF NOT EXISTS `page_visitor` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `access_history` text,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`) 
);
ALTER TABLE `page_visitor`
    ADD CONSTRAINT `fk_page_visitor_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_page_visitor_pages1` FOREIGN KEY(`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `application_visitor` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `application_id` int(11) unsigned NOT NULL,
  `access_history` text,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`) 
);
ALTER TABLE `application_visitor`
    ADD CONSTRAINT `fk_application_visitor_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_application_visitor_applications1` FOREIGN KEY(`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
	
CREATE TABLE IF NOT EXISTS `business_profile_visitor` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `business_profile_id` int(11) unsigned NOT NULL,
  `access_history` text,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`) 
);
ALTER TABLE `business_profile_visitor`
    ADD CONSTRAINT `fk_business_profile_visitor_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_business_profile_visitor_business_profile1` FOREIGN KEY(`business_profile_id`) REFERENCES `business_profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- user logs	
CREATE TABLE IF NOT EXISTS `user_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `date` varchar(25) NOT NULL,
  `log_history` text,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`) 
);
ALTER TABLE `user_log`
    ADD CONSTRAINT `fk_user_log_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `user_profile_photos`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `photo_list` text,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`) 
);

ALTER TABLE `user_profile_photos`
    ADD CONSTRAINT `user_profile_photos_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
	
-- chat application
CREATE TABLE `chat_category`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;
INSERT INTO `chat_category` (`title`) VALUES
('Room'),
('Group');
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `chat_category_id` int(11) unsigned NOT NULL,
  `reference_id` int(11) unsigned DEFAULT NULL,
  `message_list` text,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `chat_messages`
    ADD CONSTRAINT `fk_chat_messages_chat_category1` FOREIGN KEY(`chat_category_id`) REFERENCES `chat_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
-- configureable login page content
CREATE TABLE IF NOT EXISTS `configure_login_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_description` varchar(500) NOT NULL,
  `img` varchar(500) NOT NULL,
  `selected_date` varchar(25) NOT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
INSERT INTO `configure_login_page` (`img_description`, `img`, `selected_date`) VALUES
('Timothy Ward - Krisana Thai Boxing Gym', 'index1376265189.jpg', '25-07-2014');

-- configureable logout page content
CREATE TABLE IF NOT EXISTS `configure_logout_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(500) NOT NULL,
  `selected_date` varchar(25) NOT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
INSERT INTO `configure_logout_page` (`img`, `selected_date`) VALUES
('logout.png', '25-07-2014');

-- photo section
CREATE TABLE IF NOT EXISTS `albums_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(200),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `albums_categories` (`description`) VALUES
('user'),
('business profile');

CREATE TABLE IF NOT EXISTS `albums_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `album_category_id` int(11) unsigned DEFAULT NULL,
  `description` varchar(200),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `albums_types`
    ADD CONSTRAINT `fk_albums_types_albums_categories1` FOREIGN KEY(`album_category_id`) REFERENCES `albums_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `albums_types` (`id`, `album_category_id`, `description`) VALUES
(1, 1, 'user photos'),
(2, 1, 'user profile photos'),
(3, 1, 'user status photos'),
(4, 1, 'user album photos'),
(5, 2, 'business profile photos'),
(6, 2, 'business profile album photos');

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `reference_id` int(11) unsigned DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  `album_type_id` int(11) unsigned DEFAULT NULL,
  `creation_complete` boolean DEFAULT FALSE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `albums`
    ADD CONSTRAINT `fk_albums_albums_types1` FOREIGN KEY(`album_type_id`) REFERENCES `albums_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
	
CREATE TABLE IF NOT EXISTS `albums_photos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `album_id` int(11) unsigned DEFAULT NULL,
  `description` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  `img` VARCHAR(200) NOT NULL,
  `feedbacks` text,
  `likes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `albums_photos`
    ADD CONSTRAINT `fk_albums_photos_albums1` FOREIGN KEY(`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
-- footer
CREATE TABLE IF NOT EXISTS `footer_about_us` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `text_region` text,
  `image_region` text,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`) 
);
CREATE TABLE IF NOT EXISTS `footer_cu_topics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(500),
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
CREATE TABLE IF NOT EXISTS `footer_cu_operating_systems` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(500),
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
CREATE TABLE IF NOT EXISTS `footer_cu_browsers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(500),
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
CREATE TABLE IF NOT EXISTS `footer_cu_feedbacks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) unsigned DEFAULT NULL,
  `os_id` int(11) unsigned DEFAULT NULL,
  `browser_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(500) default '',
  `email` varchar(500),
  `phone` varchar(500),
  `description` text default '',
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `footer_cu_feedbacks`
    ADD CONSTRAINT `fk_footer_cu_feedbacks_topics1` FOREIGN KEY(`topic_id`) REFERENCES `footer_cu_topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `footer_cu_feedbacks`
    ADD CONSTRAINT `fk_footer_cu_feedbacks_os1` FOREIGN KEY(`os_id`) REFERENCES `footer_cu_operating_systems` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `footer_cu_feedbacks`
    ADD CONSTRAINT `fk_footer_cu_feedbacks_browsers1` FOREIGN KEY(`browser_id`) REFERENCES `footer_cu_browsers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- trending feature
CREATE TABLE IF NOT EXISTS `hashtags` (
  `hashtag` varchar(300),
  `status_list` text,
  `counter` int(11) unsigned DEFAULT 0,
  PRIMARY KEY(`hashtag`) 
);