-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 29 juin 2020 à 07:51
-- Version du serveur :  10.1.35-MariaDB
-- Version de PHP :  7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gest_data_compta`
--

-- --------------------------------------------------------

--
-- Structure de la table `bejcs`
--

CREATE TABLE `bejcs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chapitre_id` bigint(20) UNSIGNED DEFAULT NULL,
  `m_ordonnance` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nature` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `bejc_echelon`
--

CREATE TABLE `bejc_echelon` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `echelon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bejc_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `bejc_items`
--

CREATE TABLE `bejc_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `engagement_id` bigint(20) UNSIGNED NOT NULL,
  `bejc_id` bigint(20) UNSIGNED NOT NULL,
  `n_ordonnance` varchar(255) NOT NULL,
  `m_ordonnance` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `chapitres`
--

CREATE TABLE `chapitres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `n_chap` varchar(255) DEFAULT NULL,
  `l_chap` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chapitres`
--

INSERT INTO `chapitres` (`id`, `n_chap`, `l_chap`, `created_at`, `updated_at`) VALUES
(1, '60', 'ACHAT ET VARIATIONS DE STOCKS', '2020-06-15 07:55:19', '2020-06-15 08:01:18'),
(5, '63', 'SERVICES EXTERIEURS B', '2020-06-15 08:35:16', '2020-06-15 08:35:16'),
(6, '20', 'CHARGES IMMOBILISEES', '2020-06-15 08:35:29', '2020-06-15 08:35:29'),
(7, '24', 'MATERIEL', '2020-06-15 08:35:45', '2020-06-15 08:35:45'),
(8, '62', 'SERVICES EXTERIEURS A', '2020-06-15 08:36:02', '2020-06-15 08:36:02'),
(9, '66', 'CHARGES DE PERSONNEL', '2020-06-15 08:36:20', '2020-06-15 08:36:20'),
(10, '21', 'IMMOBILISATIONS INCORPORELLES', '2020-06-15 08:36:34', '2020-06-15 08:36:34'),
(15, '61', 'TRANSPORT ET MISSION', '2020-06-15 08:38:24', '2020-06-15 08:38:24'),
(16, '65', 'AUTRES CHARGES', '2020-06-15 08:38:41', '2020-06-15 08:38:41');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `chapitres_demo`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `chapitres_demo` (
`l_chap` varchar(255)
,`chap` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `document_echelon`
--

CREATE TABLE `document_echelon` (
  `document_id` bigint(20) UNSIGNED DEFAULT NULL,
  `echelon_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `echelons`
--

CREATE TABLE `echelons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `n_engage` varchar(255) DEFAULT NULL,
  `m_paye` double DEFAULT NULL,
  `date_paiement` datetime DEFAULT NULL,
  `date_depot_ac` datetime NOT NULL,
  `comment` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `engagement_id` bigint(20) UNSIGNED DEFAULT NULL,
  `etat` varchar(20) DEFAULT 'waiting',
  `n_ordonnance` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `echelons`
--

INSERT INTO `echelons` (`id`, `n_engage`, `m_paye`, `date_paiement`, `date_depot_ac`, `comment`, `created_at`, `updated_at`, `user_id`, `engagement_id`, `etat`, `n_ordonnance`) VALUES
(74, '2017/ANINF/00728', 4000000, '2020-06-29 00:00:00', '2020-06-29 00:00:00', 'Test', '2020-06-29 04:55:44', '2020-06-29 05:07:24', 1, 7540, 'validated', 'htgr78956'),
(75, '2017/ANINF/00714', 1121687, NULL, '2020-06-29 00:00:00', 'jacou le croquant', '2020-06-29 05:10:56', '2020-06-29 05:11:02', 1, 7535, 'cancelled', 'klop');

-- --------------------------------------------------------

--
-- Structure de la table `engagements`
--

CREATE TABLE `engagements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `d_exerci` int(11) DEFAULT NULL,
  `c_dest` double DEFAULT NULL,
  `nat_dep` varchar(255) DEFAULT NULL,
  `l_dep` varchar(255) DEFAULT NULL,
  `m_dispo` double DEFAULT NULL,
  `m_toteng` double DEFAULT NULL,
  `m_tengvi` double DEFAULT NULL,
  `m_totliq` double DEFAULT NULL,
  `m_tordvi` double DEFAULT NULL,
  `m_totord` double DEFAULT NULL,
  `m_dotini` double DEFAULT NULL,
  `n_engage` varchar(255) DEFAULT NULL,
  `m_engage` double DEFAULT NULL,
  `date_depot_ac` datetime DEFAULT NULL,
  `date_paiement` datetime DEFAULT NULL,
  `m_paye` double DEFAULT NULL,
  `d_engage` date DEFAULT NULL,
  `date_echeance` date DEFAULT NULL,
  `mois_` varchar(50) DEFAULT NULL,
  `m_tliqenga` double DEFAULT NULL,
  `m_non_paye` float DEFAULT NULL,
  `l_depeng` text,
  `l_nmtir` text,
  `n_mattir` int(11) DEFAULT NULL,
  `c_mattir` varchar(255) DEFAULT NULL,
  `l_chap` varchar(255) DEFAULT NULL,
  `n_devis` varchar(255) DEFAULT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `r_engage` varchar(10) DEFAULT NULL,
  `desc_r_engage` varchar(50) DEFAULT NULL,
  `v_m_paye` double DEFAULT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `chap` varchar(255) DEFAULT NULL,
  `realized` tinyint(1) NOT NULL,
  `commentaire` text,
  `cancelled` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `engagements`
--

INSERT INTO `engagements` (`id`, `d_exerci`, `c_dest`, `nat_dep`, `l_dep`, `m_dispo`, `m_toteng`, `m_tengvi`, `m_totliq`, `m_tordvi`, `m_totord`, `m_dotini`, `n_engage`, `m_engage`, `date_depot_ac`, `date_paiement`, `m_paye`, `d_engage`, `date_echeance`, `mois_`, `m_tliqenga`, `m_non_paye`, `l_depeng`, `l_nmtir`, `n_mattir`, `c_mattir`, `l_chap`, `n_devis`, `nip`, `r_engage`, `desc_r_engage`, `v_m_paye`, `is_paid`, `created_at`, `updated_at`, `chap`, `realized`, `commentaire`, `cancelled`) VALUES
(7252, 2017, 20172602100, 'Fonctionnement', 'Achats de papier d\'impression', 27752440, 7247560, 7247560, 7247560, 7247560, 7247560, 35000000, '2017/ANINF/00034', 5192000, '2017-02-02 00:00:00', '2017-03-02 00:00:00', 5192000, '2017-01-27', '2017-04-27', 'Janvier', 5192000, 0, 'Instruments de reglements pour site FINS                                                                                                                                                                                                                       ', 'MULTIPRESS GABON', 790848, 'F', 'ACHAT ET VARIATIONS DE STOCKS', '1710003                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:45', '2020-06-29 02:46:45', '60', 0, NULL, 0),
(7253, 2017, 20172602100, 'Fonctionnement', 'Achats de papier d\'impression', 27752440, 7247560, 7247560, 7247560, 7247560, 7247560, 35000000, '2017/ANINF/00035', 2055560, '2017-02-02 00:00:00', '2017-09-06 00:00:00', 2055560, '2017-01-27', '2017-04-27', 'Janvier', 2055560, 0, 'Instruments de reglements pour site FINS                                                                                                                                                                                                                       ', 'MULTIPRESS GABON', 790848, 'F', 'ACHAT ET VARIATIONS DE STOCKS', '1710004                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '60', 0, NULL, 0),
(7254, 2017, 20172632700, 'Fonctionnement', 'Honoraires Consultant', 28411500, 9988500, 9988500, 9988500, 9988500, 9988500, 38400000, '2017/ANINF/00048', 2986500, '2017-02-21 00:00:00', '2017-03-02 00:00:00', 2986500, '2017-02-02', '2017-05-03', 'Février', 2986500, 0, 'Honoraires consultant DUARTE SLEGERS période de juillet 2016                                                                                                                                                                                                   ', 'ENT. DUARTE SLEGERS', 232506, 'M', 'SERVICES EXTERIEURS B', '0007/2016                                         ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '63', 0, NULL, 0),
(7255, 2017, 20172632700, 'Fonctionnement', 'Honoraires Consultant', 28411500, 9988500, 9988500, 9988500, 9988500, 9988500, 38400000, '2017/ANINF/00049', 2986500, '2017-02-21 00:00:00', '2017-04-28 00:00:00', 2986500, '2017-02-02', '2017-05-03', 'Février', 2986500, 0, 'Honoraires consultant DUARTE SLEGERS période d\'Aout 2016                                                                                                                                                                                                       ', 'ENT. DUARTE SLEGERS', 232506, 'M', 'SERVICES EXTERIEURS B', '0008/2016                                         ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '63', 0, NULL, 0),
(7256, 2017, 20172632700, 'Fonctionnement', 'Honoraires Consultant', 28411500, 9988500, 9988500, 9988500, 9988500, 9988500, 38400000, '2017/ANINF/00050', 2986500, '2017-02-21 00:00:00', '2017-06-15 00:00:00', 2986500, '2017-02-02', '2017-05-03', 'Février', 2986500, 0, 'Honoraires consultant DUARTE SLEGERS période de septembre 2016                                                                                                                                                                                                 ', 'ENT. DUARTE SLEGERS', 232506, 'M', 'SERVICES EXTERIEURS B', '0009/2016                                         ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '63', 0, NULL, 0),
(7257, 2017, 20174202800, 'Investissement', 'Backbone National', 84709643, 15290357, 15290357, 15290357, 15290357, 15290357, 100000000, '2017/ANINF/00051', 4722890, '2017-02-21 00:00:00', '2017-01-30 00:00:00', 4722890, '2017-02-03', '2017-05-04', 'Février', 4722890, 0, 'Services Internet  pour le mois de février 2016                                                                                                                                                                                                                ', 'ORANGE', 30852, 'M', 'CHARGES IMMOBILISEES', '5210285151                                        ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '20', 0, NULL, 0),
(7258, 2017, 20174202800, 'Investissement', 'Backbone National', 84709643, 15290357, 15290357, 15290357, 15290357, 15290357, 100000000, '2017/ANINF/00052', 4722890, '2017-02-21 00:00:00', '2017-01-30 00:00:00', 4722890, '2017-02-03', '2017-05-04', 'Février', 4722890, 0, 'Services Internet  pour le mois de juillet 2016                                                                                                                                                                                                                ', 'ORANGE', 30852, 'M', 'CHARGES IMMOBILISEES', '5210295223                                        ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '20', 0, NULL, 0),
(7259, 2017, 20174202800, 'Investissement', 'Backbone National', 84709643, 15290357, 15290357, 15290357, 15290357, 15290357, 100000000, '2017/ANINF/00053', 4722890, '2017-02-21 00:00:00', '2017-01-30 00:00:00', 4722890, '2017-02-03', '2017-05-04', 'Février', 4722890, 0, 'Services Internet pour le mois d\'Aout 2016                                                                                                                                                                                                                     ', 'ORANGE', 30852, 'M', 'CHARGES IMMOBILISEES', '5210297979                                        ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '20', 0, NULL, 0),
(7260, 2017, 20174201100, 'Investissement', 'Projet RAG', 199729012, 270988, 270988, 270988, 270988, 270988, 200000000, '2017/ANINF/00054', 10141, '2017-02-21 00:00:00', '2017-03-02 00:00:00', 10141, '2017-02-03', '2017-05-04', 'Février', 10141, 0, 'Frais de coupure et de remise d\' électricité                                                                                                                                                                                                                   ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '634550568892                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '20', 0, NULL, 0),
(7261, 2017, 20174201100, 'Investissement', 'Projet RAG', 199729012, 270988, 270988, 270988, 270988, 270988, 200000000, '2017/ANINF/00055', 260847, NULL, '2017-03-02 00:00:00', 260847, '2017-02-03', '2017-05-04', 'Février', 260847, 0, 'Consommation d\'eau et d\'electricité pour la période du 26/12/2016 au 23/01/2017                                                                                                                                                                                ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '634557840765                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '20', 0, NULL, 0),
(7262, 2017, 20174202800, 'Investissement', 'Backbone National', 84709643, 15290357, 15290357, 15290357, 15290357, 15290357, 100000000, '2017/ANINF/00056', 1121687, '2017-02-21 00:00:00', '2017-03-02 00:00:00', 1121687, '2017-02-03', '2017-05-04', 'Février', 1121687, 0, 'Internet access                                                                                                                                                                                                                                                ', 'COGENT COMMUNICATIONS FRANCE', 43070, 'R', 'CHARGES IMMOBILISEES', 'sinvfr75291                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '20', 0, NULL, 0),
(7263, 2017, 20174241600, 'Investissement', 'Materiels divers', 31788136, 211864, 211864, 211864, 211864, 211864, 32000000, '2017/ANINF/00057', 211864, '2017-02-21 00:00:00', NULL, 0, '2017-02-03', '2017-05-04', 'Février', 211864, 0, 'Achat de materiels divers                                                                                                                                                                                                                                      ', 'GROUPE CECA GADIS', 790047, 'C', 'MATERIEL', '1003437                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '24', 0, NULL, 0),
(7264, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 90718959, 9281041, 9281041, 9281041, 9281041, 9281041, 100000000, '2017/ANINF/00058', 650000, '2017-02-21 00:00:00', NULL, 0, '2017-02-03', '2017-05-04', 'Février', 650000, 0, 'Travaux de plomberie au site de kalikak                                                                                                                                                                                                                        ', 'GABON FOURNITURE SERVICES BATIS', 258554, 'K', 'SERVICES EXTERIEURS A', '069/AG/2016                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '62', 0, NULL, 0),
(7265, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 90718959, 9281041, 9281041, 9281041, 9281041, 9281041, 100000000, '2017/ANINF/00059', 461041, '2017-02-21 00:00:00', NULL, 0, '2017-02-03', '2017-05-04', 'Février', 461041, 0, 'Entretien climatisation site d\'Oloumi                                                                                                                                                                                                                          ', 'SOGAFRIC SERVICES', 791871, 'W', 'SERVICES EXTERIEURS A', '290683                                            ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '62', 0, NULL, 0),
(7266, 2017, 20172632700, 'Fonctionnement', 'Honoraires Consultant', 28411500, 9988500, 9988500, 9988500, 9988500, 9988500, 38400000, '2017/ANINF/00060', 1029000, NULL, NULL, 0, '2017-02-03', '2017-05-04', 'Février', 1029000, 0, 'Honoraires                                                                                                                                                                                                                                                     ', 'CABINET GABONAIS D EXPERTISES', 225925, 'A', 'SERVICES EXTERIEURS B', '001/CGE/2016                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '63', 0, NULL, 0),
(7267, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 624500000, 25500000, 25500000, 25500000, 25500000, 25500000, 650000000, '2017/ANINF/00061', 25500000, '2017-02-21 00:00:00', '2017-03-24 00:00:00', 25500000, '2017-02-03', '2017-05-04', 'Février', 25500000, 0, 'Loyer immeuble dera haut de gué gué pour le compte du 1er trimestre 2017                                                                                                                                                                                       ', 'GUNTHER ENTREPRISE CONSTRUCTION', 79521, 'G', 'SERVICES EXTERIEURS A', '001janv/GTR/17                                    ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '62', 0, NULL, 0),
(7268, 2017, 20174241600, 'Investissement', 'Materiels divers', 19982636, 12017364, 12017364, 12017364, 12017364, 12017364, 32000000, '2017/ANINF/00063', 2066500, NULL, '2017-03-02 00:00:00', 2066500, '2017-02-09', '2017-05-10', 'Février', 2066500, 0, 'Matériels d\'\'électricité                                                                                                                                                                                                                                       ', 'CLIMAT FROID SARL', 795403, 'C', 'MATERIEL', '001-CF-1/2017                                     ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '24', 0, NULL, 0),
(7269, 2017, 20172602100, 'Fonctionnement', 'Achats de papier d\'impression', 22466630, 12533370, 12533370, 12533370, 12533370, 12533370, 35000000, '2017/ANINF/00064', 5285810, '2017-02-21 00:00:00', NULL, 0, '2017-02-09', '2017-05-10', 'Février', 5285810, 0, 'Instruments de règlement pour site Fins                                                                                                                                                                                                                        ', 'MULTIPRESS GABON', 790848, 'F', 'ACHAT ET VARIATIONS DE STOCKS', '1710012                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '60', 0, NULL, 0),
(7270, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 87973709, 12026291, 12026291, 12026291, 12026291, 12026291, 100000000, '2017/ANINF/00065', 1505250, '2017-02-21 00:00:00', '2017-03-02 00:00:00', 1505250, '2017-02-09', '2017-05-10', 'Février', 1505250, 0, 'Travaux de réhabilitation                                                                                                                                                                                                                                      ', 'GEBS', 497517, 'Z', 'SERVICES EXTERIEURS A', '012/2017                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '62', 0, NULL, 0),
(7271, 2017, 20174241600, 'Investissement', 'Materiels divers', 19982636, 12017364, 12017364, 12017364, 12017364, 12017364, 32000000, '2017/ANINF/00066', 9739000, '2017-02-21 00:00:00', NULL, 0, '2017-02-09', '2017-05-10', 'Février', 9739000, 0, 'Acquisition de split Lg 9000 btu                                                                                                                                                                                                                               ', 'ROYAL PLAZA', 781001, 'Z', 'MATERIEL', 'PRF37/514                                         ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '24', 0, NULL, 0),
(7272, 2017, 20172668400, 'Fonctionnement', 'Médecine du travail et pharmacie', 20000000, 4000000, 4000000, 4000000, 4000000, 4000000, 24000000, '2017/ANINF/00093', 4000000, '2017-03-10 00:00:00', '2017-03-02 00:00:00', 4000000, '2017-02-27', '2017-05-28', 'Février', 4000000, 0, 'Honoraires du mois de juillet 2016, médecine du travail                                                                                                                                                                                                        ', 'SANTE PLUS', 36701, 'M', 'CHARGES DE PERSONNEL', '02                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '66', 0, NULL, 0),
(7273, 2017, 20174243000, 'Investissement', 'Matériel informatique', 69500000, 500000, 500000, 500000, 500000, 500000, 70000000, '2017/ANINF/00094', 500000, '2017-03-10 00:00:00', NULL, 0, '2017-02-27', '2017-05-28', 'Février', 500000, 0, 'Fourniture d\'une carte téléphonie                                                                                                                                                                                                                              ', 'EL SCHADDAI SERVICES', 302737, 'G', 'MATERIEL', '0067/22/04/16                                     ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '24', 0, NULL, 0),
(7274, 2017, 20172632700, 'Fonctionnement', 'Honoraires Consultant', 25425000, 12975000, 12975000, 12975000, 12975000, 12975000, 38400000, '2017/ANINF/00095', 2986500, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 2986500, '2017-02-27', '2017-05-28', 'Février', 2986500, 0, 'Honoraires Consultant DUARTE SLEGERS du mois de juin 2016                                                                                                                                                                                                      ', 'ENT. DUARTE SLEGERS', 232506, 'M', 'SERVICES EXTERIEURS B', '0006/2016                                         ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '63', 0, NULL, 0),
(7275, 2017, 20174213100, 'Investissement', 'Logiciels', 64407089, 25592911, 25592911, 25592911, 25592911, 25592911, 90000000, '2017/ANINF/00096', 4475044, '2017-03-10 00:00:00', '2017-04-14 00:00:00', 4475044, '2017-02-27', '2017-05-28', 'Février', 4475044, 0, 'Equipements de securité Fortimail                                                                                                                                                                                                                              ', 'EXCLUSIVE NETWORKS SAS', 42426, 'Z', 'IMMOBILISATIONS INCORPORELLES', 'FR16017808                                        ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '21', 0, NULL, 0),
(7276, 2017, 20174213100, 'Investissement', 'Logiciels', 64407089, 25592911, 25592911, 25592911, 25592911, 25592911, 90000000, '2017/ANINF/00097', 21117867, '2017-03-10 00:00:00', '2017-04-14 00:00:00', 21117867, '2017-02-27', '2017-05-28', 'Février', 21117867, 0, 'Renouvellement des licences des équipements de sécurité Fortimail                                                                                                                                                                                              ', 'EXCLUSIVE NETWORKS SAS', 42426, 'Z', 'IMMOBILISATIONS INCORPORELLES', 'FR16017808-04                                     ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:46', '2020-06-29 02:46:46', '21', 0, NULL, 0),
(7277, 2017, 20174202800, 'Investissement', 'Backbone National', 81286269, 18713731, 18713731, 18713731, 18713731, 18713731, 100000000, '2017/ANINF/00098', 1121687, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 1121687, '2017-02-27', '2017-05-28', 'Février', 1121687, 0, 'Internet Acess pour le mois de décembre 2016                                                                                                                                                                                                                   ', 'COGENT COMMUNICATIONS FRANCE', 43070, 'R', 'CHARGES IMMOBILISEES', 'SINVFR75291                                       ', NULL, 'r', 'Réengagement OP: 2017/ANINF/00056, Exerice: 2017', NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '02', 0, NULL, 0),
(7278, 2017, 20174202800, 'Investissement', 'Backbone National', 81286269, 18713731, 18713731, 18713731, 18713731, 18713731, 100000000, '2017/ANINF/00099', 1180000, '2017-03-10 00:00:00', NULL, 0, '2017-02-27', '2017-05-28', 'Février', 1180000, 0, 'Frais d\'activation liaison internet                                                                                                                                                                                                                            ', 'GABON TELECOM SA', 780730, 'E', 'CHARGES IMMOBILISEES', '02-14122016                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7279, 2017, 20174202800, 'Investissement', 'Backbone National', 81286269, 18713731, 18713731, 18713731, 18713731, 18713731, 100000000, '2017/ANINF/00103', 1121687, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 1121687, '2017-02-28', '2017-05-29', 'Février', 1121687, 0, 'Internet Access pour le mois de février 2017                                                                                                                                                                                                                   ', 'COGENT COMMUNICATIONS FRANCE', 43070, 'R', 'CHARGES IMMOBILISEES', 'SINVFR76728                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7280, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00107', 41852, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 41852, '2017-03-01', '2017-05-30', 'Mars', 41852, 0, 'Consommation d\'eau pour la période du 27/12/2016 au 24/01/2017                                                                                                                                                                                                 ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '334554481311                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7281, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00108', 291071, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 291071, '2017-03-01', '2017-05-30', 'Mars', 291071, 0, 'Consommation d\'électricité pour la période du 26/10/2016 au 22/11/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '334557618653                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7282, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00109', 346890, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 346890, '2017-03-01', '2017-05-30', 'Mars', 346890, 0, 'Consommation d\' électricité pour la période du 26/07/2016 au 22/08/2016                                                                                                                                                                                        ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '334550096596                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7283, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00110', 169923, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 169923, '2017-03-01', '2017-05-30', 'Mars', 169923, 0, 'Consommation d\'électricité pour la période du 22/11/2016 au 22/12/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '334559027690                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7284, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00111', 334415, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 334415, '2017-03-01', '2017-05-30', 'Mars', 334415, 0, 'Consommation d\'électricité pour la périodedu 21/06/2016 au 26/07/2016                                                                                                                                                                                          ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '334553986900                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7285, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00112', 352908, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 352908, '2017-03-01', '2017-05-30', 'Mars', 352908, 0, 'Consommation d\' Electricité  pour la periode 23/09/2016 au 26/10/2016                                                                                                                                                                                          ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '334552445092                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7286, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00113', 318354, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 318354, '2017-03-01', '2017-05-30', 'Mars', 318354, 0, 'Consommation d\'eau et d\'électricité pour la période du 24/10/2016 au 23/11/2016                                                                                                                                                                                ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '634552455110                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7287, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00114', 337952, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 337952, '2017-03-01', '2017-05-30', 'Mars', 337952, 0, 'Consommation d\'eau et d\'électricité pour la périodedu 23/11/2016 au 26/12/2016                                                                                                                                                                                 ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '634553331383                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7288, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00115', 297148, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 297148, '2017-03-01', '2017-05-30', 'Mars', 297148, 0, 'Consommation d\'eau et  d\'électricité pour la periode du 26/07/2016 au 23/08/2016                                                                                                                                                                               ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '634551517773                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7289, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00116', 537711, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 537711, '2017-03-01', '2017-05-30', 'Mars', 537711, 0, 'Consommation d\'eau et d\'électricité pour la période du 26/07/2016 au 23/09/2016                                                                                                                                                                                ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '534553374834                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7290, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00117', 1302472, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 1302472, '2017-03-01', '2017-05-30', 'Mars', 1302472, 0, 'Consommation d\'eau et d\'électricité pour la période du 25/04/2016 au 29/06/2016                                                                                                                                                                                ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '534556048597                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7291, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00118', 5088, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 5088, '2017-03-01', '2017-05-30', 'Mars', 5088, 0, 'Consommation d \'eau pour la période du 25/04/2016 au 22/05/2016                                                                                                                                                                                                ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '534554458099                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7292, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00119', 223580, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 223580, '2017-03-01', '2017-05-30', 'Mars', 223580, 0, 'Consommation d\'électricité pour la période du 29/06/2016 au 26/07/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '534556697595                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7293, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00120', 137818, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 137818, '2017-03-01', '2017-05-30', 'Mars', 137818, 0, 'Consommation d\'électricité pour la période 01/10/2016 au 01/11/2016                                                                                                                                                                                            ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '491565711860                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7294, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00121', 384247, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 384247, '2017-03-01', '2017-05-30', 'Mars', 384247, 0, 'Consommation d\'électricité pour la période du 15/10/2016 au 15/11/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '791564220795                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7295, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00122', 189532, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 189532, '2017-03-01', '2017-05-30', 'Mars', 189532, 0, 'Consommation d\' électricité pour la période du 12/07/2016 au 11/08/2016                                                                                                                                                                                        ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '374457053795                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7296, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00123', 238197, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 238197, '2017-03-01', '2017-05-30', 'Mars', 238197, 0, 'Consommation d\'électricité  pour le mois de 15/11/2016 au 14/12/2016                                                                                                                                                                                           ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '474457351469                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7297, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00124', 198679, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 198679, '2017-03-01', '2017-05-30', 'Mars', 198679, 0, 'Consommation d\' électricité pour la période                                                                                                                                                                                                                    ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '374458864834                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7298, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00125', 150866, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 150866, '2017-03-01', '2017-05-30', 'Mars', 150866, 0, 'Consommation d\'électricité pour la période 01/10/2016 au 30/11/2016                                                                                                                                                                                            ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '891566353364                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7299, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 85889936, 14110064, 14110064, 14110064, 14110064, 14110064, 100000000, '2017/ANINF/00126', 1843000, '2017-03-10 00:00:00', '2017-03-24 00:00:00', 1843000, '2017-03-01', '2017-05-30', 'Mars', 1843000, 0, 'Alimentation générale  en eau                                                                                                                                                                                                                                  ', 'GABON FOURNITURE SERVICES BATIS', 258554, 'K', 'SERVICES EXTERIEURS A', '008/AG/2017                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '62', 0, NULL, 0),
(7300, 2017, 20172614200, 'Fonctionnement', 'Transport du personnel à l\'extérieur', 92925300, 7074700, 7074700, 7074700, 7074700, 7074700, 100000000, '2017/ANINF/00127', 4274700, NULL, NULL, 0, '2017-03-06', '2017-06-04', 'Mars', 4274700, 0, 'Frais de transport de GUIBINGA NGOUESSI Robert  , MFOMO MBADINGA Armand  et MOUSSAVOU MOUSSAVOU Bienvenu à Paris                                                                                                                                               ', 'CHICA VOYAGES', 84947, 'R', 'TRANSPORT ET MISSION', 'FP036                                             ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '61', 0, NULL, 0),
(7301, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00128', 303056, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 303056, '2017-03-06', '2017-06-04', 'Mars', 303056, 0, 'Consommation d\'électricité pour la période du 27/03/2016 au 22/04/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '391561595249                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7302, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00129', 197561, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 197561, '2017-03-06', '2017-06-04', 'Mars', 197561, 0, 'Consommation d\' électricité pour la période du 10/10/2016 au 10/11/2016                                                                                                                                                                                        ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '374457645902                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7303, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00130', 144904, '2017-03-10 00:00:00', '2017-05-17 00:00:00', 144904, '2017-03-06', '2017-06-04', 'Mars', 144904, 0, 'Consommation d\'électricité pour la période du 09/11/2015 au 14/12/2015                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '374454362150                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7304, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00131', 186097, '2017-03-10 00:00:00', '2017-05-17 00:00:00', 186097, '2017-03-06', '2017-06-04', 'Mars', 186097, 0, 'Consommation d\'électricité pour la période 10/11/2016 au 10/12/2016                                                                                                                                                                                            ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '374459421646                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7305, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00132', 110040, '2017-03-10 00:00:00', '2017-05-17 00:00:00', 110040, '2017-03-06', '2017-06-04', 'Mars', 110040, 0, 'Consommation d\'électricité pour la période du 15/07/2016 au 19/08/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '474456302459                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:47', '2020-06-29 02:46:47', '20', 0, NULL, 0),
(7306, 2017, 20174201100, 'Investissement', 'Projet RAG', 174279089, 25720911, 25720911, 25720911, 25720911, 25720911, 200000000, '2017/ANINF/00133', 149562, NULL, '2017-03-22 00:00:00', 149562, '2017-03-06', '2017-06-04', 'Mars', 149562, 0, 'Consommation d\'électicité pour la période du 01/11/2016 au 01/12/2016                                                                                                                                                                                          ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '891564902262                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7307, 2017, 20174201100, 'Investissement', 'Projet RAG', 171991176, 28008824, 28008824, 28008824, 28008824, 28008824, 200000000, '2017/ANINF/00134', 9246, NULL, '2017-05-17 00:00:00', 9246, '2017-03-08', '2017-06-06', 'Mars', 9246, 0, 'Consommation d\'électricité pour la période du 08/09/2016 au 12/10/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '469176291078                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7308, 2017, 20174201100, 'Investissement', 'Projet RAG', 171991176, 28008824, 28008824, 28008824, 28008824, 28008824, 200000000, '2017/ANINF/00135', 1478084, NULL, '2017-03-22 00:00:00', 1478084, '2017-03-08', '2017-06-06', 'Mars', 1478084, 0, 'Consommation d\'électricité pour la période du 08/04/2016 au 08/09/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '469174102392                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7309, 2017, 20174201100, 'Investissement', 'Projet RAG', 171991176, 28008824, 28008824, 28008824, 28008824, 28008824, 200000000, '2017/ANINF/00136', 4242, NULL, '2017-05-17 00:00:00', 4242, '2017-03-08', '2017-06-06', 'Mars', 4242, 0, 'Consommation d\'électricité pour la période du 09/11/2016 au 17/12/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '469179326340                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7310, 2017, 20174201100, 'Investissement', 'Projet RAG', 171991176, 28008824, 28008824, 28008824, 28008824, 28008824, 200000000, '2017/ANINF/00137', 8220, NULL, '2017-05-17 00:00:00', 8220, '2017-03-08', '2017-06-06', 'Mars', 8220, 0, 'Consommation d\'\'éléctricité pour la période du 09/06/2016 au 13/07/201                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '469173811747                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7311, 2017, 20174201100, 'Investissement', 'Projet RAG', 171991176, 28008824, 28008824, 28008824, 28008824, 28008824, 200000000, '2017/ANINF/00138', 6597, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 6597, '2017-03-08', '2017-06-06', 'Mars', 6597, 0, 'Consommation d\'électricité pour la période du 13/07/2016 au 09/08/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '469172354093                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7312, 2017, 20174201100, 'Investissement', 'Projet RAG', 171991176, 28008824, 28008824, 28008824, 28008824, 28008824, 200000000, '2017/ANINF/00139', 7007, '2017-03-10 00:00:00', '2017-03-22 00:00:00', 7007, '2017-03-08', '2017-06-06', 'Mars', 7007, 0, 'Consommation d\'électricité pour la période du 12/10/2016 au 09/11/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '469171756346                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7313, 2017, 20174201100, 'Investissement', 'Projet RAG', 171991176, 28008824, 28008824, 28008824, 28008824, 28008824, 200000000, '2017/ANINF/00140', 207840, '2017-03-10 00:00:00', '2017-05-17 00:00:00', 207840, '2017-03-08', '2017-06-06', 'Mars', 207840, 0, 'Consommation d\'électricité pour la période du 13/03/2016 au 12/04/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '374454504012                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7314, 2017, 20174201100, 'Investissement', 'Projet RAG', 171991176, 28008824, 28008824, 28008824, 28008824, 28008824, 200000000, '2017/ANINF/00141', 30928, '2017-03-10 00:00:00', '2017-05-17 00:00:00', 30928, '2017-03-08', '2017-06-06', 'Mars', 30928, 0, 'Consommation d\'eau et d\'\'électricité pour la période du 23/01/2017 au 22/02/2017                                                                                                                                                                               ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '634557478856                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7315, 2017, 20174201100, 'Investissement', 'Projet RAG', 171991176, 28008824, 28008824, 28008824, 28008824, 28008824, 200000000, '2017/ANINF/00142', 110417, '2017-03-10 00:00:00', '2017-05-17 00:00:00', 110417, '2017-03-08', '2017-06-06', 'Mars', 110417, 0, 'Consommation d\'électricité pour la période du 15/10/2016 au 15/11/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '474454159368                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7316, 2017, 20174201100, 'Investissement', 'Projet RAG', 171991176, 28008824, 28008824, 28008824, 28008824, 28008824, 200000000, '2017/ANINF/00143', 110417, '2017-03-10 00:00:00', '2017-05-17 00:00:00', 110417, '2017-03-08', '2017-06-06', 'Mars', 110417, 0, 'Consommation d\'électricité pour la période du 15/09/2016 au 15/10/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '474451174958                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7317, 2017, 20174201100, 'Investissement', 'Projet RAG', 171991176, 28008824, 28008824, 28008824, 28008824, 28008824, 200000000, '2017/ANINF/00144', 127810, '2017-03-10 00:00:00', '2017-05-17 00:00:00', 127810, '2017-03-08', '2017-06-06', 'Mars', 127810, 0, 'Consommation  d\'électricité pour la période  du 10/10/2015 au 09/11/2015                                                                                                                                                                                       ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '374459145428                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7318, 2017, 20174201100, 'Investissement', 'Projet RAG', 171991176, 28008824, 28008824, 28008824, 28008824, 28008824, 200000000, '2017/ANINF/00145', 187105, '2017-03-10 00:00:00', '2017-05-17 00:00:00', 187105, '2017-03-08', '2017-06-06', 'Mars', 187105, 0, 'Consommation d\'électricité pour la période du 11/08/2016 au 08/09/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '374457736494                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7319, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 622850000, 27150000, 27150000, 27150000, 27150000, 27150000, 650000000, '2017/ANINF/00153', 1650000, '2017-03-15 00:00:00', '2017-03-22 00:00:00', 1650000, '2017-03-08', '2017-06-06', 'Mars', 1650000, 0, 'Paiement de l\'avis d\'échéance 0020 du R+2 carrefour leon mba au profit de AIL ( Periode du 01.01.2017 au 31.03.2017)                                                                                                                                           ', 'AGENCE IMMOBILIERE DE LIBREVILLE', 795119, 'F', 'SERVICES EXTERIEURS A', '0020                                              ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '62', 0, NULL, 0),
(7320, 2017, 20172614200, 'Fonctionnement', 'Transport du personnel à l\'extérieur', 88436900, 11563100, 11563100, 11563100, 11563100, 11563100, 100000000, '2017/ANINF/00154', 2015400, '2017-03-15 00:00:00', '2017-03-22 00:00:00', 2015400, '2017-03-08', '2017-06-06', 'Mars', 2015400, 0, 'Frais de transport de GUIBINGA NGOUESSI Robert Serge,MFOMO MBADINGA Armand Ossey et Bienvenu MOUSSAVOU MOUSSAVOU à Paris                                                                                                                                       ', 'ROYAL  AIR MAROC', 91752, 'N', 'TRANSPORT ET MISSION', '41                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '61', 0, NULL, 0);
INSERT INTO `engagements` (`id`, `d_exerci`, `c_dest`, `nat_dep`, `l_dep`, `m_dispo`, `m_toteng`, `m_tengvi`, `m_totliq`, `m_tordvi`, `m_totord`, `m_dotini`, `n_engage`, `m_engage`, `date_depot_ac`, `date_paiement`, `m_paye`, `d_engage`, `date_echeance`, `mois_`, `m_tliqenga`, `m_non_paye`, `l_depeng`, `l_nmtir`, `n_mattir`, `c_mattir`, `l_chap`, `n_devis`, `nip`, `r_engage`, `desc_r_engage`, `v_m_paye`, `is_paid`, `created_at`, `updated_at`, `chap`, `realized`, `commentaire`, `cancelled`) VALUES
(7321, 2017, 20172614200, 'Fonctionnement', 'Transport du personnel à l\'extérieur', 88436900, 11563100, 11563100, 11563100, 11563100, 11563100, 100000000, '2017/ANINF/00167', 2473000, '2017-03-15 00:00:00', '2017-03-22 00:00:00', 2473000, '2017-03-13', '2017-06-11', 'Mars', 2473000, 0, 'Frais de transport de Cheikna AWORET et ENGONO Emeri françois à Casablanca au Maroc                                                                                                                                                                            ', 'HARIOM TRAVELS', 77975, 'N', 'TRANSPORT ET MISSION', '003/HO/IND/2017                                   ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '61', 0, NULL, 0),
(7322, 2017, 20174201400, 'Investissement', 'Projet Datacenter', 83755250, 16244750, 16244750, 16244750, 16244750, 16244750, 100000000, '2017/ANINF/00169', 8122375, '2017-03-15 00:00:00', '2017-03-24 00:00:00', 8122375, '2017-03-13', '2017-06-11', 'Mars', 8122375, 0, 'Convention d\'entretien, de nettoyager, de désinsectisation et de dératisation du Datacenter période  de janvier à mars 2016                                                                                                                                    ', 'NET SERVICES', 461640, 'G', 'CHARGES IMMOBILISEES', '36042016                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7323, 2017, 20174201400, 'Investissement', 'Projet Datacenter', 83755250, 16244750, 16244750, 16244750, 16244750, 16244750, 100000000, '2017/ANINF/00170', 8122375, '2017-03-15 00:00:00', '2017-03-24 00:00:00', 8122375, '2017-03-13', '2017-06-11', 'Mars', 8122375, 0, 'Convention d\'entretien de nettoyage de désinsectisation et de dératisation  du Datacenter                                                                                                                                                                      ', 'NET SERVICES', 461640, 'G', 'CHARGES IMMOBILISEES', '037-07-2016                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7324, 2017, 20174203900, 'Fonctionnement', 'Autres Projets', 96529652, 4504103, 4504103, 4504103, 4504103, 4504103, 101033755, '2017/ANINF/00171', 4504103, '2017-03-17 00:00:00', '2017-03-22 00:00:00', 4504103, '2017-03-14', '2017-06-12', 'Mars', 4504103, 0, 'Paiement des redevances pour le droit d\'exploitation des ressources internet pour l\'année 2017                                                                                                                                                                 ', 'AFRINIC', 993600, 'M', 'CHARGES IMMOBILISEES', 'AF011091                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7325, 2017, 20172614200, 'Fonctionnement', 'Transport du personnel à l\'extérieur', 73255850, 26744150, 26744150, 26744150, 26744150, 26744150, 100000000, '2017/ANINF/00174', 8294000, '2017-03-17 00:00:00', '2017-03-22 00:00:00', 8294000, '2017-03-15', '2017-06-13', 'Mars', 8294000, 0, 'Frais de transport de Alex BONGO ONDIMBA et EPIGA André à paris pour la période du 15 au 21 Mars 2017.                                                                                                                                                         ', 'HARIOM TRAVELS', 77975, 'N', 'TRANSPORT ET MISSION', '004/HO/IND/2017                                   ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '61', 0, NULL, 0),
(7326, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 613106613, 36893387, 36893387, 36893387, 36893387, 36893387, 650000000, '2017/ANINF/00176', 2000000, '2017-03-17 00:00:00', '2017-04-18 00:00:00', 2000000, '2017-03-15', '2017-06-13', 'Mars', 2000000, 0, 'Abonnement annuel au Parking VIP de mars 2017 à mars 2018                                                                                                                                                                                                      ', 'A.D.L. - AEROPORT DE LIBREVILLE', 794112, 'E', 'SERVICES EXTERIEURS A', '17z912798                                         ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '62', 0, NULL, 0),
(7327, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 613106613, 36893387, 36893387, 36893387, 36893387, 36893387, 650000000, '2017/ANINF/00177', 1250000, '2017-03-17 00:00:00', '2017-06-12 00:00:00', 1250000, '2017-03-15', '2017-06-13', 'Mars', 1250000, 0, 'Tickets ponctuel d\'Accès au salon EKENA periode de mars 2017                                                                                                                                                                                                   ', 'A.D.L. - AEROPORT DE LIBREVILLE', 794112, 'E', 'SERVICES EXTERIEURS A', '17z912799                                         ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '62', 0, NULL, 0),
(7328, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 613106613, 36893387, 36893387, 36893387, 36893387, 36893387, 650000000, '2017/ANINF/00178', 1000000, '2017-03-17 00:00:00', '2017-03-22 00:00:00', 1000000, '2017-03-15', '2017-06-13', 'Mars', 1000000, 0, 'Abonnement EKENA plein tarif année 2017                                                                                                                                                                                                                        ', 'A.D.L. - AEROPORT DE LIBREVILLE', 794112, 'E', 'SERVICES EXTERIEURS A', '17z912788                                         ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '62', 0, NULL, 0),
(7329, 2017, 20174201100, 'Investissement', 'Projet RAG', 126785258, 73214742, 73214742, 73214742, 73214742, 73214742, 200000000, '2017/ANINF/00179', 381215, NULL, '2017-05-17 00:00:00', 381215, '2017-03-16', '2017-06-14', 'Mars', 381215, 0, 'Consommation d\'électricité pour la période du 23/08/2016 au 27/09/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '391564733436                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7330, 2017, 20174201100, 'Investissement', 'Projet RAG', 126785258, 73214742, 73214742, 73214742, 73214742, 73214742, 200000000, '2017/ANINF/00180', 295516, '2017-03-24 00:00:00', '2017-05-17 00:00:00', 295516, '2017-03-16', '2017-06-14', 'Mars', 295516, 0, 'Consommation d\'électricité pour la période du 27/10/2016 au 21/11/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '391566780461                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7331, 2017, 20174201100, 'Investissement', 'Projet RAG', 126785258, 73214742, 73214742, 73214742, 73214742, 73214742, 200000000, '2017/ANINF/00181', 369147, '2017-03-24 00:00:00', '2017-05-17 00:00:00', 369147, '2017-03-16', '2017-06-14', 'Mars', 369147, 0, 'Consommation d\'électricité pour la période du 21/11/2016 au 27/12/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '391563284763                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7332, 2017, 20174201100, 'Investissement', 'Projet RAG', 126785258, 73214742, 73214742, 73214742, 73214742, 73214742, 200000000, '2017/ANINF/00185', 110040, '2017-03-24 00:00:00', '2017-05-17 00:00:00', 110040, '2017-03-16', '2017-06-14', 'Mars', 110040, 0, 'Consommation d\'électricité pour la période du 16/08/2016 au 15/09/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '474454442504                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7333, 2017, 20174202800, 'Investissement', 'Backbone National', 71840487, 28159513, 28159513, 28159513, 28159513, 28159513, 100000000, '2017/ANINF/00186', 4722891, '2017-03-24 00:00:00', '2017-03-22 00:00:00', 4722891, '2017-03-17', '2017-06-15', 'Mars', 4722891, 0, 'Services Internet pour le mois de janvier 2017                                                                                                                                                                                                                 ', 'ORANGE', 30852, 'M', 'CHARGES IMMOBILISEES', '5210309186                                        ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7334, 2017, 20174202800, 'Investissement', 'Backbone National', 71840487, 28159513, 28159513, 28159513, 28159513, 28159513, 100000000, '2017/ANINF/00187', 4722891, '2017-03-24 00:00:00', '2017-03-24 00:00:00', 4722891, '2017-03-17', '2017-06-15', 'Mars', 4722891, 0, 'Services internet  pour le mois février 2017                                                                                                                                                                                                                   ', 'ORANGE', 30852, 'M', 'CHARGES IMMOBILISEES', '5210311242                                        ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '20', 0, NULL, 0),
(7335, 2017, 20172614200, 'Fonctionnement', 'Transport du personnel à l\'extérieur', 73255850, 26744150, 26744150, 26744150, 26744150, 26744150, 100000000, '2017/ANINF/00188', 3025050, '2017-03-24 00:00:00', '2017-03-22 00:00:00', 3025050, '2017-03-20', '2017-06-18', 'Mars', 3025050, 0, 'Frais de transport de NDZANDOU Benjamin à Paris                                                                                                                                                                                                                ', 'ESPACE VOYAGE TOURISME', 89533, 'Y', 'TRANSPORT ET MISSION', 'PF17306                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '61', 0, NULL, 0),
(7336, 2017, 20172637100, 'Fonctionnement', 'Frais de gardiennage, surveillance', 81500000, 18500000, 18500000, 18500000, 18500000, 18500000, 100000000, '2017/ANINF/00189', 6166000, '2017-03-24 00:00:00', '2017-03-24 00:00:00', 6166000, '2017-03-20', '2017-06-18', 'Mars', 6166000, 0, 'Frais de gardiennage pour le mois de janvier ( 1er accompte)                                                                                                                                                                                                   ', 'GOLD SÉCURITÉ GABON', 271062, 'A', 'SERVICES EXTERIEURS B', 'N0005-A/BPMO/RM/2016                              ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '63', 0, NULL, 0),
(7337, 2017, 20172637100, 'Fonctionnement', 'Frais de gardiennage, surveillance', 81500000, 18500000, 18500000, 18500000, 18500000, 18500000, 100000000, '2017/ANINF/00190', 6166000, '2017-03-24 00:00:00', '2017-05-05 00:00:00', 6166000, '2017-03-20', '2017-06-18', 'Mars', 6166000, 0, 'Frais de gardiennage pour le mois de janvier (acompte 2)                                                                                                                                                                                                       ', 'GOLD SÉCURITÉ GABON', 271062, 'A', 'SERVICES EXTERIEURS B', 'N0005-B/BPMO/RM/2016                              ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '63', 0, NULL, 0),
(7338, 2017, 20172637100, 'Fonctionnement', 'Frais de gardiennage, surveillance', 81500000, 18500000, 18500000, 18500000, 18500000, 18500000, 100000000, '2017/ANINF/00191', 6168000, '2017-03-24 00:00:00', '2017-11-22 00:00:00', 6168000, '2017-03-20', '2017-06-18', 'Mars', 6168000, 0, 'Frais de gardiennage pour le mois de janvier (acompte 3)                                                                                                                                                                                                       ', 'GOLD SÉCURITÉ GABON', 271062, 'A', 'SERVICES EXTERIEURS B', 'N0005-C/BPMO/RM/2016                              ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '63', 0, NULL, 0),
(7339, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 613106613, 36893387, 36893387, 36893387, 36893387, 36893387, 650000000, '2017/ANINF/00194', 5493387, '2017-03-24 00:00:00', NULL, 0, '2017-03-21', '2017-06-19', 'Mars', 5493387, 0, 'Dégats des eaux  du 17/07/2016 , immeuble ABIALI                                                                                                                                                                                                               ', 'SOCIETE CIVILE IMMOBILIERE ABIALI', 793861, 'P', 'SERVICES EXTERIEURS A', '2017ND001AB ANI                                   ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '62', 0, NULL, 0),
(7340, 2017, 20172604200, 'Fonctionnement', 'Matières combustibles (carburants et lubrifiants)', 35007100, 10000000, 10000000, 10000000, 10000000, 10000000, 45007100, '2017/ANINF/00195', 5000000, '2017-03-24 00:00:00', '2017-03-22 00:00:00', 5000000, '2017-03-21', '2017-06-19', 'Mars', 5000000, 0, 'Commande de carburant                                                                                                                                                                                                                                          ', 'PETRO GABON', 780697, 'E', 'ACHAT ET VARIATIONS DE STOCKS', 'CSC14/03/2017 Z2                                  ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '60', 0, NULL, 0),
(7341, 2017, 20172604200, 'Fonctionnement', 'Matières combustibles (carburants et lubrifiants)', 35007100, 10000000, 10000000, 10000000, 10000000, 10000000, 45007100, '2017/ANINF/00196', 5000000, '2017-03-24 00:00:00', '2017-06-23 00:00:00', 5000000, '2017-03-21', '2017-06-19', 'Mars', 5000000, 0, 'Commande de carburant                                                                                                                                                                                                                                          ', 'PETRO GABON', 780697, 'E', 'ACHAT ET VARIATIONS DE STOCKS', 'CSC14/03/2017 Z3                                  ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '60', 0, NULL, 0),
(7342, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 85544706, 14455294, 14455294, 14455294, 14455294, 14455294, 100000000, '2017/ANINF/00197', 345230, '2017-03-24 00:00:00', '2017-03-22 00:00:00', 345230, '2017-03-21', '2017-06-19', 'Mars', 345230, 0, 'Réparation véhicule                                                                                                                                                                                                                                            ', 'TRACTAFRIC CAT', 790215, 'F', 'SERVICES EXTERIEURS A', 'FM10097188                                        ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '62', 0, NULL, 0),
(7343, 2017, 20172668400, 'Fonctionnement', 'Médecine du travail et pharmacie', 4000000, 20000000, 20000000, 20000000, 20000000, 20000000, 24000000, '2017/ANINF/00198', 4000000, NULL, '2017-03-22 00:00:00', 4000000, '2017-03-23', '2017-06-21', 'Mars', 4000000, 0, 'Prestation Médicale du mois de septembre 2016                                                                                                                                                                                                                  ', 'SANTE PLUS', 36701, 'M', 'CHARGES DE PERSONNEL', '04                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '66', 0, NULL, 0),
(7344, 2017, 20172668400, 'Fonctionnement', 'Médecine du travail et pharmacie', 4000000, 20000000, 20000000, 20000000, 20000000, 20000000, 24000000, '2017/ANINF/00199', 4000000, NULL, '2017-03-22 00:00:00', 4000000, '2017-03-23', '2017-06-21', 'Mars', 4000000, 0, 'Prestation Médicale du mois d\'octobre 2016                                                                                                                                                                                                                     ', 'SANTE PLUS', 36701, 'M', 'CHARGES DE PERSONNEL', '05                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '66', 0, NULL, 0),
(7345, 2017, 20172668400, 'Fonctionnement', 'Médecine du travail et pharmacie', 4000000, 20000000, 20000000, 20000000, 20000000, 20000000, 24000000, '2017/ANINF/00200', 4000000, NULL, '2017-03-22 00:00:00', 4000000, '2017-03-23', '2017-06-21', 'Mars', 4000000, 0, 'Prestation Médicale du mois de novembre 2016                                                                                                                                                                                                                   ', 'SANTE PLUS', 36701, 'M', 'CHARGES DE PERSONNEL', '06                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '66', 0, NULL, 0),
(7346, 2017, 20172668400, 'Fonctionnement', 'Médecine du travail et pharmacie', 4000000, 20000000, 20000000, 20000000, 20000000, 20000000, 24000000, '2017/ANINF/00201', 4000000, NULL, '2017-03-22 00:00:00', 4000000, '2017-03-23', '2017-06-21', 'Mars', 4000000, 0, 'Prestation médicale du mois de décembre 2016                                                                                                                                                                                                                   ', 'SANTE PLUS', 36701, 'M', 'CHARGES DE PERSONNEL', '07                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '66', 0, NULL, 0),
(7347, 2017, 20172614200, 'Fonctionnement', 'Transport du personnel à l\'extérieur', 73255850, 26744150, 26744150, 26744150, 26744150, 26744150, 100000000, '2017/ANINF/00206', 3862000, '2017-03-29 00:00:00', '2017-03-22 00:00:00', 3862000, '2017-03-23', '2017-06-21', 'Mars', 3862000, 0, 'Frais de transport de Alex Bernard BONGO ONDIMBA au Togo                                                                                                                                                                                                       ', 'HARIOM TRAVELS', 77975, 'N', 'TRANSPORT ET MISSION', '005/HO/IND/2017                                   ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:48', '2020-06-29 02:46:48', '61', 0, NULL, 0),
(7348, 2017, 20172668400, 'Fonctionnement', 'Médecine du travail et pharmacie', 0, 24000000, 24000000, 24000000, 24000000, 24000000, 24000000, '2017/ANINF/00212', 4000000, '2017-03-29 00:00:00', '2017-03-24 00:00:00', 4000000, '2017-03-24', '2017-06-22', 'Mars', 4000000, 0, 'Honoraires medecin du travail comptant pour le mois de janvier 2017                                                                                                                                                                                            ', 'SANTE PLUS', 36701, 'M', 'CHARGES DE PERSONNEL', '08/01/2017                                        ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '66', 0, NULL, 0),
(7349, 2017, 20172602100, 'Fonctionnement', 'Achats de papier d\'impression', 16566654, 18433346, 18433346, 18433346, 18433346, 18433346, 35000000, '2017/ANINF/00213', 5899976, '2017-03-29 00:00:00', '2017-03-24 00:00:00', 5899976, '2017-03-27', '2017-06-25', 'Mars', 5899976, 0, 'Instruments de règlements pour site fins                                                                                                                                                                                                                       ', 'MULTIPRESS GABON', 790848, 'F', 'ACHAT ET VARIATIONS DE STOCKS', '1750011                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '60', 0, NULL, 0),
(7350, 2017, 20172632700, 'Fonctionnement', 'Honoraires Consultant', 21425000, 16975000, 16975000, 16975000, 16975000, 16975000, 38400000, '2017/ANINF/00221', 4000000, '2017-04-05 00:00:00', '2017-03-24 00:00:00', 4000000, '2017-03-31', '2017-06-29', 'Mars', 4000000, 0, 'Honoraires du mois de février 2017                                                                                                                                                                                                                             ', 'SANTE PLUS', 36701, 'M', 'SERVICES EXTERIEURS B', '09                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '63', 0, NULL, 0),
(7351, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 82948706, 17051294, 17051294, 17051294, 17051294, 17051294, 100000000, '2017/ANINF/00229', 2596000, '2017-04-07 00:00:00', NULL, 0, '2017-04-03', '2017-07-02', 'Avril', 2596000, 0, 'Travaux de maconnerie, Réalisation de deux portes blindées                                                                                                                                                                                                     ', 'CONSTRUCTION MÉTALLIQUE ARC-EN-CIEL', 255090, 'X', 'SERVICES EXTERIEURS A', '001-AB/03/2017                                    ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7352, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 587606613, 62393387, 62393387, 62393387, 62393387, 62393387, 650000000, '2017/ANINF/00230', 25500000, '2017-04-07 00:00:00', '2017-03-24 00:00:00', 25500000, '2017-04-03', '2017-07-02', 'Avril', 25500000, 0, 'Loyer immeuble Dera Haut de gué gué ( 2 ème trimestre 2017)                                                                                                                                                                                                    ', 'GUNTHER ENTREPRISE CONSTRUCTION', 79521, 'G', 'SERVICES EXTERIEURS A', '002 Avril/GTR/17                                  ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7353, 2017, 20172658900, 'Fonctionnement', 'Autres charges diverses', 126966633, 173033367, 173033367, 133033367, 173033367, 133033367, 300000000, '2017/ANINF/00232', 1500000, '2017-04-07 00:00:00', '2017-12-22 00:00:00', 1500000, '2017-04-05', '2017-07-04', 'Avril', 1500000, 0, 'Frais de paprticipation à la ligue elite                                                                                                                                                                                                                       ', 'SISMAR GROUP', 41344, 'E', 'AUTRES CHARGES', 'RFP002-2                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '65', 0, NULL, 0),
(7354, 2017, 20172658900, 'Fonctionnement', 'Autres charges diverses', 126966633, 173033367, 173033367, 133033367, 173033367, 133033367, 300000000, '2017/ANINF/00236', 2190000, '2017-04-14 00:00:00', '2017-04-24 00:00:00', 2190000, '2017-04-05', '2017-07-04', 'Avril', 2190000, 0, 'Organisation ceremonie du 1 er mai ( Cocktail)                                                                                                                                                                                                                 ', 'CHRISTAL EVENTS', 265481, 'R', 'AUTRES CHARGES', '001                                               ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '65', 0, NULL, 0),
(7355, 2017, 20172658900, 'Fonctionnement', 'Autres charges diverses', 126966633, 173033367, 173033367, 133033367, 173033367, 133033367, 300000000, '2017/ANINF/00237', 922350, '2017-04-14 00:00:00', '2017-04-24 00:00:00', 922350, '2017-04-05', '2017-07-04', 'Avril', 922350, 0, 'Collation ceremonie 1er mai                                                                                                                                                                                                                                    ', 'PRIX IMPORT', 795688, 'R', 'AUTRES CHARGES', 'F1700484                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '65', 0, NULL, 0),
(7356, 2017, 20174201100, 'Investissement', 'Projet RAG', 120482177, 79517823, 79517823, 79517823, 79517823, 79517823, 200000000, '2017/ANINF/00238', 2682864, '2017-04-14 00:00:00', '2017-12-22 00:00:00', 2682864, '2017-04-06', '2017-07-05', 'Avril', 2682864, 0, 'Frais de formation préparatoire et certifante LINUX                                                                                                                                                                                                            ', 'CAMPUS NUMERIQUE FRANCOPHONE DE LIBREVILLE', 83404, 'Y', 'CHARGES IMMOBILISEES', '05_2003_2017                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7357, 2017, 20174201100, 'Investissement', 'Projet RAG', 120482177, 79517823, 79517823, 79517823, 79517823, 79517823, 200000000, '2017/ANINF/00239', 3135000, '2017-04-14 00:00:00', '2017-05-05 00:00:00', 3135000, '2017-04-06', '2017-07-05', 'Avril', 3135000, 0, 'Frais de formation  préparatoire et certifiante  LINUX                                                                                                                                                                                                         ', 'CAMPUS NUMERIQUE FRANCOPHONE DE LIBREVILLE', 83404, 'Y', 'CHARGES IMMOBILISEES', '06_2003_2017                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7358, 2017, 20172625300, 'Fonctionnement', 'Assurances matériel roulant', 19521420, 478580, 478580, 478580, 478580, 478580, 20000000, '2017/ANINF/00240', 239290, '2017-04-14 00:00:00', '2017-04-10 00:00:00', 239290, '2017-04-06', '2017-07-05', 'Avril', 239290, 0, 'Assurance automobile, bus imm : AU-006-AA                                                                                                                                                                                                                      ', 'GABONAISE DE COURTAGE ASSURANCES', 782585, 'N', 'SERVICES EXTERIEURS A', '211735/04/17/X                                    ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7359, 2017, 20172625300, 'Fonctionnement', 'Assurances matériel roulant', 19521420, 478580, 478580, 478580, 478580, 478580, 20000000, '2017/ANINF/00241', 239290, '2017-04-14 00:00:00', '2017-04-18 00:00:00', 239290, '2017-04-06', '2017-07-05', 'Avril', 239290, 0, 'Assurance Automobile Bus Toyota imm: AU -009- AA                                                                                                                                                                                                               ', 'GABONAISE DE COURTAGE ASSURANCES', 782585, 'N', 'SERVICES EXTERIEURS A', '211734/04/17/X                                    ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7360, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 505066613, 144933387, 144933387, 144933387, 144933387, 144933387, 650000000, '2017/ANINF/00242', 28520000, '2017-04-20 00:00:00', '2017-04-10 00:00:00', 28520000, '2017-04-07', '2017-07-06', 'Avril', 28520000, 0, 'Location entrepot pour le mois d\' avril 2015                                                                                                                                                                                                                   ', 'SCI KAM', 88557, 'A', 'SERVICES EXTERIEURS A', '1336/B                                            ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7361, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 505066613, 144933387, 144933387, 144933387, 144933387, 144933387, 650000000, '2017/ANINF/00243', 14260000, '2017-04-20 00:00:00', '2017-04-10 00:00:00', 14260000, '2017-04-07', '2017-07-06', 'Avril', 14260000, 0, 'Location entrepot pour le mois de septembre 2016                                                                                                                                                                                                               ', 'SCI KAM', 88557, 'A', 'SERVICES EXTERIEURS A', '2341                                              ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7362, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 505066613, 144933387, 144933387, 144933387, 144933387, 144933387, 650000000, '2017/ANINF/00244', 14260000, '2017-04-20 00:00:00', '2017-04-10 00:00:00', 14260000, '2017-04-10', '2017-07-09', 'Avril', 14260000, 0, 'Location entrepot owendo pour le mois d\'\'octobre 2016                                                                                                                                                                                                          ', 'SCI KAM', 88557, 'A', 'SERVICES EXTERIEURS A', '2342                                              ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7363, 2017, 20174201100, 'Investissement', 'Projet RAG', 120482177, 79517823, 79517823, 79517823, 79517823, 79517823, 200000000, '2017/ANINF/00245', 373732, '2017-04-20 00:00:00', '2017-05-17 00:00:00', 373732, '2017-04-10', '2017-07-09', 'Avril', 373732, 0, 'Consommation d\'électricité pour la période du 23/02/2017 au 22/03/2017                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '391567677698                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7364, 2017, 20174201100, 'Investissement', 'Projet RAG', 120482177, 79517823, 79517823, 79517823, 79517823, 79517823, 200000000, '2017/ANINF/00246', 111485, '2017-04-20 00:00:00', '2017-05-17 00:00:00', 111485, '2017-04-10', '2017-07-09', 'Avril', 111485, 0, 'Consommation d\'électricité pour la période du 01/02/2017 au 06/03/2017                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '491565073738                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7365, 2017, 20172614200, 'Fonctionnement', 'Transport du personnel à l\'extérieur', 69793650, 30206350, 30206350, 30206350, 30206350, 30206350, 100000000, '2017/ANINF/00247', 1328100, NULL, '2017-04-18 00:00:00', 1328100, '2017-04-10', '2017-07-09', 'Avril', 1328100, 0, 'Frais de transport de MFOMO MBADINGA Armand  à Casablanca                                                                                                                                                                                                      ', 'CHICA VOYAGES', 84947, 'R', 'TRANSPORT ET MISSION', 'FP048                                             ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '61', 0, NULL, 0),
(7366, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 505066613, 144933387, 144933387, 144933387, 144933387, 144933387, 650000000, '2017/ANINF/00248', 25500000, '2017-04-20 00:00:00', '2017-04-14 00:00:00', 25500000, '2017-04-11', '2017-07-10', 'Avril', 25500000, 0, 'Loyer immeuble DERA Haut de gué gué pour les mois de juillet,aout septembre 2016                                                                                                                                                                               ', 'GUNTHER ENTREPRISE CONSTRUCTION', 79521, 'G', 'SERVICES EXTERIEURS A', '003/juillet/gtr/16                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7367, 2017, 20174201400, 'Investissement', 'Projet Datacenter', 75726790, 24273210, 24273210, 24273210, 24273210, 24273210, 100000000, '2017/ANINF/00265', 1222480, '2017-04-20 00:00:00', '2017-04-18 00:00:00', 1222480, '2017-04-12', '2017-07-11', 'Avril', 1222480, 0, 'Eclairage Datacenter                                                                                                                                                                                                                                           ', 'MATELEC', 90047, 'F', 'CHARGES IMMOBILISEES', '1021404                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7368, 2017, 20174201400, 'Investissement', 'Projet Datacenter', 75726790, 24273210, 24273210, 24273210, 24273210, 24273210, 100000000, '2017/ANINF/00266', 6805980, '2017-04-20 00:00:00', '2017-04-18 00:00:00', 6805980, '2017-04-12', '2017-07-11', 'Avril', 6805980, 0, 'Frais pour l\'isolation du DATACENTER                                                                                                                                                                                                                           ', 'AMPOUMET SERVICE', 452055, 'F', 'CHARGES IMMOBILISEES', 'FV000147                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7369, 2017, 20174243000, 'Fonctionnement', 'Matériel informatique', 69307500, 692500, 692500, 692500, 692500, 692500, 70000000, '2017/ANINF/00270', 192500, '2017-04-26 00:00:00', '2017-04-18 00:00:00', 192500, '2017-04-14', '2017-07-13', 'Avril', 192500, 0, 'Acquisition d\' un Cable réseau  cuivre                                                                                                                                                                                                                         ', 'SGEF', 226247, 'E', 'MATERIEL', 'FACT-SGEF/N°023/2017                              ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '24', 0, NULL, 0),
(7370, 2017, 20172614200, 'Fonctionnement', 'Transport du personnel à l\'extérieur', 69793650, 30206350, 30206350, 30206350, 30206350, 30206350, 100000000, '2017/ANINF/00273', 1398200, '2017-04-26 00:00:00', '2017-04-18 00:00:00', 1398200, '2017-04-18', '2017-07-17', 'Avril', 1398200, 0, 'Frais de transport de Alex BONGO ONDIMBA et EPIGA Andre Bernard à Abidjan                                                                                                                                                                                      ', 'AIR COTE D IVOIRE', 732962, 'F', 'TRANSPORT ET MISSION', 'HF130417/0001                                     ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '61', 0, NULL, 0),
(7371, 2017, 20174201100, 'Investissement', 'Projet RAG', 120217381, 79782619, 79782619, 79782619, 79782619, 79782619, 200000000, '2017/ANINF/00281', 264796, '2017-05-05 00:00:00', '2017-05-17 00:00:00', 264796, '2017-04-20', '2017-07-19', 'Avril', 264796, 0, 'Consommation d\' eau et d\'électricité  pour la période  du 23/02/2017 au 22/03/17                                                                                                                                                                               ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '534553600389                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7372, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 79790158, 20209842, 20209842, 20209842, 20209842, 20209842, 100000000, '2017/ANINF/00282', 464948, '2017-05-05 00:00:00', NULL, 0, '2017-04-20', '2017-07-19', 'Avril', 464948, 0, 'Maintenances Installations et Climatisation Immeuble ABIALI                                                                                                                                                                                                    ', 'SOGAFRIC SERVICES', 791871, 'W', 'SERVICES EXTERIEURS A', '1201414                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7373, 2017, 20172604500, 'Fonctionnement', 'Consommables informatiques', 23524195, 1475805, 1475805, 1475805, 1475805, 1475805, 25000000, '2017/ANINF/00283', 1475805, '2017-05-05 00:00:00', NULL, 0, '2017-04-20', '2017-07-19', 'Avril', 1475805, 0, 'Achat de consommables pour imprimantes                                                                                                                                                                                                                         ', 'GABON MECA', 790131, 'L', 'ACHAT ET VARIATIONS DE STOCKS', 'DC252141                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '60', 0, NULL, 0),
(7374, 2017, 20174201400, 'Investissement', 'Projet Datacenter', 71791048, 28208952, 28208952, 28208952, 28208952, 28208952, 100000000, '2017/ANINF/00284', 3935742, '2017-05-05 00:00:00', '2017-05-17 00:00:00', 3935742, '2017-04-20', '2017-07-19', 'Avril', 3935742, 0, 'Hébergement d\'infogérence de la VM,au DATACENTER de Montpellier                                                                                                                                                                                                ', 'SYLOE', 993440, 'F', 'CHARGES IMMOBILISEES', 'FA1703-0790                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7375, 2017, 20172614200, 'Fonctionnement', 'Transport du personnel à l\'extérieur', 68321850, 31678150, 31678150, 31678150, 31678150, 31678150, 100000000, '2017/ANINF/00286', 1471800, '2017-05-05 00:00:00', '2017-04-24 00:00:00', 1471800, '2017-04-24', '2017-07-23', 'Avril', 1471800, 0, 'Frais de transport de NWENGNANDJI leila et MASSAMBA Martial à Casablanca                                                                                                                                                                                       ', 'ROYAL  AIR MAROC', 91752, 'N', 'TRANSPORT ET MISSION', '36                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '61', 0, NULL, 0),
(7376, 2017, 20174202800, 'Investissement', 'Backbone National', 71102007, 28897993, 28897993, 28897993, 28897993, 28897993, 100000000, '2017/ANINF/00288', 738480, '2017-05-05 00:00:00', '2017-04-28 00:00:00', 738480, '2017-04-26', '2017-07-25', 'Avril', 738480, 0, 'Démontage et réinstallation du FH de la BLR Stage Angondje à ACE vers le Delta Postal                                                                                                                                                                          ', 'TELECOMMUNICATIONS MONETIQUE SERVICES', 70024, 'L', 'CHARGES IMMOBILISEES', '69080406-17                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7377, 2017, 20172625300, 'Fonctionnement', 'Assurances matériel roulant', 15347318, 4652682, 4652682, 4652682, 4652682, 4652682, 20000000, '2017/ANINF/00292', 4174102, '2017-05-05 00:00:00', '2017-05-17 00:00:00', 4174102, '2017-05-02', '2017-07-31', 'Mai', 4174102, 0, 'Assurances automobile de 11 Véhicules de fonction                                                                                                                                                                                                              ', 'GABONAISE DE COURTAGE ASSURANCES', 782585, 'N', 'SERVICES EXTERIEURS A', '211759/04/17/X                                    ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7378, 2017, 20172632700, 'Fonctionnement', 'Honoraires Consultant', 1765500, 36634500, 36634500, 36634500, 36634500, 36634500, 38400000, '2017/ANINF/00296', 2986500, '2017-05-10 00:00:00', '2017-07-07 00:00:00', 2986500, '2017-05-03', '2017-08-01', 'Mai', 2986500, 0, 'Honoraires Consultant  pour le mois d\'octobre 2016                                                                                                                                                                                                             ', 'ENT. DUARTE SLEGERS', 232506, 'M', 'SERVICES EXTERIEURS B', '0010/2016                                         ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '63', 0, NULL, 0),
(7379, 2017, 20172632700, 'Fonctionnement', 'Honoraires Consultant', 1765500, 36634500, 36634500, 36634500, 36634500, 36634500, 38400000, '2017/ANINF/00297', 2986500, '2017-05-10 00:00:00', '2017-09-05 00:00:00', 2986500, '2017-05-03', '2017-08-01', 'Mai', 2986500, 0, 'Honoraires Consultant Sledgers pour le mois de novembre 2016                                                                                                                                                                                                   ', 'ENT. DUARTE SLEGERS', 232506, 'M', 'SERVICES EXTERIEURS B', '0011/2016                                         ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '63', 0, NULL, 0),
(7380, 2017, 20172632700, 'Fonctionnement', 'Honoraires Consultant', 1765500, 36634500, 36634500, 36634500, 36634500, 36634500, 38400000, '2017/ANINF/00298', 2986500, '2017-05-10 00:00:00', '2017-09-08 00:00:00', 2986500, '2017-05-03', '2017-08-01', 'Mai', 2986500, 0, 'Honoraires Consultant Sledgers pour le mois de décembre 2016                                                                                                                                                                                                   ', 'ENT. DUARTE SLEGERS', 232506, 'M', 'SERVICES EXTERIEURS B', '0012/2016                                         ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '63', 0, NULL, 0),
(7381, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 465306613, 184693387, 184693387, 184693387, 184693387, 184693387, 650000000, '2017/ANINF/00304', 14260000, '2017-05-15 00:00:00', '2017-05-05 00:00:00', 14260000, '2017-05-04', '2017-08-02', 'Mai', 14260000, 0, 'Location mensuelle entrepot owendo                                                                                                                                                                                                                             ', 'SCI KAM', 88557, 'A', 'SERVICES EXTERIEURS A', '1117/17                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7382, 2017, 20174201400, 'Investissement', 'Projet Datacenter', 46266053, 53733947, 53733947, 53733947, 53733947, 53733947, 100000000, '2017/ANINF/00305', 8122375, '2017-05-15 00:00:00', '2017-12-14 00:00:00', 8122375, '2017-05-05', '2017-08-03', 'Mai', 8122375, 0, 'Entretien  Préventif des baies , Serveurs et autres appareils                                                                                                                                                                                                  ', 'NET SERVICES', 461640, 'G', 'CHARGES IMMOBILISEES', '038                                               ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7383, 2017, 20174201400, 'Investissement', 'Projet Datacenter', 46266053, 53733947, 53733947, 53733947, 53733947, 53733947, 100000000, '2017/ANINF/00306', 8122375, '2017-05-15 00:00:00', NULL, 0, '2017-05-05', '2017-08-03', 'Mai', 8122375, 0, 'Entretien Préventif des baies,serveurs  (Dactacenter )                                                                                                                                                                                                         ', 'NET SERVICES', 461640, 'G', 'CHARGES IMMOBILISEES', '039-10-2016                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7384, 2017, 20174201400, 'Investissement', 'Projet Datacenter', 46266053, 53733947, 53733947, 53733947, 53733947, 53733947, 100000000, '2017/ANINF/00307', 8122375, '2017-05-15 00:00:00', NULL, 0, '2017-05-05', '2017-08-03', 'Mai', 8122375, 0, 'Entretien Préventif des baies, serveurs ( Datacenter) pour la période de janvier à mars 2017                                                                                                                                                                   ', 'NET SERVICES', 461640, 'G', 'CHARGES IMMOBILISEES', '040-01-2017                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7385, 2017, 20174201400, 'Investissement', 'Projet Datacenter', 46266053, 53733947, 53733947, 53733947, 53733947, 53733947, 100000000, '2017/ANINF/00308', 1157870, '2017-05-15 00:00:00', '2017-06-12 00:00:00', 1157870, '2017-05-05', '2017-08-03', 'Mai', 1157870, 0, 'Réparation des moteurs de central de clim du Datacenter                                                                                                                                                                                                        ', 'SOGAFRIC SERVICES', 791871, 'W', 'CHARGES IMMOBILISEES', '17-PC-059-13-04-ASH                               ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7386, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 79513452, 20486548, 20486548, 20486548, 20486548, 20486548, 100000000, '2017/ANINF/00309', 315000, '2017-05-15 00:00:00', NULL, 0, '2017-05-05', '2017-08-03', 'Mai', 264706, 0, 'Refection Salle CAFIMB                                                                                                                                                                                                                                         ', 'GROUPE CECA GADIS', 790047, 'C', 'SERVICES EXTERIEURS A', '1003502                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7387, 2017, 20174201100, 'Investissement', 'Projet RAG', 115625187, 84374813, 84374813, 84374813, 84374813, 84374813, 200000000, '2017/ANINF/00310', 26008, '2017-05-15 00:00:00', '2017-07-07 00:00:00', 26008, '2017-05-05', '2017-08-03', 'Mai', 26008, 0, 'Consommation d\'eau pour la période du 24/02/2017 au 23/03/2017                                                                                                                                                                                                 ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '334555569938                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0);
INSERT INTO `engagements` (`id`, `d_exerci`, `c_dest`, `nat_dep`, `l_dep`, `m_dispo`, `m_toteng`, `m_tengvi`, `m_totliq`, `m_tordvi`, `m_totord`, `m_dotini`, `n_engage`, `m_engage`, `date_depot_ac`, `date_paiement`, `m_paye`, `d_engage`, `date_echeance`, `mois_`, `m_tliqenga`, `m_non_paye`, `l_depeng`, `l_nmtir`, `n_mattir`, `c_mattir`, `l_chap`, `n_devis`, `nip`, `r_engage`, `desc_r_engage`, `v_m_paye`, `is_paid`, `created_at`, `updated_at`, `chap`, `realized`, `commentaire`, `cancelled`) VALUES
(7388, 2017, 20172614200, 'Fonctionnement', 'Transport du personnel à l\'extérieur', 56389200, 43610800, 43610800, 43610800, 43610800, 43610800, 100000000, '2017/ANINF/00311', 6595300, '2017-05-15 00:00:00', '2017-05-05 00:00:00', 6595300, '2017-05-05', '2017-08-03', 'Mai', 6595300, 0, 'Frais de transport de BONGO ONDIMBA Alex, et EPIGA  Andre Bernard à Rabat                                                                                                                                                                                      ', 'HARIOM TRAVELS', 77975, 'N', 'TRANSPORT ET MISSION', '007/HO/IND/2017                                   ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '61', 0, NULL, 0),
(7389, 2017, 20174213900, 'Fonctionnement', 'Certification ISO 9001', 58480000, 16520000, 16520000, 16520000, 16520000, 16520000, 75000000, '2017/ANINF/00316', 5900000, '2017-05-18 00:00:00', '2017-05-17 00:00:00', 5900000, '2017-05-09', '2017-08-07', 'Mai', 5900000, 0, 'Audit Organisationnel ( 2ème partie)                                                                                                                                                                                                                           ', 'ERNST & YOUNG', 791330, 'W', 'IMMOBILISATIONS INCORPORELLES', 'GAL0200004849                                     ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '21', 0, NULL, 0),
(7390, 2017, 20174213900, 'Fonctionnement', 'Certification ISO 9001', 58480000, 16520000, 16520000, 16520000, 16520000, 16520000, 75000000, '2017/ANINF/00317', 5900000, '2017-05-18 00:00:00', '2017-05-17 00:00:00', 5900000, '2017-05-09', '2017-08-07', 'Mai', 5900000, 0, 'Audit Organisationnel ( 3ème partie)                                                                                                                                                                                                                           ', 'ERNST & YOUNG', 791330, 'W', 'IMMOBILISATIONS INCORPORELLES', 'GAL0200004850                                     ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '21', 0, NULL, 0),
(7391, 2017, 20174213900, 'Fonctionnement', 'Certification ISO 9001', 58480000, 16520000, 16520000, 16520000, 16520000, 16520000, 75000000, '2017/ANINF/00318', 4720000, '2017-05-18 00:00:00', NULL, 0, '2017-05-09', '2017-08-07', 'Mai', 4720000, 0, 'Audit Organisationnel ( 4ème partie)                                                                                                                                                                                                                           ', 'ERNST & YOUNG', 791330, 'W', 'IMMOBILISATIONS INCORPORELLES', 'GAL0200004851                                     ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '21', 0, NULL, 0),
(7392, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 465306613, 184693387, 184693387, 184693387, 184693387, 184693387, 650000000, '2017/ANINF/00323', 15250000, '2017-05-18 00:00:00', '2017-06-15 00:00:00', 15250000, '2017-05-09', '2017-08-07', 'Mai', 15250000, 0, 'Location immeuble DERA Haut de Gué-Gué pour le compte du 2 ème trimestre ( Acompte 1)                                                                                                                                                                          ', 'GUNTHER ENTREPRISE CONSTRUCTION', 79521, 'G', 'SERVICES EXTERIEURS A', '002 Avril/GTR/17                                  ', NULL, 'r', 'Réengagement OP: 2017/ANINF/00230, Exerice: 2017', NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '22', 0, NULL, 0),
(7393, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 465306613, 184693387, 184693387, 184693387, 184693387, 184693387, 650000000, '2017/ANINF/00324', 10250000, '2017-05-18 00:00:00', NULL, 0, '2017-05-09', '2017-08-07', 'Mai', 10250000, 0, 'Location immeuble DERA Haut de Gué-Gué pour le compte du 2 ème trimestre (Solde)                                                                                                                                                                               ', 'GUNTHER ENTREPRISE CONSTRUCTION', 79521, 'G', 'SERVICES EXTERIEURS A', '002Avril/GTR/17                                   ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7394, 2017, 20172614200, 'Fonctionnement', 'Transport du personnel à l\'extérieur', 56389200, 43610800, 43610800, 43610800, 43610800, 43610800, 100000000, '2017/ANINF/00338', 5337350, NULL, '2017-06-12 00:00:00', 5337350, '2017-05-12', '2017-08-10', 'Mai', 5337350, 0, 'Frais de Transport de Rachel Lissenguet et PARAGA JEROME A PARIS                                                                                                                                                                                               ', 'OPINGA  PRESTATIONS', 31027, 'U', 'TRANSPORT ET MISSION', 'RF00055                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '61', 0, NULL, 0),
(7395, 2017, 20174201100, 'Investissement', 'Projet RAG', 115625187, 84374813, 84374813, 84374813, 84374813, 84374813, 200000000, '2017/ANINF/00345', 141186, '2017-05-24 00:00:00', '2017-06-12 00:00:00', 141186, '2017-05-16', '2017-08-14', 'Mai', 141186, 0, 'Installation d\' une liaison internet site de Haut de Gué-Gué                                                                                                                                                                                                   ', 'GABON TELECOM SA', 780730, 'E', 'CHARGES IMMOBILISEES', '08/05/2017                                        ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7396, 2017, 20172632700, 'Fonctionnement', 'Honoraires Consultant', 1765500, 36634500, 36634500, 36634500, 36634500, 36634500, 38400000, '2017/ANINF/00346', 2400000, '2017-05-24 00:00:00', '2017-07-07 00:00:00', 2400000, '2017-05-16', '2017-08-14', 'Mai', 2400000, 0, 'Convention d\'assistance juridique pour le mois de juillet 2016                                                                                                                                                                                                 ', 'LEGIS CONSULTING', 41553, 'B', 'SERVICES EXTERIEURS B', '7                                                 ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '63', 0, NULL, 0),
(7397, 2017, 20172632700, 'Fonctionnement', 'Honoraires Consultant', 1765500, 36634500, 36634500, 36634500, 36634500, 36634500, 38400000, '2017/ANINF/00347', 2400000, '2017-05-24 00:00:00', NULL, 0, '2017-05-16', '2017-08-14', 'Mai', 2400000, 0, 'Convention d\'assistance juridique pour le mois d\'aout 2016                                                                                                                                                                                                     ', 'LEGIS CONSULTING', 41553, 'B', 'SERVICES EXTERIEURS B', '08                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '63', 0, NULL, 0),
(7398, 2017, 20172632700, 'Fonctionnement', 'Honoraires Consultant', 915500, 37484500, 37484500, 37484500, 37484500, 37484500, 38400000, '2017/ANINF/00351', 850000, '2017-05-22 00:00:00', '2017-06-12 00:00:00', 850000, '2017-05-19', '2017-08-17', 'Mai', 850000, 0, 'Prestation d\' Assistance médicale sportive                                                                                                                                                                                                                     ', 'SANTE PLUS', 36701, 'M', 'SERVICES EXTERIEURS B', '01                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '63', 0, NULL, 0),
(7399, 2017, 20172658900, 'Fonctionnement', 'Autres charges diverses', 56205836, 243794164, 243794164, 203794164, 243794164, 203794164, 300000000, '2017/ANINF/00352', 4000000, '2017-05-22 00:00:00', '2017-06-12 00:00:00', 4000000, '2017-05-19', '2017-08-17', 'Mai', 4000000, 0, 'Presation Médicale du mois de mars 2017                                                                                                                                                                                                                        ', 'SANTE PLUS', 36701, 'M', 'AUTRES CHARGES', '10                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '65', 0, NULL, 0),
(7400, 2017, 20172658900, 'Fonctionnement', 'Autres charges diverses', 56205836, 243794164, 243794164, 203794164, 243794164, 203794164, 300000000, '2017/ANINF/00353', 4000000, '2017-05-22 00:00:00', NULL, 0, '2017-05-19', '2017-08-17', 'Mai', 4000000, 0, 'Prestation médicale du mois d avril 2017                                                                                                                                                                                                                       ', 'SANTE PLUS', 36701, 'M', 'AUTRES CHARGES', '11                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '65', 0, NULL, 0),
(7401, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 78359206, 21640794, 21640794, 21640794, 21640794, 21640794, 100000000, '2017/ANINF/00356', 459853, '2017-05-31 00:00:00', '2017-06-12 00:00:00', 459853, '2017-05-23', '2017-08-21', 'Mai', 459853, 0, 'Achat de split                                                                                                                                                                                                                                                 ', 'SOGAFRIC SERVICES', 791871, 'W', 'SERVICES EXTERIEURS A', '67-PC-0049-09-0                                   ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7402, 2017, 20172602100, 'Fonctionnement', 'Achats de papier d\'impression', 5169580, 29830420, 29830420, 29830420, 29830420, 29830420, 35000000, '2017/ANINF/00357', 11397074, '2017-05-31 00:00:00', NULL, 0, '2017-05-23', '2017-08-21', 'Mai', 11397074, 0, 'Instruments de règlements Site Fins                                                                                                                                                                                                                            ', 'MULTIPRESS GABON', 790848, 'F', 'ACHAT ET VARIATIONS DE STOCKS', '1750021                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '60', 0, NULL, 0),
(7403, 2017, 20172614100, 'Fonctionnement', 'Transport du personnel à l\'intérieur', 9640002, 359998, 359998, 359998, 359998, 359998, 10000000, '2017/ANINF/00358', 359998, '2017-05-31 00:00:00', NULL, 0, '2017-05-23', '2017-08-21', 'Mai', 359998, 0, 'Frais de transport de Mavoungou Sleidge  et DENDE Philippe à Port- gentil                                                                                                                                                                                      ', 'CHICA VOYAGES', 84947, 'R', 'TRANSPORT ET MISSION', 'FW275                                             ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '61', 0, NULL, 0),
(7404, 2017, 20174201100, 'Investissement', 'Projet RAG', 87780238, 112219762, 112219762, 112219762, 112219762, 112219762, 200000000, '2017/ANINF/00359', 465331, '2017-05-31 00:00:00', '2017-07-07 00:00:00', 465331, '2017-05-23', '2017-08-21', 'Mai', 465331, 0, 'Consommation d\'électricité pour la période du 22/03/2017 au 28/04/2017                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '391564208270                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7405, 2017, 20174201100, 'Investissement', 'Projet RAG', 87780238, 112219762, 112219762, 112219762, 112219762, 112219762, 200000000, '2017/ANINF/00360', 4160, '2017-05-31 00:00:00', '2017-07-07 00:00:00', 4160, '2017-05-23', '2017-08-21', 'Mai', 4160, 0, 'Consommation d\'eau et d\'électricité pour la période du 22/03/2017 au 24/04/2017                                                                                                                                                                                ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '534559848444                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7406, 2017, 20174201100, 'Investissement', 'Projet RAG', 87780238, 112219762, 112219762, 112219762, 112219762, 112219762, 200000000, '2017/ANINF/00361', 112729, '2017-05-31 00:00:00', '2017-07-07 00:00:00', 112729, '2017-05-23', '2017-08-21', 'Mai', 112729, 0, 'Consommation d\'électricité pour la période du 15/03/2017 au 21/04/2017                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '791568422130                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7407, 2017, 20174241600, 'Investissement', 'Materiels divers', 19807636, 12192364, 12192364, 12192364, 12192364, 12192364, 32000000, '2017/ANINF/00362', 25000, '2017-05-31 00:00:00', NULL, 0, '2017-05-23', '2017-08-21', 'Mai', 25000, 0, 'Achat de Bombonne d\'\'eau de 20l                                                                                                                                                                                                                                ', 'SOCIETE DE TRAITEMENT D EAU MINERALE DE GLASS', 88352, 'P', 'MATERIEL', 'FA3657                                            ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '24', 0, NULL, 0),
(7408, 2017, 20174241600, 'Investissement', 'Materiels divers', 19807636, 12192364, 12192364, 12192364, 12192364, 12192364, 32000000, '2017/ANINF/00363', 150000, '2017-05-31 00:00:00', NULL, 0, '2017-05-23', '2017-08-21', 'Mai', 150000, 0, 'Achat d\'une Fontaine d\'eau                                                                                                                                                                                                                                     ', 'SOCIETE DE TRAITEMENT D EAU MINERALE DE GLASS', 88352, 'P', 'MATERIEL', 'FA3656                                            ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '24', 0, NULL, 0),
(7409, 2017, 20174201100, 'Investissement', 'Projet RAG', 87780238, 112219762, 112219762, 112219762, 112219762, 112219762, 200000000, '2017/ANINF/00364', 112729, '2017-05-31 00:00:00', '2017-07-07 00:00:00', 112729, '2017-05-23', '2017-08-21', 'Mai', 112729, 0, 'Consommation d\'électricité pour la période du 06/03/2017 au 06/04/2017                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '491569038804                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7410, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 436786613, 213213387, 213213387, 213213387, 213213387, 213213387, 650000000, '2017/ANINF/00365', 14260000, '2017-05-26 00:00:00', NULL, 0, '2017-05-23', '2017-08-21', 'Mai', 14260000, 0, 'Location sur la période du mois de novembre 2016                                                                                                                                                                                                               ', 'SCI KAM', 88557, 'A', 'SERVICES EXTERIEURS A', '2343                                              ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7411, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 436786613, 213213387, 213213387, 213213387, 213213387, 213213387, 650000000, '2017/ANINF/00366', 14260000, '2017-05-26 00:00:00', '2017-07-07 00:00:00', 14260000, '2017-05-23', '2017-08-21', 'Mai', 14260000, 0, 'Location entrepot pour le mois d owendo pour le mois de Décembre 2016                                                                                                                                                                                          ', 'SCI KAM', 88557, 'A', 'SERVICES EXTERIEURS A', '2344                                              ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7412, 2017, 20174202800, 'Investissement', 'Backbone National', 69980320, 30019680, 30019680, 30019680, 30019680, 30019680, 100000000, '2017/ANINF/00367', 1121687, '2017-05-26 00:00:00', '2017-06-23 00:00:00', 1121687, '2017-05-23', '2017-08-21', 'Mai', 1121687, 0, 'Internet Access pour le mois mars 2017                                                                                                                                                                                                                         ', 'COGENT COMMUNICATIONS FRANCE', 43070, 'R', 'CHARGES IMMOBILISEES', 'SINVFR77448                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7413, 2017, 20172614200, 'Fonctionnement', 'Transport du personnel à l\'extérieur', 37175045, 62824955, 62824955, 62824955, 62824955, 62824955, 100000000, '2017/ANINF/00386', 13230550, NULL, NULL, 0, '2017-05-31', '2017-08-29', 'Mai', 13230550, 0, 'Frais de transport de BONGO ONDIMBA Alex Bernard ( Libreville-Paris-San Francisco)                                                                                                                                                                             ', 'CHICA VOYAGES', 84947, 'R', 'TRANSPORT ET MISSION', 'FP088                                             ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '61', 0, NULL, 0),
(7414, 2017, 20172614200, 'Fonctionnement', 'Transport du personnel à l\'extérieur', 37175045, 62824955, 62824955, 62824955, 62824955, 62824955, 100000000, '2017/ANINF/00391', 5692350, NULL, '2017-06-23 00:00:00', 5692350, '2017-05-31', '2017-08-29', 'Mai', 5692350, 0, 'Frais de transport LISSENGUET MABOBET Rachel   et Jerome PARAGA à Paris                                                                                                                                                                                        ', 'OPINGA  PRESTATIONS', 31027, 'U', 'TRANSPORT ET MISSION', 'RF0060                                            ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '61', 0, NULL, 0),
(7415, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 78009206, 21990794, 21990794, 21990794, 21990794, 21990794, 100000000, '2017/ANINF/00395', 350000, '2017-06-06 00:00:00', '2017-06-12 00:00:00', 350000, '2017-06-02', '2017-08-31', 'Juin', 350000, 0, 'Acquisition split samsung                                                                                                                                                                                                                                      ', 'Y G INTERNATIONAL SARL', 741970, 'F', 'SERVICES EXTERIEURS A', 'DEV 152                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7416, 2017, 20174202800, 'Investissement', 'Backbone National', 68858633, 31141367, 31141367, 31141367, 31141367, 31141367, 100000000, '2017/ANINF/00400', 1121687, '2017-06-28 00:00:00', '2017-12-10 00:00:00', 1121687, '2017-06-08', '2017-09-06', 'Juin', 1121687, 0, 'Internet Access avril 2017                                                                                                                                                                                                                                     ', 'COGENT COMMUNICATIONS FRANCE', 43070, 'R', 'CHARGES IMMOBILISEES', 'SINVFR78160                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7417, 2017, 20172614200, 'Fonctionnement', 'Transport du personnel à l\'extérieur', 2651445, 97348555, 97348555, 97348555, 97348555, 97348555, 100000000, '2017/ANINF/00415', 13230550, '2017-06-28 00:00:00', NULL, 0, '2017-06-19', '2017-09-17', 'Juin', 13230550, 0, 'Frais de transport d\'Alex Bernard BONGO ONDIMBA a San Francisco                                                                                                                                                                                                ', 'CHICA VOYAGES', 84947, 'R', 'TRANSPORT ET MISSION', 'FW324                                             ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '61', 0, NULL, 0),
(7418, 2017, 20172602100, 'Fonctionnement', 'Achats de papier d\'impression', 174823, 34825177, 34825177, 34825177, 34825177, 34825177, 35000000, '2017/ANINF/00416', 1356600, '2017-06-28 00:00:00', '2017-06-23 00:00:00', 1356600, '2017-06-21', '2017-09-19', 'Juin', 1356600, 0, 'Instruments de règlement pour site Fins                                                                                                                                                                                                                        ', 'MULTIPRESS GABON', 790848, 'F', 'ACHAT ET VARIATIONS DE STOCKS', '1750026                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '60', 0, NULL, 0),
(7419, 2017, 20174203900, 'Investissement', 'Autres Projets', 1027652, 100006103, 100006103, 100006103, 98956103, 100006103, 101033755, '2017/ANINF/00421', 2400000, '2017-06-28 00:00:00', NULL, 0, '2017-06-27', '2017-09-25', 'Juin', 2400000, 0, 'Convention d\'assistance juridique (octobre 2016)                                                                                                                                                                                                               ', 'LEGIS CONSULTING', 41553, 'B', 'CHARGES IMMOBILISEES', '10                                                ', NULL, 'r', 'Réengagement OP: 2017/ANINF/00352, Exerice: 2017', NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '03', 0, NULL, 0),
(7420, 2017, 20174203900, 'Investissement', 'Autres Projets', 1027652, 100006103, 100006103, 100006103, 98956103, 100006103, 101033755, '2017/ANINF/00422', 2400000, '2017-06-28 00:00:00', NULL, 0, '2017-06-27', '2017-09-25', 'Juin', 2400000, 0, 'Convention d\' assistance juridique ( Novembre 2016)                                                                                                                                                                                                            ', 'LEGIS CONSULTING', 41553, 'B', 'CHARGES IMMOBILISEES', '11                                                ', NULL, 'r', 'Réengagement OP: 2017/ANINF/00353, Exerice: 2017', NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '03', 0, NULL, 0),
(7421, 2017, 20174203900, 'Investissement', 'Autres Projets', 1027652, 100006103, 100006103, 100006103, 98956103, 100006103, 101033755, '2017/ANINF/00423', 2400000, '2017-06-28 00:00:00', NULL, 0, '2017-06-27', '2017-09-25', 'Juin', 2400000, 0, 'Convention d\'\'assistance Juridique (décembre 2016)                                                                                                                                                                                                             ', 'LEGIS CONSULTING', 41553, 'B', 'CHARGES IMMOBILISEES', '12                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '20', 0, NULL, 0),
(7422, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 72428676, 27571324, 27571324, 27571324, 27571324, 27571324, 100000000, '2017/ANINF/00424', 1092180, '2017-06-28 00:00:00', NULL, 0, '2017-06-27', '2017-09-25', 'Juin', 1092180, 0, 'Deshumidificateur domestique                                                                                                                                                                                                                                   ', 'SOGAFRIC SERVICES', 791871, 'W', 'SERVICES EXTERIEURS A', '78-PC-0049-09-01                                  ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:49', '2020-06-29 02:46:49', '62', 0, NULL, 0),
(7423, 2017, 20174213200, 'Investissement', 'Logiciel des fréquences', 51470100, 8529900, 8529900, 8529900, 8529900, 8529900, 60000000, '2017/ANINF/00430', 8700000, '2017-07-10 00:00:00', NULL, 0, '2017-06-29', '2017-09-27', 'Juin', 8700000, 0, 'Retransmission Satellite Tournoi de Football                                                                                                                                                                                                                   ', 'IN OUT TECHNOLOGY', 319725, 'K', 'IMMOBILISATIONS INCORPORELLES', '018/1/UL/TX                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '21', 0, NULL, 0),
(7424, 2017, 20174213200, 'Investissement', 'Logiciel des fréquences', 51470100, 8529900, 8529900, 8529900, 8529900, 8529900, 60000000, '2017/ANINF/00431', 2700000, '2017-07-10 00:00:00', '2017-07-07 00:00:00', 2700000, '2017-06-29', '2017-09-27', 'Juin', 2700000, 0, 'Retransmission satellite Tournoi de Football                                                                                                                                                                                                                   ', 'IN OUT TECHNOLOGY', 319725, 'K', 'IMMOBILISATIONS INCORPORELLES', '022/1/UL/TX                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '21', 0, NULL, 0),
(7425, 2017, 20172614200, 'Fonctionnement', 'Transport du personnel à l\'extérieur', 2651445, 97348555, 97348555, 97348555, 97348555, 97348555, 100000000, '2017/ANINF/00432', 832900, '2017-07-10 00:00:00', '2017-07-07 00:00:00', 832900, '2017-06-29', '2017-09-27', 'Juin', 832900, 0, 'Frais de transport de LIFANDI Kevin Stallin à Paris                                                                                                                                                                                                            ', 'ROYAL  AIR MAROC', 91752, 'N', 'TRANSPORT ET MISSION', '41                                                ', NULL, 'r', 'Réengagement OP: 2017/ANINF/00154, Exerice: 2017', NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '14', 0, NULL, 0),
(7426, 2017, 20172633000, 'Fonctionnement', 'Frais de formation du personnel', 15026270, 4973730, 4973730, 4973730, 4973730, 4973730, 20000000, '2017/ANINF/00434', 3481000, '2017-08-03 00:00:00', '2017-09-08 00:00:00', 3481000, '2017-07-03', '2017-10-01', 'Juillet', 3481000, 0, 'Formation sur la fixation des objectifs  de la Direction de Ressources Humaines                                                                                                                                                                                ', 'ULYSS', 87297, 'M', 'SERVICES EXTERIEURS B', '004-05-17                                         ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '63', 0, NULL, 0),
(7427, 2017, 20172658900, 'Fonctionnement', 'Autres charges diverses', 130836, 299869164, 299869164, 259869164, 298869164, 259869164, 300000000, '2017/ANINF/00436', 1000000, '2017-08-03 00:00:00', NULL, 0, '2017-07-03', '2017-10-01', 'Juillet', 1000000, 0, 'Expedition et Receptions des documents                                                                                                                                                                                                                         ', 'D.H.L. INTERNATIONAL GABON', 791887, 'X', 'AUTRES CHARGES', 'LBVM01-12617                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '65', 0, NULL, 0),
(7428, 2017, 20172614200, 'Fonctionnement', 'Transport du personnel à l\'extérieur', 2651445, 97348555, 97348555, 97348555, 97348555, 97348555, 100000000, '2017/ANINF/00440', 16327550, NULL, NULL, 0, '2017-07-03', '2017-10-01', 'Juillet', 16327550, 0, 'Frais de transport délégation ANINF mission maroc                                                                                                                                                                                                              ', 'ESPACE VOYAGE TOURISME', 89533, 'Y', 'TRANSPORT ET MISSION', 'PF17622                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '61', 0, NULL, 0),
(7429, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 72428676, 27571324, 27571324, 27571324, 27571324, 27571324, 100000000, '2017/ANINF/00442', 3310000, '2017-08-03 00:00:00', '2017-07-07 00:00:00', 3310000, '2017-07-10', '2017-10-08', 'Juillet', 3310000, 0, 'Travaux de réhabiliation hall entrée de l\'immeuble de la solde                                                                                                                                                                                                 ', 'GABON FOURNITURE SERVICES BATIS', 258554, 'K', 'SERVICES EXTERIEURS A', '021/AG/2017                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '62', 0, NULL, 0),
(7430, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00456', 10321, '2017-08-03 00:00:00', '2017-12-22 00:00:00', 10321, '2017-07-17', '2017-10-15', 'Juillet', 10321, 0, 'Frais de Coupure / Remise d\'électricité                                                                                                                                                                                                                        ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '891560310239                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7431, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00457', 360670, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 360670, '2017-07-17', '2017-10-15', 'Juillet', 360670, 0, 'Consommation d\' électricité pour la période du 28/04/2017 au 23/05/2017                                                                                                                                                                                        ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '391569816336                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7432, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00458', 10321, '2017-08-03 00:00:00', '2017-12-22 00:00:00', 10321, '2017-07-17', '2017-10-15', 'Juillet', 10321, 0, 'Frais de coupure/remise d\'élecrticité                                                                                                                                                                                                                          ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '791564311726                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7433, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00459', 275540, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 275540, '2017-07-17', '2017-10-15', 'Juillet', 275540, 0, 'Consommation d\'électricité pour la période du 24/04/2017 au 22/05/2017                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '534555183082                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7434, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00460', 281, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 281, '2017-07-17', '2017-10-15', 'Juillet', 281, 0, 'Consommation d\'eau pour la période du 24/04/2017 au 20/05/2017                                                                                                                                                                                                 ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '231139715437                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7435, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00461', 10321, '2017-08-03 00:00:00', '2017-12-22 00:00:00', 10321, '2017-07-17', '2017-10-15', 'Juillet', 10321, 0, 'Frais de coupure et remise d\'elecrticité                                                                                                                                                                                                                       ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '491568259276                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7436, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00462', 2593, '2017-08-03 00:00:00', '2017-12-22 00:00:00', 2593, '2017-07-17', '2017-10-15', 'Juillet', 2593, 0, 'Consommation d\'eau pour la période du 25/04/2017 au 24/05/2017                                                                                                                                                                                                 ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '334553088486                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7437, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00464', 10141, '2017-08-03 00:00:00', '2017-12-22 00:00:00', 10141, '2017-07-17', '2017-10-15', 'Juillet', 10141, 0, 'Frais de coupure et remise d\' électricité                                                                                                                                                                                                                      ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '634555422798                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7438, 2017, 20172658300, 'Fonctionnement', 'Frais de Stage', 8702550, 26297450, 26297450, 26297450, 26297450, 26297450, 35000000, '2017/ANINF/00465', 1977450, '2017-08-03 00:00:00', NULL, 0, '2017-07-17', '2017-10-15', 'Juillet', 1977450, 0, 'Frais de transport du Consultant  LAHRICHI SAAD au Maroc                                                                                                                                                                                                       ', 'CHICA VOYAGES', 84947, 'R', 'AUTRES CHARGES', '272                                               ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '65', 0, NULL, 0),
(7439, 2017, 20174202800, 'Investissement', 'Backbone National', 65493572, 34506428, 34506428, 34506428, 34506428, 34506428, 100000000, '2017/ANINF/00466', 1121687, '2017-08-03 00:00:00', '2017-09-05 00:00:00', 1121687, '2017-07-17', '2017-10-15', 'Juillet', 1121687, 0, 'Internet Access du mois de juillet 2017                                                                                                                                                                                                                        ', 'COGENT COMMUNICATIONS FRANCE', 43070, 'R', 'CHARGES IMMOBILISEES', 'SINVFR80319                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7440, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 72428676, 27571324, 27571324, 27571324, 27571324, 27571324, 100000000, '2017/ANINF/00470', 1178350, '2017-08-03 00:00:00', '2017-09-05 00:00:00', 1178350, '2017-07-21', '2017-10-19', 'Juillet', 1178350, 0, 'Réparation véhicule de mission ( Pick up Toyota Hilux 006)                                                                                                                                                                                                     ', 'GARAGE MOTORS', 270029, 'F', 'SERVICES EXTERIEURS A', '00372/2017                                        ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '62', 0, NULL, 0),
(7441, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00471', 362604, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 362604, '2017-07-24', '2017-10-22', 'Juillet', 362604, 0, 'Consommation d\'eau et d\' électricité  pour la période du 23/08/2016 au 26/09/2016                                                                                                                                                                              ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '634554110978                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7442, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00472', 394645, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 394645, '2017-07-24', '2017-10-22', 'Juillet', 394645, 0, 'Consommation d\'eau et d\'électricité pour la période du 28/12/2015 au 28/01/2016                                                                                                                                                                                ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '634554065583                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7443, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00473', 327287, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 327287, '2017-07-24', '2017-10-22', 'Juillet', 327287, 0, 'Consommation d\' eau et  d\' Electicité pour la période du 26/09/2016 au 24/10/2016                                                                                                                                                                              ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '634553067045                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7444, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00474', 810081, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 810081, '2017-07-24', '2017-10-22', 'Juillet', 810081, 0, 'Consommation d\'eau et d\'électricité  pour la période  du 25/02/2016 au 23/04/2016                                                                                                                                                                              ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '634554443009                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7445, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00475', 10321, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 10321, '2017-07-24', '2017-10-22', 'Juillet', 10321, 0, 'Frais de coupure et de remise d \'électricité                                                                                                                                                                                                                   ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '391563851794                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7446, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00476', 465331, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 465331, '2017-07-24', '2017-10-22', 'Juillet', 465331, 0, 'Consommation d\'electricité pour la période 22/03/2017 aun 28/04/2017                                                                                                                                                                                           ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '391564208270                                      ', NULL, 'r', 'Réengagement OP: 2017/ANINF/00359, Exerice: 2017', NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '01', 0, NULL, 0),
(7447, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00477', 393240, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 393240, '2017-07-24', '2017-10-22', 'Juillet', 393240, 0, 'Consommation d\'électricité pour la période du 24/01/2017 au 23/02/2017                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '391567457034                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7448, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00478', 346176, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 346176, '2017-07-24', '2017-10-22', 'Juillet', 346176, 0, 'Consommation d \'électricité pour la période du 27/12/2016 au 24/01/2017                                                                                                                                                                                        ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '391568610616                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7449, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00479', 329629, '2017-08-03 00:00:00', '2017-12-22 00:00:00', 329629, '2017-07-24', '2017-10-22', 'Juillet', 329629, 0, 'Consommation d\'électricité pour la période du 27/09/2016 au 27/10/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '391564946439                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7450, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00480', 10321, '2017-08-03 00:00:00', '2017-12-22 00:00:00', 10321, '2017-07-24', '2017-10-22', 'Juillet', 10321, 0, 'Frais de coupure/ de remise d\'électricité                                                                                                                                                                                                                      ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '791560092317                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7451, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00481', 330543, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 330543, '2017-07-24', '2017-10-22', 'Juillet', 330543, 0, 'Frais d\'électricité pour la période du 21/04/2017 au 15/05/2017                                                                                                                                                                                                ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '791565855027                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7452, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00482', 112729, '2017-08-03 00:00:00', '2017-12-22 00:00:00', 112729, '2017-07-24', '2017-10-22', 'Juillet', 112729, 0, 'Consommation d\'éléctricité pour la période du 15/03/2017 au 21/04/2017                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '791568422130                                      ', NULL, 'r', 'Réengagement OP: 2017/ANINF/00361, Exerice: 2017', NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '01', 0, NULL, 0),
(7453, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00483', 363135, '2017-08-03 00:00:00', NULL, 0, '2017-07-24', '2017-10-22', 'Juillet', 363135, 0, 'Consommation d\' électricité pour la période du 15/02/2017 au 15/03/2017                                                                                                                                                                                        ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '791567364608                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7454, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00484', 663274, '2017-08-03 00:00:00', NULL, 0, '2017-07-24', '2017-10-22', 'Juillet', 663274, 0, 'Consommation d électricité pour la période du 15/11/2016 au 16/01/2017                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '791564842615                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7455, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00485', 668185, '2017-08-03 00:00:00', NULL, 0, '2017-07-24', '2017-10-22', 'Juillet', 668185, 0, 'Consommation d \'électricité pour la période du 13/08/2016 au 15/10/2016                                                                                                                                                                                        ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '791563212464                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0);
INSERT INTO `engagements` (`id`, `d_exerci`, `c_dest`, `nat_dep`, `l_dep`, `m_dispo`, `m_toteng`, `m_tengvi`, `m_totliq`, `m_tordvi`, `m_totord`, `m_dotini`, `n_engage`, `m_engage`, `date_depot_ac`, `date_paiement`, `m_paye`, `d_engage`, `date_echeance`, `mois_`, `m_tliqenga`, `m_non_paye`, `l_depeng`, `l_nmtir`, `n_mattir`, `c_mattir`, `l_chap`, `n_devis`, `nip`, `r_engage`, `desc_r_engage`, `v_m_paye`, `is_paid`, `created_at`, `updated_at`, `chap`, `realized`, `commentaire`, `cancelled`) VALUES
(7456, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00486', 1738791, '2017-08-03 00:00:00', NULL, 0, '2017-07-24', '2017-10-22', 'Juillet', 1738791, 0, 'Consommation d\'électricité pour la période du 23/09/2016 au 23/02/2017                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '534551343233                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7457, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00487', 377677, '2017-08-03 00:00:00', '2017-12-22 00:00:00', 377677, '2017-07-24', '2017-10-22', 'Juillet', 377677, 0, 'Consommation d\'électricité pour la période du 16/01/2017 au 15/02/2017                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '791566689559                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7458, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00488', 136886, '2017-08-03 00:00:00', '2017-12-22 00:00:00', 136886, '2017-07-24', '2017-10-22', 'Juillet', 136886, 0, 'Consommation d\'électricité pour la période du 01/11/2016 au 31/12/2016                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '491567651325                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7459, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00492', 4160, '2017-08-03 00:00:00', '2017-12-22 00:00:00', 4160, '2017-07-31', '2017-10-29', 'Juillet', 4160, 0, 'Consommation d eau et d\'electricité pour la période du 22/03/2017 au 24/04/17                                                                                                                                                                                  ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '534559848444                                      ', NULL, 'r', 'Réengagement OP: 2017/ANINF/00360, Exerice: 2017', NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '01', 0, NULL, 0),
(7460, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00493', 10044, '2017-08-03 00:00:00', '2017-12-22 00:00:00', 10044, '2017-07-31', '2017-10-29', 'Juillet', 10044, 0, 'Frais de de coupure et de remise d \'électricité                                                                                                                                                                                                                ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '534555749150                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7461, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00494', 114737, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 114737, '2017-07-31', '2017-10-29', 'Juillet', 114737, 0, 'Consommation d\'électricité pour la période du 10/05/2017 au 12/06/2017                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '491562700052                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7462, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00495', 112729, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 112729, '2017-07-31', '2017-10-29', 'Juillet', 112729, 0, 'Consommation d\'\'\'\' électricité pour la période du 06/03/2017 au 06/04/2017                                                                                                                                                                                     ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '491569038804                                      ', NULL, 'r', 'Réengagement OP: 2017/ANINF/00364, Exerice: 2017', NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '01', 0, NULL, 0),
(7463, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00496', 137763, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 137763, '2017-07-31', '2017-10-29', 'Juillet', 137763, 0, 'Consommation d\"électricité pour la période du 02/01/2017 au 01/02/2017                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '491565908236                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7464, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00497', 139544, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 139544, '2017-07-31', '2017-10-29', 'Juillet', 139544, 0, 'Consommation d\'eau et d\'electricité pour la période du 01/12/2016 au 02/01/2017                                                                                                                                                                                ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '491566292928                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7465, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00498', 112729, '2017-08-03 00:00:00', '2017-09-06 00:00:00', 112729, '2017-07-31', '2017-10-29', 'Juillet', 112729, 0, 'Consommation d\'electricité pour la période du 06/04/2017 au 10/05/2017                                                                                                                                                                                         ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '491565504391                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7466, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00499', 10141, '2017-08-03 00:00:00', '2017-12-22 00:00:00', 10141, '2017-07-31', '2017-10-29', 'Juillet', 10141, 0, 'Frais de coupure et de remise d\'électicité                                                                                                                                                                                                                     ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '634555422798                                      ', NULL, 'r', 'Réengagement OP: 2017/ANINF/00464, Exerice: 2017', NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '01', 0, NULL, 0),
(7467, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00500', 10141, '2017-08-22 00:00:00', '2017-12-22 00:00:00', 10141, '2017-07-31', '2017-10-29', 'Juillet', 10141, 0, 'Frais de coupure et remise d elecricité                                                                                                                                                                                                                        ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '634554335033                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '20', 0, NULL, 0),
(7468, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 424321435, 225678565, 225678565, 225678565, 225678565, 225678565, 650000000, '2017/ANINF/00503', 4074585, '2017-08-22 00:00:00', NULL, 0, '2017-08-02', '2017-10-31', 'Août', 4074585, 0, 'Loyer 3eme  trimestre 2017 immeuble les forestiers                                                                                                                                                                                                             ', 'ALLIANCE', 794872, 'R', 'SERVICES EXTERIEURS A', 'G002/81AGENC-03                                   ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:50', '2020-06-29 02:46:50', '62', 0, NULL, 0),
(7469, 2017, 20174202500, 'Fonctionnement', 'Projet FODEN', 1257300, 48742700, 48742700, 48742700, 48742700, 48742700, 50000000, '2017/ANINF/00510', 3346350, NULL, '2017-09-05 00:00:00', 3346350, '2017-08-04', '2017-11-02', 'Août', 3346350, 0, 'Frais de transport de Mr Anicet NDJIYA KOUAMBA à paris                                                                                                                                                                                                         ', 'EURAFRIQUE - VOYAGES', 791219, 'L', 'CHARGES IMMOBILISEES', '1138                                              ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '20', 0, NULL, 0),
(7470, 2017, 20174213100, 'Investissement', 'Logiciels', 57352089, 32647911, 32647911, 32647911, 32647911, 32647911, 90000000, '2017/ANINF/00536', 1055000, '2017-08-22 00:00:00', NULL, 0, '2017-08-11', '2017-11-09', 'Août', 1055000, 0, 'Frais de transport de M POUAGNE VASCO Tina Isabelle Audrey Doris à paris                                                                                                                                                                                       ', 'HARIOM TRAVELS', 77975, 'N', 'IMMOBILISATIONS INCORPORELLES', '004/PERFORMA/2017                                 ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '21', 0, NULL, 0),
(7471, 2017, 20174202800, 'Investissement', 'Backbone National', 65493572, 34506428, 34506428, 34506428, 34506428, 34506428, 100000000, '2017/ANINF/00541', 1121687, '2017-08-28 00:00:00', '2017-12-22 00:00:00', 1121687, '2017-08-22', '2017-11-20', 'Août', 1121687, 0, 'Internet Acess du mois de mai 2017                                                                                                                                                                                                                             ', 'COGENT COMMUNICATIONS FRANCE', 43070, 'R', 'CHARGES IMMOBILISEES', 'SINVFR78881                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '20', 0, NULL, 0),
(7472, 2017, 20174202800, 'Investissement', 'Backbone National', 65493572, 34506428, 34506428, 34506428, 34506428, 34506428, 100000000, '2017/ANINF/00542', 1121687, '2017-08-28 00:00:00', '2017-12-22 00:00:00', 1121687, '2017-08-22', '2017-11-20', 'Août', 1121687, 0, 'Internet Acess  pour le mois de juin 2017                                                                                                                                                                                                                      ', 'COGENT COMMUNICATIONS FRANCE', 43070, 'R', 'CHARGES IMMOBILISEES', 'SINVFR79601                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '20', 0, NULL, 0),
(7473, 2017, 20172602100, 'Fonctionnement', 'Achats de papier d\'impression', 174823, 34825177, 34825177, 34825177, 34825177, 34825177, 35000000, '2017/ANINF/00550', 1561875, '2017-08-30 00:00:00', '2017-09-08 00:00:00', 1561875, '2017-08-28', '2017-11-26', 'Août', 1561875, 0, 'Instruments de reglement pour site solde                                                                                                                                                                                                                       ', 'MULTIPRESS GABON', 790848, 'F', 'ACHAT ET VARIATIONS DE STOCKS', '1750032                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '60', 0, NULL, 0),
(7474, 2017, 20172602100, 'Fonctionnement', 'Achats de papier d\'impression', 174823, 34825177, 34825177, 34825177, 34825177, 34825177, 35000000, '2017/ANINF/00551', 615230, '2017-08-30 00:00:00', NULL, 0, '2017-08-28', '2017-11-26', 'Août', 615230, 0, 'Instrument de reglements pour FINS                                                                                                                                                                                                                             ', 'MULTIPRESS GABON', 790848, 'F', 'ACHAT ET VARIATIONS DE STOCKS', '1750027                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '60', 0, NULL, 0),
(7475, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 424321435, 225678565, 225678565, 225678565, 225678565, 225678565, 650000000, '2017/ANINF/00552', 1260593, '2017-08-31 00:00:00', '2017-09-08 00:00:00', 1260593, '2017-08-29', '2017-11-27', 'Août', 1260593, 0, 'Tickets acces au salon EKENA                                                                                                                                                                                                                                   ', 'A.D.L. - AEROPORT DE LIBREVILLE', 794112, 'E', 'SERVICES EXTERIEURS A', '17Z913376                                         ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '62', 0, NULL, 0),
(7476, 2017, 20174201100, 'Investissement', 'Projet RAG', 57752291, 142247709, 142247709, 142247709, 142247709, 142247709, 200000000, '2017/ANINF/00553', 804916, '2017-09-06 00:00:00', '2017-09-08 00:00:00', 804916, '2017-08-30', '2017-11-28', 'Août', 804916, 0, 'Frais de transport de la délégation à Port Gentil pour la préparation du RAG                                                                                                                                                                                   ', 'NATIONALE REGIONALE TRANSPORT', 784655, 'N', 'CHARGES IMMOBILISEES', 'M1288/08/17                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '20', 0, NULL, 0),
(7477, 2017, 20174213200, 'Fonctionnement', 'Logiciel des fréquences', 51470100, 8529900, 8529900, 8529900, 8529900, 8529900, 60000000, '2017/ANINF/00555', 1403400, '2017-09-06 00:00:00', '2017-10-12 00:00:00', 1403400, '2017-08-31', '2017-11-29', 'Août', 1403400, 0, 'Frais de transport de Mr GUIMBINA NGOUESSI Robert Serge et de Mr MFOMO MBADINGA Armand Ossey pour  la mission UAT                                                                                                                                              ', 'AIR COTE D IVOIRE', 732962, 'F', 'IMMOBILISATIONS INCORPORELLES', '300817/0001                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '21', 0, NULL, 0),
(7478, 2017, 20172602100, 'Fonctionnement', 'Achats de papier d\'impression', 174823, 34825177, 34825177, 34825177, 34825177, 34825177, 35000000, '2017/ANINF/00558', 936892, NULL, '2017-12-22 00:00:00', 936892, '2017-09-08', '2017-12-07', 'Septembre', 936892, 0, 'Achat de toner laser noir cyan magenta et jaune                                                                                                                                                                                                                ', 'GABON MECA', 790131, 'L', 'ACHAT ET VARIATIONS DE STOCKS', 'DC273503                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '60', 0, NULL, 0),
(7479, 2017, 20172602100, 'Fonctionnement', 'Achats de papier d\'impression', 174823, 34825177, 34825177, 34825177, 34825177, 34825177, 35000000, '2017/ANINF/00559', 524160, '2017-09-12 00:00:00', '2017-09-08 00:00:00', 524160, '2017-09-08', '2017-12-07', 'Septembre', 524160, 0, 'Achat de Toner noir  cyan jaune magenta laser                                                                                                                                                                                                                  ', 'BS GABON', 2840078, 'B', 'ACHAT ET VARIATIONS DE STOCKS', 'DIO272366                                         ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '60', 0, NULL, 0),
(7480, 2017, 20172604500, 'Fonctionnement', 'Consommables informatiques', 3439906, 21560094, 21560094, 21560094, 21560094, 21560094, 25000000, '2017/ANINF/00560', 3265055, '2017-09-12 00:00:00', '2017-12-22 00:00:00', 3265055, '2017-09-08', '2017-12-07', 'Septembre', 3265055, 0, 'Achat encre Canon et pochette Kraft                                                                                                                                                                                                                            ', 'GABON MECA', 790131, 'L', 'ACHAT ET VARIATIONS DE STOCKS', 'DC268022                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '60', 0, NULL, 0),
(7481, 2017, 20172604500, 'Fonctionnement', 'Consommables informatiques', 3439906, 21560094, 21560094, 21560094, 21560094, 21560094, 25000000, '2017/ANINF/00561', 4984071, '2017-09-12 00:00:00', NULL, 0, '2017-09-08', '2017-12-07', 'Septembre', 4984071, 0, 'Achat de cartouches couleurs et Toner laser de noir cyan magenta et jaune                                                                                                                                                                                      ', 'GABON MECA', 790131, 'L', 'ACHAT ET VARIATIONS DE STOCKS', 'DC268019                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '60', 0, NULL, 0),
(7482, 2017, 20172604500, 'Fonctionnement', 'Consommables informatiques', 3439906, 21560094, 21560094, 21560094, 21560094, 21560094, 25000000, '2017/ANINF/00563', 5009985, '2017-09-12 00:00:00', '2017-12-22 00:00:00', 5009985, '2017-09-08', '2017-12-07', 'Septembre', 5009985, 0, 'Achat de consommable informatique                                                                                                                                                                                                                              ', 'GABON MECA', 790131, 'L', 'ACHAT ET VARIATIONS DE STOCKS', 'DC268017                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '60', 0, NULL, 0),
(7483, 2017, 20172604500, 'Fonctionnement', 'Consommables informatiques', 3439906, 21560094, 21560094, 21560094, 21560094, 21560094, 25000000, '2017/ANINF/00564', 5073533, '2017-09-12 00:00:00', '2017-12-22 00:00:00', 5073533, '2017-09-08', '2017-12-07', 'Septembre', 5073533, 0, 'Achat de consommables informatiques Toner  laser et Canon                                                                                                                                                                                                      ', 'GABON MECA', 790131, 'L', 'ACHAT ET VARIATIONS DE STOCKS', 'DC268020                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '60', 0, NULL, 0),
(7484, 2017, 20172604500, 'Fonctionnement', 'Consommables informatiques', 3439906, 21560094, 21560094, 21560094, 21560094, 21560094, 25000000, '2017/ANINF/00565', 913455, '2017-09-12 00:00:00', '2017-10-12 00:00:00', 913455, '2017-09-08', '2017-12-07', 'Septembre', 913455, 0, 'Achat de cartouches canon et Toner laser encres jet                                                                                                                                                                                                            ', 'GABON MECA', 790131, 'L', 'ACHAT ET VARIATIONS DE STOCKS', 'DC273603                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '60', 0, NULL, 0),
(7485, 2017, 20172604500, 'Fonctionnement', 'Consommables informatiques', 3439906, 21560094, 21560094, 21560094, 21560094, 21560094, 25000000, '2017/ANINF/00566', 838190, '2017-09-12 00:00:00', '2017-09-08 00:00:00', 838190, '2017-09-08', '2017-12-07', 'Septembre', 838190, 0, 'Achat de consommables informatiques                                                                                                                                                                                                                            ', 'GABON MECA', 790131, 'L', 'ACHAT ET VARIATIONS DE STOCKS', 'DC267511                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '60', 0, NULL, 0),
(7486, 2017, 20172614100, 'Fonctionnement', 'Transport du personnel à l\'intérieur', 4443602, 5556398, 5556398, 5556398, 5556398, 5556398, 10000000, '2017/ANINF/00567', 3996400, NULL, '2017-10-12 00:00:00', 3996400, '2017-09-11', '2017-12-10', 'Septembre', 3996400, 0, 'Frais de transport BONGO ONDIMBA ALex                                                                                                                                                                                                                          ', 'ESPACE VOYAGE TOURISME', 89533, 'Y', 'TRANSPORT ET MISSION', 'PF17903                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '61', 0, NULL, 0),
(7487, 2017, 20174201400, 'Investissement', 'Projet Datacenter', 45975121, 54024879, 54024879, 54024879, 54024879, 54024879, 100000000, '2017/ANINF/00570', 290932, NULL, '2017-10-12 00:00:00', 290932, '2017-09-13', '2017-12-12', 'Septembre', 290932, 0, 'Acquisition Batteries pour le Groupe électrogène du Datacenter                                                                                                                                                                                                 ', 'PIECES EQUIP\'AUTO', 903700, 'P', 'CHARGES IMMOBILISEES', '072                                               ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '20', 0, NULL, 0),
(7488, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 424321435, 225678565, 225678565, 225678565, 225678565, 225678565, 650000000, '2017/ANINF/00571', 7130000, NULL, '2017-12-14 00:00:00', 7130000, '2017-09-14', '2017-12-13', 'Septembre', 7130000, 0, 'Loyer Entrepot  OWENDO  du mois de juillet 2017                                                                                                                                                                                                                ', 'SCI KAM', 88557, 'A', 'SERVICES EXTERIEURS A', '1820/17                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '62', 0, NULL, 0),
(7489, 2017, 20174202800, 'Investissement', 'Backbone National', 56047790, 43952210, 43952210, 43952210, 43952210, 43952210, 100000000, '2017/ANINF/00585', 4722891, NULL, '2017-10-12 00:00:00', 4722891, '2017-09-15', '2017-12-14', 'Septembre', 4722891, 0, 'Services Internet pour le mois de juillet 2017                                                                                                                                                                                                                 ', 'ORANGE', 30852, 'M', 'CHARGES IMMOBILISEES', '5210323246                                        ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '20', 0, NULL, 0),
(7490, 2017, 20174202800, 'Investissement', 'Backbone National', 56047790, 43952210, 43952210, 43952210, 43952210, 43952210, 100000000, '2017/ANINF/00586', 4722891, NULL, '2017-12-14 00:00:00', 4722891, '2017-09-15', '2017-12-14', 'Septembre', 4722891, 0, 'Services Internet , aout 2017                                                                                                                                                                                                                                  ', 'ORANGE', 30852, 'M', 'CHARGES IMMOBILISEES', '5210325339                                        ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '20', 0, NULL, 0),
(7491, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 365781435, 284218565, 284218565, 284218565, 284218565, 284218565, 650000000, '2017/ANINF/00587', 7130000, NULL, '2017-12-14 00:00:00', 7130000, '2017-09-15', '2017-12-14', 'Septembre', 7130000, 0, 'Loyer du mois d\'Aout 2017 , entrepot Owendo                                                                                                                                                                                                                    ', 'SCI KAM', 88557, 'A', 'SERVICES EXTERIEURS A', '1821/17                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '62', 0, NULL, 0),
(7492, 2017, 20174203900, 'Investissement', 'Autres Projets', 149652, 100884103, 100884103, 100884103, 99834103, 100884103, 101033755, '2017/ANINF/00588', 878000, NULL, '2017-11-22 00:00:00', 878000, '2017-09-15', '2017-12-14', 'Septembre', 878000, 0, 'Penalité pour  Règlement  en retard d\'une facture de redevence pour le droit d\'exploitation de ressources  d internet                                                                                                                                          ', 'AFRINIC', 993600, 'M', 'CHARGES IMMOBILISEES', 'AF011945                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '20', 0, NULL, 0),
(7493, 2017, 20172604700, 'Fonctionnement', 'Imprimés et fournitures de bureau', 14992480, 5007520, 5007520, 5007520, 5007520, 5007520, 20000000, '2017/ANINF/00589', 1795710, NULL, '2017-11-22 00:00:00', 1795710, '2017-09-15', '2017-12-14', 'Septembre', 1795710, 0, 'Instruments de reglement site Fins                                                                                                                                                                                                                             ', 'MULTIPRESS GABON', 790848, 'F', 'ACHAT ET VARIATIONS DE STOCKS', '1750039                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '60', 0, NULL, 0),
(7494, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 71088736, 28911264, 28911264, 28911264, 28911264, 28911264, 100000000, '2017/ANINF/00590', 1339940, NULL, NULL, 0, '2017-09-20', '2017-12-19', 'Septembre', 1339940, 0, 'Dépannage des groupes condenseurs , reparation  des Fuites de Gaz et entretien des centrales                                                                                                                                                                   ', 'SOGAFRIC SERVICES', 791871, 'W', 'SERVICES EXTERIEURS A', '17-PC-0106-13-09-ASH                              ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '62', 0, NULL, 0),
(7495, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 365781435, 284218565, 284218565, 284218565, 284218565, 284218565, 650000000, '2017/ANINF/00593', 25500000, NULL, '2017-12-14 00:00:00', 25500000, '2017-10-04', '2018-01-02', 'Octobre', 25500000, 0, 'Loyer 3eme immeuble  DERA Haut de gue gue                                                                                                                                                                                                                      ', 'GUNTHER ENTREPRISE CONSTRUCTION', 79521, 'G', 'SERVICES EXTERIEURS A', '003 Juill/GTR/17                                  ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '62', 0, NULL, 0),
(7496, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 365781435, 284218565, 284218565, 284218565, 284218565, 284218565, 650000000, '2017/ANINF/00596', 14260000, NULL, '2017-12-14 00:00:00', 14260000, '2017-10-04', '2018-01-02', 'Octobre', 14260000, 0, 'Location entrepot du mois de fevrier 2017                                                                                                                                                                                                                      ', 'SCI KAM', 88557, 'A', 'SERVICES EXTERIEURS A', '1118/17                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '62', 0, NULL, 0),
(7497, 2017, 20172627100, 'Fonctionnement', 'Annonces, insertions', 7000000, 3000000, 3000000, 3000000, 3000000, 3000000, 10000000, '2017/ANINF/00597', 3000000, NULL, NULL, 0, '2017-10-04', '2018-01-02', 'Octobre', 3000000, 0, 'Insertion  communique                                                                                                                                                                                                                                          ', 'SONAPRESSE', 790891, 'X', 'SERVICES EXTERIEURS A', 'SC/PAN/20/07/2017                                 ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '62', 0, NULL, 0),
(7498, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 365781435, 284218565, 284218565, 284218565, 284218565, 284218565, 650000000, '2017/ANINF/00598', 10000000, NULL, '2017-10-12 00:00:00', 10000000, '2017-10-05', '2018-01-03', 'Octobre', 10000000, 0, 'Loyer immeuble DERA septembre 2017                                                                                                                                                                                                                             ', 'GUNTHER ENTREPRISE CONSTRUCTION', 79521, 'G', 'SERVICES EXTERIEURS A', '005/GTR 09-2017                                   ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '62', 0, NULL, 0),
(7499, 2017, 20172604700, 'Fonctionnement', 'Imprimés et fournitures de bureau', 14992480, 5007520, 5007520, 5007520, 5007520, 5007520, 20000000, '2017/ANINF/00599', 3211810, NULL, '2017-10-12 00:00:00', 3211810, '2017-10-05', '2018-01-03', 'Octobre', 3211810, 0, 'Instruments de règlement pour site Fins                                                                                                                                                                                                                        ', 'MULTIPRESS GABON', 790848, 'F', 'ACHAT ET VARIATIONS DE STOCKS', '1750047                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '60', 0, NULL, 0),
(7500, 2017, 20172658200, 'Fonctionnement', 'Caisses de menues dépenses', 2736126, 7263874, 7263874, 7263874, 7263874, 7263874, 10000000, '2017/ANINF/00602', 4000000, NULL, '2017-10-12 00:00:00', 4000000, '2017-10-06', '2018-01-04', 'Octobre', 4000000, 0, 'Prestation medicale du mois de mai 2017                                                                                                                                                                                                                        ', 'SANTE PLUS', 36701, 'M', 'AUTRES CHARGES', '012                                               ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:51', '2020-06-29 02:46:51', '65', 0, NULL, 0),
(7501, 2017, 20174213200, 'Investissement', 'Logiciel des fréquences', 40198945, 19801055, 19801055, 19801055, 19801055, 19801055, 60000000, '2017/ANINF/00603', 5000000, NULL, '2017-11-22 00:00:00', 5000000, '2017-10-06', '2018-01-04', 'Octobre', 5000000, 0, 'Paiement des Honoraires se Maitre ONDO Alicia Lidwine ACOMPTE (1/2)                                                                                                                                                                                            ', 'ONDO ALICIA LIDWINE', 334750, 'R', 'IMMOBILISATIONS INCORPORELLES', '2A/55/14/ANINF                                    ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '21', 0, NULL, 0),
(7502, 2017, 20174213200, 'Investissement', 'Logiciel des fréquences', 40198945, 19801055, 19801055, 19801055, 19801055, 19801055, 60000000, '2017/ANINF/00604', 5000000, NULL, '2017-11-22 00:00:00', 5000000, '2017-10-06', '2018-01-04', 'Octobre', 5000000, 0, 'Honoraires de diligence acompte (2/2)                                                                                                                                                                                                                          ', 'ONDO ALICIA LIDWINE', 334750, 'R', 'IMMOBILISATIONS INCORPORELLES', '2A/55/14/ANINF                                    ', NULL, 'r', 'Réengagement OP: 2017/ANINF/00603, Exerice: 2017', NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '13', 0, NULL, 0),
(7503, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 365781435, 284218565, 284218565, 284218565, 284218565, 284218565, 650000000, '2017/ANINF/00605', 1650000, NULL, NULL, 0, '2017-10-09', '2018-01-07', 'Octobre', 1650000, 0, 'Loyer  Immeuble R+2 pour la période du 01/01/2017 au 31/03/2017                                                                                                                                                                                                ', 'AGENCE IMMOBILIERE DE LIBREVILLE', 795119, 'F', 'SERVICES EXTERIEURS A', '01.04.2017                                        ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '62', 0, NULL, 0),
(7504, 2017, 20174241600, 'Investissement', 'Materiels divers', 12646986, 19353014, 19353014, 19353014, 19353014, 19353014, 32000000, '2017/ANINF/00625', 160650, NULL, NULL, 0, '2017-10-17', '2018-01-15', 'Octobre', 160650, 0, 'Eclairage                                                                                                                                                                                                                                                      ', 'MATELEC', 90047, 'F', 'MATERIEL', '1028104:28;12                                     ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '24', 0, NULL, 0),
(7505, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 65352636, 34647364, 34647364, 34647364, 34647364, 34647364, 100000000, '2017/ANINF/00626', 156950, NULL, NULL, 0, '2017-10-17', '2018-01-15', 'Octobre', 156950, 0, 'Achat d\'une batterie                                                                                                                                                                                                                                           ', 'PIECES EQUIP\'AUTO', 903700, 'P', 'SERVICES EXTERIEURS A', '668003                                            ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '62', 0, NULL, 0),
(7506, 2017, 20174201100, 'Investissement', 'Projet RAG', 57748769, 142251231, 142251231, 142251231, 142251231, 142251231, 200000000, '2017/ANINF/00627', 3522, NULL, NULL, 0, '2017-10-17', '2018-01-15', 'Octobre', 3522, 0, 'Consommation d\'eau pour la période du 24/07/2017 au 24/08/2017                                                                                                                                                                                                 ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '33440722678                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '20', 0, NULL, 0),
(7507, 2017, 20172627100, 'Fonctionnement', 'Annonces, insertions', 6000000, 4000000, 4000000, 4000000, 4000000, 4000000, 10000000, '2017/ANINF/00628', 1000000, NULL, NULL, 0, '2017-10-17', '2018-01-15', 'Octobre', 1000000, 0, 'Insertion communiqué                                                                                                                                                                                                                                           ', 'SONAPRESSE', 790891, 'X', 'SERVICES EXTERIEURS A', 'LC/30/17                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '62', 0, NULL, 0),
(7508, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 65352636, 34647364, 34647364, 34647364, 34647364, 34647364, 100000000, '2017/ANINF/00629', 400800, NULL, NULL, 0, '2017-10-18', '2018-01-16', 'Octobre', 400800, 0, 'Travaux d\'\' entretien batiment                                                                                                                                                                                                                                 ', 'ENTREPRISE GABONAISE DE CONSTRUCTION ET PEINTURE', 270050, 'Y', 'SERVICES EXTERIEURS A', '018/EGCP/2017                                     ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '62', 0, NULL, 0),
(7509, 2017, 20172604200, 'Investissement', 'Matières combustibles (carburants et lubrifiants)', 30007100, 15000000, 15000000, 15000000, 15000000, 15000000, 45007100, '2017/ANINF/00630', 2500000, NULL, '2017-11-22 00:00:00', 2500000, '2017-10-18', '2018-01-16', 'Octobre', 2500000, 0, 'Carburant pour les véhicules                                                                                                                                                                                                                                   ', 'PETRO GABON', 780697, 'E', 'ACHAT ET VARIATIONS DE STOCKS', 'csc06/10/2017c                                    ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '60', 0, NULL, 0),
(7510, 2017, 20174213200, 'Investissement', 'Logiciel des fréquences', 32098945, 27901055, 27901055, 27901055, 27901055, 27901055, 60000000, '2017/ANINF/00631', 4200000, NULL, '2017-12-14 00:00:00', 4200000, '2017-10-18', '2018-01-16', 'Octobre', 4200000, 0, 'Retransmission satellite  Tournoi de football Inter arrondissement                                                                                                                                                                                             ', 'IN OUT TECHNOLOGY', 319725, 'K', 'IMMOBILISATIONS INCORPORELLES', '020/1/UL/TX                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '21', 0, NULL, 0),
(7511, 2017, 20174213200, 'Investissement', 'Logiciel des fréquences', 32098945, 27901055, 27901055, 27901055, 27901055, 27901055, 60000000, '2017/ANINF/00634', 3900000, NULL, '2017-12-14 00:00:00', 3900000, '2017-10-20', '2018-01-18', 'Octobre', 3900000, 0, 'Retransmission satellite tournoi de football Inter arrondissement                                                                                                                                                                                              ', 'IN OUT TECHNOLOGY', 319725, 'K', 'IMMOBILISATIONS INCORPORELLES', '021/1/UL/TX                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '21', 0, NULL, 0),
(7512, 2017, 20172604200, 'Fonctionnement', 'Matières combustibles (carburants et lubrifiants)', 30007100, 15000000, 15000000, 15000000, 15000000, 15000000, 45007100, '2017/ANINF/00635', 2500000, NULL, NULL, 0, '2017-10-20', '2018-01-18', 'Octobre', 2500000, 0, 'Commande de carburant                                                                                                                                                                                                                                          ', 'PETRO GABON', 780697, 'E', 'ACHAT ET VARIATIONS DE STOCKS', 'csc06/10/2017B                                    ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '60', 0, NULL, 0),
(7513, 2017, 20172637100, 'Fonctionnement', 'Frais de gardiennage, surveillance', 75334000, 24666000, 24666000, 24666000, 24666000, 24666000, 100000000, '2017/ANINF/00636', 6166000, NULL, NULL, 0, '2017-10-20', '2018-01-18', 'Octobre', 6166000, 0, 'Prestation de nettoyage  de dite et gardiennage mois de fevrier ( acompte 1)                                                                                                                                                                                   ', 'GOLD SÉCURITÉ GABON', 271062, 'A', 'SERVICES EXTERIEURS B', '0006/BPMO/RM/2016                                 ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '63', 0, NULL, 0),
(7514, 2017, 20174201400, 'Investissement', 'Projet Datacenter', 9711698, 90288302, 90288302, 90288302, 90288302, 90288302, 100000000, '2017/ANINF/00637', 36263423, NULL, '2017-10-12 00:00:00', 36263423, '2017-10-20', '2018-01-18', 'Octobre', 36263423, 0, 'Achat de 2 Imprimantes de production Printronix                                                                                                                                                                                                                ', 'BULL GABON', 791223, 'M', 'CHARGES IMMOBILISEES', 'FN/2017/16/10/01                                  ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '20', 0, NULL, 0),
(7515, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 65352636, 34647364, 34647364, 34647364, 34647364, 34647364, 100000000, '2017/ANINF/00638', 4000000, NULL, '2017-11-22 00:00:00', 4000000, '2017-10-20', '2018-01-18', 'Octobre', 4000000, 0, 'Prestation medicale du mois de juillet 2017                                                                                                                                                                                                                    ', 'SANTE PLUS', 36701, 'M', 'SERVICES EXTERIEURS A', '14                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '62', 0, NULL, 0),
(7516, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 65352636, 34647364, 34647364, 34647364, 34647364, 34647364, 100000000, '2017/ANINF/00639', 1178350, NULL, NULL, 0, '2017-10-20', '2018-01-18', 'Octobre', 1178350, 0, 'Réparation Véhicule , Pick up Toyota Hilux 006 AA                                                                                                                                                                                                              ', 'GARAGE MOTORS', 270029, 'F', 'SERVICES EXTERIEURS A', '00372/2017                                        ', NULL, 'r', 'Réengagement OP: 2017/ANINF/00470, Exerice: 2017', NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '24', 0, NULL, 0),
(7517, 2017, 20172604500, 'Fonctionnement', 'Consommables informatiques', 123111, 24876889, 24876889, 24876889, 24876889, 24876889, 25000000, '2017/ANINF/00645', 958193, NULL, '2017-12-14 00:00:00', 958193, '2017-11-03', '2018-02-01', 'Novembre', 958193, 0, 'Consommables informatiques pour imprimantes                                                                                                                                                                                                                    ', 'GABON MECA', 790131, 'L', 'ACHAT ET VARIATIONS DE STOCKS', 'DC279922                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '60', 0, NULL, 0),
(7518, 2017, 20172604500, 'Fonctionnement', 'Consommables informatiques', 123111, 24876889, 24876889, 24876889, 24876889, 24876889, 25000000, '2017/ANINF/00646', 269166, NULL, '2017-12-22 00:00:00', 269166, '2017-11-03', '2018-02-01', 'Novembre', 269166, 0, 'Papier copieur                                                                                                                                                                                                                                                 ', 'GABON MECA', 790131, 'L', 'ACHAT ET VARIATIONS DE STOCKS', 'DC280066                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '60', 0, NULL, 0),
(7519, 2017, 20172604500, 'Fonctionnement', 'Consommables informatiques', 123111, 24876889, 24876889, 24876889, 24876889, 24876889, 25000000, '2017/ANINF/00647', 405627, NULL, NULL, 0, '2017-11-03', '2018-02-01', 'Novembre', 405627, 0, 'Achat de Cartouches d\' encre HP                                                                                                                                                                                                                                ', 'COMMUNICATION INGÉNIERIE SYSTÈMES', 796710, 'T', 'ACHAT ET VARIATIONS DE STOCKS', 'DCL89871                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '60', 0, NULL, 0),
(7520, 2017, 20172604500, 'Fonctionnement', 'Consommables informatiques', 123111, 24876889, 24876889, 24876889, 24876889, 24876889, 25000000, '2017/ANINF/00648', 882678, NULL, NULL, 0, '2017-11-03', '2018-02-01', 'Novembre', 882678, 0, 'Achat de cartouche encre TONER SHARP                                                                                                                                                                                                                           ', 'CFAO TECHNOLOGIES', 782094, 'R', 'ACHAT ET VARIATIONS DE STOCKS', '005/10/2017                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '60', 0, NULL, 0),
(7521, 2017, 20172604700, 'Fonctionnement', 'Imprimés et fournitures de bureau', 4057570, 15942430, 15942430, 15942430, 15942430, 15942430, 20000000, '2017/ANINF/00667', 1299480, NULL, NULL, 0, '2017-11-22', '2018-02-20', 'Novembre', 1299480, 0, 'Instruments de règlement site FINS                                                                                                                                                                                                                             ', 'MULTIPRESS GABON', 790848, 'F', 'ACHAT ET VARIATIONS DE STOCKS', '1750072                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '60', 0, NULL, 0),
(7522, 2017, 20172604700, 'Fonctionnement', 'Imprimés et fournitures de bureau', 4057570, 15942430, 15942430, 15942430, 15942430, 15942430, 20000000, '2017/ANINF/00668', 3891300, NULL, NULL, 0, '2017-11-22', '2018-02-20', 'Novembre', 3891300, 0, 'Instruments de règlement de site fins                                                                                                                                                                                                                          ', 'MULTIPRESS GABON', 790848, 'F', 'ACHAT ET VARIATIONS DE STOCKS', '1750076                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '60', 0, NULL, 0),
(7523, 2017, 20172604500, 'Fonctionnement', 'Consommables informatiques', 123111, 24876889, 24876889, 24876889, 24876889, 24876889, 25000000, '2017/ANINF/00669', 468446, NULL, '2017-12-22 00:00:00', 468446, '2017-11-22', '2018-02-20', 'Novembre', 468446, 0, 'Encres pour imprimantes                                                                                                                                                                                                                                        ', 'GABON MECA', 790131, 'L', 'ACHAT ET VARIATIONS DE STOCKS', 'DC283598                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:52', '2020-06-29 02:46:52', '60', 0, NULL, 0);
INSERT INTO `engagements` (`id`, `d_exerci`, `c_dest`, `nat_dep`, `l_dep`, `m_dispo`, `m_toteng`, `m_tengvi`, `m_totliq`, `m_tordvi`, `m_totord`, `m_dotini`, `n_engage`, `m_engage`, `date_depot_ac`, `date_paiement`, `m_paye`, `d_engage`, `date_echeance`, `mois_`, `m_tliqenga`, `m_non_paye`, `l_depeng`, `l_nmtir`, `n_mattir`, `c_mattir`, `l_chap`, `n_devis`, `nip`, `r_engage`, `desc_r_engage`, `v_m_paye`, `is_paid`, `created_at`, `updated_at`, `chap`, `realized`, `commentaire`, `cancelled`) VALUES
(7524, 2017, 20174243000, 'Investissement', 'Matériel informatique', 68814500, 1185500, 1185500, 1185500, 1185500, 1185500, 70000000, '2017/ANINF/00671', 188000, NULL, NULL, 0, '2017-11-22', '2018-02-20', 'Novembre', 188000, 0, 'Fourniture Informatique                                                                                                                                                                                                                                        ', 'GET SERVICES', 86474, 'R', 'MATERIEL', '71/2017                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:53', '2020-06-29 04:54:31', '24', 1, 'Mise a jour statut', 1),
(7525, 2017, 20174213200, 'Investissement', 'Logiciel des fréquences', 19517945, 40482055, 40482055, 40482055, 40482055, 40482055, 60000000, '2017/ANINF/00673', 4496400, NULL, NULL, 0, '2017-11-27', '2018-02-25', 'Novembre', 4496400, 0, 'Frais de transport de Benjamin NDZANDOU, et ELANGMANE Jean-Clotaire à Genève                                                                                                                                                                                   ', 'CHICA VOYAGES', 84947, 'R', 'IMMOBILISATIONS INCORPORELLES', '705                                               ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:53', '2020-06-29 02:46:53', '21', 0, NULL, 0),
(7526, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 354131435, 295868565, 295868565, 295868565, 295868565, 295868565, 650000000, '2017/ANINF/00676', 1650000, NULL, '2017-12-22 00:00:00', 1650000, '2017-11-27', '2018-02-25', 'Novembre', 1650000, 0, 'Loyer du 3ème trimestre 2017 immeuble  R+2 Carrefour  LEON MBA                                                                                                                                                                                                 ', 'AGENCE IMMOBILIERE DE LIBREVILLE', 795119, 'F', 'SERVICES EXTERIEURS A', '0625                                              ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:53', '2020-06-29 02:46:53', '62', 0, NULL, 0),
(7527, 2017, 20172624900, 'Fonctionnement', 'Autres entretiens et réparations', 65274338, 34725662, 34725662, 34725662, 34725662, 34725662, 100000000, '2017/ANINF/00677', 78298, NULL, NULL, 0, '2017-11-27', '2018-02-25', 'Novembre', 78298, 0, 'Achat de Batterie                                                                                                                                                                                                                                              ', 'PIECES EQUIP\'AUTO', 903700, 'P', 'SERVICES EXTERIEURS A', '086                                               ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:53', '2020-06-29 02:46:53', '62', 0, NULL, 0),
(7528, 2017, 20172622900, 'Fonctionnement', 'Location et charges locatives diverses', 354131435, 295868565, 295868565, 295868565, 295868565, 295868565, 650000000, '2017/ANINF/00678', 10000000, NULL, '2017-12-14 00:00:00', 10000000, '2017-11-27', '2018-02-25', 'Novembre', 10000000, 0, 'Location Immeuble  DERA ( Haut de Gué Gué) pour le mois d\'octobre 2017                                                                                                                                                                                         ', 'GUNTHER ENTREPRISE CONSTRUCTION', 79521, 'G', 'SERVICES EXTERIEURS A', '006/GTR 10-2017                                   ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:53', '2020-06-29 02:46:53', '62', 0, NULL, 0),
(7529, 2017, 20174201100, 'Investissement', 'Projet RAG', 57692212, 142307788, 142307788, 142307788, 142307788, 142307788, 200000000, '2017/ANINF/00679', 56557, NULL, '2017-12-22 00:00:00', 56557, '2017-11-27', '2018-02-25', 'Novembre', 56557, 0, 'Consommation d\' électricité pour la période du 22/08/17 au 28/08/17                                                                                                                                                                                            ', 'SEEG', 790326, 'D', 'CHARGES IMMOBILISEES', '734558059371                                      ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:53', '2020-06-29 02:46:53', '20', 0, NULL, 0),
(7530, 2017, 20172604700, 'Fonctionnement', 'Imprimés et fournitures de bureau', 4057570, 15942430, 15942430, 15942430, 15942430, 15942430, 20000000, '2017/ANINF/00684', 3580115, NULL, NULL, 0, '2017-12-11', '2018-03-11', 'Décembre', 3580115, 0, 'Instruments de Règlements pour site FINS                                                                                                                                                                                                                       ', 'MULTIPRESS GABON', 790848, 'F', 'ACHAT ET VARIATIONS DE STOCKS', '1750090                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:54', '2020-06-29 02:46:54', '60', 0, NULL, 0),
(7531, 2017, 20174213100, 'Investissement', 'Logiciels', 52902483, 37097517, 37097517, 37097517, 37097517, 37097517, 90000000, '2017/ANINF/00685', 4449606, NULL, '2017-12-22 00:00:00', 4449606, '2017-12-11', '2018-03-11', 'Décembre', 4449606, 0, 'Paiement de la Redevance pour les droits d\'exploitation Internet pour l\'année 2018                                                                                                                                                                             ', 'AFRINIC', 993600, 'M', 'IMMOBILISATIONS INCORPORELLES', 'AF013035                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:54', '2020-06-29 02:46:54', '21', 0, NULL, 0),
(7532, 2017, 20172633000, 'Fonctionnement', 'Frais de formation du personnel', 3026270, 16973730, 16973730, 16973730, 16973730, 16973730, 20000000, '2017/ANINF/00693', 4000000, NULL, '2017-12-14 00:00:00', 4000000, '2017-12-13', '2018-03-13', 'Décembre', 4000000, 0, 'Prestation Médicale du mois d\'aout 2017                                                                                                                                                                                                                        ', 'SANTE PLUS', 36701, 'M', 'SERVICES EXTERIEURS B', '15                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:54', '2020-06-29 02:46:54', '63', 0, NULL, 0),
(7533, 2017, 20172604700, 'Fonctionnement', 'Imprimés et fournitures de bureau', 4057570, 15942430, 15942430, 15942430, 15942430, 15942430, 20000000, '2017/ANINF/00707', 2164015, NULL, '2017-11-22 00:00:00', 2164015, '2017-12-18', '2018-03-18', 'Décembre', 2164015, 0, 'Instruments de reglements pou site fins                                                                                                                                                                                                                        ', 'MULTIPRESS GABON', 790848, 'F', 'ACHAT ET VARIATIONS DE STOCKS', '1710129                                           ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:54', '2020-06-29 02:46:54', '60', 0, NULL, 0),
(7534, 2017, 20174202800, 'Investissement', 'Backbone National', 53804416, 46195584, 46195584, 46195584, 46195584, 46195584, 100000000, '2017/ANINF/00713', 1121687, NULL, NULL, 0, '2017-12-26', '2018-03-26', 'Décembre', 1121687, 0, 'Internet Access pour le mois de mai 2017                                                                                                                                                                                                                       ', 'COGENT COMMUNICATIONS FRANCE', 43070, 'R', 'CHARGES IMMOBILISEES', 'SINVFR78881                                       ', NULL, 'r', 'Réengagement OP: 2017/ANINF/00541, Exerice: 2017', NULL, 0, '2020-06-29 02:46:54', '2020-06-29 02:46:54', '02', 0, NULL, 0),
(7535, 2017, 20174202800, 'Investissement', 'Backbone National', 53804416, 46195584, 46195584, 46195584, 46195584, 46195584, 100000000, '2017/ANINF/00714', 1121687, NULL, NULL, 0, '2017-12-26', '2018-03-26', 'Décembre', 1121687, 0, 'Internet Access du mois de septembre 2017                                                                                                                                                                                                                      ', 'COGENT COMMUNICATIONS FRANCE', 43070, 'R', 'CHARGES IMMOBILISEES', 'SINVFR81784                                       ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:54', '2020-06-29 05:11:14', '20', 0, NULL, 1),
(7536, 2017, 20172633000, 'Fonctionnement', 'Frais de formation du personnel', 3026270, 16973730, 16973730, 16973730, 16973730, 16973730, 20000000, '2017/ANINF/00715', 4000000, NULL, '2017-12-14 00:00:00', 4000000, '2017-12-26', '2018-03-26', 'Décembre', 4000000, 0, 'Prestation Médicale du mois de Juin 2017                                                                                                                                                                                                                       ', 'SANTE PLUS', 36701, 'M', 'SERVICES EXTERIEURS B', '13                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:54', '2020-06-29 02:46:54', '63', 0, NULL, 0),
(7537, 2017, 20174213900, 'Investissement', 'Certification ISO 9001', 50018700, 24981300, 24981300, 24981300, 24981300, 24981300, 75000000, '2017/ANINF/00723', 1961300, NULL, '2017-12-22 00:00:00', 1961300, '2017-12-28', '2018-03-28', 'Décembre', 1961300, 0, 'Titre de transport de M. Anicet NDJIYA KOUAMBA (LBV-PAR-LBV)                                                                                                                                                                                                   ', 'EURAFRIQUE - VOYAGES', 791219, 'L', 'IMMOBILISATIONS INCORPORELLES', '1667/2017                                         ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:54', '2020-06-29 02:46:54', '21', 0, NULL, 0),
(7538, 2017, 20174213200, 'Investissement', 'Logiciel des fréquences', 19517945, 40482055, 40482055, 40482055, 40482055, 40482055, 60000000, '2017/ANINF/00724', 1784600, NULL, '2017-12-14 00:00:00', 1784600, '2017-12-29', '2018-03-29', 'Décembre', 1784600, 0, 'Titres de transport de Messieurs Benjamin NDZANDOU et Clotaire ELANGMANE (LBV-PAR-GVA-PAR-LBV)                                                                                                                                                                 ', 'EURAFRIQUE - VOYAGES', 791219, 'L', 'IMMOBILISATIONS INCORPORELLES', '1535/2017                                         ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:54', '2020-06-29 02:46:54', '21', 0, NULL, 0),
(7539, 2017, 20172633000, 'Fonctionnement', 'Frais de formation du personnel', 3026270, 16973730, 16973730, 16973730, 16973730, 16973730, 20000000, '2017/ANINF/00726', 4000000, NULL, NULL, 0, '2017-12-29', '2018-03-29', 'Décembre', 4000000, 0, 'Prestation médicale et gestion de l\'infirmerie                                                                                                                                                                                                                 ', 'SANTE PLUS', 36701, 'M', 'SERVICES EXTERIEURS B', '17                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:54', '2020-06-29 02:46:54', '63', 0, NULL, 0),
(7540, 2017, 20172604300, 'Fonctionnement', 'Produits d\'entretien et de nettoyage', 1000000, 4000000, 4000000, 4000000, 4000000, 4000000, 5000000, '2017/ANINF/00728', 4000000, '2020-06-29 00:00:00', '2020-06-29 00:00:00', 4000000, '2017-12-29', '2018-03-29', 'Décembre', 4000000, 0, 'Prestation médicale et gestion de l\'infirmerie                                                                                                                                                                                                                 ', 'SANTE PLUS', 36701, 'M', 'ACHAT ET VARIATIONS DE STOCKS', '18                                                ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:55', '2020-06-29 05:08:14', '60', 1, 'Activité déjà achevée', 0),
(7541, 2017, 20174202900, 'Investissement', 'Projet Cyber Sécurité', 3550000, 46450000, 46450000, 46450000, 72050000, 46450000, 50000000, '2017/ANINF/00730', 5000000, NULL, '2017-12-22 00:00:00', 5000000, '2018-01-03', '2018-04-03', 'Janvier', 5000000, 0, 'Honoraires  Consultant                                                                                                                                                                                                                                         ', 'ONDO ALICIA LIDWINE', 334750, 'R', 'CHARGES IMMOBILISEES', '55/14                                             ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:55', '2020-06-29 02:46:55', '20', 0, NULL, 0),
(7542, 2017, 20172604500, 'Fonctionnement', 'Consommables informatiques', 123111, 24876889, 24876889, 24876889, 24876889, 24876889, 25000000, '2017/ANINF/00731', 332685, NULL, NULL, 332685, '2018-01-11', '2018-04-11', 'Janvier', 332685, 0, 'Achat de consommables (Encres)                                                                                                                                                                                                                                 ', 'GABON MECA', 790131, 'L', 'ACHAT ET VARIATIONS DE STOCKS', 'DC289890                                          ', NULL, NULL, NULL, NULL, 0, '2020-06-29 02:46:55', '2020-06-29 02:46:55', '60', 0, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fichiers`
--

CREATE TABLE `fichiers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(2, 'Chefs de Service Comptabilité', 'Groupe des utilisateurs ayant les droits de chef de service au service comptabilité', '2020-05-27 07:31:44', '2020-06-12 01:10:23', 1, 1),
(3, 'Administrateurs', 'groupe des utilisateurs qui ont tous les droits', '2020-05-27 08:05:12', '2020-05-27 08:05:12', 1, 1),
(4, 'Invite', 'Ne peut que consulter', '2020-06-12 01:07:12', '2020-06-12 01:07:12', 1, 1),
(5, 'Agent comptabilité', 'Tous les agents du service comptabilité', '2020-06-12 01:07:55', '2020-06-12 01:07:55', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `group_permission`
--

CREATE TABLE `group_permission` (
  `group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `permission_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `group_permission`
--

INSERT INTO `group_permission` (`group_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(3, 1, '2020-05-28 10:58:55', '2020-05-28 10:58:55'),
(3, 3, '2020-05-28 10:58:55', '2020-05-28 10:58:55'),
(3, 1, '2020-05-28 10:58:56', '2020-05-28 10:58:56'),
(3, 2, '2020-05-28 10:58:56', '2020-05-28 10:58:56'),
(3, 8, '2020-05-28 10:58:57', '2020-05-28 10:58:57'),
(3, 8, '2020-05-28 10:58:58', '2020-05-28 10:58:58'),
(3, 8, '2020-05-28 10:58:59', '2020-05-28 10:58:59'),
(3, 8, '2020-05-28 10:59:00', '2020-05-28 10:59:00'),
(3, 10, '2020-05-28 10:59:00', '2020-05-28 10:59:00'),
(3, 8, '2020-05-28 10:59:01', '2020-05-28 10:59:01'),
(3, 11, '2020-05-28 10:59:01', '2020-05-28 10:59:01'),
(3, 8, '2020-05-28 10:59:02', '2020-05-28 10:59:02'),
(3, 12, '2020-05-28 10:59:02', '2020-05-28 10:59:02'),
(3, 8, '2020-05-28 10:59:03', '2020-05-28 10:59:03'),
(3, 14, '2020-05-28 10:59:04', '2020-05-28 10:59:04'),
(3, 14, '2020-05-28 10:59:05', '2020-05-28 10:59:05'),
(3, 15, '2020-05-28 10:59:05', '2020-05-28 10:59:05'),
(5, 1, '2020-06-12 01:13:59', '2020-06-12 01:13:59'),
(5, 1, '2020-06-12 01:14:00', '2020-06-12 01:14:00'),
(5, 2, '2020-06-12 01:14:00', '2020-06-12 01:14:00'),
(5, 1, '2020-06-12 01:14:03', '2020-06-12 01:14:03'),
(5, 3, '2020-06-12 01:14:03', '2020-06-12 01:14:03'),
(5, 8, '2020-06-12 01:14:05', '2020-06-12 01:14:05'),
(5, 8, '2020-06-12 01:14:07', '2020-06-12 01:14:07'),
(5, 9, '2020-06-12 01:14:07', '2020-06-12 01:14:07'),
(5, 8, '2020-06-12 01:14:11', '2020-06-12 01:14:11'),
(5, 12, '2020-06-12 01:14:11', '2020-06-12 01:14:11'),
(5, 14, '2020-06-12 01:14:17', '2020-06-12 01:14:17'),
(5, 14, '2020-06-12 01:14:18', '2020-06-12 01:14:18'),
(5, 15, '2020-06-12 01:14:18', '2020-06-12 01:14:18'),
(2, 1, '2020-06-12 01:14:46', '2020-06-12 01:14:46'),
(2, 3, '2020-06-12 01:14:46', '2020-06-12 01:14:46'),
(2, 1, '2020-06-12 01:14:47', '2020-06-12 01:14:47'),
(2, 2, '2020-06-12 01:14:47', '2020-06-12 01:14:47'),
(2, 8, '2020-06-12 01:14:50', '2020-06-12 01:14:50'),
(2, 8, '2020-06-12 01:14:51', '2020-06-12 01:14:51'),
(2, 9, '2020-06-12 01:14:52', '2020-06-12 01:14:52'),
(2, 8, '2020-06-12 01:14:52', '2020-06-12 01:14:52'),
(2, 10, '2020-06-12 01:14:52', '2020-06-12 01:14:52'),
(2, 8, '2020-06-12 01:14:55', '2020-06-12 01:14:55'),
(2, 11, '2020-06-12 01:14:55', '2020-06-12 01:14:55'),
(2, 8, '2020-06-12 01:14:56', '2020-06-12 01:14:56'),
(2, 13, '2020-06-12 01:14:56', '2020-06-12 01:14:56'),
(2, 8, '2020-06-12 01:14:57', '2020-06-12 01:14:57'),
(2, 12, '2020-06-12 01:14:57', '2020-06-12 01:14:57'),
(2, 8, '2020-06-12 01:16:51', '2020-06-12 01:16:51'),
(2, 24, '2020-06-12 01:16:51', '2020-06-12 01:16:51'),
(2, 14, '2020-06-12 01:16:54', '2020-06-12 01:16:54'),
(2, 14, '2020-06-12 01:16:56', '2020-06-12 01:16:56'),
(2, 15, '2020-06-12 01:16:56', '2020-06-12 01:16:56'),
(3, 8, '2020-06-12 01:17:19', '2020-06-12 01:17:19'),
(4, 1, '2020-06-12 01:18:10', '2020-06-12 01:18:10'),
(4, 8, '2020-06-12 01:18:13', '2020-06-12 01:18:13'),
(4, 14, '2020-06-12 01:18:15', '2020-06-12 01:18:15'),
(4, 8, '2020-06-12 01:18:19', '2020-06-12 01:18:19'),
(4, 12, '2020-06-12 01:18:19', '2020-06-12 01:18:19'),
(4, 14, '2020-06-12 01:18:20', '2020-06-12 01:18:20'),
(4, 15, '2020-06-12 01:18:20', '2020-06-12 01:18:20'),
(4, 1, '2020-06-12 01:18:22', '2020-06-12 01:18:22'),
(4, 3, '2020-06-12 01:18:22', '2020-06-12 01:18:22'),
(3, 1, '2020-06-29 03:34:23', '2020-06-29 03:34:23'),
(3, 32, '2020-06-29 03:59:22', '2020-06-29 03:59:22'),
(3, 30, '2020-06-29 04:16:17', '2020-06-29 04:16:17'),
(3, 30, '2020-06-29 04:31:38', '2020-06-29 04:31:38'),
(3, 31, '2020-06-29 04:31:38', '2020-06-29 04:31:38'),
(3, 1, '2020-06-29 04:45:20', '2020-06-29 04:45:20'),
(3, 25, '2020-06-29 04:45:20', '2020-06-29 04:45:20'),
(3, 8, '2020-06-29 04:52:41', '2020-06-29 04:52:41'),
(3, 9, '2020-06-29 04:52:41', '2020-06-29 04:52:41'),
(3, 8, '2020-06-29 05:01:35', '2020-06-29 05:01:35'),
(3, 8, '2020-06-29 05:01:36', '2020-06-29 05:01:36'),
(3, 8, '2020-06-29 05:06:53', '2020-06-29 05:06:53'),
(3, 13, '2020-06-29 05:06:53', '2020-06-29 05:06:53'),
(3, 8, '2020-06-29 05:06:54', '2020-06-29 05:06:54'),
(3, 24, '2020-06-29 05:06:54', '2020-06-29 05:06:54'),
(3, 26, '2020-06-29 05:23:01', '2020-06-29 05:23:01'),
(3, 26, '2020-06-29 05:23:01', '2020-06-29 05:23:01'),
(3, 27, '2020-06-29 05:23:01', '2020-06-29 05:23:01'),
(3, 26, '2020-06-29 05:23:02', '2020-06-29 05:23:02'),
(3, 28, '2020-06-29 05:23:02', '2020-06-29 05:23:02'),
(3, 26, '2020-06-29 05:23:03', '2020-06-29 05:23:03'),
(3, 29, '2020-06-29 05:23:04', '2020-06-29 05:23:04'),
(3, 16, '2020-06-29 05:24:19', '2020-06-29 05:24:19'),
(3, 16, '2020-06-29 05:24:20', '2020-06-29 05:24:20'),
(3, 17, '2020-06-29 05:24:20', '2020-06-29 05:24:20'),
(3, 16, '2020-06-29 05:24:21', '2020-06-29 05:24:21'),
(3, 18, '2020-06-29 05:24:21', '2020-06-29 05:24:21'),
(3, 16, '2020-06-29 05:24:23', '2020-06-29 05:24:23'),
(3, 19, '2020-06-29 05:24:23', '2020-06-29 05:24:23'),
(3, 20, '2020-06-29 05:24:24', '2020-06-29 05:24:24'),
(3, 23, '2020-06-29 05:24:24', '2020-06-29 05:24:24'),
(3, 20, '2020-06-29 05:24:25', '2020-06-29 05:24:25'),
(3, 22, '2020-06-29 05:24:25', '2020-06-29 05:24:25'),
(3, 20, '2020-06-29 05:24:25', '2020-06-29 05:24:25'),
(3, 21, '2020-06-29 05:24:25', '2020-06-29 05:24:25');

-- --------------------------------------------------------

--
-- Structure de la table `historiques`
--

CREATE TABLE `historiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `historiques`
--

INSERT INTO `historiques` (`id`, `body`, `created_at`, `updated_at`) VALUES
(1, '{\"user\":\"ndong otogue yvon paul brice\",\"action\":\"Importations engagements\",\"filename\":\"2017-1593402415.xlsx\"}', '2020-06-29 02:46:56', '2020-06-29 02:46:56'),
(2, '{\"echelon_id\":74,\"user\":\"ndong otogue yvon paul brice\",\"action\":\"Ajouter un paiement\",\"engagement\":\"2017\\/ANINF\\/00728\",\"montant\":4000000}', '2020-06-29 04:55:44', '2020-06-29 04:55:44'),
(3, '{\"echelon_id\":74,\"user\":\"ndong otogue yvon paul brice\",\"action\":\"Valider paiement\",\"engagement\":\"2017\\/ANINF\\/00728\",\"montant\":4000000}', '2020-06-29 05:07:24', '2020-06-29 05:07:24'),
(4, '{\"echelon_id\":75,\"user\":\"ndong otogue yvon paul brice\",\"action\":\"Ajouter un paiement\",\"engagement\":\"2017\\/ANINF\\/00714\",\"montant\":1121687}', '2020-06-29 05:10:56', '2020-06-29 05:10:56'),
(5, '{\"echelon_id\":75,\"user\":\"ndong otogue yvon paul brice\",\"action\":\"Valider paiement\",\"engagement\":\"2017\\/ANINF\\/00714\",\"montant\":1121687}', '2020-06-29 05:11:02', '2020-06-29 05:11:02');

-- --------------------------------------------------------

--
-- Structure de la table `importations`
--

CREATE TABLE `importations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `importations`
--

INSERT INTO `importations` (`id`, `filename`, `created_at`, `updated_at`) VALUES
(12, '2017-1593402415.xlsx', '2020-06-29 02:46:57', '2020-06-29 02:46:57');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_11_25_172216_add_fields_to_users_table', 1),
(5, '2019_11_25_182037_create_departements_table', 2),
(6, '2019_11_25_184011_create_entreprises_table', 2),
(7, '2019_11_25_184301_add_entreprise_id_to_departements_table', 3),
(8, '2019_11_25_184530_add_foreign_key_entreprise_id_to_departements_table', 4),
(9, '2019_11_25_184836_add_nom_to_entreprises_table', 5),
(10, '2019_12_24_205613_create_customers_table', 6),
(11, '2019_12_24_211156_create_groups_table', 6),
(12, '2019_12_24_212450_add_foreign_keys_customer_group_to_users_table', 7),
(13, '2019_12_24_213827_add_fields_slug_to_groups_table', 8),
(14, '2019_12_24_215021_add_fields_user_id_to_customers_table', 9),
(15, '2019_12_24_220144_add_fields_phonenumber_to_users_table', 10),
(16, '2019_12_24_220352_add_fields_phonenumber_to_users_table_1', 11),
(17, '2019_12_24_223203_add_field_enable_to_users_table', 12),
(18, '2019_12_24_223443_add_field_status_to_users_table', 13),
(19, '2020_01_06_171317_create_roles_table', 14),
(20, '2020_01_06_172618_add_fields_name_slug_to_roles_table', 15),
(21, '2020_01_06_174055_add_foreign_key_customer_to_groups_table', 16),
(22, '2020_01_08_111407_add_field_customer_id_to_groups_table', 16),
(23, '2020_01_08_114953_add_field_api_token_to_users_table', 17),
(24, '2020_01_09_150255_add_forey_key_role_id_to_users_table', 18),
(25, '2020_01_11_200359_add_fields_website_to_customers_table', 19),
(26, '2020_01_11_205254_add_foreign_key_manager_id_to_customers_table', 20),
(27, '2020_01_11_210341_add_foreign_key_manager_id_to_customers_table', 21),
(28, '2020_01_12_114742_add_fields_country_city_activiy_to_customers_table', 22),
(29, '2020_01_13_080031_create_accounts_table', 23),
(30, '2020_01_15_123114_create_folders_table', 24),
(31, '2020_01_17_090410_create_folder_events_table', 25),
(32, '2020_01_17_113209_create_forms_table', 26),
(33, '2020_01_17_120227_add_foreign_key_forms_table', 27),
(34, '2020_01_26_124903_create_form_fields_table', 28),
(35, '2020_02_06_141450_create_engagements_table', 29),
(36, '2020_02_13_090152_add_fk_user_id_to_echelons_table', 30),
(37, '2020_02_25_101953_add_fk_id_engagement_to_echelons_table', 31),
(38, '2020_03_05_111552_create_fichiers_table', 32),
(39, '2020_03_25_130316_create_documents_table', 32),
(40, '2020_03_25_131839_create_pivot_table_document_echelon', 33),
(41, '2020_05_20_110157_create_groups_table', 34),
(42, '2020_05_20_110710_add_fk_created_by_to_groups_table', 35),
(43, '2020_05_20_110851_add_fk_updated__by_to_groups_table', 36),
(44, '2020_05_27_084431_add_fk_user_id_to_groups_table', 37),
(45, '2020_05_27_102614_create_modules_table', 38),
(46, '2020_05_27_103808_create_permissions_table', 39),
(47, '2020_05_27_112255_add_fk_group_id_to_users_table', 40),
(48, '2020_05_28_100624_create_group_permission_table', 41),
(49, '2020_06_08_151949_add_validated_field_to_echelons_table', 42),
(50, '2020_06_08_153033_create_historiques_table', 43),
(51, '2020_06_10_005025_create_importations_table', 44),
(52, '2020_06_15_071624_add_chap_field_to_engagements_table', 45),
(53, '2020_06_15_073038_add_chap_field_to_engagements_table', 46),
(54, '2020_06_15_075559_create_chapitres_table', 47),
(55, '2020_06_15_102837_add_realized_field_to_engagements_table', 48),
(56, '2020_06_15_111001_add_commentaire_field_to_engagements_table', 49),
(57, '2020_06_15_202902_create_bejcs_table', 50),
(58, '2020_06_16_041859_add_fk_user_id_to_bejcs_table', 51),
(59, '2020_06_16_050716_create_bejc_items_table', 52),
(60, '2020_06_16_052044_add_nature_field_to_bejcs_table', 53),
(61, '2020_06_26_133734_create_pivot_table_echelon_bejc', 54),
(62, '2020_06_28_061201_add_field_cancelled_to_engagements_table', 55);

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `modules`
--

INSERT INTO `modules` (`id`, `slug`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'engagements', 'Engagements', 'Gestion des engagements', NULL, NULL),
(2, 'paiements', 'Paiements', 'Gestion des paiements', NULL, NULL),
(3, 'fournisseurs', 'Fournisseurs', 'Gestion des fournisseurs', NULL, NULL),
(4, 'utilisateurs', 'Utilisateurs', 'Gestion des utilisateurs', NULL, NULL),
(5, 'groupes', 'Groupes', 'Gestion des groupes', NULL, NULL),
(6, 'chapitres', 'Chapitres', 'Gestion des chapitres', NULL, NULL),
(7, 'bejcs', 'Bordereau Journées Comptables', 'Gestion des bordereaux d\'envoi des journées comptables', NULL, NULL),
(8, 'statistiques', 'Statistiques', 'Tableau de bord strategique', NULL, NULL);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `nature_depenses`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `nature_depenses` (
`nat_dep` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `permissions`
--

INSERT INTO `permissions` (`id`, `module_id`, `slug`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'consulter', 'Consulter', 'Consulter', NULL, NULL),
(2, 1, 'importer', 'Importer', 'Importer', NULL, NULL),
(3, 1, 'exporter', 'Exporter/Imprimer', 'Exporter/Imprimer', NULL, NULL),
(8, 2, 'consulter', 'Consulter', 'Consulter', NULL, NULL),
(9, 2, 'ajouter', 'Ajouter', 'Ajouter', NULL, NULL),
(10, 2, 'modifier', 'Modifier', 'Modifier', NULL, NULL),
(11, 2, 'supprimer', 'Supprimer', 'Supprimer', NULL, NULL),
(12, 2, 'exporter', 'Exporter/Imprimer', 'Exporter/Imprimer', NULL, NULL),
(13, 2, 'valider', 'Valider', 'Valider', NULL, NULL),
(14, 3, 'consulter', 'Consulter', 'Consulter', NULL, NULL),
(15, 3, 'exporter', 'Exporter/Imprimer', 'Exporter/Imprimer', NULL, NULL),
(16, 4, 'consulter', 'Consulter', 'Consulter', NULL, NULL),
(17, 4, 'creer', 'Créer', 'Créer', NULL, NULL),
(18, 4, 'supprimer', 'Supprimer', 'Supprimer', NULL, NULL),
(19, 4, 'modifier', 'Modifier', 'Modifier', NULL, NULL),
(20, 5, 'consulter', 'Consulter', 'Consulter', NULL, NULL),
(21, 5, 'creer', 'Créer', 'Créer', NULL, NULL),
(22, 5, 'modifier', 'Modifier', 'Modifier', NULL, NULL),
(23, 5, 'supprimer', 'Supprimer', 'Supprimer', NULL, NULL),
(24, 2, 'annuler', 'Annuler', 'Annulation des paiements', '2020-06-11 23:00:00', '2020-06-11 23:00:00'),
(25, 1, 'modifier', 'Modifier', 'Modification, Validation...', NULL, NULL),
(26, 6, 'consulter', 'Consulter', 'Consulter', NULL, NULL),
(27, 6, 'creer', 'Créer', 'Créer', NULL, NULL),
(28, 6, 'modifier', 'Modifier', 'Modifier', NULL, NULL),
(29, 6, 'supprimer', 'Supprimer', 'Supprimer', NULL, NULL),
(30, 7, 'consulter', 'Consulter', 'Consulter', NULL, NULL),
(31, 7, 'éditer', 'Editer', 'Editer', NULL, NULL),
(32, 8, 'consulter', 'Consulter', 'Consulter les statistiques', NULL, NULL);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `providers`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `providers` (
`name` text
);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT 'manager',
  `name` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `api_token` varchar(80) DEFAULT NULL,
  `phonenumber` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `name`, `firstname`, `email`, `email_verified_at`, `status`, `api_token`, `phonenumber`, `remember_token`, `created_at`, `updated_at`, `group_id`) VALUES
(1, 'admin', '$2y$10$WqS6aBTLa8Lky4KaXBtFNeLSGK85AUakEuNbY5RDVgyM..yInc8EG', 'superadmin', 'ndong otogue', 'yvon paul brice', 'yvon.ndong@neosystechnologie.ga', NULL, 1, 'MM374gMYF0j8vOv1WCcDX72G5F71XWrsd39zsmXwgfekXR60DToIjR346CTeHJLug9XfVuGJvM12naIJ', NULL, 'anl6zOC9K8h7IXUjjOVRUsxATthgCA6wfrnaPwrn0PyPMr5mK38nrTXq9s0E', '2019-11-25 17:08:52', '2020-05-29 07:01:46', 3),
(21, 'beranger.nsa-oyono', '$2y$10$C8JRc4yAiCA7Qnwa9Jvf8e/71NM8tt2o2zVCnv28ilJeGE0eXZ.sK', 'admin', 'nsa oyono', 'beranger', 'beranger.nsa-oyono@aninf.ga', NULL, 1, 'pJOUufsHDPqeBfL9pihAPWres9ogDIunNRflb5RDvTg5oKS42tpQEs1Xj5ioaFMZQNx3k0gZSzrQQLrc', NULL, '59e6HKqL110yXBEnOKxpYxUQ7guvCdcf0tMnMBSx7mCHO3unq0Uu3jbfgOEy', '2020-02-06 07:53:28', '2020-06-12 01:11:15', 3),
(22, 'steave-gael.ivombo', '$2y$10$hnLe2M5cRRUdrz5XcaAnReSj0nQf1uuee2n97X/sGNZHKy59wcjpS', 'admin', 'ivombo', 'steave gael', 'steave.ivombo@aninf.ga', NULL, 1, 'X3VlFDiE6HmTHRhcRSxU4KaiDJmBdEWVPXawFnIb0IlGS7taX4y9aBgNoS2NGsi3tWn5lhO6vpO8V5S1', NULL, NULL, '2020-02-06 07:58:29', '2020-06-12 01:09:00', 3),
(23, 'yves-boris.indoumou', '$2y$10$fCOrw/iOUCzpTQIIIDjY6.BKOplW2kCJcaYIRFDlPZGLJqXLEoZkC', 'manager', 'INDOUMOU', 'Yves Boris', 'yves-boris.indoumou@aninf.ga', NULL, 1, 'Vs57R01XZjU9Bk20Kc2PwSH7pVsDvG95x9GRMufJ4z7VKpx6dvGx3m3KUBZcWU33NnXLmcItQVARc9lr', NULL, NULL, '2020-06-11 23:59:29', '2020-06-12 01:08:26', 4),
(24, 'mwande.nding', '$2y$10$Te4ePAAQhwKaiOQejNmwSerHJkbcOBN./WUtJqY71SBZveAo2GeUS', 'manager', 'NDING', 'MWANDE', 'mwande.nding@aninf.ga', NULL, 1, 'iVZnZGOriLGhWvoSFkjsJj8XhlOpyxYn2meRYE9Jenqn1X9c7btIso24AjQzTNi7XqaK2ZEtd7SDhp1X', NULL, NULL, '2020-06-12 00:02:11', '2020-06-12 00:02:11', 2),
(25, 'yvan-lionel.mapaga', '$2y$10$3ytPXOZ9sJdxXRqHbrGo9OO3D8BWi4E/99GMoaXaqQLABE1Ofrp5a', 'manager', 'MAPAGA', 'Yvan Lionel', 'yvan-lionel.mapaga@aninf.ga', NULL, 1, 'CAbpyUEL6TRaPDhxe04Jmsw2J58bvpnp2s7xf06Dhr0hk8NhTtBSoqSQxhjYsKMEgeCHMEyk7lthVd8d', NULL, 'yqU8CbaB6YlmCQI0A6nI2Ye5rdXBmre1qcPg1QIQn9Dfv31w1048KbwiLf3l', '2020-06-12 00:03:54', '2020-06-12 01:09:35', 5),
(26, 'harris.ndjounga', '$2y$10$.q4yfKHeO7cRxt0ZBHX/0eY8aeYo/yNfsPkuzOYQSLDibJZ3CQoha', 'manager', 'NDJOUNGA', 'Harris', 'harris.ndjounga@aninf.ga', NULL, 1, 'CEgnm0ChR2r6i1vizN8Gy1PKyZooPRK17gmffKkbIywPOa77atgL78sNkcnOC9mydXR5ihLBmpBn1wes', NULL, NULL, '2020-06-12 01:42:39', '2020-06-12 01:42:39', 5);

-- --------------------------------------------------------

--
-- Structure de la vue `chapitres_demo`
--
DROP TABLE IF EXISTS `chapitres_demo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `chapitres_demo`  AS  select distinct `engagements`.`l_chap` AS `l_chap`,`engagements`.`chap` AS `chap` from `engagements` ;

-- --------------------------------------------------------

--
-- Structure de la vue `nature_depenses`
--
DROP TABLE IF EXISTS `nature_depenses`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nature_depenses`  AS  select distinct `engagements`.`nat_dep` AS `nat_dep` from `engagements` order by `engagements`.`nat_dep` ;

-- --------------------------------------------------------

--
-- Structure de la vue `providers`
--
DROP TABLE IF EXISTS `providers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `providers`  AS  select distinct `engagements`.`l_nmtir` AS `name` from `engagements` ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bejcs`
--
ALTER TABLE `bejcs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bejcs_chapitre_id_index` (`chapitre_id`),
  ADD KEY `bejcs_user_id_index` (`user_id`);

--
-- Index pour la table `bejc_echelon`
--
ALTER TABLE `bejc_echelon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `echelon_bejc_echelon_id_index` (`echelon_id`),
  ADD KEY `echelon_bejc_bejc_id_index` (`bejc_id`);

--
-- Index pour la table `bejc_items`
--
ALTER TABLE `bejc_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bejc_items_engagement_id_index` (`engagement_id`),
  ADD KEY `bejc_items_bejc_id_index` (`bejc_id`);

--
-- Index pour la table `chapitres`
--
ALTER TABLE `chapitres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chapitres_n_chap_unique` (`n_chap`),
  ADD UNIQUE KEY `chapitres_l_chap_unique` (`l_chap`);

--
-- Index pour la table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `document_echelon`
--
ALTER TABLE `document_echelon`
  ADD KEY `document_echelon_document_id_index` (`document_id`),
  ADD KEY `document_echelon_echelon_id_index` (`echelon_id`);

--
-- Index pour la table `echelons`
--
ALTER TABLE `echelons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `echelons_n_engagement_index` (`n_engage`),
  ADD KEY `echelons_user_id_index` (`user_id`),
  ADD KEY `echelons_engagement_id_index` (`engagement_id`);

--
-- Index pour la table `engagements`
--
ALTER TABLE `engagements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `n_devis` (`n_devis`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fichiers`
--
ALTER TABLE `fichiers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `groups_created_by_index` (`created_by`),
  ADD KEY `groups_updated_by_index` (`updated_by`);

--
-- Index pour la table `group_permission`
--
ALTER TABLE `group_permission`
  ADD KEY `group_permission_group_id_foreign` (`group_id`),
  ADD KEY `group_permission_permission_id_foreign` (`permission_id`);

--
-- Index pour la table `historiques`
--
ALTER TABLE `historiques`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `importations`
--
ALTER TABLE `importations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_module_id_index` (`module_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_api_token_unique` (`api_token`),
  ADD KEY `users_group_id_index` (`group_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bejcs`
--
ALTER TABLE `bejcs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `bejc_echelon`
--
ALTER TABLE `bejc_echelon`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bejc_items`
--
ALTER TABLE `bejc_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `chapitres`
--
ALTER TABLE `chapitres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `echelons`
--
ALTER TABLE `echelons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT pour la table `engagements`
--
ALTER TABLE `engagements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7543;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fichiers`
--
ALTER TABLE `fichiers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `historiques`
--
ALTER TABLE `historiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `importations`
--
ALTER TABLE `importations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bejc_echelon`
--
ALTER TABLE `bejc_echelon`
  ADD CONSTRAINT `echelon_bejc_bejc_id_foreign` FOREIGN KEY (`bejc_id`) REFERENCES `bejcs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `echelon_bejc_echelon_id_foreign` FOREIGN KEY (`echelon_id`) REFERENCES `echelons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `document_echelon`
--
ALTER TABLE `document_echelon`
  ADD CONSTRAINT `document_echelon_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `document_echelon_echelon_id_foreign` FOREIGN KEY (`echelon_id`) REFERENCES `echelons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `echelons`
--
ALTER TABLE `echelons`
  ADD CONSTRAINT `echelons_engagement_id_foreign` FOREIGN KEY (`engagement_id`) REFERENCES `engagements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `echelons_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `groups_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `group_permission`
--
ALTER TABLE `group_permission`
  ADD CONSTRAINT `group_permission_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
