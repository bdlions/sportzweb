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
(3, 1, 3),
(4, 2, 3),
(5, 3, 3),
(6, 4, 2),
(7, 4, 3);

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
`order` int(11) DEFAULT 239,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=240 ;
-- 
-- Dumping data for table `countries`
-- 
INSERT INTO `countries` VALUES (1, 'US', 'United States', 1);
INSERT INTO `countries` VALUES (2, 'CA', 'Canada', 239);
INSERT INTO `countries` VALUES (3, 'AF', 'Afghanistan', 239);
INSERT INTO `countries` VALUES (4, 'AL', 'Albania', 239);
INSERT INTO `countries` VALUES (5, 'DZ', 'Algeria', 239);
INSERT INTO `countries` VALUES (6, 'DS', 'American Samoa', 239);
INSERT INTO `countries` VALUES (7, 'AD', 'Andorra', 239);
INSERT INTO `countries` VALUES (8, 'AO', 'Angola', 239);
INSERT INTO `countries` VALUES (9, 'AI', 'Anguilla', 239);
INSERT INTO `countries` VALUES (10, 'AQ', 'Antarctica', 239);
INSERT INTO `countries` VALUES (11, 'AG', 'Antigua and/or Barbuda', 239);
INSERT INTO `countries` VALUES (12, 'AR', 'Argentina', 239);
INSERT INTO `countries` VALUES (13, 'AM', 'Armenia', 239);
INSERT INTO `countries` VALUES (14, 'AW', 'Aruba', 239);
INSERT INTO `countries` VALUES (15, 'AU', 'Australia', 239);
INSERT INTO `countries` VALUES (16, 'AT', 'Austria', 239);
INSERT INTO `countries` VALUES (17, 'AZ', 'Azerbaijan', 239);
INSERT INTO `countries` VALUES (18, 'BS', 'Bahamas', 239);
INSERT INTO `countries` VALUES (19, 'BH', 'Bahrain', 239);
INSERT INTO `countries` VALUES (20, 'BD', 'Bangladesh', 239);
INSERT INTO `countries` VALUES (21, 'BB', 'Barbados', 239);
INSERT INTO `countries` VALUES (22, 'BY', 'Belarus', 239);
INSERT INTO `countries` VALUES (23, 'BE', 'Belgium', 239);
INSERT INTO `countries` VALUES (24, 'BZ', 'Belize', 239);
INSERT INTO `countries` VALUES (25, 'BJ', 'Benin', 239);
INSERT INTO `countries` VALUES (26, 'BM', 'Bermuda', 239);
INSERT INTO `countries` VALUES (27, 'BT', 'Bhutan', 239);
INSERT INTO `countries` VALUES (28, 'BO', 'Bolivia', 239);
INSERT INTO `countries` VALUES (29, 'BA', 'Bosnia and Herzegovina', 239);
INSERT INTO `countries` VALUES (30, 'BW', 'Botswana', 239);
INSERT INTO `countries` VALUES (31, 'BV', 'Bouvet Island', 239);
INSERT INTO `countries` VALUES (32, 'BR', 'Brazil', 239);
INSERT INTO `countries` VALUES (33, 'IO', 'British lndian Ocean Territory', 239);
INSERT INTO `countries` VALUES (34, 'BN', 'Brunei Darussalam', 239);
INSERT INTO `countries` VALUES (35, 'BG', 'Bulgaria', 239);
INSERT INTO `countries` VALUES (36, 'BF', 'Burkina Faso', 239);
INSERT INTO `countries` VALUES (37, 'BI', 'Burundi', 239);
INSERT INTO `countries` VALUES (38, 'KH', 'Cambodia', 239);
INSERT INTO `countries` VALUES (39, 'CM', 'Cameroon', 239);
INSERT INTO `countries` VALUES (40, 'CV', 'Cape Verde', 239);
INSERT INTO `countries` VALUES (41, 'KY', 'Cayman Islands', 239);
INSERT INTO `countries` VALUES (42, 'CF', 'Central African Republic', 239);
INSERT INTO `countries` VALUES (43, 'TD', 'Chad', 239);
INSERT INTO `countries` VALUES (44, 'CL', 'Chile', 239);
INSERT INTO `countries` VALUES (45, 'CN', 'China', 239);
INSERT INTO `countries` VALUES (46, 'CX', 'Christmas Island', 239);
INSERT INTO `countries` VALUES (47, 'CC', 'Cocos (Keeling) Islands', 239);
INSERT INTO `countries` VALUES (48, 'CO', 'Colombia', 239);
INSERT INTO `countries` VALUES (49, 'KM', 'Comoros', 239);
INSERT INTO `countries` VALUES (50, 'CG', 'Congo', 239);
INSERT INTO `countries` VALUES (51, 'CK', 'Cook Islands', 239);
INSERT INTO `countries` VALUES (52, 'CR', 'Costa Rica', 239);
INSERT INTO `countries` VALUES (53, 'HR', 'Croatia (Hrvatska)', 239);
INSERT INTO `countries` VALUES (54, 'CU', 'Cuba', 239);
INSERT INTO `countries` VALUES (55, 'CY', 'Cyprus', 239);
INSERT INTO `countries` VALUES (56, 'CZ', 'Czech Republic', 239);
INSERT INTO `countries` VALUES (57, 'DK', 'Denmark', 239);
INSERT INTO `countries` VALUES (58, 'DJ', 'Djibouti', 239);
INSERT INTO `countries` VALUES (59, 'DM', 'Dominica', 239);
INSERT INTO `countries` VALUES (60, 'DO', 'Dominican Republic', 239);
INSERT INTO `countries` VALUES (61, 'TP', 'East Timor', 239);
INSERT INTO `countries` VALUES (62, 'EC', 'Ecudaor', 239);
INSERT INTO `countries` VALUES (63, 'EG', 'Egypt', 239);
INSERT INTO `countries` VALUES (64, 'SV', 'El Salvador', 239);
INSERT INTO `countries` VALUES (65, 'GQ', 'Equatorial Guinea', 239);
INSERT INTO `countries` VALUES (66, 'ER', 'Eritrea', 239);
INSERT INTO `countries` VALUES (67, 'EE', 'Estonia', 239);
INSERT INTO `countries` VALUES (68, 'ET', 'Ethiopia', 239);
INSERT INTO `countries` VALUES (69, 'FK', 'Falkland Islands (Malvinas)', 239);
INSERT INTO `countries` VALUES (70, 'FO', 'Faroe Islands', 239);
INSERT INTO `countries` VALUES (71, 'FJ', 'Fiji', 239);
INSERT INTO `countries` VALUES (72, 'FI', 'Finland', 239);
INSERT INTO `countries` VALUES (73, 'FR', 'France', 239);
INSERT INTO `countries` VALUES (74, 'FX', 'France, Metropolitan', 239);
INSERT INTO `countries` VALUES (75, 'GF', 'French Guiana', 239);
INSERT INTO `countries` VALUES (76, 'PF', 'French Polynesia', 239);
INSERT INTO `countries` VALUES (77, 'TF', 'French Southern Territories', 239);
INSERT INTO `countries` VALUES (78, 'GA', 'Gabon', 239);
INSERT INTO `countries` VALUES (79, 'GM', 'Gambia', 239);
INSERT INTO `countries` VALUES (80, 'GE', 'Georgia', 239);
INSERT INTO `countries` VALUES (81, 'DE', 'Germany', 239);
INSERT INTO `countries` VALUES (82, 'GH', 'Ghana', 239);
INSERT INTO `countries` VALUES (83, 'GI', 'Gibraltar', 239);
INSERT INTO `countries` VALUES (84, 'GR', 'Greece', 239);
INSERT INTO `countries` VALUES (85, 'GL', 'Greenland', 239);
INSERT INTO `countries` VALUES (86, 'GD', 'Grenada', 239);
INSERT INTO `countries` VALUES (87, 'GP', 'Guadeloupe', 239);
INSERT INTO `countries` VALUES (88, 'GU', 'Guam', 239);
INSERT INTO `countries` VALUES (89, 'GT', 'Guatemala', 239);
INSERT INTO `countries` VALUES (90, 'GN', 'Guinea', 239);
INSERT INTO `countries` VALUES (91, 'GW', 'Guinea-Bissau', 239);
INSERT INTO `countries` VALUES (92, 'GY', 'Guyana', 239);
INSERT INTO `countries` VALUES (93, 'HT', 'Haiti', 239);
INSERT INTO `countries` VALUES (94, 'HM', 'Heard and Mc Donald Islands', 239);
INSERT INTO `countries` VALUES (95, 'HN', 'Honduras', 239);
INSERT INTO `countries` VALUES (96, 'HK', 'Hong Kong', 239);
INSERT INTO `countries` VALUES (97, 'HU', 'Hungary', 239);
INSERT INTO `countries` VALUES (98, 'IS', 'Iceland', 239);
INSERT INTO `countries` VALUES (99, 'IN', 'India', 239);
INSERT INTO `countries` VALUES (100, 'ID', 'Indonesia', 239);
INSERT INTO `countries` VALUES (101, 'IR', 'Iran (Islamic Republic of)', 239);
INSERT INTO `countries` VALUES (102, 'IQ', 'Iraq', 239);
INSERT INTO `countries` VALUES (103, 'IE', 'Ireland', 239);
INSERT INTO `countries` VALUES (104, 'IL', 'Israel', 239);
INSERT INTO `countries` VALUES (105, 'IT', 'Italy', 239);
INSERT INTO `countries` VALUES (106, 'CI', 'Ivory Coast', 239);
INSERT INTO `countries` VALUES (107, 'JM', 'Jamaica', 239);
INSERT INTO `countries` VALUES (108, 'JP', 'Japan', 239);
INSERT INTO `countries` VALUES (109, 'JO', 'Jordan', 239);
INSERT INTO `countries` VALUES (110, 'KZ', 'Kazakhstan', 239);
INSERT INTO `countries` VALUES (111, 'KE', 'Kenya', 239);
INSERT INTO `countries` VALUES (112, 'KI', 'Kiribati', 239);
INSERT INTO `countries` VALUES (113, 'KP', 'Korea, Democratic People''s Republic of', 239);
INSERT INTO `countries` VALUES (114, 'KR', 'Korea, Republic of', 239);
INSERT INTO `countries` VALUES (115, 'KW', 'Kuwait', 239);
INSERT INTO `countries` VALUES (116, 'KG', 'Kyrgyzstan', 239);
INSERT INTO `countries` VALUES (117, 'LA', 'Lao People''s Democratic Republic', 239);
INSERT INTO `countries` VALUES (118, 'LV', 'Latvia', 239);
INSERT INTO `countries` VALUES (119, 'LB', 'Lebanon', 239);
INSERT INTO `countries` VALUES (120, 'LS', 'Lesotho', 239);
INSERT INTO `countries` VALUES (121, 'LR', 'Liberia', 239);
INSERT INTO `countries` VALUES (122, 'LY', 'Libyan Arab Jamahiriya', 239);
INSERT INTO `countries` VALUES (123, 'LI', 'Liechtenstein', 239);
INSERT INTO `countries` VALUES (124, 'LT', 'Lithuania', 239);
INSERT INTO `countries` VALUES (125, 'LU', 'Luxembourg', 239);
INSERT INTO `countries` VALUES (126, 'MO', 'Macau', 239);
INSERT INTO `countries` VALUES (127, 'MK', 'Macedonia', 239);
INSERT INTO `countries` VALUES (128, 'MG', 'Madagascar', 239);
INSERT INTO `countries` VALUES (129, 'MW', 'Malawi', 239);
INSERT INTO `countries` VALUES (130, 'MY', 'Malaysia', 239);
INSERT INTO `countries` VALUES (131, 'MV', 'Maldives', 239);
INSERT INTO `countries` VALUES (132, 'ML', 'Mali', 239);
INSERT INTO `countries` VALUES (133, 'MT', 'Malta', 239);
INSERT INTO `countries` VALUES (134, 'MH', 'Marshall Islands', 239);
INSERT INTO `countries` VALUES (135, 'MQ', 'Martinique', 239);
INSERT INTO `countries` VALUES (136, 'MR', 'Mauritania', 239);
INSERT INTO `countries` VALUES (137, 'MU', 'Mauritius', 239);
INSERT INTO `countries` VALUES (138, 'TY', 'Mayotte', 239);
INSERT INTO `countries` VALUES (139, 'MX', 'Mexico', 239);
INSERT INTO `countries` VALUES (140, 'FM', 'Micronesia, Federated States of', 239);
INSERT INTO `countries` VALUES (141, 'MD', 'Moldova, Republic of', 239);
INSERT INTO `countries` VALUES (142, 'MC', 'Monaco', 239);
INSERT INTO `countries` VALUES (143, 'MN', 'Mongolia', 239);
INSERT INTO `countries` VALUES (144, 'MS', 'Montserrat', 239);
INSERT INTO `countries` VALUES (145, 'MA', 'Morocco', 239);
INSERT INTO `countries` VALUES (146, 'MZ', 'Mozambique', 239);
INSERT INTO `countries` VALUES (147, 'MM', 'Myanmar', 239);
INSERT INTO `countries` VALUES (148, 'NA', 'Namibia', 239);
INSERT INTO `countries` VALUES (149, 'NR', 'Nauru', 239);
INSERT INTO `countries` VALUES (150, 'NP', 'Nepal', 239);
INSERT INTO `countries` VALUES (151, 'NL', 'Netherlands', 239);
INSERT INTO `countries` VALUES (152, 'AN', 'Netherlands Antilles', 239);
INSERT INTO `countries` VALUES (153, 'NC', 'New Caledonia', 239);
INSERT INTO `countries` VALUES (154, 'NZ', 'New Zealand', 239);
INSERT INTO `countries` VALUES (155, 'NI', 'Nicaragua', 239);
INSERT INTO `countries` VALUES (156, 'NE', 'Niger', 239);
INSERT INTO `countries` VALUES (157, 'NG', 'Nigeria', 239);
INSERT INTO `countries` VALUES (158, 'NU', 'Niue', 239);
INSERT INTO `countries` VALUES (159, 'NF', 'Norfork Island', 239);
INSERT INTO `countries` VALUES (160, 'MP', 'Northern Mariana Islands', 239);
INSERT INTO `countries` VALUES (161, 'NO', 'Norway', 239);
INSERT INTO `countries` VALUES (162, 'OM', 'Oman', 239);
INSERT INTO `countries` VALUES (163, 'PK', 'Pakistan', 239);
INSERT INTO `countries` VALUES (164, 'PW', 'Palau', 239);
INSERT INTO `countries` VALUES (165, 'PA', 'Panama', 239);
INSERT INTO `countries` VALUES (166, 'PG', 'Papua New Guinea', 239);
INSERT INTO `countries` VALUES (167, 'PY', 'Paraguay', 239);
INSERT INTO `countries` VALUES (168, 'PE', 'Peru', 239);
INSERT INTO `countries` VALUES (169, 'PH', 'Philippines', 239);
INSERT INTO `countries` VALUES (170, 'PN', 'Pitcairn', 239);
INSERT INTO `countries` VALUES (171, 'PL', 'Poland', 239);
INSERT INTO `countries` VALUES (172, 'PT', 'Portugal', 239);
INSERT INTO `countries` VALUES (173, 'PR', 'Puerto Rico', 239);
INSERT INTO `countries` VALUES (174, 'QA', 'Qatar', 239);
INSERT INTO `countries` VALUES (175, 'RE', 'Reunion', 239);
INSERT INTO `countries` VALUES (176, 'RO', 'Romania', 239);
INSERT INTO `countries` VALUES (177, 'RU', 'Russian Federation', 239);
INSERT INTO `countries` VALUES (178, 'RW', 'Rwanda', 239);
INSERT INTO `countries` VALUES (179, 'KN', 'Saint Kitts and Nevis', 239);
INSERT INTO `countries` VALUES (180, 'LC', 'Saint Lucia', 239);
INSERT INTO `countries` VALUES (181, 'VC', 'Saint Vincent and the Grenadines', 239);
INSERT INTO `countries` VALUES (182, 'WS', 'Samoa', 239);
INSERT INTO `countries` VALUES (183, 'SM', 'San Marino', 239);
INSERT INTO `countries` VALUES (184, 'ST', 'Sao Tome and Principe', 239);
INSERT INTO `countries` VALUES (185, 'SA', 'Saudi Arabia', 239);
INSERT INTO `countries` VALUES (186, 'SN', 'Senegal', 239);
INSERT INTO `countries` VALUES (187, 'SC', 'Seychelles', 239);
INSERT INTO `countries` VALUES (188, 'SL', 'Sierra Leone', 239);
INSERT INTO `countries` VALUES (189, 'SG', 'Singapore', 239);
INSERT INTO `countries` VALUES (190, 'SK', 'Slovakia', 239);
INSERT INTO `countries` VALUES (191, 'SI', 'Slovenia', 239);
INSERT INTO `countries` VALUES (192, 'SB', 'Solomon Islands', 239);
INSERT INTO `countries` VALUES (193, 'SO', 'Somalia', 239);
INSERT INTO `countries` VALUES (194, 'ZA', 'South Africa', 239);
INSERT INTO `countries` VALUES (195, 'GS', 'South Georgia South Sandwich Islands', 239);
INSERT INTO `countries` VALUES (196, 'ES', 'Spain', 239);
INSERT INTO `countries` VALUES (197, 'LK', 'Sri Lanka', 239);
INSERT INTO `countries` VALUES (198, 'SH', 'St. Helena', 239);
INSERT INTO `countries` VALUES (199, 'PM', 'St. Pierre and Miquelon', 239);
INSERT INTO `countries` VALUES (200, 'SD', 'Sudan', 239);
INSERT INTO `countries` VALUES (201, 'SR', 'Suriname', 239);
INSERT INTO `countries` VALUES (202, 'SJ', 'Svalbarn and Jan Mayen Islands', 239);
INSERT INTO `countries` VALUES (203, 'SZ', 'Swaziland', 239);
INSERT INTO `countries` VALUES (204, 'SE', 'Sweden', 239);
INSERT INTO `countries` VALUES (205, 'CH', 'Switzerland', 239);
INSERT INTO `countries` VALUES (206, 'SY', 'Syrian Arab Republic', 239);
INSERT INTO `countries` VALUES (207, 'TW', 'Taiwan', 239);
INSERT INTO `countries` VALUES (208, 'TJ', 'Tajikistan', 239);
INSERT INTO `countries` VALUES (209, 'TZ', 'Tanzania, United Republic of', 239);
INSERT INTO `countries` VALUES (210, 'TH', 'Thailand', 239);
INSERT INTO `countries` VALUES (211, 'TG', 'Togo', 239);
INSERT INTO `countries` VALUES (212, 'TK', 'Tokelau', 239);
INSERT INTO `countries` VALUES (213, 'TO', 'Tonga', 239);
INSERT INTO `countries` VALUES (214, 'TT', 'Trinidad and Tobago', 239);
INSERT INTO `countries` VALUES (215, 'TN', 'Tunisia', 239);
INSERT INTO `countries` VALUES (216, 'TR', 'Turkey', 239);
INSERT INTO `countries` VALUES (217, 'TM', 'Turkmenistan', 239);
INSERT INTO `countries` VALUES (218, 'TC', 'Turks and Caicos Islands', 239);
INSERT INTO `countries` VALUES (219, 'TV', 'Tuvalu', 239);
INSERT INTO `countries` VALUES (220, 'UG', 'Uganda', 239);
INSERT INTO `countries` VALUES (221, 'UA', 'Ukraine', 239);
INSERT INTO `countries` VALUES (222, 'AE', 'United Arab Emirates', 239);
INSERT INTO `countries` VALUES (223, 'GB', 'United Kingdom', 2);
INSERT INTO `countries` VALUES (224, 'UM', 'United States minor outlying islands', 239);
INSERT INTO `countries` VALUES (225, 'UY', 'Uruguay', 239);
INSERT INTO `countries` VALUES (226, 'UZ', 'Uzbekistan', 239);
INSERT INTO `countries` VALUES (227, 'VU', 'Vanuatu', 239);
INSERT INTO `countries` VALUES (228, 'VA', 'Vatican City State', 239);
INSERT INTO `countries` VALUES (229, 'VE', 'Venezuela', 239);
INSERT INTO `countries` VALUES (230, 'VN', 'Vietnam', 239);
INSERT INTO `countries` VALUES (231, 'VG', 'Virigan Islands (British)', 239);
INSERT INTO `countries` VALUES (232, 'VI', 'Virgin Islands (U.S.)', 239);
INSERT INTO `countries` VALUES (233, 'WF', 'Wallis and Futuna Islands', 239);
INSERT INTO `countries` VALUES (234, 'EH', 'Western Sahara', 239);
INSERT INTO `countries` VALUES (235, 'YE', 'Yemen', 239);
INSERT INTO `countries` VALUES (236, 'YU', 'Yugoslavia', 239);
INSERT INTO `countries` VALUES (237, 'ZR', 'Zaire', 239);
INSERT INTO `countries` VALUES (238, 'ZM', 'Zambia', 239);
INSERT INTO `countries` VALUES (239, 'ZW', 'Zimbabwe', 239);

