-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 05 avr. 2026 à 17:05
-- Version du serveur : 11.4.10-MariaDB
-- Version de PHP : 8.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sc1tasq5564_ecosystemeimmo`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','conseiller') NOT NULL DEFAULT 'conseiller',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin_users`
--

INSERT INTO `admin_users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `role`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Olivier', 'Colas', 'contact@ecosystemeimmo.fr', '652100', NULL, 'admin', 1, '2026-04-05 15:09:45', '2026-04-05 15:09:45');

-- --------------------------------------------------------

--
-- Structure de la table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(10) UNSIGNED NOT NULL,
  `admin_user_id` int(10) UNSIGNED NOT NULL,
  `prospect_id` int(10) UNSIGNED DEFAULT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `rdv_type_id` int(10) UNSIGNED NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` enum('scheduled','confirmed','cancelled','completed') NOT NULL DEFAULT 'scheduled',
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `appointments`
--

INSERT INTO `appointments` (`id`, `admin_user_id`, `prospect_id`, `client_id`, `rdv_type_id`, `start_time`, `end_time`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 1, '2023-12-15 10:00:00', '2023-12-15 11:00:00', 'scheduled', NULL, '2026-04-05 15:11:05', '2026-04-05 15:11:05');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `prospect_id` int(10) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contract_signed_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `conseillers`
--

CREATE TABLE `conseillers` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `statut` enum('actif','inactif','en_attente') DEFAULT 'en_attente',
  `date_inscription` datetime DEFAULT current_timestamp(),
  `dernier_acces` datetime DEFAULT NULL,
  `id_territoire` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `exercice_mots_cles`
--

