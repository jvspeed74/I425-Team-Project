-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2024 at 09:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `f1_db`
--
CREATE DATABASE IF NOT EXISTS `f1_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `f1_db`;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `team_id` smallint(5) UNSIGNED DEFAULT NULL,
  `model` varchar(100) NOT NULL,
  `year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `team_id`, `model`, `year`) VALUES
(1, 1, 'RB20', '2024'),
(2, 2, 'W15', '2024'),
(3, 3, 'SF-24', '2024'),
(4, 4, 'AMR24', '2024'),
(5, 5, 'MCL60', '2024'),
(6, 6, 'A524', '2024'),
(7, 7, 'AT04', '2024'),
(8, 8, 'C44', '2024'),
(9, 9, 'VF-24', '2024'),
(10, 10, 'FW46', '2024');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'Afghanistan'),
(2, 'Albania'),
(3, 'Algeria'),
(4, 'Andorra'),
(5, 'Angola'),
(6, 'Antigua and Barbuda'),
(7, 'Argentina'),
(8, 'Armenia'),
(9, 'Australia'),
(10, 'Austria'),
(11, 'Azerbaijan'),
(12, 'Bahamas'),
(13, 'Bahrain'),
(14, 'Bangladesh'),
(15, 'Barbados'),
(16, 'Belarus'),
(17, 'Belgium'),
(18, 'Belize'),
(19, 'Benin'),
(20, 'Bhutan'),
(21, 'Bolivia'),
(22, 'Bosnia and Herzegovina'),
(23, 'Botswana'),
(24, 'Brazil'),
(25, 'Brunei'),
(26, 'Bulgaria'),
(27, 'Burkina Faso'),
(28, 'Burundi'),
(29, 'Cabo Verde'),
(30, 'Cambodia'),
(31, 'Cameroon'),
(32, 'Canada'),
(33, 'Central African Republic'),
(34, 'Chad'),
(35, 'Chile'),
(36, 'China'),
(37, 'Colombia'),
(38, 'Comoros'),
(39, 'Congo, Democratic Republic of the'),
(40, 'Congo, Republic of the'),
(41, 'Costa Rica'),
(42, 'Croatia'),
(43, 'Cuba'),
(44, 'Cyprus'),
(45, 'Czechia'),
(46, 'Denmark'),
(47, 'Djibouti'),
(48, 'Dominica'),
(49, 'Dominican Republic'),
(50, 'Ecuador'),
(51, 'Egypt'),
(52, 'El Salvador'),
(53, 'Equatorial Guinea'),
(54, 'Eritrea'),
(55, 'Estonia'),
(56, 'Eswatini'),
(57, 'Ethiopia'),
(58, 'Fiji'),
(59, 'Finland'),
(60, 'France'),
(61, 'Gabon'),
(62, 'Gambia'),
(63, 'Georgia'),
(64, 'Germany'),
(65, 'Ghana'),
(66, 'Greece'),
(67, 'Grenada'),
(68, 'Guatemala'),
(69, 'Guinea'),
(70, 'Guinea-Bissau'),
(71, 'Guyana'),
(72, 'Haiti'),
(73, 'Honduras'),
(74, 'Hungary'),
(75, 'Iceland'),
(76, 'India'),
(77, 'Indonesia'),
(78, 'Iran'),
(79, 'Iraq'),
(80, 'Ireland'),
(81, 'Israel'),
(82, 'Italy'),
(83, 'Ivory Coast'),
(84, 'Jamaica'),
(85, 'Japan'),
(86, 'Jordan'),
(87, 'Kazakhstan'),
(88, 'Kenya'),
(89, 'Kiribati'),
(90, 'Korea, North'),
(91, 'Korea, South'),
(92, 'Kosovo'),
(93, 'Kuwait'),
(94, 'Kyrgyzstan'),
(95, 'Laos'),
(96, 'Latvia'),
(97, 'Lebanon'),
(98, 'Lesotho'),
(99, 'Liberia'),
(100, 'Libya'),
(101, 'Liechtenstein'),
(102, 'Lithuania'),
(103, 'Luxembourg'),
(104, 'Madagascar'),
(105, 'Malawi'),
(106, 'Malaysia'),
(107, 'Maldives'),
(108, 'Mali'),
(109, 'Malta'),
(110, 'Marshall Islands'),
(111, 'Mauritania'),
(112, 'Mauritius'),
(113, 'Mexico'),
(114, 'Micronesia'),
(115, 'Moldova'),
(116, 'Monaco'),
(117, 'Mongolia'),
(118, 'Montenegro'),
(119, 'Morocco'),
(120, 'Mozambique'),
(121, 'Myanmar (Burma)'),
(122, 'Namibia'),
(123, 'Nauru'),
(124, 'Nepal'),
(125, 'Netherlands'),
(126, 'New Zealand'),
(127, 'Nicaragua'),
(128, 'Niger'),
(129, 'Nigeria'),
(130, 'North Macedonia'),
(131, 'Norway'),
(132, 'Oman'),
(133, 'Pakistan'),
(134, 'Palau'),
(135, 'Panama'),
(136, 'Papua New Guinea'),
(137, 'Paraguay'),
(138, 'Peru'),
(139, 'Philippines'),
(140, 'Poland'),
(141, 'Portugal'),
(142, 'Qatar'),
(143, 'Romania'),
(144, 'Russia'),
(145, 'Rwanda'),
(146, 'Saint Kitts and Nevis'),
(147, 'Saint Lucia'),
(148, 'Saint Vincent and the Grenadines'),
(149, 'Samoa'),
(150, 'San Marino'),
(151, 'Sao Tome and Principe'),
(152, 'Saudi Arabia'),
(153, 'Senegal'),
(154, 'Serbia'),
(155, 'Seychelles'),
(156, 'Sierra Leone'),
(157, 'Singapore'),
(158, 'Slovakia'),
(159, 'Slovenia'),
(160, 'Solomon Islands'),
(161, 'Somalia'),
(162, 'South Africa'),
(163, 'South Sudan'),
(164, 'Spain'),
(165, 'Sri Lanka'),
(166, 'Sudan'),
(167, 'Suriname'),
(168, 'Sweden'),
(169, 'Switzerland'),
(170, 'Syria'),
(171, 'Taiwan'),
(172, 'Tajikistan'),
(173, 'Tanzania'),
(174, 'Thailand'),
(175, 'Timor-Leste'),
(176, 'Togo'),
(177, 'Tonga'),
(178, 'Trinidad and Tobago'),
(179, 'Tunisia'),
(180, 'Turkey'),
(181, 'Turkmenistan'),
(182, 'Tuvalu'),
(183, 'Uganda'),
(184, 'Ukraine'),
(185, 'United Arab Emirates'),
(186, 'United Kingdom'),
(187, 'United States of America'),
(188, 'Uruguay'),
(189, 'Uzbekistan'),
(190, 'Vanuatu'),
(191, 'Vatican City'),
(192, 'Venezuela'),
(193, 'Vietnam'),
(194, 'Yemen'),
(195, 'Zambia'),
(196, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `team_id` smallint(5) UNSIGNED DEFAULT NULL,
  `nationality_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `birthday` date NOT NULL,
  `driver_number` smallint(5) UNSIGNED NOT NULL,
  `career_points` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `career_wins` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `career_podiums` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `championships` smallint(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `first_name`, `last_name`, `team_id`, `nationality_id`, `birthday`, `driver_number`, `career_points`, `career_wins`, `career_podiums`, `championships`) VALUES
(1, 'Max', 'Verstappen', 1, 53, '1997-09-30', 1, 2917.50, 61, 109, 3),
(2, 'Lewis', 'Hamilton', 2, 57, '1985-01-07', 44, 4500.00, 103, 180, 7),
(3, 'Charles', 'Leclerc', 3, 122, '1997-10-16', 16, 800.00, 5, 25, 0),
(4, 'Sergio', 'Perez', 1, 119, '1990-01-26', 11, 1500.00, 7, 35, 0),
(5, 'Fernando', 'Alonso', 4, 167, '1981-07-29', 14, 2150.00, 32, 100, 2),
(6, 'Carlos', 'Sainz', 3, 167, '1994-09-01', 55, 950.00, 2, 20, 0),
(7, 'George', 'Russell', 2, 57, '1998-02-15', 63, 700.00, 1, 10, 0),
(8, 'Lando', 'Norris', 5, 57, '1999-11-13', 4, 650.00, 0, 20, 0),
(9, 'Oscar', 'Piastri', 5, 10, '2001-04-06', 81, 250.00, 0, 5, 0),
(10, 'Pierre', 'Gasly', 6, 66, '1996-02-07', 10, 400.00, 1, 8, 0),
(11, 'Esteban', 'Ocon', 6, 66, '1996-09-17', 31, 450.00, 1, 10, 0),
(12, 'Lance', 'Stroll', 4, 35, '1998-10-29', 18, 350.00, 0, 3, 0),
(13, 'Valtteri', 'Bottas', 8, 65, '1989-08-28', 77, 1700.00, 10, 60, 0),
(14, 'Zhou', 'Guanyu', 8, 39, '1999-05-30', 24, 150.00, 0, 1, 0),
(15, 'Kevin', 'Magnussen', 9, 49, '1992-10-05', 20, 250.00, 0, 2, 0),
(16, 'Nico', 'Hulkenberg', 9, 70, '1987-08-19', 27, 500.00, 0, 3, 0),
(17, 'Alexander', 'Albon', 10, 178, '1996-03-23', 23, 220.00, 0, 2, 0),
(18, 'Logan', 'Sargeant', 10, 4, '2000-12-31', 2, 50.00, 0, 0, 0),
(19, 'Yuki', 'Tsunoda', 7, 91, '2000-05-11', 22, 150.00, 0, 1, 0),
(20, 'Liam', 'Lawson', 7, 130, '2002-02-11', 40, 100.00, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `scheduled_date` date DEFAULT NULL,
  `track_id` smallint(5) UNSIGNED DEFAULT NULL,
  `status` enum('Planned','Ongoing','Completed','Cancelled') NOT NULL DEFAULT 'Planned'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `scheduled_date`, `track_id`, `status`) VALUES
(1, 'Formula 1 Grand Prix de Monaco 2024', '2024-05-26', 1, 'Completed'),
(2, 'Formula 1 Aramco British Grand Prix 2024', '2024-07-07', 2, 'Completed'),
(3, 'Formula 1 Pirelli Gran Premio D\'Italia 2024', '2024-09-08', 3, 'Completed'),
(4, 'Formula 1 Rolex Belgian Grand Prix 2024', '2024-08-25', 4, 'Completed'),
(5, 'Formula 1 Honda Japanese Grand Prix 2024', '2024-10-13', 5, 'Completed'),
(6, 'Formula 1 Pirelli Grand Prix du Canada 2024', '2024-06-09', 6, 'Completed'),
(7, 'Formula 1 Singapore Airlines Singapore Grand Prix 2024', '2024-09-22', 7, 'Completed'),
(8, 'Formula 1 Heineken Grande Prêmio de São Paulo 2024', '2024-11-17', 8, 'Planned'),
(9, 'Formula 1 Lenovo United States Grand Prix 2024', '2024-10-20', 9, 'Planned'),
(10, 'Formula 1 Etihad Airways Abu Dhabi Grand Prix 2024', '2024-12-01', 10, 'Planned'),
(11, 'Formula 1 Rolex Australian Grand Prix 2024', '2024-03-17', 11, 'Completed'),
(12, 'Formula 1 STC Saudi Arabian Grand Prix 2024', '2024-03-31', 12, 'Completed'),
(13, 'Formula 1 Rolex Großer Preis von Österreich 2024', '2024-07-14', 13, 'Completed'),
(14, 'Formula 1 Gulf Air Bahrain Grand Prix 2024', '2024-03-03', 14, 'Completed'),
(15, 'Formula 1 Qatar Airways Hungarian Grand Prix 2024', '2024-08-04', 15, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `nationalities`
--

CREATE TABLE `nationalities` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nationalities`
--

INSERT INTO `nationalities` (`id`, `name`) VALUES
(1, 'Afghan'),
(2, 'Albanian'),
(3, 'Algerian'),
(4, 'American'),
(5, 'Andorran'),
(6, 'Angolan'),
(7, 'Antiguan or Barbudan'),
(8, 'Argentine'),
(9, 'Armenian'),
(10, 'Australian'),
(11, 'Austrian'),
(12, 'Azerbaijani'),
(13, 'Bahamian'),
(14, 'Bahraini'),
(15, 'Bangladeshi'),
(16, 'Barbadian'),
(17, 'Basotho'),
(18, 'Belarusian'),
(19, 'Belgian'),
(20, 'Belizean'),
(21, 'Beninese'),
(22, 'Bhutanese'),
(23, 'Bolivian'),
(24, 'Bosnian or Herzegovinian'),
(25, 'Botswanan'),
(26, 'Brazilian'),
(27, 'Bruneian'),
(28, 'Bulgarian'),
(29, 'Burkinabe'),
(30, 'Burmese'),
(31, 'Burundian'),
(32, 'Cabo Verdean'),
(33, 'Cambodian'),
(34, 'Cameroonian'),
(35, 'Canadian'),
(36, 'Central African'),
(37, 'Chadian'),
(38, 'Chilean'),
(39, 'Chinese'),
(40, 'Colombian'),
(41, 'Comoran'),
(42, 'Congolese, Democratic Republic'),
(43, 'Congolese, Republic'),
(44, 'Costa Rican'),
(45, 'Croatian'),
(46, 'Cuban'),
(47, 'Cypriot'),
(48, 'Czech'),
(49, 'Danish'),
(50, 'Djiboutian'),
(51, 'Dominican'),
(52, 'Dominican (Republic)'),
(53, 'Dutch'),
(54, 'Ecuadorian'),
(55, 'Egyptian'),
(56, 'Emirati'),
(57, 'English'),
(58, 'Equatorial Guinean'),
(59, 'Eritrean'),
(60, 'Estonian'),
(61, 'Eswatini'),
(62, 'Ethiopian'),
(63, 'Fijian'),
(64, 'Filipino'),
(65, 'Finnish'),
(66, 'French'),
(67, 'Gabonese'),
(68, 'Gambian'),
(69, 'Georgian'),
(70, 'German'),
(71, 'Ghanaian'),
(72, 'Greek'),
(73, 'Grenadian'),
(74, 'Guatemalan'),
(76, 'Guinea-Bissauan'),
(75, 'Guinean'),
(77, 'Guyanese'),
(78, 'Haitian'),
(79, 'Honduran'),
(80, 'Hungarian'),
(81, 'Icelandic'),
(82, 'Indian'),
(83, 'Indonesian'),
(84, 'Iranian'),
(85, 'Iraqi'),
(86, 'Irish'),
(87, 'Israeli'),
(88, 'Italian'),
(89, 'Ivorian'),
(90, 'Jamaican'),
(91, 'Japanese'),
(92, 'Jordanian'),
(93, 'Kazakhstani'),
(94, 'Kenyan'),
(95, 'Kiribati'),
(96, 'Korean, North'),
(97, 'Korean, South'),
(98, 'Kosovar'),
(99, 'Kuwaiti'),
(100, 'Kyrgyzstani'),
(101, 'Lao'),
(102, 'Latvian'),
(103, 'Lebanese'),
(104, 'Liberian'),
(105, 'Libyan'),
(106, 'Liechtenstein'),
(107, 'Lithuanian'),
(108, 'Luxembourgish'),
(109, 'Madagascan'),
(110, 'Malagasy'),
(111, 'Malawian'),
(112, 'Malaysian'),
(113, 'Maldivian'),
(114, 'Malian'),
(115, 'Maltese'),
(116, 'Marshallese'),
(117, 'Mauritanian'),
(118, 'Mauritian'),
(119, 'Mexican'),
(120, 'Micronesian'),
(121, 'Moldovan'),
(122, 'Monégasque'),
(123, 'Mongolian'),
(124, 'Montenegrin'),
(125, 'Moroccan'),
(126, 'Mozambican'),
(127, 'Namibian'),
(128, 'Nauruan'),
(129, 'Nepali'),
(130, 'New Zealander'),
(131, 'Nicaraguan'),
(133, 'Nigerian'),
(132, 'Nigerien'),
(134, 'North Macedonian'),
(135, 'Norwegian'),
(136, 'Omani'),
(137, 'Pakistani'),
(138, 'Palauan'),
(139, 'Panamanian'),
(140, 'Papua New Guinean'),
(141, 'Paraguayan'),
(142, 'Peruvian'),
(143, 'Polish'),
(144, 'Portuguese'),
(145, 'Qatari'),
(146, 'Romanian'),
(147, 'Russian'),
(148, 'Rwandan'),
(149, 'Saint Kitts and Nevis'),
(150, 'Saint Lucian'),
(151, 'Saint Vincentian'),
(152, 'Samoan'),
(153, 'Sanmarinese'),
(154, 'Sao Tomean'),
(155, 'Saudi Arabian'),
(156, 'Senegalese'),
(157, 'Serbian'),
(158, 'Seychellois'),
(159, 'Sierra Leonean'),
(160, 'Singaporean'),
(161, 'Slovak'),
(162, 'Slovene'),
(163, 'Solomon Islander'),
(164, 'Somali'),
(165, 'South African'),
(166, 'South Sudanese'),
(167, 'Spanish'),
(168, 'Sri Lankan'),
(169, 'Sudanese'),
(170, 'Surinamese'),
(171, 'Swazi'),
(172, 'Swedish'),
(173, 'Swiss'),
(174, 'Syrian'),
(175, 'Taiwanese'),
(176, 'Tajikistani'),
(177, 'Tanzanian'),
(178, 'Thai'),
(179, 'Timorese'),
(180, 'Togolese'),
(181, 'Tongan'),
(182, 'Trinidadian or Tobagonian'),
(183, 'Tunisian'),
(184, 'Turkish'),
(185, 'Turkmen'),
(186, 'Tuvaluan'),
(187, 'Ugandan'),
(188, 'Ukrainian'),
(189, 'Uruguayan'),
(190, 'Uzbekistani'),
(191, 'Vanuatuan'),
(192, 'Vatican'),
(193, 'Venezuelan'),
(194, 'Vietnamese'),
(195, 'Yemeni'),
(196, 'Zambian'),
(197, 'Zimbabwean');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `official_name` varchar(100) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `headquarters` varchar(100) NOT NULL,
  `team_principal` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `official_name`, `short_name`, `headquarters`, `team_principal`) VALUES