--
-- Table structure for table `basic_profile`
--

CREATE TABLE IF NOT EXISTS `basic_profile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `clg_or_uni` varchar(30),
  `employer` varchar(20),
  `gender_id` int(11) unsigned,
  `dob` varchar(30),
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
INSERT INTO `statuses` (`user_id`, `status_category_id`, `shared_type_id`, `description`, `created_on`, `modified_on`) VALUES
(1, 1, 7, 'Welcome to Sonuto', 1427345599, 1427345599),
(1, 1, 8, '', 1427345598, 1427345598),
(1, 1, 9, '', 1427345597, 1427345597),
(1, 1, 10, '', 1427345596, 1427345596),
(1, 1, 11, '', 1427345595, 1427345595),
(1, 1, 12, '', 1427345594, 1427345594),
(1, 1, 13, '', 1427345593, 1427345593),
(1, 1, 14, '', 1427345592, 1427345592),
(1, 1, 15, '', 1427345591, 1427345591),
(1, 1, 16, '', 1427345590, 1427345590),
(1, 1, 17, '', 1427345590, 1427345590);
	
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
  `order` int(11) Default 0,
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
(8, 'Score Prediction'),
(9, 'Shop'),
(10, 'Gympro');

-- application item reference site information
CREATE TABLE IF NOT EXISTS `app_item_reference_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(500),
  `img` varchar(200),
  `link` text default '',  
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_item_reference_list` (`title`, `img`, `link`) VALUES
('Sky Sports', 'sky_sports.png', '<a target="_blank" href="http://www.skysports.com">Sky Sports</a>');

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
  `reference_id` int(11) unsigned DEFAULT NULL,
  `title` varchar(500) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `duration` text DEFAULT '',
  `ingredients` text DEFAULT '',
  `preparation_method` text DEFAULT '',
  `main_picture` varchar(1000) DEFAULT '',
  `recommend_desserts` text DEFAULT '',
  `alternative_recipes` text DEFAULT '',
  `shared_text` varchar(2000) NOT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `recipes`
    ADD CONSTRAINT `fk_recipes_recipe_category1` FOREIGN KEY(`recipe_category_id`) REFERENCES `recipe_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_recipes_app_item_reference_list1` FOREIGN KEY(`reference_id`) REFERENCES `app_item_reference_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  `name` varchar(300) DEFAULT '',
  `title` varchar(300) DEFAULT '',
  `latitude` varchar(300) DEFAULT 0,
  `longitude` varchar(300) DEFAULT 0,
  `address` varchar(300) DEFAULT '',
  `city` varchar(100) DEFAULT '',
  `country_id` int(11) unsigned NOT NULL,
  `post_code` varchar(30) DEFAULT '', 
  `opening_hours` varchar(300) DEFAULT '',
  `telephone` varchar(20) DEFAULT '',
  `website` varchar(300) DEFAULT '',
  `business_profile_id` int(11) unsigned DEFAULT NULL,
  `picture` varchar(300) DEFAULT '',
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
  `reference_id` int(11) unsigned DEFAULT NULL,
  `headline` text DEFAULT '',
  `summary` text DEFAULT '',
  `description` text DEFAULT '',
  `picture` text,
  `picture_description` text default '',
  `news_date` varchar(50) DEFAULT NULL,
  `user_liked_list` text,
  `shared_text` varchar(2000) NOT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;