CREATE TABLE `exercice_mots_cles` (
  `id` int(11) NOT NULL,
  `id_lead` int(11) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `apparait_premiere_page` enum('oui','non','parfois') DEFAULT 'non',
  `concurrents` text DEFAULT NULL,
  `leads_perdus_estimes` varchar(20) DEFAULT NULL,
  `date_completion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `ville` varchar(100) NOT NULL,
  `reponse_epee` text NOT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  `statut` enum('nouveau','contacte','rdv_pris','converti','perdu') DEFAULT 'nouveau',
  `source` varchar(50) DEFAULT 'formulaire_epee',
  `ip_address` varchar(45) DEFAULT NULL,
  `utm_source` varchar(100) DEFAULT NULL,
  `utm_medium` varchar(100) DEFAULT NULL,
  `utm_campaign` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mots_cles`
--

CREATE TABLE `mots_cles` (
  `id` int(11) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `mot_cle` varchar(100) NOT NULL,
  `volume_recherche` int(11) DEFAULT 0,
  `difficulte` enum('faible','moyenne','elevee') DEFAULT 'moyenne',
  `position_concurrent_1` varchar(100) DEFAULT NULL,
  `position_concurrent_2` varchar(100) DEFAULT NULL,
  `position_concurrent_3` varchar(100) DEFAULT NULL,
  `date_maj` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `mots_cles`
--

INSERT INTO `mots_cles` (`id`, `ville`, `mot_cle`, `volume_recherche`, `difficulte`, `position_concurrent_1`, `position_concurrent_2`, `position_concurrent_3`, `date_maj`) VALUES
(1, 'Paris', 'agence immobilière Paris', 1200, 'elevee', 'SeLoger', 'Leboncoin', 'Orpi', '2026-04-05 17:05:00'),
(2, 'Paris', 'vendre ma maison rapidement Paris', 800, 'moyenne', 'MeilleursAgents', 'PAP', 'Logic-Immo', '2026-04-05 17:05:00'),
(3, 'Paris', 'estimation gratuite Paris', 600, 'moyenne', 'Century 21', 'Laforêt', 'Barnes', '2026-04-05 17:05:00');

-- --------------------------------------------------------

--
-- Structure de la table `prospects`
--

CREATE TABLE `prospects` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `source` enum('site_web','réseau','recommandation','autre') DEFAULT 'site_web',
  `status` enum('nouveau','contacté','intéressé','perdu') DEFAULT 'nouveau',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `prospects`
--

INSERT INTO `prospects` (`id`, `first_name`, `last_name`, `email`, `phone`, `address`, `source`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Olivier', 'Colas', 'oliviercolas83@gmail.com', '0785611700', NULL, 'site_web', 'nouveau', '2026-04-05 15:10:35', '2026-04-05 15:10:35');

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

CREATE TABLE `rdv` (
  `id` int(11) NOT NULL,
  `id_lead` int(11) NOT NULL,
  `date_rdv` datetime NOT NULL,
  `duree_minutes` int(11) DEFAULT 30,
  `type_rdv` enum('qualification','demo','cloture') DEFAULT 'qualification',
  `statut` enum('planifie','annule','termine') DEFAULT 'planifie',
  `lien_calendly` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rdv_types`
--

CREATE TABLE `rdv_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `duration` int(11) NOT NULL DEFAULT 60,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `rdv_types`
--

INSERT INTO `rdv_types` (`id`, `name`, `duration`, `description`) VALUES
(1, 'Visite', 60, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `target_cities`
--

CREATE TABLE `target_cities` (
  `id` int(11) NOT NULL,
  `city` varchar(100) NOT NULL,
  `is_exclusive` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('available','exclusive_closed','beta_closed','estimator_active') NOT NULL,
  `beta_status` enum('available','closed') DEFAULT NULL,
  `advisor` varchar(100) DEFAULT NULL,
  `advisor_beta` varchar(100) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `max_people` int(11) DEFAULT NULL,
  `population` int(11) DEFAULT NULL,
  `score` decimal(3,1) DEFAULT NULL,
  `price_standard` decimal(10,2) DEFAULT NULL,
  `engagement_months` int(11) DEFAULT 12,
  `setup_fee` decimal(10,2) DEFAULT NULL,
  `recurring_price` decimal(10,2) DEFAULT NULL,
  `cumulative_mrr` decimal(10,2) DEFAULT NULL,
  `cumulative_setup` decimal(10,2) DEFAULT NULL,
  `launch_date` date DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `target_cities`
--

INSERT INTO `target_cities` (`id`, `city`, `is_exclusive`, `status`, `beta_status`, `advisor`, `advisor_beta`, `department`, `max_people`, `population`, `score`, `price_standard`, `engagement_months`, `setup_fee`, `recurring_price`, `cumulative_mrr`, `cumulative_setup`, `launch_date`, `comments`, `created_at`, `updated_at`) VALUES
(1, 'Bordeaux', 1, 'exclusive_closed', 'closed', NULL, NULL, '33', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, 'Exclusivité fermée - Beta fermé', '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(2, 'Nantes', 1, 'exclusive_closed', 'closed', NULL, NULL, '44', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, 'Exclusivité fermée - Beta fermé', '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(3, 'Aix-en-Provence', 1, 'exclusive_closed', 'closed', NULL, NULL, '13', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, 'Exclusivité fermée - Beta fermé', '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(4, 'Lannion', 1, 'exclusive_closed', 'closed', NULL, NULL, '22', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, 'Exclusivité fermée - Beta fermé', '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(5, 'Nandy', 1, 'exclusive_closed', 'closed', NULL, NULL, '77', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, 'Exclusivité fermée - Beta fermé', '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(6, 'Paris', 0, 'available', 'available', NULL, NULL, '75', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(7, 'Marseille', 0, 'available', 'available', NULL, NULL, '13', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(8, 'Toulouse', 0, 'available', 'available', NULL, NULL, '31', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(9, 'Montpellier', 0, 'available', 'available', NULL, NULL, '34', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(10, 'Strasbourg', 0, 'available', 'available', NULL, NULL, '67', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(11, 'Nice', 0, 'available', 'available', NULL, NULL, '06', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(12, 'Rennes', 0, 'available', 'available', NULL, NULL, '35', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(13, 'Lille', 0, 'available', 'available', NULL, NULL, '59', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(14, 'Grenoble', 0, 'available', 'available', NULL, NULL, '38', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(15, 'Toulon', 0, 'available', 'available', NULL, NULL, '83', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(16, 'Saint-Étienne', 0, 'available', 'available', NULL, NULL, '42', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(17, 'Le Havre', 0, 'available', 'available', NULL, NULL, '76', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(18, 'Reims', 0, 'available', 'available', NULL, NULL, '51', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(19, 'Dijon', 0, 'available', 'available', NULL, NULL, '21', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(20, 'Angers', 0, 'estimator_active', 'available', NULL, NULL, '49', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, 'Estimateur actif', '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(21, 'Nîmes', 0, 'available', 'available', NULL, NULL, '30', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(22, 'Clermont-Ferrand', 0, 'available', 'available', NULL, NULL, '63', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(23, 'Le Mans', 0, 'available', 'available', NULL, NULL, '72', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(24, 'Aix-en-Provence', 0, 'available', 'available', NULL, NULL, '13', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(25, 'Brest', 0, 'available', 'available', NULL, NULL, '29', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(26, 'Tours', 0, 'available', 'available', NULL, NULL, '37', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(27, 'Amiens', 0, 'available', 'available', NULL, NULL, '80', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(28, 'Limoges', 0, 'available', 'available', NULL, NULL, '87', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(29, 'Villeurbanne', 0, 'available', 'available', NULL, NULL, '69', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(30, 'Metz', 0, 'available', 'available', NULL, NULL, '57', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(31, 'Besançon', 0, 'available', 'available', NULL, NULL, '25', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(32, 'Caen', 0, 'available', 'available', NULL, NULL, '14', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(33, 'Orléans', 0, 'available', 'available', NULL, NULL, '45', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(34, 'Rouen', 0, 'available', 'available', NULL, NULL, '76', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(35, 'Mulhouse', 0, 'available', 'available', NULL, NULL, '68', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(36, 'Perpignan', 0, 'available', 'available', NULL, NULL, '66', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(37, 'Nancy', 0, 'available', 'available', NULL, NULL, '54', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(38, 'Argenteuil', 0, 'available', 'available', NULL, NULL, '95', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(39, 'Montreuil', 0, 'available', 'available', NULL, NULL, '93', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(40, 'Roubaix', 0, 'available', 'available', NULL, NULL, '59', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(41, 'Tourcoing', 0, 'available', 'available', NULL, NULL, '59', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(42, 'Avignon', 0, 'available', 'available', NULL, NULL, '84', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(43, 'Nanterre', 0, 'available', 'available', NULL, NULL, '92', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(44, 'Vitry-sur-Seine', 0, 'available', 'available', NULL, NULL, '94', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(45, 'Créteil', 0, 'available', 'available', NULL, NULL, '94', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(46, 'Poitiers', 0, 'available', 'available', NULL, NULL, '86', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(47, 'Courbevoie', 0, 'available', 'available', NULL, NULL, '92', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(48, 'Fort-de-France', 0, 'available', 'available', NULL, NULL, '972', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(49, 'Versailles', 0, 'available', 'available', NULL, NULL, '78', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(50, 'Colombes', 0, 'available', 'available', NULL, NULL, '92', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(51, 'Saint-Denis', 0, 'available', 'available', NULL, NULL, '93', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(52, 'Aulnay-sous-Bois', 0, 'available', 'available', NULL, NULL, '93', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(53, 'Pau', 0, 'available', 'available', NULL, NULL, '64', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(54, 'La Rochelle', 0, 'available', 'available', NULL, NULL, '17', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(55, 'Antibes', 0, 'available', 'available', NULL, NULL, '06', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(56, 'Saint-Maur-des-Fossés', 0, 'available', 'available', NULL, NULL, '94', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(57, 'Mérignac', 0, 'available', 'available', NULL, NULL, '33', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(58, 'Cannes', 0, 'available', 'available', NULL, NULL, '06', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(59, 'Asnières-sur-Seine', 0, 'available', 'available', NULL, NULL, '92', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(60, 'Rueil-Malmaison', 0, 'available', 'available', NULL, NULL, '92', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(61, 'Champigny-sur-Marne', 0, 'available', 'available', NULL, NULL, '94', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(62, 'Saint-Nazaire', 0, 'available', 'available', NULL, NULL, '44', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(63, 'Colmar', 0, 'available', 'available', NULL, NULL, '68', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(64, 'Drancy', 0, 'available', 'available', NULL, NULL, '93', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(65, 'Noisy-le-Grand', 0, 'available', 'available', NULL, NULL, '93', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(66, 'Issy-les-Moulineaux', 0, 'available', 'available', NULL, NULL, '92', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(67, 'Évry-Courcouronnes', 0, 'available', 'available', NULL, NULL, '91', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(68, 'Levallois-Perret', 0, 'available', 'available', NULL, NULL, '92', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(69, 'Massy', 0, 'available', 'available', NULL, NULL, '91', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(70, 'Annecy', 0, 'available', 'available', NULL, NULL, '74', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(71, 'Bayonne', 0, 'available', 'available', NULL, NULL, '64', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(72, 'Biarritz', 0, 'available', 'available', NULL, NULL, '64', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(73, 'Chambéry', 0, 'available', 'available', NULL, NULL, '73', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(74, 'Vannes', 0, 'available', 'available', NULL, NULL, '56', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(75, 'Quimper', 0, 'available', 'available', NULL, NULL, '29', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(76, 'Lorient', 0, 'available', 'available', NULL, NULL, '56', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(77, 'Troyes', 0, 'available', 'available', NULL, NULL, '10', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(78, 'Valence', 0, 'available', 'available', NULL, NULL, '26', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(79, 'Angoulême', 0, 'available', 'available', NULL, NULL, '16', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(80, 'Bayeux', 0, 'available', 'available', NULL, NULL, '14', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(81, 'Chartres', 0, 'available', 'available', NULL, NULL, '28', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(82, 'Laval', 0, 'available', 'available', NULL, NULL, '53', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(83, 'Saint-Brieuc', 0, 'available', 'available', NULL, NULL, '22', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(84, 'Évreux', 0, 'available', 'available', NULL, NULL, '27', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(85, 'Calais', 0, 'available', 'available', NULL, NULL, '62', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(86, 'Dunkerque', 0, 'available', 'available', NULL, NULL, '59', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(87, 'Arles', 0, 'available', 'available', NULL, NULL, '13', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(88, 'Ajaccio', 0, 'available', 'available', NULL, NULL, '2A', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(89, 'Bastia', 0, 'available', 'available', NULL, NULL, '2B', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(90, 'Fréjus', 0, 'available', 'available', NULL, NULL, '83', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(91, 'Gap', 0, 'available', 'available', NULL, NULL, '05', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(92, 'Albi', 0, 'available', 'available', NULL, NULL, '81', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(93, 'Rodez', 0, 'available', 'available', NULL, NULL, '12', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(94, 'Alençon', 0, 'available', 'available', NULL, NULL, '61', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(95, 'Châteauroux', 0, 'available', 'available', NULL, NULL, '36', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(96, 'Bourges', 0, 'available', 'available', NULL, NULL, '18', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(97, 'Mâcon', 0, 'available', 'available', NULL, NULL, '71', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(98, 'Chalon-sur-Saône', 0, 'available', 'available', NULL, NULL, '71', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(99, 'Auxerre', 0, 'available', 'available', NULL, NULL, '89', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28'),
(100, 'Lyon', 0, 'available', 'available', NULL, NULL, '69', NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-05 13:32:28', '2026-04-05 13:32:28');

-- --------------------------------------------------------

--
-- Structure de la table `territoires`
--

CREATE TABLE `territoires` (
  `id` int(11) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `departement` varchar(10) DEFAULT NULL,
  `region` varchar(50) DEFAULT NULL,
  `statut` enum('libre','reserve') DEFAULT 'libre',
  `id_conseiller` int(11) DEFAULT NULL,
  `date_reservation` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `territoires`
--

INSERT INTO `territoires` (`id`, `ville`, `code_postal`, `departement`, `region`, `statut`, `id_conseiller`, `date_reservation`) VALUES
(1, 'Paris', '75000', '75', 'Île-de-France', 'libre', NULL, NULL),
(2, 'Lyon', '69000', '69', 'Auvergne-Rhône-Alpes', 'libre', NULL, NULL),
(3, 'Bordeaux', '33000', '33', 'Nouvelle-Aquitaine', 'libre', NULL, NULL),
(4, 'Toulouse', '31000', '31', 'Occitanie', 'libre', NULL, NULL),
(5, 'Nantes', '44000', '44', 'Pays de la Loire', 'libre', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_user_id` (`admin_user_id`),
  ADD KEY `prospect_id` (`prospect_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `rdv_type_id` (`rdv_type_id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prospect_id` (`prospect_id`);

--
-- Index pour la table `conseillers`
--
ALTER TABLE `conseillers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_territoire` (`id_territoire`);

--
-- Index pour la table `exercice_mots_cles`
--
ALTER TABLE `exercice_mots_cles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lead` (`id_lead`);

--
-- Index pour la table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mots_cles`
--
ALTER TABLE `mots_cles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_mot_cle_ville` (`ville`,`mot_cle`);

--
-- Index pour la table `prospects`
--
ALTER TABLE `prospects`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lead` (`id_lead`);

--
-- Index pour la table `rdv_types`
--
ALTER TABLE `rdv_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `target_cities`
--
ALTER TABLE `target_cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_city` (`city`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_exclusive` (`is_exclusive`);

--
-- Index pour la table `territoires`
--
ALTER TABLE `territoires`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_ville` (`ville`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `conseillers`
--
ALTER TABLE `conseillers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `exercice_mots_cles`
--
ALTER TABLE `exercice_mots_cles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mots_cles`
--
ALTER TABLE `mots_cles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `prospects`
--
ALTER TABLE `prospects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `rdv`
--
ALTER TABLE `rdv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `rdv_types`
--
ALTER TABLE `rdv_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `target_cities`
--
ALTER TABLE `target_cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT pour la table `territoires`
--
ALTER TABLE `territoires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`admin_user_id`) REFERENCES `admin_users` (`id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`prospect_id`) REFERENCES `prospects` (`id`),
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `appointments_ibfk_4` FOREIGN KEY (`rdv_type_id`) REFERENCES `rdv_types` (`id`);

--
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`prospect_id`) REFERENCES `prospects` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `conseillers`
--
ALTER TABLE `conseillers`
  ADD CONSTRAINT `conseillers_ibfk_1` FOREIGN KEY (`id_territoire`) REFERENCES `territoires` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `exercice_mots_cles`
--
ALTER TABLE `exercice_mots_cles`
  ADD CONSTRAINT `exercice_mots_cles_ibfk_1` FOREIGN KEY (`id_lead`) REFERENCES `leads` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD CONSTRAINT `rdv_ibfk_1` FOREIGN KEY (`id_lead`) REFERENCES `leads` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
