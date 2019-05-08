-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2017 at 07:05 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `damilaresho_wfg`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountdetails`
--

CREATE TABLE IF NOT EXISTS `accountdetails` (
  `accountdetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `bankname` varchar(500) NOT NULL,
  `bankaccountname` varchar(500) NOT NULL,
  `bankaccountnumber` varchar(20) NOT NULL,
  `member_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `createdon` datetime NOT NULL,
  `modifiedon` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  PRIMARY KEY (`accountdetail_id`),
  KEY `bankaccountname` (`bankaccountname`,`bankaccountnumber`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `accountdetails`
--

INSERT INTO `accountdetails` (`accountdetail_id`, `bankname`, `bankaccountname`, `bankaccountnumber`, `member_id`, `status`, `createdon`, `modifiedon`, `modifiedby`) VALUES
(2, 'Guarantee Trust Bank', 'Damilare Shobowale', '0127506510', 1, 5, '2017-06-26 18:22:53', '0000-00-00 00:00:00', 0),
(3, 'uba', 'felix felix', '8293492034832', 5, 5, '2017-06-26 19:03:12', '0000-00-00 00:00:00', 0),
(4, 'gtb', 'daniel daniel', '19102028178', 4, 5, '2017-06-26 19:09:34', '0000-00-00 00:00:00', 0),
(5, 'sdfgh', 'dfghj fghj', '34789543456', 6, 5, '2017-06-26 19:17:50', '0000-00-00 00:00:00', 0),
(6, 'asdfghj', 'asdfgh sdfghj', '23456789', 7, 5, '2017-06-26 19:21:03', '0000-00-00 00:00:00', 0),
(7, 'mgnb', 'edsfghfg ghfbmgn', '135468878', 8, 5, '2017-06-26 19:24:19', '0000-00-00 00:00:00', 0),
(8, 'fghjkl;lkjhg', 'dfghjkl hjkl;lkjhg', '2345678987', 9, 5, '2017-06-26 19:27:53', '0000-00-00 00:00:00', 0),
(9, 'fcmb', ',sdmnsa., olanrewaju', '1221435346366', 10, 5, '2017-06-26 19:31:30', '0000-00-00 00:00:00', 0),
(10, 'skye', 'oalm kept', '1238492379', 11, 5, '2017-06-26 19:34:24', '0000-00-00 00:00:00', 0),
(11, 'first bank of africa', 'oreolu olanredan', 'alskdfjaik', 12, 5, '2017-06-26 19:37:05', '0000-00-00 00:00:00', 0),
(12, 'bro dammy', 'olakunle kayode', '12424153', 13, 5, '2017-06-26 19:39:40', '0000-00-00 00:00:00', 0),
(13, 'wealth fund mikrofinamce bank', 'olaore oreola', '12425412', 14, 5, '2017-06-26 19:43:20', '0000-00-00 00:00:00', 0),
(14, 'laiskjfd', 'ls;dijgasoiglk ;iolsakdgmds;okl', '348957349', 15, 5, '2017-06-26 19:46:23', '0000-00-00 00:00:00', 0),
(15, 'banker', 'bro bank', '838773774329', 16, 5, '2017-06-26 19:50:18', '0000-00-00 00:00:00', 0),
(16, 'First Bank', 'Gbenga Oye', '0127506520', 18, 5, '2017-06-29 13:13:45', '0000-00-00 00:00:00', 0),
(17, 'Skye Bank', 'Gbenga Otedola', '0123657890', 19, 5, '2017-06-30 00:12:47', '0000-00-00 00:00:00', 0),
(18, 'dhsdbcwh', 'fwefwge shgdsgh', '323298342083', 17, 5, '2017-07-03 21:34:30', '0000-00-00 00:00:00', 0),
(19, 'dhjsfsds', 'sgdsgsgh hssdssd', '290392322', 15, 5, '2017-07-03 21:36:07', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=240 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, 0),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, 0),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, 246),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, 61),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, 672),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506),
(53, 'CI', 'COTE D''IVOIRE', 'Cote D''Ivoire', 'CIV', 384, 225),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, 0),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, 0),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE''S REPUBLIC OF', 'Korea, Democratic People''s Republic of', 'PRK', 408, 850),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996),
(116, 'LA', 'LAO PEOPLE''S DEMOCRATIC REPUBLIC', 'Lao People''s Democratic Republic', 'LAO', 418, 856),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, 269),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, 970),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, 670),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263);

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE IF NOT EXISTS `donations` (
  `donation_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `donation_ph` varchar(100) NOT NULL,
  `donation_gh` varchar(100) NOT NULL,
  `createdon` datetime NOT NULL,
  `firsttime` int(11) NOT NULL DEFAULT '0',
  `accountdetail_id` int(11) NOT NULL,
  `leftover` varchar(1000) NOT NULL DEFAULT '0',
  `readydonation_ph` datetime NOT NULL,
  `readydonation_gh` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `firstph` int(11) NOT NULL DEFAULT '0',
  `matchedstatus` int(11) NOT NULL DEFAULT '0',
  `leftover_id` varchar(255) NOT NULL DEFAULT '0',
  `paymentconfirm` int(11) NOT NULL DEFAULT '0',
  `growth` varchar(100) NOT NULL,
  `testimonialstatus` int(11) NOT NULL,
  `testimony_id` int(11) NOT NULL,
  PRIMARY KEY (`donation_id`),
  KEY `donation_ph` (`donation_ph`,`donation_gh`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`donation_id`, `member_id`, `donation_ph`, `donation_gh`, `createdon`, `firsttime`, `accountdetail_id`, `leftover`, `readydonation_ph`, `readydonation_gh`, `status`, `firstph`, `matchedstatus`, `leftover_id`, `paymentconfirm`, `growth`, `testimonialstatus`, `testimony_id`) VALUES
