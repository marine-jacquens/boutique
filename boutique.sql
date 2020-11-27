-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 26 nov. 2020 à 15:53
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `boutique`
--

-- --------------------------------------------------------

--
-- Structure de la table `bills_addresses`
--

DROP TABLE IF EXISTS `bills_addresses`;
CREATE TABLE IF NOT EXISTS `bills_addresses` (
  `id_bill_address` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `bill_address` varchar(255) NOT NULL,
  `bill_city` varchar(255) NOT NULL,
  `bill_country` varchar(255) NOT NULL,
  `bill_postcode` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  PRIMARY KEY (`id_bill_address`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `bills_addresses`
--

INSERT INTO `bills_addresses` (`id_bill_address`, `id_user`, `bill_address`, `bill_city`, `bill_country`, `bill_postcode`, `firstname`, `lastname`, `phone`, `mail`) VALUES
(11, 55, '7 Boulevard Jean Baptiste Ivaldi', 'Marseille', 'France', 13004, 'Mélanie', 'Jacquens', '0646113565', 'marine.jacquens@gmail.com'),
(10, 53, '7 Boulevard Jean Baptiste Ivaldi', 'Marseille', 'France', 13004, 'Marine', 'Jacquens', '0646113565', 'marine.jacquens@gmail.com'),
(9, 53, '7 Boulevard Jean Baptiste Ivaldi', 'Marseille', 'France', 13004, 'Marine', 'Jacquens', '0646113565', 'marine.jacquens@gmail.com'),
(8, 53, '7 Boulevard Jean Baptiste Ivaldi', 'Marseille', 'France', 13004, 'Marine', 'Jacquens', '0646113565', 'marine.jacquens@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE IF NOT EXISTS `cart_items` (
  `id_cart_item` int(11) NOT NULL AUTO_INCREMENT,
  `id_product_detail` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `saved_for_later` tinyint(1) NOT NULL,
  `quantity` int(11) NOT NULL,
  `time_added` datetime NOT NULL,
  PRIMARY KEY (`id_cart_item`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cart_items`
--

INSERT INTO `cart_items` (`id_cart_item`, `id_product_detail`, `id_user`, `saved_for_later`, `quantity`, `time_added`) VALUES
(1, 109, 53, 0, 1, '2020-11-23 16:46:19'),
(2, 110, 53, 0, 1, '2020-11-25 11:23:04'),
(3, 105, 53, 0, 1, '2020-11-25 11:29:51'),
(4, 108, 53, 0, 2, '2020-11-22 15:36:41'),
(5, 107, 53, 0, 1, '2020-11-18 22:16:35'),
(6, 106, 53, 0, 1, '2020-11-23 00:48:50'),
(7, 103, 53, 0, 1, '2020-11-23 16:58:15'),
(8, 103, 55, 0, 1, '2020-11-21 11:13:06'),
(9, 102, 53, 0, 1, '2020-11-23 16:58:26'),
(10, 114, 53, 0, 1, '2020-11-25 18:30:17'),
(11, 113, 53, 0, 1, '2020-11-25 18:29:14'),
(12, 111, 53, 0, 1, '2020-11-25 18:30:24'),
(13, 112, 53, 0, 1, '2020-11-25 18:30:06');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `name_category` varchar(250) NOT NULL,
  `description_category` text DEFAULT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_category`, `name_category`, `description_category`) VALUES
(1, 'femme', 'Entre chic parisien et flegme contemporain, la collection série de Dupez mêle habilement des styles différent et vous réconcilie avec les tendances du moment : robes, blazers, blousons motard, tee-shirts, jeans, combinaisons, sweat-shirts, blousons aviateur, etc.'),
(2, 'homme', 'Découvrez les essentiels modernes et urbains du vestiaire masculin. La saison fait la part belle aux différentes textures, avec de la laine de premier choix, du velours et du cuir métallisé texturisé. Les graphismes audacieux sont caractérisés par une palette noire et blanche.'),
(3, 'enfant', 'Tout est une question d’attitude. Ces pièces sportives pour fille et garçon sont idéales pour donner le coup d’envoi à l’automne et ses milles aventures.');

-- --------------------------------------------------------

--
-- Structure de la table `deliveries_addresses`
--

DROP TABLE IF EXISTS `deliveries_addresses`;
CREATE TABLE IF NOT EXISTS `deliveries_addresses` (
  `id_delivery_address` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `delivery_address` varchar(255) NOT NULL,
  `delivery_city` varchar(255) NOT NULL,
  `delivery_country` varchar(255) NOT NULL,
  `delivery_postcode` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  PRIMARY KEY (`id_delivery_address`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `deliveries_addresses`
--

INSERT INTO `deliveries_addresses` (`id_delivery_address`, `id_user`, `delivery_address`, `delivery_city`, `delivery_country`, `delivery_postcode`, `firstname`, `lastname`, `phone`, `mail`) VALUES
(16, 55, '7 Boulevard Jean Baptiste Ivaldi', 'Marseille', 'France', 13004, 'Mélanie', 'Jacquens', '0646113565', 'marine.jacquens@gmail.com'),
(15, 53, '7 Boulevard Jean Baptiste Ivaldi', 'Marseille', 'France', 13004, 'Marine', 'Jacquens', '0646113565', 'marine.jacquens@gmail.com'),
(14, 53, '7 Boulevard Jean Baptiste Ivaldi', 'Marseille', 'France', 13004, 'Marine', 'Jacquens', '0646113565', 'marine.jacquens@gmail.com'),
(13, 53, '7 Boulevard Jean Baptiste Ivaldi', 'Marseille', 'France', 13004, 'Marine', 'Jacquens', '0646113565', 'marine.jacquens@gmail.com'),
(12, 53, '7 Boulevard Jean Baptiste Ivaldi', 'Marseille', 'France', 13004, 'Marine', 'Jacquens', '0646113565', 'marine.jacquens@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `discount`
--

DROP TABLE IF EXISTS `discount`;
CREATE TABLE IF NOT EXISTS `discount` (
  `id_discount` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `discount` float NOT NULL,
  `type` varchar(250) NOT NULL,
  `date_created` datetime NOT NULL,
  `validity` datetime NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id_discount`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
CREATE TABLE IF NOT EXISTS `newsletter` (
  `id_newsletter` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `mail` varchar(255) NOT NULL,
  `autorisation` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_newsletter`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `newsletter`
--

INSERT INTO `newsletter` (`id_newsletter`, `id_user`, `mail`, `autorisation`) VALUES
(1, 53, 'marine.jacquens@gmail.com', 0),
(2, NULL, 'melanie.jacquens@gmail.com', 0),
(20, 55, 'melanie.roset@gmail.com', 1);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id_order` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_bill_address` int(11) NOT NULL,
  `id_delivery_address` int(11) NOT NULL,
  `id_discount` int(11) DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `status` varchar(250) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`id_order`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id_order`, `id_user`, `id_bill_address`, `id_delivery_address`, `id_discount`, `date_created`, `date_modified`, `status`, `amount`) VALUES
(8, 53, 10, 15, NULL, '2020-11-25 11:30:25', NULL, 'pending', 30),
(7, 53, 9, 14, NULL, '2020-11-25 11:23:43', '2020-11-25 19:54:12', 'cancelled', 55),
(6, 53, 8, 13, NULL, '2020-11-25 02:33:50', '2020-11-25 11:21:57', 'cancelled', 204),
(9, 55, 11, 16, NULL, '2020-11-25 21:35:42', NULL, 'pending', 35);

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id_order_item` int(11) NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL,
  `id_product_detail` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id_order_item`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `order_items`
--

INSERT INTO `order_items` (`id_order_item`, `id_order`, `id_product_detail`, `quantity`) VALUES
(17, 8, 103, 1),
(16, 8, 105, 1),
(15, 7, 111, 1),
(14, 7, 110, 1),
(13, 6, 113, 2),
(12, 6, 114, 3);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `id_sub_category_2` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id_product`)
) ENGINE=MyISAM AUTO_INCREMENT=114 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id_product`, `id_sub_category_2`, `product_name`, `description`, `picture`, `price`) VALUES
(106, 2, '	PULL A COL EN V JAUNE VU SUR FALLON DANS DYNASTIE', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 'uploads/dynastie-pull-froufrou-jaune-fallon.png', 35),
(110, 33, 'POCHETTE EN CUIR AVEC CHAINE VUE AU BRAS DE KIM KARDASHIAN', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 'uploads/POCHETTE EN CUIR AVEC CHAINE VU AU BRAS DE  KIM KARDASHIAN.jpg', 20),
(113, 2, 'ROBE JAUNE A MOTIF VUE SUR EMILY DANS EMILY IN PARIS', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 'uploads/robe-jaune-motif-emily-in-paris.png', 38),
(112, 2, 'VESTE BOMBER MOTIFS FLORAUX VUE SUR VILLANELLE DANS KILLING EVE', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 'uploads/veste bomber motifs floraux_killing eve.png', 45),
(111, 1, 'ROBE JEAN PAUL GAULTIER VUE SUR KIM KARDASHIAN', 'Evénement : PEOPLE S CHOICE AWARDS', 'uploads/ROBE JEAN PAUL GAULTIER .png', 45),
(109, 33, 'TALONS DELICATS NOIRS VUS SUR KIM KARDASHIAN', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 'uploads/talons-delicats-noirs-kim-kardashian.jpg', 35),
(107, 34, 'SAC MULTICOLOR PORTÉ ÉPAULE VU DANS ELITE AU BRAS DE  CARLA', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 'uploads/elite-sac-carla-multicolor.jpeg', 30),
(108, 34, 'VESTE EN SATIN VERTE VU SUR LUCRECIA DANS ELITE', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 'uploads/elite-veste-lucrecia-satin-vert.png', 45);

-- --------------------------------------------------------

--
-- Structure de la table `product_details`
--

DROP TABLE IF EXISTS `product_details`;
CREATE TABLE IF NOT EXISTS `product_details` (
  `id_product_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `size` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  PRIMARY KEY (`id_product_detail`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `product_details`
--

INSERT INTO `product_details` (`id_product_detail`, `id_product`, `size`, `color`) VALUES
(112, 111, 'L', 'noir'),
(111, 110, 'unique', 'noir'),
(110, 109, '40', 'noir'),
(109, 108, 'XS', 'vert'),
(108, 108, 'S', 'vert'),
(107, 108, 'M', 'vert'),
(106, 108, 'L', 'vert'),
(105, 107, 'unique', 'arc-en-ciel'),
(104, 106, 'XS', 'jaune'),
(103, 106, 'S', 'jaune'),
(102, 106, 'M', 'jaune'),
(101, 106, 'L', 'jaune'),
(113, 112, 'M', 'noir'),
(114, 113, 'S', 'jaune');

-- --------------------------------------------------------

--
-- Structure de la table `stock_products`
--

DROP TABLE IF EXISTS `stock_products`;
CREATE TABLE IF NOT EXISTS `stock_products` (
  `id_stock_product` int(11) NOT NULL AUTO_INCREMENT,
  `id_product_detail` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`id_stock_product`)
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `stock_products`
--

INSERT INTO `stock_products` (`id_stock_product`, `id_product_detail`, `product_name`, `stock`) VALUES
(92, 109, 'VESTE EN SATIN VERTE VU SUR LUCRECIA DANS ELITE', 15),
(91, 108, 'VESTE EN SATIN VERTE VU SUR LUCRECIA DANS ELITE', 15),
(90, 107, 'VESTE EN SATIN VERTE VU SUR LUCRECIA DANS ELITE', 25),
(89, 106, 'VESTE EN SATIN VERTE VU SUR LUCRECIA DANS ELITE', 25),
(88, 105, 'SAC MULTICOLOR PORTÉ ÉPAULE VU DANS ELITE AU BRAS DE  CARLA', 15),
(87, 104, 'PULL A FROUFROU COL EN V JAUNE VU SUR FALLON DANS DYNASTIE', 0),
(86, 103, '	PULL A COL EN V JAUNE VU SUR FALLON DANS DYNASTIE', 10),
(85, 102, 'PULL A FROUFROU COL EN V VU SUR FALLON DANS DYNASTIE', 25),
(84, 101, 'PULL A FROUFROU COL EN V VU SUR FALLON DANS DYNASTIE', 25),
(93, 110, 'TALONS DELICATS NOIRS VUS SUR KIM KARDASHIAN', 20),
(94, 111, 'POCHETTE EN CUIR AVEC CHAINE VUE AU BRAS DE KIM KARDASHIAN', 15),
(95, 112, 'ROBE JEAN PAUL GAULTIER VUE SUR KIM KARDASHIAN', 5),
(96, 113, 'VESTE BOMBER MOTIFS FLORAUX VUE SUR VILLANELLE DANS KILLING EVE', 10),
(97, 114, 'ROBE JAUNE A MOTIF VUE SUR EMILY DANS EMILY IN PARIS', 40);

-- --------------------------------------------------------

--
-- Structure de la table `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
CREATE TABLE IF NOT EXISTS `sub_categories` (
  `id_sub_category` int(11) NOT NULL AUTO_INCREMENT,
  `name_sub_category` varchar(255) NOT NULL,
  `description_sub_category` text NOT NULL,
  PRIMARY KEY (`id_sub_category`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sub_categories`
--

INSERT INTO `sub_categories` (`id_sub_category`, `name_sub_category`, `description_sub_category`) VALUES
(1, 'automne', '	\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(2, 'hiver', '	\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(3, 'printemps', '	\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(4, 'été', '	\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"');

-- --------------------------------------------------------

--
-- Structure de la table `sub_categories_2`
--

DROP TABLE IF EXISTS `sub_categories_2`;
CREATE TABLE IF NOT EXISTS `sub_categories_2` (
  `id_sub_category_2` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(11) NOT NULL,
  `id_sub_category` int(11) NOT NULL,
  `name_sub_category_2` varchar(255) NOT NULL,
  `description_sub_category_2` text DEFAULT NULL,
  PRIMARY KEY (`id_sub_category_2`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sub_categories_2`
--

INSERT INTO `sub_categories_2` (`id_sub_category_2`, `id_category`, `id_sub_category`, `name_sub_category_2`, `description_sub_category_2`) VALUES
(1, 1, 1, 'influenceuse', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(2, 1, 1, 'star du petit écran', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(3, 1, 2, 'influenceuse', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(4, 2, 2, 'star du petit écran', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(5, 2, 4, 'star du petit écran', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(6, 2, 1, 'influenceuse', NULL),
(26, 1, 3, 'influenceuse', '	\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(24, 3, 1, 'influenceurs pitchoun', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(23, 3, 1, 'star du grand écran', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(15, 2, 1, 'star du petit écran', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(21, 3, 1, 'star du petit écran', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(28, 1, 1, 'star du grand écran', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(29, 1, 2, 'star du petit écran', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(30, 1, 2, 'star du grand écran', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(31, 1, 3, 'star du petit écran', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(32, 1, 3, 'star du grand écran', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(33, 1, 4, 'influenceuse', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(34, 1, 4, 'star du petit écran', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"'),
(35, 1, 4, 'star du grand écran', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"');

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id_tag` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id_tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(250) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `gender` varchar(250) NOT NULL,
  `birthday` date NOT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `mail` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `date_joined` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `account_type` varchar(250) NOT NULL,
  `autorisation_rgpd` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `lastname`, `firstname`, `gender`, `birthday`, `phone`, `mail`, `password`, `date_joined`, `date_modified`, `account_type`, `autorisation_rgpd`) VALUES
(53, 'Jacquens', 'Marine', 'female', '1992-07-08', '0646113565', 'marine.jacquens@gmail.com', '$2y$10$DQYqJvjFWmJAP1ve9PZ4Du.fc13l0jnGxKISx6d1cS0LA.qNfqhvq', '2020-10-19 19:44:13', '2020-11-21 20:56:31', 'admin', 1),
(55, 'Jacquens', 'Mélanie', 'female', '1993-07-08', '0646113567', 'melanie.roset@gmail.com', '$2y$10$XmN69PMIuzbDyz4NK0xSd.K0UvLgLxFemqePB4HTrogBwfFMNpReu', '2020-11-21 11:12:30', '2020-11-21 19:14:35', 'normal', 1);

-- --------------------------------------------------------

--
-- Structure de la table `wish_list_items`
--

DROP TABLE IF EXISTS `wish_list_items`;
CREATE TABLE IF NOT EXISTS `wish_list_items` (
  `id_wish_list` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `saved_for_later` tinyint(1) NOT NULL,
  `time_added` datetime NOT NULL,
  PRIMARY KEY (`id_wish_list`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `wish_list_items`
--

INSERT INTO `wish_list_items` (`id_wish_list`, `id_product`, `id_user`, `saved_for_later`, `time_added`) VALUES
(22, 106, 53, 0, '2020-11-23 17:55:39'),
(21, 109, 53, 0, '2020-11-25 21:31:37'),
(20, 107, 53, 0, '2020-11-23 17:55:33'),
(19, 107, 55, 1, '2020-11-21 11:12:57'),
(18, 108, 55, 1, '2020-11-21 11:12:54'),
(17, 108, 53, 0, '2020-11-23 17:55:37'),
(23, 112, 53, 0, '2020-11-24 22:40:25'),
(24, 113, 53, 0, '2020-11-25 21:31:30'),
(25, 110, 53, 0, '2020-11-25 21:31:33'),
(26, 111, 53, 0, '2020-11-25 21:31:10');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