(1, 'Oracle Red Bull Racing', 'Red Bull', 'Milton Keynes, United Kingdom', 'Christian Horner'),
(2, 'Mercedes-AMG Petronas Formula One Team', 'Mercedes', 'Brackley, United Kingdom', 'Toto Wolff'),
(3, 'Scuderia Ferrari', 'Ferrari', 'Maranello, Italy', 'Frédéric Vasseur'),
(4, 'Aston Martin Aramco Cognizant Formula One Team', 'Aston Martin', 'Silverstone, United Kingdom', 'Mike Krack'),
(5, 'McLaren F1 Team', 'McLaren', 'Woking, United Kingdom', 'Andrea Stella'),
(6, 'BWT Alpine F1 Team', 'Alpine', 'Enstone, United Kingdom', 'Bruno Famin'),
(7, 'Scuderia AlphaTauri', 'AlphaTauri', 'Faenza, Italy', 'Franz Tost'),
(8, 'Alfa Romeo F1 Team Stake', 'Alfa Romeo', 'Hinwil, Switzerland', 'Alessandro Alunni Bravi'),
(9, 'Updated Team', 'UpTeam', 'Milton Keynes, United Kingdom', 'Tom Manly'),
(10, 'Williams Racing', 'Williams', 'Grove, United Kingdom', 'James Vowles');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` smallint(6) NOT NULL,
  `user_id` smallint(6) NOT NULL,
  `token` varchar(800) NOT NULL,
  `token_type` enum('bearer','jwt') NOT NULL,
  `revoked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `expires_at` timestamp NOT NULL DEFAULT (current_timestamp() + interval 15 minute)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `user_id`, `token`, `token_type`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