(26, 12, '50000', '', '2017-04-10 13:27:48', 0, 11, '0', '2017-07-03 13:27:48', '2017-07-14 13:27:48', 0, 0, 5, '1', 0, '71667', 0, 0),
(27, 13, '50000', '', '2017-06-10 13:28:33', 0, 12, '0', '2017-07-03 13:28:33', '2017-07-14 13:28:33', 5, 0, 0, '0', 0, '71667', 0, 0),
(28, 14, '10000', '', '2017-06-10 13:29:29', 0, 13, '0', '2017-07-03 13:29:29', '2017-07-14 13:29:29', 0, 0, 5, '1', 0, '14334', 1, 0),
(37, 1, '50000', '', '2017-06-22 21:57:21', 0, 2, '0', '2017-06-29 21:57:21', '2017-06-21 21:57:21', 0, 0, 5, '0', 0, '75000', 0, 0),
(43, 16, '5000', '', '2017-06-22 23:16:30', 0, 15, '0', '2017-06-29 23:16:30', '2017-06-21 23:16:30', 0, 0, 5, '0', 0, '7500', 0, 0),
(44, 16, '', '7000', '2017-07-03 23:26:39', 1, 15, '0', '2017-07-06 23:26:39', '2017-07-03 23:26:39', 0, 0, 5, '0', 0, '', 5, 4),
(45, 15, '', '3000', '2017-07-03 23:26:44', 0, 14, '0', '2017-07-06 23:26:44', '2017-07-03 23:26:44', 3, 0, 5, '0', 0, '', 0, 0),
(46, 6, '100000', '', '2017-06-10 23:31:52', 0, 5, '0', '2017-07-07 23:31:52', '2017-07-18 23:31:52', 0, 0, 5, '1', 0, '130000', 0, 0),
(47, 1, '', '80000', '2017-07-03 23:34:55', 1, 2, '0', '2017-07-06 23:34:55', '2017-07-03 23:34:55', 0, 0, 5, '0', 0, '', 5, 3),
(48, 15, '', '20000', '2017-07-03 23:35:01', 1, 14, '0', '2017-07-06 23:35:01', '2017-07-03 23:35:01', 3, 0, 5, '0', 0, '', 0, 0),
(49, 19, '10000', '', '2017-06-22 23:38:29', 0, 17, '0', '2017-06-29 23:38:29', '2017-06-21 23:38:29', 0, 0, 5, '0', 0, '15000', 0, 0),
(50, 19, '', '15000', '2017-07-03 23:39:29', 1, 17, '0', '2017-07-06 23:39:29', '2017-07-03 23:39:29', 0, 0, 5, '0', 0, '', 0, 0),
(51, 17, '', '0', '2017-07-03 23:39:46', 1, 18, '0', '2017-07-06 23:39:46', '2017-07-03 23:39:46', 3, 0, 5, '0', 0, '', 0, 0),
(52, 17, '', '35000', '2017-07-03 23:50:00', 1, 18, '0', '2017-07-06 23:50:00', '2017-07-03 23:50:00', 5, 0, 0, '0', 0, '', 0, 0),
(53, 11, '100000', '', '2017-06-10 23:58:02', 0, 10, '0', '2017-07-07 23:58:02', '2017-07-18 23:58:02', 5, 0, 0, '0', 0, '126667', 0, 0),
(54, 8, '10000', '', '2017-07-11 22:57:01', 0, 7, '0', '2017-07-15 22:57:00', '2017-07-26 22:57:00', 5, 0, 0, '0', 0, '10334', 0, 0),
(55, 7, '5000', '', '2017-05-11 23:05:38', 0, 6, '0', '2017-07-15 23:05:38', '2017-07-26 23:05:38', 0, 0, 5, '0', 0, '5167', 0, 0),
(56, 1, '10000', '', '2017-05-30 23:11:13', 1, 2, '0', '2017-07-07 23:11:13', '2017-06-29 23:11:13', 0, 0, 5, '0', 0, '15000', 0, 0),
(58, 1, '', '15000', '2017-07-11 23:14:43', 1, 2, '0', '2017-07-14 23:14:43', '2017-07-11 23:14:43', 0, 0, 5, '0', 0, '', 1, 0),
(59, 10, '10000', '', '2017-05-11 23:17:47', 0, 9, '0', '2017-07-15 23:17:47', '2017-07-26 23:17:47', 3, 0, 5, '0', 0, '10334', 0, 0),
(60, 1, '50000', '', '2017-07-02 18:19:35', 1, 2, '0', '2017-07-09 18:19:35', '2017-07-01 18:19:35', 0, 0, 5, '0', 0, '', 0, 0),
(61, 1, '50000', '', '2017-07-02 18:31:41', 1, 2, '0', '2017-07-09 18:31:41', '2017-07-01 18:31:41', 0, 0, 5, '0', 0, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `donationsreceivable`
--

CREATE TABLE IF NOT EXISTS `donationsreceivable` (
  `donationsreceivable_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `withdrawn` varchar(100) NOT NULL,
  `balance` varchar(100) NOT NULL,
  `thedate` datetime NOT NULL,
  PRIMARY KEY (`donationsreceivable_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `donationsreceivable`
--

INSERT INTO `donationsreceivable` (`donationsreceivable_id`, `member_id`, `amount`, `withdrawn`, `balance`, `thedate`) VALUES
(33, 12, '5000', '0', '5000', '2017-07-11 23:33:31'),
(34, 13, '0', '0', '0', '2017-07-11 23:33:31'),
(35, 14, '15000', '0', '15000', '2017-07-11 23:33:31'),
(36, 19, '15000', '15000', '0', '2017-07-11 23:33:31'),
(37, 1, '92000', '0', '92000', '2017-07-11 23:33:31'),
(38, 16, '7500', '7000', '500', '2017-07-11 23:33:31'),
(39, 6, '1000', '0', '1000', '2017-07-11 23:33:31'),
(40, 11, '0', '0', '0', '2017-07-11 23:33:31'),
(41, 8, '0', '0', '0', '2017-07-11 23:33:31'),
(42, 7, '0', '0', '0', '2017-07-11 23:33:31'),
(43, 10, '0', '0', '0', '2017-07-11 23:33:31');

-- --------------------------------------------------------

--
-- Table structure for table `matching`
--

CREATE TABLE IF NOT EXISTS `matching` (
  `matching_id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_id` int(11) NOT NULL,
  `receive_id` int(11) NOT NULL,
  `accountdetail_id` int(11) NOT NULL,
  `transferfund_id` int(11) NOT NULL,
  `receivefund_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `amount` varchar(10000) NOT NULL,
  `thedate` datetime NOT NULL,
  `admin_id` int(11) NOT NULL,
  `expirydate` datetime NOT NULL,
  `sendemail` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`matching_id`),
  KEY `transfer_id` (`transfer_id`,`receive_id`,`thedate`,`expirydate`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

--
-- Dumping data for table `matching`
--

INSERT INTO `matching` (`matching_id`, `transfer_id`, `receive_id`, `accountdetail_id`, `transferfund_id`, `receivefund_id`, `status`, `amount`, `thedate`, `admin_id`, `expirydate`, `sendemail`) VALUES
(86, 14, 16, 15, 28, 44, 0, '7000', '2017-07-03 23:26:44', 0, '2017-07-06 23:26:44', 0),
(87, 14, 15, 14, 28, 45, 5, '3000', '2017-07-03 23:26:44', 0, '2017-07-06 23:26:44', 0),
(88, 6, 1, 2, 46, 47, 0, '80000', '2017-07-03 23:35:01', 0, '2017-07-06 23:35:01', 0),
(89, 6, 15, 14, 46, 48, 5, '20000', '2017-07-03 23:35:01', 0, '2017-07-06 23:35:01', 0),
(90, 12, 19, 17, 26, 50, 0, '15000', '2017-07-03 23:39:46', 0, '2017-07-06 23:39:46', 0),
(91, 12, 17, 18, 26, 51, 4, '35000', '2017-07-03 23:39:46', 0, '2017-07-06 23:39:46', 0),
(92, 7, 1, 2, 55, 58, 0, '5000', '2017-07-11 23:33:31', 0, '2017-07-14 23:33:31', 0),
(93, 10, 1, 2, 59, 58, 5, '10000', '2017-07-11 23:33:31', 0, '2017-07-14 23:33:31', 0);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `new_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `content` text NOT NULL,
  `thedate` datetime NOT NULL,
  PRIMARY KEY (`new_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`new_id`, `member_id`, `title`, `content`, `thedate`) VALUES
(1, 1, 'Welcome to Wealth Fund Global Community', '<p><strong></strong><strong></strong><strong>Welcome to&nbsp;</strong><strong>Global Fund Community,&nbsp;</strong>a community where you transfer and receive fund for the benefits of all.</p>', '2017-07-08 03:25:15');

-- --------------------------------------------------------

--
-- Table structure for table `testimony`
--

CREATE TABLE IF NOT EXISTS `testimony` (
  `testimony_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` varchar(300) NOT NULL,
  `letter` text NOT NULL,
  `donation_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `thedate` datetime NOT NULL,
  PRIMARY KEY (`testimony_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `testimony`
--

INSERT INTO `testimony` (`testimony_id`, `member_id`, `letter`, `donation_id`, `status`, `thedate`) VALUES
(3, '1', 'My Name is Shobowale Damilare and I live in Lagos, Nigeria. I made a transfer request of 50000 on the 30th June, 2017 and I received the sum of 80000 on the 7th June 2017. Thanks to Wealth Fund Global!', 47, 5, '2017-07-07 20:57:55'),
(4, '16', 'Hello', 44, 5, '2017-07-07 21:15:40');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