ALTER TABLE `news`
    ADD CONSTRAINT `fk_news_app_item_reference_list1` FOREIGN KEY(`reference_id`) REFERENCES `app_item_reference_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
	
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
CREATE TABLE `news_home_page`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `news_list` text,
  `date` varchar(50) DEFAULT NULL,
  PRIMARY KEY(`id`) 
)AUTO_INCREMENT=1;
CREATE TABLE `app_news_latest_news_configuration`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `news_list` text,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  `selected_date` varchar(25) NOT NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;
CREATE TABLE `app_news_breaking_news_configuration`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `news_list` text,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  `selected_date` varchar(25) NOT NULL,
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
  `ref_id` int(11) unsigned DEFAULT NULL,
  `blog_status_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `title` varchar(5000) NOT NULL,
  `description` text,
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
    ADD CONSTRAINT `fk_blogs_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `fk_blogs_app_item_reference_list1` FOREIGN KEY(`ref_id`) REFERENCES `app_item_reference_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
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
  `league_tbl_conf` text,
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
  `point_home` varchar(200) default '',
  `point_away` varchar(200) default '',
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
INSERT INTO `app_sp_matches` (`id`, `tournament_id`, `team_id_home`, `team_id_away`, `date`, `time`, `point_home`, `point_away`, `status_id`) VALUES
(1, 1, 1, 2, '2014-06-17', '09:00', '3', '0', '2'),
(2, 1, 3, 4, '2014-06-17', '11:00', '1', '1', '4'),
(3, 1, 3, 2, '2014-06-27', '12:00', '3', '0', '2');
CREATE TABLE IF NOT EXISTS `app_sp_match_predictions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(11) unsigned NOT NULL,
  `prediction_list` text NOT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_sp_match_predictions_matches1_idx` (`match_id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_sp_match_predictions`
	ADD CONSTRAINT `app_sp_match_predictions_matches1` FOREIGN KEY(`match_id`) REFERENCES `app_sp_matches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
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

-- gympro application
CREATE TABLE IF NOT EXISTS `app_gympro_account_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_account_types` (`title`) VALUES
('Client'),
('Personal Trainer');
CREATE TABLE IF NOT EXISTS `app_gympro_height_unit_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_height_unit_types` (`title`) VALUES
('Centimeters'),
('Feet & inches');
CREATE TABLE IF NOT EXISTS `app_gympro_weight_unit_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_weight_unit_types` (`title`) VALUES
('Kilograms'),
('Pounds');
CREATE TABLE IF NOT EXISTS `app_gympro_girth_unit_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_girth_unit_types` (`title`) VALUES
('Centimeters'),
('Inches');
CREATE TABLE IF NOT EXISTS `app_gympro_time_zones` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_time_zones` (`title`) VALUES
('-12:00'),
('-11:00'),
('-10:00'),
('-09:00'),
('-08:00'),
('-07:00'),
('-06:00'),
('-05:00'),
('-04:00'),
('-03:00'),
('-02:00'),
('-01:00'),
('+00:00'),
('+01:00'),
('+02:00'),
('+03:00'),
('+04:00'),
('+05:00'),
('+06:00'),
('+07:00'),
('+08:00'),
('+09:00'),
('+10:00'),
('+11:00'),
('+12:00');
CREATE TABLE IF NOT EXISTS `app_gympro_hourly_rates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_hourly_rates` (`title`) VALUES
('5'),
('10'),
('15'),
('20'),
('25'),
('30'),
('35'),
('40'),
('45'),
('50'),
('55'),
('60'),
('65'),
('70'),
('75'),
('80'),
('85'),
('90'),
('95'),
('100'),
('105'),
('110'),
('115'),
('120'),
('125'),
('130'),
('135'),
('140'),
('145'),
('150'),
('155'),
('160'),
('165'),
('170'),
('175'),
('180'),
('185'),
('190'),
('195'),
('200');
CREATE TABLE IF NOT EXISTS `app_gympro_currencies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `currency_code` varchar(50),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_currencies` (`title`, `currency_code`) VALUES
('&#36;', 'USD'),
('&#163;', 'GBP'),
('&#8364;', 'EUR');
CREATE TABLE IF NOT EXISTS `app_gympro_users` (
  `user_id` int(11) unsigned NOT NULL,
  `account_type_id` int(11) unsigned DEFAULT NULL,
  `height_unit_id` int(11) unsigned DEFAULT NULL,
  `weight_unit_id` int(11) unsigned DEFAULT NULL,
  `girth_unit_id` int(11) unsigned DEFAULT NULL,
  `time_zone_id` int(11) unsigned DEFAULT NULL,
  `hourly_rate_id` int(11) unsigned DEFAULT NULL,
  `currency_id` int(11) unsigned DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `app_gympro_users_u1_idx` (`user_id`),
  KEY `app_gympro_users_at1_idx` (`account_type_id`),
  KEY `app_gympro_users_hut1_idx` (`height_unit_id`),
  KEY `app_gympro_users_wut1_idx` (`weight_unit_id`),
  KEY `app_gympro_users_gut1_idx` (`girth_unit_id`),
  KEY `app_gympro_users_tz1_idx` (`time_zone_id`),
  KEY `app_gympro_users_hr1_idx` (`hourly_rate_id`),
  KEY `app_gympro_users_c1_idx` (`currency_id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_gympro_users`
	ADD CONSTRAINT `app_gympro_users_u1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,	
	ADD CONSTRAINT `app_gympro_users_at1` FOREIGN KEY(`account_type_id`) REFERENCES `app_gympro_account_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,	
	ADD CONSTRAINT `app_gympro_users_hut1` FOREIGN KEY(`height_unit_id`) REFERENCES `app_gympro_height_unit_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,	
	ADD CONSTRAINT `app_gympro_users_wut1` FOREIGN KEY(`weight_unit_id`) REFERENCES `app_gympro_weight_unit_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,	
	ADD CONSTRAINT `app_gympro_users_gut1` FOREIGN KEY(`girth_unit_id`) REFERENCES `app_gympro_girth_unit_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,	
	ADD CONSTRAINT `app_gympro_users_tz1` FOREIGN KEY(`time_zone_id`) REFERENCES `app_gympro_time_zones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,	
	ADD CONSTRAINT `app_gympro_users_hr1` FOREIGN KEY(`hourly_rate_id`) REFERENCES `app_gympro_hourly_rates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,	
	ADD CONSTRAINT `app_gympro_users_c1` FOREIGN KEY(`currency_id`) REFERENCES `app_gympro_currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;	
-- --------------------------------------------------------------- Client And Group Module ------------------------------------------------------ --
CREATE TABLE IF NOT EXISTS `app_gympro_health_questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `show_additional_info` boolean DEFAULT TRUE,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_health_questions` (`title`) VALUES
('Smoker?'),
('Blood pressure too high or too low?'),
('Any known cardiovascular problems?'),
('High cholesterol?'),
('Overweight?'),
('Any injuries or orthopaedic problems?'),
('Taking any prescribed medication or dietary supplements?'),
('Any other medical conditions or problems not previously mentioned?'),
('Drinking?');
CREATE TABLE IF NOT EXISTS `app_gympro_client_statuses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_client_statuses` (`title`) VALUES
('Active'),
('Inactive'),
('Potential');
CREATE TABLE IF NOT EXISTS `app_gympro_clients` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `member_id` int(11) unsigned NOT NULL,
  `gender_id` int(11) unsigned DEFAULT NULL,
  `start_date` varchar(200),
  `end_date` varchar(200),
  `status_id` int(11) unsigned DEFAULT NULL,
  `phone` varchar(200),
  `mobile` varchar(200),
  `picture` varchar(200),
  `address` text,
  `emergency_contact` varchar(200),
  `emergency_phone` varchar(200),
  `question_answer_list` text,
  `height` varchar(200),
  `resting_heart_rate` varchar(200),
  `blood_pressure` varchar(200),
  `notes` text,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_gympro_clients_u1_idx` (`user_id`),
  KEY `app_gympro_clients_u2_idx` (`member_id`),
  KEY `app_gympro_clients_gender1_idx` (`gender_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_gympro_clients`
	ADD CONSTRAINT `app_gympro_clients_u1` FOREIGN KEY(`user_id`) REFERENCES `app_gympro_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_gympro_clients_u2` FOREIGN KEY(`member_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_gympro_clients_gender1` FOREIGN KEY(`gender_id`) REFERENCES `gender` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
CREATE TABLE IF NOT EXISTS `app_gympro_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `title` varchar(200),
  `phone` varchar(200),
  `mobile` varchar(200),
  `notes` text,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_gympro_groups_u1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_gympro_groups`
	ADD CONSTRAINT `app_gympro_groups_u1` FOREIGN KEY(`user_id`) REFERENCES `app_gympro_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
CREATE TABLE IF NOT EXISTS `app_gympro_groups_clients` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned NOT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_gympro_groups_clients1_idx` (`client_id`),
  KEY `app_gympro_groups_clients2_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_gympro_groups_clients`
	ADD CONSTRAINT `app_gympro_groups_clients1` FOREIGN KEY(`client_id`) REFERENCES `app_gympro_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_gympro_groups_clients2` FOREIGN KEY(`group_id`) REFERENCES `app_gympro_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
-- --------------------------------------------------Program Module------------------------------------------------ --
CREATE TABLE IF NOT EXISTS `app_gympro_reviews` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_reviews` (`title`) VALUES
('2 weeks'),
('3 weeks'),
('4 weeks'),
('5 weeks'),
('6 weeks'),
('7 weeks'),
('8 weeks');
CREATE TABLE IF NOT EXISTS `app_gympro_exercise_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_exercise_categories` (`id`, `title`) VALUES
(1, 'Back'),
(2, 'Balance'),
(3, 'Bosu'),
(4, 'Cable'),
(5, 'Cardio'),
(6, 'Chest'),
(7, 'Combo'),
(8, 'Elastic'),
(9, 'Explosive'),
(10, 'Flexibility'),
(11, 'Forearm'),
(12, 'General Movement'),
(13, 'Hip'),
(14, 'Kettlebell'),
(15, 'Lower body'),
(16, 'Machine'),
(17, 'Medicine ball'),
(18, 'SAQ'),
(19, 'Shoulder'),
(20, 'Sled'),
(21, 'Swiss ball'),
(22, 'Testing'),
(23, 'Thigh'),
(24, 'Torso'),
(25, 'Upper Arm'),
(26, 'Yoga');
CREATE TABLE IF NOT EXISTS `app_gympro_exercise_subcategories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) unsigned NOT NULL,
  `title` varchar(200),
  `picture` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_gympro_exercise_subcategories_categories1_idx` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_gympro_exercise_subcategories`
	ADD CONSTRAINT `app_gympro_exercise_subcategories_categories1` FOREIGN KEY(`category_id`) REFERENCES `app_gympro_exercise_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `app_gympro_exercise_subcategories` (`category_id`, `title`,`picture`) VALUES
(1, 'Barbell Bent-over Row','1250301861_36560400.jpg'),
(1, 'Bend over DB row','1250907697_27384300.jpg'),
(1, 'Bend over T-bar row','1250907712_45029600.jpg'),
(1, 'Cable Underhand Pulldown','1208220623_49984300.jpg'),
(1, 'Chin Up','1208168069_79454200.jpg'),
(1, 'Dumbbell Bent-over Row','1208168252_23252400.jpg'),
(1, 'Hammer grip pull ups','1250302302_33446100.jpg'),
(1, 'Inverted row with feet up','1250907732_12647200.jpg'),
(1, 'Lat Pulldown','1208238986_02375800.jpg'),
(1, 'Lying Down Incline Pull Up','1208221570_05210900.jpg'),
(1, 'Lying Down Pull Up','1208221540_53130800.jpg'),
(1, 'Machine Seated Cable Row','1208239800_25048300.jpg'),
(1, 'Pull downs','1249107897_89879700.jpg'),
(1, 'Rope climb','1250301951_12295700.jpg'),
(1, 'Seated Row','1208159450_40771000.jpg'),
(2, 'Disc hip raises','1250296261_19256300.jpg'),
(2, 'Dumbbell Shoulder Press','1250295579_92587200.jpg'),
(2, 'Dumbell overhead squat','1250295427_06530000.jpg'),
(2, 'Dumbell Squat','1250295554_06957000.jpg'),
(2, 'Rocker board Squats','1250295776_42571500.jpg'),
(2, 'Single leg cone touch','1250295616_70556100.jpg'),
(2, 'Squat/Superman','1250295658_04112500.jpg'),
(3, 'BOSU Ab cycle','1250296310_64321900.jpg'),
(3, 'BOSU Bird','1250296333_25934400.jpg'),
(3, 'Inverted BOSU pushups','1250296397_56487600.jpg'),
(4, '3 Point Reverse single arm cable fly','1250296736_52740600.jpg'),
(4, 'Cable punch','1250296670_79892100.jpg'),
(4, 'Diagonal cable raise','1250296535_77941100.jpg'),
(4, 'Double D lat-pulldown','1250296883_59986300.jpg'),
(4, 'External shoulder rotation with a slight abduction','1250296591_41854400.jpg'),
(4, 'Front deltoid raise','1250296653_73082200.jpg'),
(4, 'Lat-pulldown','1250296821_42962000.jpg'),
(4, 'Reverse grip lat-pulldown','1250296799_47050200.jpg'),
(4, 'Rope pushdown','1250296764_13342500.jpg'),
(4, 'Standing cable row','1250296512_59938300.jpg'),
(4, 'Standing high cable row','1250296928_74159900.jpg'),
(4, 'Tricep rope pushdowns','1250296962_29169600.jpg'),
(4, 'Upward cable fly','1250296695_68931600.jpg'),
(5, 'Bike','1208167752_20472800.jpg'),
(5, 'Cross Trainer','1208168112_02059900.jpg'),
(5, 'Running','1208239624_33009100.jpg'),
(5, 'Swimming','1248860021_18634500.jpg'),
(6, 'Assisted Chest Dip','1208156600_91709800.jpg'),
(6, 'Barbell Bench Press','1208157529_28215000.jpg'),
(6, 'Barbell incline bench press','1250303631_05656200.jpg'),
(6, 'Cable Standing Fly','1208167698_28058600.jpg'),
(6, 'Decline bench press','1249107237_80492600.jpg'),
(6, 'Dumbbell Bench press','1249107065_43243700.jpg'),
(6, 'Dumbbell Incline Bench Press','1208237001_11364000.jpg'),
(6, 'Dumbbell Reverse Grip Bench Fly','1250303559_70889900.jpg'),
(6, 'Hammer Grip Dumbbell Press','1250303705_17127000.jpg'),
(6, 'Push up','1249107253_16919900.jpg'),
(6, 'Pushup with trainer resistance','1250303329_62645800.jpg'),
(6, 'Rocker board pushup','1250303367_07311000.jpg'),
(6, 'Weighted Pushup','1250303272_99629100.jpg'),
(7, 'Dumbbell Step-up with knee raise','1250297066_23601100.jpg'),
(7, 'Jerk','1250297084_89977900.jpg'),
(7, 'Single leg/arm bentover row','1250297150_54797400.jpg'),
(7, 'Split Squat DB tricep overhead extension','1250297169_95923300.jpg'),
(7, 'Split Squat Dumbbell Raise/Twist','1250297119_06260800.jpg'),
(7, 'Split Squat Plate raise and twist','1250297191_71459000.jpg'),
(7, 'Step-up with Dumbbell raise','1250297037_70361100.jpg'),
(8, 'Alternating punches with elastic resistance','1250396420_00971400.jpg'),
(8, 'Ankle band lateral step shuffle','1250906814_52107200.jpg'),
(8, 'Cable Lateral Rotation','1250396057_52197500.jpg'),
(8, 'Crunches with elastic resistance','1250397076_71406400.jpg'),
(8, 'Elastic Alternating upright row','1250396290_89360700.jpg'),
(8, 'Elastic Bent Over Row','1250395896_77699300.jpg'),
(8, 'Elastic bicep curls','1250396325_72564500.jpg'),
(8, 'Elastic front raise','1250396370_77668700.jpg'),
(8, 'Elastic hyperextension','1250397372_80904800.jpg'),
(8, 'Elastic Lat pulldown','1250396763_12232800.jpg'),
(8, 'Elastic Lateral Rotation','1250397457_54955800.jpg'),
(8, 'Elastic leg extension','1250397030_73302000.jpg'),
(8, 'Elastic Lying down leg abductor','1250396991_16530200.jpg'),
(8, 'Elastic push ups','1250397512_46965300.jpg'),
(8, 'Elastic Squat with shoulder press','1250396223_12420000.jpg'),
(8, 'Elastic upwright row','1250397572_16422900.jpg'),
(8, 'Lateral raise','1250906795_84583000.jpg'),
(8, 'Pysioball pressups with Elastic resistance','1250396109_70630400.jpg'),
(8, 'Single leg Hip raises (elastic resistance)','1250396846_24001100.jpg'),
(8, 'Squats with elastic resistance','1250397315_44636500.jpg'),
(8, 'Standing leg abduction (bent over)','1250397188_69120000.jpg'),
(8, 'Standingh Transverse Extension','1250396542_22466100.jpg'),
(9, 'Clean and Jerk','1250906760_43905100.jpg'),
(9, 'Clean and Jerk','1250390640_10038700.jpg'),
(9, 'Depth Jumps','1250389833_14959500.jpg'),
(9, 'Diagonal Swing/Lift','1250390343_57004600.jpg'),
(9, 'Double Leg Box Jump','1250389155_13874400.jpg'),
(9, 'Dumbbell cleans','1250391034_67291000.jpg'),
(9, 'Frog Jumps','1250389943_91260800.jpg'),
(9, 'Hurdle Hops','1250389667_37135400.jpg'),
(9, 'Plyometric Push Ups','1250390106_83997000.jpg'),
(9, 'Power clean','1250390763_17618300.jpg'),
(9, 'Snatch','1250906734_31455200.jpg'),
(9, 'Split squat jumps','1250389881_51337600.jpg'),
(9, 'Weighted Squat Jumps','1250390150_45155700.jpg'),
(10, 'Alternating Halfway Side Splits','1250392226_43168700.jpg'),
(10, 'Hamstring Stretch','1250392298_74367700.jpg'),
(10, 'Inner Thigh Stretch','1250391238_50542800.jpg'),
(10, 'Knees to Chest','1250391309_12626300.jpg'),
(10, 'Lying Down Quadriceps Stretch','1250391708_21069500.jpg'),
(10, 'Overhead Triceps Stretch','1250392363_87898500.jpg'),
(10, 'Seated Side Splits with Toes Up','1250391993_32015900.jpg'),
(10, 'Sitting Spinal Twist','1250391573_13925600.jpg'),
(10, 'Spine Twist','1250391272_32549900.jpg'),
(10, 'Standing Calf Stretch','1250391631_30501600.jpg'),
(10, 'Standing Quadriceps Stretch','1250391679_57901100.jpg'),
(10, 'Stick stretches','1250392617_52007500.jpg'),
(11, 'Barbell Reverse Curl','1208160876_50973300.jpg'),
(11, 'Barbell Wrist Curl','1208167033_36758900.jpg'),
(11, 'Dumbbell Lying Pronation','1208237692_58764600.jpg'),
(11, 'Dumbbell Lying Supination','1208237775_11051100.jpg'),
(11, 'Dumbbell Reverse Wrist Curl','1208237842_31410600.jpg'),
(11, 'Hanging weight roll up','1250297624_88709800.jpg'),
(12, 'Bounding jumps','1250907405_72249600.jpg'),
(12, 'Bounding or leaping movement','1250907292_75204500.jpg'),
(12, 'Double foot ladder','1250907371_42750300.jpg'),
(12, 'Frog Squats','1250907224_87752200.jpg'),
(12, 'High Step','1250907211_81448100.jpg'),
(12, 'Hurdle single foot jumps','1250907311_66528100.jpg'),
(12, 'Kick swings','1250907274_62684200.jpg'),
(12, 'Knee to chest hold','1250907196_08409700.jpg'),
(12, 'Lateral foot strike','1250907385_69035100.jpg'),
(12, 'Lateral hurdle single foot jumps','1250907339_04180400.jpg'),
(12, 'Lunge','1250907258_90691000.jpg'),
(12, 'Quad stretch','1250907180_59050500.jpg'),
(12, 'Single foot strike ladder','1250907355_31675000.jpg'),
(12, 'V-ups','1250907239_64677000.jpg'),
(12, 'V-ups to standing','1250907425_15178000.jpg'),
(13, 'Barbell Squat','1208161267_05808500.jpg'),
(13, 'Dumbbell Lunge','1208168717_28525000.jpg'),
(13, 'Hip Abduction','1208239287_55006900.jpg'),
(14, 'Kettlebell lunges','1250300019_67419000.jpg'),
(14, 'Kettlebell Shoulder Press','1250300078_68809300.jpg'),
(14, 'Kettlebell squats','1250299990_67747800.jpg'),
(15, 'Adduction raise','1250907471_20986900.jpg'),
(15, 'Barbell overhead lunge','1250305780_73096800.jpg'),
(15, 'Barbell Single Leg Calf Raise','1208238080_21805200.jpg'),
(15, 'Barbell Standing Calf Raise','1208161318_45467500.jpg'),
(15, 'Box squats','1250306276_99313600.jpg'),
(15, 'Bulgarian lunge','1250907486_03262400.jpg'),
(15, 'Chair squats','1250306387_29741500.jpg'),
(15, 'Deadlift','1250398295_56962300.jpg'),
(15, 'Dumbbell box squats','1250398257_94659800.jpg'),
(15, 'Dumbbell box step up','1250398546_36916600.jpg'),
(15, 'Dumbbell lunges (with/without Incline)','1250398700_31996800.jpg'),
(15, 'Dumbbell Step up','1208238255_67724700.jpg'),
(15, 'Dumbbell sumo dead lift or squat','1250907576_41165600.jpg'),
(15, 'Front squats','1250398202_87105800.jpg'),
(15, 'Lateral leg lift','1250398035_25836200.jpg'),
(15, 'Lunges','1250398643_70410200.jpg'),
(15, 'Machine Calf Press','1208239230_07601000.jpg'),
(15, 'Prison squat','1250907549_17025600.jpg'),
(15, 'Single leg box squats','1250305890_19393000.jpg'),
(15, 'Single leg hamstring','1250907531_40275100.jpg'),
(15, 'Single leg squats','1250306341_82442900.jpg'),
(15, 'Standing Barbell hyperextension','1250398419_54441200.jpg'),
(15, 'Steps ups with Dumbbell','1250907515_47191400.jpg'),
(15, 'Straddle explosive jumps','1250907448_90701300.jpg'),
(15, 'Weighted Lateral leg lift','1250398472_77103100.jpg'),
(16, 'Ab Machine','1250394157_89503800.jpg'),
(16, 'Bicycle Machine','1250393048_26446000.jpg'),
(16, 'Cable Seated Row','1250393952_83651600.jpg'),
(16, 'Cross Trainer','1250392800_87901600.jpg'),
(16, 'Crosstrainer Bicycle','1250393012_11514600.jpg'),
(16, 'Leg Curl or Hamstring Curl','1250393287_76154000.jpg'),
(16, 'Leg extension','1250393250_69292900.jpg'),
(16, 'Leg press','1250393318_34833800.jpg'),
(16, 'Machine chest fly','1250394075_30906200.jpg'),
(16, 'Machine Hammer Grip Pull Downs','1250393484_33930000.jpg'),
(16, 'Machine Hyperextension','1250393441_72046400.jpg'),
(16, 'Machine Seated Shoulder Press','1250393593_92427000.jpg'),
(16, 'Peck Deck Fly','1208239655_53525200.jpg'),
(16, 'Rear Delt Machine','1250393685_79021300.jpg'),
(16, 'Rowing Machine','1250393071_07202400.jpg'),
(16, 'Seated Row','1250394037_99855200.jpg'),
(16, 'Smith machine squats','1250393355_42531900.jpg'),
(16, 'Stepper Machine','1250393125_83578300.jpg'),
(16, 'Tricep Dips Machine','1250393726_63344400.jpg'),
(17, 'Medball Alternate push up','1250486149_73817000.jpg'),
(17, 'Medball Ankle to shoulder twist','1250486618_79297000.jpg'),
(17, 'Medball Crunches','1250486320_71122500.jpg'),
(17, 'Medball front catch/squat and throw','1250486175_37202000.jpg'),
(17, 'Medball Lying chest throw','1250486462_11160300.jpg'),
(17, 'Medball Lying chest throw to partner','1250486511_46209400.jpg'),
(17, 'Medball Oblique twists (standing)','1250486299_52673400.jpg'),
(17, 'Medball overhead straight arm crunch','1250486438_44530200.jpg'),
(17, 'Medball partner sit up pass','1250486484_43751000.jpg'),
(17, 'Medball Push up','1250486391_57061300.jpg'),
(17, 'Medball Russian twists (sit up)','1250486536_07320000.jpg'),
(17, 'Medball Russian twists (sit up)','1250486592_32173100.jpg'),
(17, 'Medball scoop throw','1250486703_85991900.jpg'),
(17, 'Medball Single leg squat','1250486344_17399600.jpg'),
(17, 'Medball Sit up','1250486568_50699800.jpg'),
(17, 'Medball Sit up pass','1250486411_66720800.jpg'),
(17, 'Medball Sit up with arm lift','1250486676_97156900.jpg'),
(17, 'Medball Squat throws','1250486223_80685000.jpg'),
(17, 'Medball Squat/overhead haul','1250486277_62439300.jpg'),
(17, 'Medball Squat/overhead haul','1250486372_95597600.jpg'),
(17, 'Medball Standing chest pass','1250486249_03848200.jpg'),
(17, 'Medball Standing overhead haul to ankle swing','1250486652_76979600.jpg'),
(17, 'Medball twist wall throw','1250486130_03481300.jpg'),
(17, 'Medicine ball slams','1250486201_98945600.jpg'),
(18, '5 by 5 diagonal cone sprints','1250907143_11782500.jpg'),
(18, 'Agility T drill','1250906999_65398800.jpg'),
(18, 'Box drill','1250907019_22543800.jpg'),
(18, 'Figure of 8 sprints or run','1250907035_54976800.jpg'),
(18, 'In and out of cone sprints','1250907053_10845200.jpg'),
(18, 'Shuttles/sprints','1250907123_64523100.jpg'),
(18, 'Triangle sprints','1250906979_22145300.jpg'),
(18, 'Zig Zag cone to cone sprints','1250907073_85061000.jpg'),
(19, 'Arm shoulder circles','1250907641_37727200.jpg'),
(19, 'Barbell Behind Neck Press','1208160416_69181300.jpg'),
(19, 'Barbell Military press','1249107646_37236900.jpg'),
(19, 'Bent over Dumbbell Rear Lateral Raise','1208237143_26383000.jpg'),
(19, 'Bent over Lateral Raises - Bent Arm','1250302819_32356400.jpg'),
(19, 'Dumbbell front raise','1208159957_49697200.jpg'),
(19, 'Dumbbell lateral raise','1208220787_98395000.jpg'),
(19, 'Dumbbell lying rear delt row','1208220865_95064100.jpg'),
(19, 'Dumbbell shoulder press','1208168209_26700600.jpg'),
(19, 'Dumbbell Upright Row','1208237192_50995300.jpg'),
(19, 'Hand stand wall push ups','1250302918_50511800.jpg'),
(19, 'Laying down rear delt raise','1250907609_14942100.jpg'),
(19, 'Overhead lateral raise (thumbs facing outwards)','1250907660_24067000.jpg'),
(19, 'Seated Reverse Fly','1250302703_67306300.jpg'),
(19, 'Standing Reverse Fly','1250302689_36590500.jpg'),
(20, 'Single leg abduction','1250298443_19163100.jpg'),
(20, 'Sled mountain climbers','1250298514_85851400.jpg'),
(21, 'Swiss ball alternate arm push up with Medball','1250486937_52611200.jpg'),
(21, 'Swiss ball back extension','1250487172_30993200.jpg'),
(21, 'Swiss ball crunch','1250487120_30854200.jpg'),
(21, 'Swiss ball Dumbbell concentration curls','1250487324_22808900.jpg'),
(21, 'Swiss ball Dumbbell curls','1250487348_89336400.jpg'),
(21, 'Swiss ball Dumbbell shoulder press','1250487293_00236400.jpg'),
(21, 'Swiss ball feet to hands pass','1250487380_06257700.jpg'),
(21, 'Swiss Ball Leg curls','1250486868_81084900.jpg'),
(21, 'Swiss ball leg extensions','1250486958_87940400.jpg'),
(21, 'Swiss ball leg extensions','1250487011_10604500.jpg'),
(21, 'Swiss ball Prone leg lift','1250486893_13743400.jpg'),
(21, 'Swiss ball reverse curl','1250487142_39786100.jpg'),
(21, 'Swiss ball shoulder press with thera-band','1250487057_41612500.jpg'),
(21, 'Swiss ball single arm Dumbbell punch','1250486986_47859000.jpg'),
(21, 'Swiss ball single arm reverse fly','1250487197_25560500.jpg'),
(21, 'Swiss ball Sit up (brace feet)','1250487431_49268000.jpg'),
(21, 'Swiss ball sitting lateral skull crushers','1250487264_01398100.jpg'),
(21, 'Swiss ball Straight leg raises','1250486912_73819300.jpg'),
(21, 'Swiss ball straight-legged jack knife','1250487406_81206400.jpg'),
(21, 'Swiss ball triceps extension','1250487232_79705500.jpg'),
(21, 'Swiss ball Triceps floor touch','1250487029_43672500.jpg'),
(21, 'Swiss ball upright row with thera-band','1250487081_86344300.jpg'),
(21, 'Swiss ball wall squat/shoulder press','1250487102_62244600.jpg'),
(22, 'Skinfolds - Abdominal','1250298703_46515100.jpg'),
(22, 'Vertical Jump','1250298606_60955800.jpg'),
(23, 'Barbell Front Squat','1208167300_72056600.jpg'),
(23, 'Barbell Lunge','1208161007_28896900.jpg'),
(23, 'Dumbbell Lunges','1208238954_58762900.jpg'),
(23, 'Lying Leg Curl','1208239611_53298400.jpg'),
(24, 'Alternating Dumbbell row on machine','1250305315_78273300.jpg'),
(24, 'Barbell Ab Roll up','1250304932_20425700.jpg'),
(24, 'Barbell Deadlift','1208157404_60847100.jpg'),
(24, 'Captains Chair Hanging Leg Raise','1250304859_99291100.jpg'),
(24, 'Full sit-ups','1250304368_24396700.jpg'),
(24, 'Hanging Leg Raise','1250305068_98086100.jpg'),
(24, 'Hanging Reverse Crunch','1250305017_85548900.jpg'),
(24, 'Jack Knives','1250304622_95159900.jpg'),
(24, 'Lying down Leg raisers','1250304671_84868900.jpg'),
(24, 'Medicine ball hyperextension','1250298902_50999400.jpg'),
(24, 'Physio Ball Hyperextension','1208240479_31081900.jpg'),
(24, 'Plank','1250304021_00202900.jpg'),
(24, 'Pushup hold - Single arm','1250304128_77693300.jpg'),
(24, 'Reverse crunch','1250304182_05087900.jpg'),
(24, 'Side crunches','1250304967_71116700.jpg'),
(24, 'Side plank','1250304050_02112700.jpg'),
(24, 'Sit up benc crunches','1250305160_90115200.jpg'),
(24, 'Straight Arm Abdominal Crunches','1250304302_24776300.jpg'),
(24, 'Twisting Crunch','1208238447_16868700.jpg'),
(24, 'Twisting crunch','1250304243_25695000.jpg'),
(24, 'Vertical Leg Raise','1208240599_58806800.jpg'),
(24, 'Weighted Crunch','1208168666_50568700.jpg'),
(24, 'Weighted Hyperextension','1208160545_47067100.jpg'),
(25, 'Barbell Lying Triceps Extension','1208161048_85457900.jpg'),
(25, 'Bench dip','1250297693_37248200.jpg'),
(25, 'Dumbbell Scull crushers','1250297816_54043600.jpg'),
(25, 'Dumbell Curl','1208159596_02171200.jpg'),
(25, 'Preacher Curl Machine','1208161119_36024500.jpg'),
(25, 'Reverse Grip Bicep Curls','1250297998_05885700.jpg'),
(25, 'Tricep Machine','1208168568_07093700.jpg'),
(25, 'Triceps push up','1249108091_75103800.jpg'),
(25, 'Triceps rope downs','1249108009_19656000.jpg'),
(26, 'Cobblers Pose','1250300931_66361500.jpg'),
(26, 'Cobra Pose','1250300611_35877100.jpg'),
(26, 'Crane Pose','1250300558_63745100.jpg'),
(26, 'Crescent Moon Pose','1250300447_12280500.jpg'),
(26, 'Dog pose','1250300287_38635200.jpg'),
(26, 'Downward Facing Dog','1250300479_95252100.jpg'),
(26, 'Easy pose','1250301050_16026800.jpg'),
(26, 'exercise1',''),
(26, 'Plough Pose','1250300990_29125300.jpg'),
(26, 'Seated forward bend','1250300381_47186700.jpg'),
(26, 'Shoulder stand','1250301102_51869600.jpg'),
(26, 'Spread leg sideways fold','1250301181_56915500.jpg'),
(26, 'Standing forward bend','1250300337_83021100.jpg'),
(26, 'Tree Pose','1250301226_75356900.jpg'),
(26, 'Triangle pose','1250301293_94358800.jpg');
CREATE TABLE IF NOT EXISTS `app_gympro_programs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `client_id` int(11) unsigned DEFAULT NULL,
  `focus` varchar(500),
  `start_date` varchar(50),
  `description` text,
  `warm_up` text,
  `cool_down` text,
  `review_id` int(11) unsigned DEFAULT NULL,
  `exercise_list` text,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_gympro_programs_u1_idx` (`user_id`),
  KEY `app_gympro_programs_reviews1_idx` (`review_id`),
  KEY `app_gympro_programs_c1_idx` (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_gympro_programs`
	ADD CONSTRAINT `app_gympro_programs_reviews1` FOREIGN KEY(`review_id`) REFERENCES `app_gympro_reviews` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_gympro_programs_u1` FOREIGN KEY(`user_id`) REFERENCES `app_gympro_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_gympro_programs_c1` FOREIGN KEY(`client_id`) REFERENCES `app_gympro_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
	
CREATE TABLE IF NOT EXISTS `app_gympro_exercises` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `client_id` int(11) unsigned DEFAULT NULL,
  `category_id` int(11) unsigned NOT NULL,
  `name` varchar(500),
  `description` text,
  `picture` varchar(500),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_gympro_exercises_u1_idx` (`user_id`),
  KEY `app_gympro_exercises_c1_idx` (`client_id`),
  KEY `app_gympro_exercises_categories1_idx` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_gympro_exercises`
	ADD CONSTRAINT `app_gympro_exercises_categories1` FOREIGN KEY(`category_id`) REFERENCES `app_gympro_exercise_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_gympro_exercises_u1` FOREIGN KEY(`user_id`) REFERENCES `app_gympro_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_gympro_exercises_c1` FOREIGN KEY(`client_id`) REFERENCES `app_gympro_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
-- --------------------------------------------------Nutrition Module -------------------------------------------- --
CREATE TABLE IF NOT EXISTS `app_gympro_meal_times` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `order` int(11) unsigned NOT NULL DEFAULT 0,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_meal_times` (`title`, `order`) VALUES
('12.00 am', 1),
('12.15 am', 2),
('12.30 am', 3),
('12.45 am', 4),
('1.00 am', 5),
('1.15 am', 6),
('1.30 am', 7),
('1.45 am', 8),
('2.00 am', 9),
('2.15 am', 10),
('2.30 am', 11),
('2.45 am', 12),
('3.00 am', 13),
('3.15 am', 14),
('3.30 am', 15),
('3.45 am', 16),
('4.00 am', 17),
('4.15 am', 18),
('4.30 am', 19),
('4.45 am', 20),
('5.00 am', 21),
('5.15 am', 22),
('5.30 am', 23),
('5.45 am', 24),
('6.00 am', 25),
('6.15 am', 26),
('6.30 am', 27),
('6.45 am', 28),
('7.00 am', 29),
('7.15 am', 30),
('7.30 am', 31),
('7.45 am', 32),
('8.00 am', 33),
('8.15 am', 34),
('8.30 am', 35),
('8.45 am', 36),
('9.00 am', 37),
('9.15 am', 38),
('9.30 am', 39),
('9.45 am', 40),
('10.00 am', 41),
('10.15 am', 42),
('10.30 am', 43),
('10.45 am', 44),
('11.00 am', 45),
('11.15 am', 46),
('11.30 am', 47),
('11.45 am', 48),
('12.00 pm', 49),
('12.15 pm', 50),
('12.30 pm', 51),
('12.45 pm', 52),
('1.00 pm', 53),
('1.15 pm', 54),
('1.30 pm', 55),
('1.45 pm', 56),
('2.00 pm', 57),
('2.15 pm', 58),
('2.30 pm', 59),
('2.45 pm', 60),
('3.00 pm', 61),
('3.15 pm', 62),
('3.30 pm', 63),
('3.45 pm', 64),
('4.00 pm', 65),
('4.15 pm', 66),
('4.30 pm', 67),
('4.45 pm', 68),
('5.00 pm', 69),
('5.15 pm', 70),
('5.30 pm', 71),
('5.45 pm', 72),
('6.00 pm', 73),
('6.15 pm', 74),
('6.30 pm', 75),
('6.45 pm', 76),
('7.00 pm', 77),
('7.15 pm', 78),
('7.30 pm', 79),
('7.45 pm', 80),
('8.00 pm', 81),
('8.15 pm', 82),
('8.30 pm', 83),
('8.45 pm', 84),
('9.00 pm', 85),
('9.15 pm', 86),
('9.30 pm', 87),
('9.45 pm', 88),
('10.00 pm', 89),
('10.15 pm', 90),
('10.30 pm', 91),
('10.45 pm', 92),
('11.00 pm', 93),
('11.15 pm', 94),
('11.30 pm', 95),
('11.45 pm', 96);
CREATE TABLE IF NOT EXISTS `app_gympro_workouts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_workouts` (`title`) VALUES
('Pre workout'),
('Post workout');
CREATE TABLE IF NOT EXISTS `app_gympro_nutritions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `client_id` int(11) unsigned DEFAULT NULL,
  `meal_list` text,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_gympro_nutritions_u1_idx` (`user_id`),
  KEY `app_gympro_nutritions_c1_idx` (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_gympro_nutritions`
	ADD CONSTRAINT `app_gympro_nutritions_u1` FOREIGN KEY(`user_id`) REFERENCES `app_gympro_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_gympro_nutritions_c1` FOREIGN KEY(`client_id`) REFERENCES `app_gympro_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
-- --------------------------------------------------Assessment Module -------------------------------------------- --
CREATE TABLE IF NOT EXISTS `app_gympro_reassess` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_reassess` (`title`) VALUES
('1 week'),
('2 weeks'),
('3 weeks'),
('4 weeks'),
('5 weeks'),
('6 weeks'),
('7 weeks'),
('8 weeks'),
('9 weeks'),
('10 weeks');
CREATE TABLE IF NOT EXISTS `app_gympro_assessments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `client_id` int(11) unsigned DEFAULT NULL,
  `reassess_id` int(11) unsigned NOT NULL,
  `date` varchar(50),
  `weight` varchar(100),
  `body_fat` varchar(100),
  `head` varchar(100),
  `neck` varchar(100),
  `chest` varchar(100),
  `abdominal` varchar(100),
  `waist` varchar(100),
  `hip` varchar(100),
  `ls_arm_relaxed` varchar(100),
  `ls_arm_flexed` varchar(100),
  `ls_forearm` varchar(100),
  `ls_wrist` varchar(100),
  `ls_thigh_gluteal` varchar(100),
  `ls_thigh_mid` varchar(100),
  `ls_calf` varchar(100),
  `ls_ankle` varchar(100),
  `rs_arm_relaxed` varchar(100),
  `rs_arm_flexed` varchar(100),
  `rs_forearm` varchar(100),
  `rs_wrist` varchar(100),
  `rs_thigh_gluteal` varchar(100),
  `rs_thigh_mid` varchar(100),
  `rs_calf` varchar(100),
  `rs_ankle` varchar(100),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_gympro_assessments_u1_idx` (`user_id`),
  KEY `app_gympro_assessments_c1_idx` (`client_id`),
  KEY `app_gympro_assessments_reassess1_idx` (`reassess_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_gympro_assessments`
	ADD CONSTRAINT `app_gympro_assessments_reassess1` FOREIGN KEY(`reassess_id`) REFERENCES `app_gympro_reassess` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_gympro_assessments_u1` FOREIGN KEY(`user_id`) REFERENCES `app_gympro_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_gympro_assessments_c1` FOREIGN KEY(`client_id`) REFERENCES `app_gympro_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
-- --------------------------------------------------Mission Module -------------------------------------------- --
CREATE TABLE IF NOT EXISTS `app_gympro_missions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `client_id` int(11) unsigned DEFAULT NULL,
  `label` varchar(500),
  `start_date` varchar(50),
  `end_date` varchar(50),
  `monday` text,
  `tuesday` text,
  `wednesday` text,
  `thursday` text,
  `friday` text,
  `saturday` text,
  `sunday` text,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_gympro_missions_u1_idx` (`user_id`),
  KEY `app_gympro_missions_c1_idx` (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_gympro_missions`
	ADD CONSTRAINT `app_gympro_missions_u1` FOREIGN KEY(`user_id`) REFERENCES `app_gympro_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_gympro_missions_c1` FOREIGN KEY(`client_id`) REFERENCES `app_gympro_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ---------------------------------------------------- Session Module -------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `app_gympro_session_repeats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_session_repeats` (`title`) VALUES
('2'),
('3'),
('4'),
('5'),
('6'),
('7'),
('8'),
('9'),
('10'),
('11'),
('12'),
('13'),
('14'),
('15'),
('16'),
('17'),
('18'),
('19'),
('20');
CREATE TABLE IF NOT EXISTS `app_gympro_session_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_session_types` (`title`) VALUES
('Single session'),
('Repeated daily'),
('Repeat weekly'),
('Repeat biweekly'),
('Repeat monthly');
CREATE TABLE IF NOT EXISTS `app_gympro_session_times` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `title_24` varchar(200),
  `order` int(11) unsigned NOT NULL DEFAULT 0,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_session_times` (`title`, `title_24`, `order`) VALUES
('12:00 am', '00:00:00', 1),
('12:15 am', '00:15:00', 2),
('12:30 am', '00:30:00', 3),
('12:45 am', '00:45:00', 4),
('1:00 am', '01:00:00', 5),
('1:15 am', '01:15:00', 6),
('1:30 am', '01:30:00', 7),
('1:45 am', '01:45:00', 8),
('2:00 am', '02:00:00', 9),
('2:15 am', '02:15:00', 10),
('2:30 am', '02:30:00', 11),
('2:45 am', '02:45:00', 12),
('3:00 am', '03:00:00', 13),
('3:15 am', '03:15:00', 14),
('3:30 am', '03:30:00', 15),
('3:45 am', '03:45:00', 16),
('4:00 am', '04:00:00', 17),
('4:15 am', '04:15:00', 18),
('4:30 am', '04:30:00', 19),
('4:45 am', '04:45:00', 20),
('5:00 am', '05:00:00', 21),
('5:15 am', '05:15:00', 22),
('5:30 am', '05:30:00', 23),
('5:45 am', '05:45:00', 24),
('6:00 am', '06:00:00', 25),
('6:15 am', '06:15:00', 26),
('6:30 am', '06:30:00', 27),
('6:45 am', '06:45:00', 28),
('7:00 am', '07:00:00', 29),
('7:15 am', '07:15:00', 30),
('7:30 am', '07:30:00', 31),
('7:45 am', '07:45:00', 32),
('8:00 am', '08:00:00', 33),
('8:15 am', '08:15:00', 34),
('8:30 am', '08:30:00', 35),
('8:45 am', '08:45:00', 36),
('9:00 am', '09:00:00', 37),
('9:15 am', '09:15:00', 38),
('9:30 am', '09:30:00', 39),
('9:45 am', '09:45:00', 40),
('10:00 am', '10:00:00', 41),
('10:15 am', '10:15:00', 42),
('10:30 am', '10:30:00', 43),
('10:45 am', '10:45:00', 44),
('11:00 am', '11:00:00', 45),
('11:15 am', '11:15:00', 46),
('11:30 am', '11:30:00', 47),
('11:45 am', '11:45:00', 48),
('12:00 pm', '12:00:00', 49),
('12:15 pm', '12:15:00', 50),
('12:30 pm', '12:30:00', 51),
('12:45 pm', '12:45:00', 52),
('1:00 pm', '13:00:00', 53),
('1:15 pm', '13:15:00', 54),
('1:30 pm', '13:30:00', 55),
('1:45 pm', '13:45:00', 56),
('2:00 pm', '14:00:00', 57),
('2:15 pm', '14:15:00', 58),
('2:30 pm', '14:30:00', 59),
('2:45 pm', '14:45:00', 60),
('3:00 pm', '15:00:00', 61),
('3:15 pm', '15:15:00', 62),
('3:30 pm', '15:30:00', 63),
('3:45 pm', '15:45:00', 64),
('4:00 pm', '16:00:00', 65),
('4:15 pm', '16:15:00', 66),
('4:30 pm', '16:30:00', 67),
('4:45 pm', '16:45:00', 68),
('5:00 pm', '17:00:00', 69),
('5:15 pm', '17:15:00', 70),
('5:30 pm', '17:30:00', 71),
('5:45 pm', '17:45:00', 72),
('6:00 pm', '18:00:00', 73),
('6:15 pm', '18:15:00', 74),
('6:30 pm', '18:30:00', 75),
('6:45 pm', '18:45:00', 76),
('7:00 pm', '19:00:00', 77),
('7:15 pm', '19:15:00', 78),
('7:30 pm', '19:30:00', 79),
('7:45 pm', '19:45:00', 80),
('8:00 pm', '20:00:00', 81),
('8:15 pm', '20:15:00', 82),
('8:30 pm', '20:30:00', 83),
('8:45 pm', '20:45:00', 84),
('9:00 pm', '21:00:00', 85),
('9:15 pm', '21:15:00', 86),
('9:30 pm', '21:30:00', 87),
('9:45 pm', '21:45:00', 88),
('10:00 pm', '22:00:00', 89),
('10:15 pm', '22:15:00', 90),
('10:30 pm', '22:30:00', 91),
('10:45 pm', '22:45:00', 92),
('11:00 pm', '23:00:00', 93),
('11:15 pm', '23:15:00', 94),
('11:30 pm', '23:30:00', 95),
('11:45 pm', '23:45:00', 96);
CREATE TABLE IF NOT EXISTS `app_gympro_session_costs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_session_costs` (`title`) VALUES
('5'),
('10'),
('15'),
('20'),
('25'),
('30'),
('35'),
('40'),
('45'),
('50'),
('55'),
('60'),
('65'),
('70'),
('75'),
('80'),
('85'),
('90'),
('95'),
('100'),
('105'),
('110'),
('115'),
('120'),
('125'),
('130'),
('135'),
('140'),
('145'),
('150'),
('155'),
('160'),
('165'),
('170'),
('175'),
('180'),
('185'),
('190'),
('195'),
('200');
CREATE TABLE IF NOT EXISTS `app_gympro_session_statuses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_gympro_session_statuses` (`title`) VALUES
('Unpaid'),
('Paid Cash'),
('Paid via PT Pro'),
('Cancelled');
CREATE TABLE IF NOT EXISTS `app_gympro_sessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `title` varchar(500),
  `created_for_type_id` int(11) unsigned NOT NULL,
  `reference_id` int(11) unsigned NOT NULL,
  `date` varchar(50),
  `start` varchar(50),
  `end` varchar(50),
  `location` varchar(500),
  `type_id` int(11) unsigned NOT NULL,
  `repeat` varchar(50),
  `cost` varchar(500),
  `currency_id` int(11) unsigned DEFAULT NULL,
  `status_id` int(11) unsigned NOT NULL,
  `note` text,  
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_gympro_sessions_users1_idx` (`user_id`),
  KEY `app_gympro_sessions_types1_idx` (`type_id`),
  KEY `app_gympro_sessions_statuses1_idx` (`status_id`),
  KEY `app_gympro_sessions_currency1_idx` (`currency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `app_gympro_sessions`
	ADD CONSTRAINT `app_gympro_sessions_users1` FOREIGN KEY(`user_id`) REFERENCES `app_gympro_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_gympro_sessions_types1` FOREIGN KEY(`type_id`) REFERENCES `app_gympro_session_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_gympro_sessions_statuses1` FOREIGN KEY(`status_id`) REFERENCES `app_gympro_session_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `app_gympro_sessions_currency1` FOREIGN KEY(`currency_id`) REFERENCES `app_gympro_currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
-- INSERT INTO `app_gympro_sessions` (`user_id`, `title`, `created_for_type_id`, `reference_id`, `date`, `start`, `end`, `type_id`, `status_id`) VALUES
-- (4, 'title', 1, 1, '2015-01-23', '14:00:00', '17:00:00', 1, 1)
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

-- shop
CREATE TABLE IF NOT EXISTS `app_shop_product_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_shop_product_category` (`id`, `title`) VALUES
(1, 'WOMEN'),
(2, 'MEN'),
(3, 'KIDS');

CREATE TABLE IF NOT EXISTS `app_shop_product_color` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `description` varchar(200),
  `picture` varchar(200) DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_shop_product_color` (`id`, `title`, `description`, `picture`) VALUES
(1, 'black', 'Black', 'black.jpg'),
(2, 'blue', 'Blue', 'blue.jpg'),
(3, 'brown', 'Brown', 'brown.jpg'),
(4, 'gold', 'Gold', 'gold.jpg'),
(5, 'green', 'Green', 'green.jpg'),
(6, 'grey', 'Grey', 'grey.jpg'),
(7, 'natural', 'Natural', 'natural.jpg'),
(8, 'orange', 'Orange', 'orange.jpg'),
(9, 'pink', 'Pink', 'pink.jpg'),
(10, 'purple', 'Purple', 'purple.jpg'),
(11, 'red', 'Red', 'red.jpg'),
(12, 'silver', 'Silver', 'silver.jpg'),
(13, 'white', 'White', 'white.jpg'),
(14, 'yellow', 'Yellow', 'yellow.jpg');

CREATE TABLE IF NOT EXISTS `app_shop_sizing_chart_men` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `us_ca` varchar(200),
  `uk` varchar(200),
  `eu` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_shop_sizing_chart_men` (`id`, `title`, `us_ca`, `uk`, `eu`) VALUES
(1, 'UK6/US7', '7', '6', '40'),
(2, 'UK7/US8', '8', '7', '40.5'),
(3, 'UK7.5/US8.5', '8.5', '7.5', '41'),
(4, 'UK8/US9', '9', '8', '42'),
(5, 'UK8.5/US9.6', '9.5', '8.5', '42.5'),
(6, 'UK9/US10', '10', '9', '43'),
(7, 'UK9.5/US10.5', '10.5', '9.5', '43.5'),
(8, 'UK10/US11', '11', '10', '44'),
(9, 'UK10.5/US11.5', '11.5', '10.5', '44.5'),
(10, 'UK11/US12', '12', '11', '45'),
(11, 'UK12/US13', '13', '12', '46'),
(12, 'UK13/US14', '14', '13', '47.5');
CREATE TABLE IF NOT EXISTS `app_shop_sizing_chart_women` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `us_ca` varchar(200),
  `uk` varchar(200),
  `eu` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_shop_sizing_chart_women` (`id`, `title`, `us_ca`, `uk`, `eu`) VALUES
(1, 'UK3/US5', '5', '3', '35.5');
CREATE TABLE IF NOT EXISTS `app_shop_sizing_chart_tiny_toms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `us_ca` varchar(200),
  `uk` varchar(200),
  `eu` varchar(200),
  `approx_age` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_shop_sizing_chart_tiny_toms` (`id`, `title`, `us_ca`, `uk`, `eu`, `approx_age`) VALUES
(1, 'UK1.5/US2', '2', '1.5', '17.5', 'Infant (0-12 months)');
CREATE TABLE IF NOT EXISTS `app_shop_sizing_chart_youth` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `us_ca` varchar(200),
  `uk` varchar(200),
  `eu` varchar(200),
  `approx_age` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_shop_sizing_chart_youth` (`id`, `title`, `us_ca`, `uk`, `eu`, `approx_age`) VALUES
(1, 'UK12.0/US11.0', '12.0', '11.0', '30.0', 'Children (5 years)');

CREATE TABLE IF NOT EXISTS `app_shop_product_feature` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `category_id_list` text,
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `app_shop_product_feature` (`id`, `title`) VALUES
(1, 'Animal Print'),
(2, 'Burlap'),
(3, 'Canvas'),
(4, 'Core'),
(5, 'Denim'),
(6, 'Glitter'),
(7, 'Fleece'),
(8, 'Knit'),
(9, 'Pattern'),
(10, 'Plaid'),
(11, 'Prints and Patterns'),
(12, 'Recyclable'),
(13, 'Shine'),
(14, 'Solids'),
(15, 'Twill'),
(16, 'Vegan'),
(17, 'Wool'),
(18, 'Woven');
	
CREATE TABLE IF NOT EXISTS `app_shop_product_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200),
  `created_on` int(11) unsigned DEFAULT NULL,
  `modified_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

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
  `user_id` int(11) unsigned DEFAULT NULL,
  `topic_id` int(11) unsigned DEFAULT NULL,
  `os_id` int(11) unsigned DEFAULT NULL,
  `browser_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(500) default '',
  `email` varchar(500),
  `phone` varchar(500),
  `description` text default '',
  `created_on` int(11) unsigned DEFAULT 0,
  `modified_on` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `footer_cu_feedbacks_users1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `footer_cu_feedbacks`
    ADD CONSTRAINT `fk_footer_cu_feedbacks_topics1` FOREIGN KEY(`topic_id`) REFERENCES `footer_cu_topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_footer_cu_feedbacks_os1` FOREIGN KEY(`os_id`) REFERENCES `footer_cu_operating_systems` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_footer_cu_feedbacks_browsers1` FOREIGN KEY(`browser_id`) REFERENCES `footer_cu_browsers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `footer_cu_feedbacks_users1` FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
CREATE TABLE IF NOT EXISTS `footer_terms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` text,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`) 
);
INSERT INTO `footer_terms` (`description`) VALUES
('Sample terms');
CREATE TABLE IF NOT EXISTS `footer_privacy` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` text,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`) 
);
INSERT INTO `footer_privacy` (`description`) VALUES
('Sample privacy');
-- trending feature
CREATE TABLE IF NOT EXISTS `hashtags` (
  `hashtag` varchar(300),
  `status_list` text,
  `counter` int(11) unsigned DEFAULT 0,
  PRIMARY KEY(`hashtag`) 
);
-- notifications
CREATE TABLE IF NOT EXISTS `notification_list`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `list` text,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;
ALTER TABLE `notification_list`
ADD CONSTRAINT `fk_notification_list` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Login page background image configuration table
CREATE TABLE `landing_img`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(500) NOT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`)
)AUTO_INCREMENT=1;