(1, 2, '7cd76cdf4f74eae64050b4b8d6cb6b17a737f2bfe6116d1fb46309355dfdbcbb', 'bearer', 0, '2024-11-22 07:39:32', '2024-11-22 07:39:32', '2024-12-31 07:38:48'),
(2, 2, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3MzIyNjE2MjcsImV4cCI6MTczNDg5MTY0M30.Sc8UicNae0t2MYbjp3vSFJu-BKveY1Bp81Pv7fuY3ns', 'jwt', 0, '2024-11-22 13:47:07', '2024-11-22 13:47:07', '2024-12-23 00:20:43');

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE `tracks` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `length_km` decimal(5,2) NOT NULL,
  `continent` enum('Africa','Asia','Europe','North America','South America','Australia','Antarctica') NOT NULL,
  `country_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `description` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tracks`
--

INSERT INTO `tracks` (`id`, `name`, `length_km`, `continent`, `country_id`, `description`) VALUES
(1, 'Circuit de Monaco', 3.34, 'Europe', 116, 'Historic street circuit known for its tight turns and luxury backdrop.'),
(2, 'Silverstone Circuit', 5.89, 'Europe', 186, 'The birthplace of Formula 1, located in the United Kingdom.'),
(3, 'Monza Circuit', 5.79, 'Europe', 82, 'Known as the Temple of Speed, one of the fastest circuits in the world.'),
(4, 'Spa-Francorchamps', 7.00, 'Europe', 17, 'A challenging circuit famous for Eau Rouge and fast elevation changes.'),
(5, 'Suzuka International Racing Course', 5.81, 'Asia', 85, 'Unique figure-eight circuit in Japan known for its challenging corners.'),
(6, 'Circuit Gilles Villeneuve', 4.36, 'North America', 32, 'A hybrid track located in Montreal, blending street and purpose-built features.'),
(7, 'Marina Bay Street Circuit', 5.06, 'Asia', 157, 'Singapore street circuit, famous for hosting the F1 night race.'),
(8, 'Interlagos (Autódromo José Carlos Pace)', 4.31, 'South America', 24, 'Brazilian circuit known for its passionate fans and undulating terrain.'),
(9, 'Circuit of the Americas', 5.51, 'North America', 187, 'Located in Austin, Texas, known for its long straights and challenging elevation changes.'),
(10, 'Yas Marina Circuit', 5.55, 'Asia', 185, 'Abu Dhabi circuit known for hosting the season finale and racing under the lights.'),
(11, 'Albert Park Circuit', 5.28, 'Australia', 9, 'Street circuit in Melbourne, the traditional opening race of the season.'),
(12, 'Jeddah Street Circuit', 6.17, 'Asia', 152, 'High-speed street circuit in Saudi Arabia, known as one of the fastest street circuits.'),
(13, 'Red Bull Ring', 4.32, 'Europe', 10, 'A short but high-speed track located in Austria with stunning scenic views.'),
(14, 'Bahrain International Circuit', 5.41, 'Asia', 13, 'A desert circuit known for its night race and heavy braking zones.'),
(15, 'Hungaroring', 4.38, 'Europe', 74, 'A technical track in Hungary, often called \"Monaco without the walls\".');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` smallint(6) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'default', '$2y$10$rd3rB1CpuT44jEnDBITGYe9j8m7Ndtsqv2gvTZqnUMioCjOS0nzIe', '2024-11-21 23:09:38', '2024-11-21 23:09:38'),
(2, 'test', '$2y$10$xZ/6bz./NVyTVnBZLmXPtuDKUEVKXzYDIjoK9psKYwVwwdJfTi4Zy', '2024-11-21 23:10:44', '2024-11-21 23:10:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `idx_year` (`year`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `driver_number` (`driver_number`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `nationality_id` (`nationality_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD KEY `track_id` (`track_id`);

--
-- Indexes for table `nationalities`
--
ALTER TABLE `nationalities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `official_name` (`official_name`),
  ADD UNIQUE KEY `short_name` (`short_name`) USING BTREE;

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`) USING HASH,
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tracks`
--
ALTER TABLE `tracks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `nationalities`
--
ALTER TABLE `nationalities`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tracks`
--
ALTER TABLE `tracks`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `drivers_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `drivers_ibfk_2` FOREIGN KEY (`nationality_id`) REFERENCES `nationalities` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tracks`
--
ALTER TABLE `tracks`
  ADD CONSTRAINT `tracks_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
