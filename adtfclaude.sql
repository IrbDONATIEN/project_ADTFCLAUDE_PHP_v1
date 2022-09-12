-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 07 nov. 2020 à 11:16
-- Version du serveur :  5.7.31
-- Version de PHP : 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `adtfclaude`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997');

-- --------------------------------------------------------

--
-- Structure de la table `agence`
--

DROP TABLE IF EXISTS `agence`;
CREATE TABLE IF NOT EXISTS `agence` (
  `idag` int(11) NOT NULL AUTO_INCREMENT,
  `codAg` varchar(100) NOT NULL,
  `idprov` int(11) NOT NULL,
  `matriculeFiscale` varchar(100) NOT NULL,
  `nomAg` varchar(100) NOT NULL,
  `adresseAg` varchar(200) NOT NULL,
  `telephone` varchar(30) NOT NULL,
  `emailAg` varchar(200) NOT NULL,
  `etatAg` bit(1) NOT NULL DEFAULT b'1',
  `dateCreationAg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idag`),
  KEY `idprov` (`idprov`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `agence`
--

INSERT INTO `agence` (`idag`, `codAg`, `idprov`, `matriculeFiscale`, `nomAg`, `adresseAg`, `telephone`, `emailAg`, `etatAg`, `dateCreationAg`) VALUES
(1, 'A170287', 3, 'A139291A1', 'CROIS SEULEMENT LUBUMBASHI', 'AV. LIKASI, C/LUBUMBASHI, HAUT-KATANGA', '202021', 'croisseulementlubumbashi@gmail.com', b'1', '2020-11-06 03:45:17'),
(2, 'A137232', 15, 'A321A131', 'CROIS SEULEMENT KOLWEZI', 'Bld Lumumba, C/DILALA, KOLWEZI', '2292020', 'croisseulementkolwezi@gmail.com', b'1', '2020-11-06 03:47:36');

-- --------------------------------------------------------

--
-- Structure de la table `beneficiaire`
--

DROP TABLE IF EXISTS `beneficiaire`;
CREATE TABLE IF NOT EXISTS `beneficiaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomBen` varchar(100) NOT NULL,
  `postnomBen` varchar(100) NOT NULL,
  `prenomBen` varchar(100) NOT NULL,
  `telephoneBen` varchar(30) NOT NULL,
  `adresseBen` varchar(200) NOT NULL,
  `client_ben_id` int(11) NOT NULL,
  `etat_ben` tinyint(4) NOT NULL DEFAULT '0',
  `dateCreation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `agence_ben_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `agence_ben_id` (`agence_ben_id`),
  KEY `client_ben_id` (`client_ben_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `beneficiaire`
--

INSERT INTO `beneficiaire` (`id`, `nomBen`, `postnomBen`, `prenomBen`, `telephoneBen`, `adresseBen`, `client_ben_id`, `etat_ben`, `dateCreation`, `agence_ben_id`) VALUES
(1, 'CLAUVIS', 'CLAUVIS', 'CLAUVIS', '293992', 'KOLWEZI', 1, 1, '2020-11-06 15:50:02', 1),
(2, 'TITI', 'TITA', 'TOTI', '3223', 'KOLWEZI', 2, 1, '2020-11-06 18:59:10', 1),
(3, 'GEDEON', 'KADIATA', 'LOUI', '000887', 'AV BIL', 3, 1, '2020-11-07 07:36:49', 2);

-- --------------------------------------------------------

--
-- Structure de la table `bon_retrail`
--

DROP TABLE IF EXISTS `bon_retrail`;
CREATE TABLE IF NOT EXISTS `bon_retrail` (
  `id_bon` int(11) NOT NULL AUTO_INCREMENT,
  `motif` varchar(100) NOT NULL,
  `date_create` date NOT NULL,
  `beneficiaire_id` int(11) NOT NULL,
  `agence_bon_id` int(11) NOT NULL,
  `etat_transaction` int(11) NOT NULL,
  PRIMARY KEY (`id_bon`),
  KEY `beneficiaire_id` (`beneficiaire_id`),
  KEY `agence_bon_id` (`agence_bon_id`),
  KEY `etat_transaction` (`etat_transaction`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `bon_retrail`
--

INSERT INTO `bon_retrail` (`id_bon`, `motif`, `date_create`, `beneficiaire_id`, `agence_bon_id`, `etat_transaction`) VALUES
(1, 'Retrait Fonds', '2020-11-07', 1, 2, 1),
(2, 'Retrait Fonds', '2020-11-07', 2, 2, 2),
(3, 'BON DE RETRAIT', '2020-12-06', 3, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `telephone` varchar(30) NOT NULL,
  `etat` tinyint(4) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `agence_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `agence_id` (`agence_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `nom`, `prenom`, `telephone`, `etat`, `date_created`, `agence_id`) VALUES
(1, 'CLAUDE', 'CLAUDE', '29292', 1, '2020-11-06 15:11:03', 1),
(2, 'TATI', 'TATI', '29393', 1, '2020-11-06 18:48:24', 1),
(3, 'NKULU', 'RUTH', '09888888', 1, '2020-11-07 07:35:57', 2);

-- --------------------------------------------------------

--
-- Structure de la table `guichets`
--

DROP TABLE IF EXISTS `guichets`;
CREATE TABLE IF NOT EXISTS `guichets` (
  `codeGuichet` varchar(100) NOT NULL,
  `nomGuichet` varchar(100) NOT NULL,
  `etatGuichet` bit(1) NOT NULL DEFAULT b'1',
  `idAg` int(11) NOT NULL,
  PRIMARY KEY (`codeGuichet`),
  KEY `idAg` (`idAg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `guichets`
--

INSERT INTO `guichets` (`codeGuichet`, `nomGuichet`, `etatGuichet`, `idAg`) VALUES
('G107182', 'A', b'1', 1),
('G122207', 'B', b'1', 2),
('G137232', 'B', b'1', 1),
('G5392', 'A', b'1', 2);

-- --------------------------------------------------------

--
-- Structure de la table `horaires`
--

DROP TABLE IF EXISTS `horaires`;
CREATE TABLE IF NOT EXISTS `horaires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `horaires`
--

INSERT INTO `horaires` (`id`, `heure_debut`, `heure_fin`) VALUES
(1, '12:00:00', '12:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `umatricule` varchar(30) NOT NULL,
  `type` varchar(100) NOT NULL,
  `message` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `umatricule` (`umatricule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
CREATE TABLE IF NOT EXISTS `provinces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomProvince` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `provinces`
--

INSERT INTO `provinces` (`id`, `nomProvince`) VALUES
(1, 'Bas-Uele'),
(2, 'Equateur'),
(3, 'Haut-Katanga'),
(4, 'Haut-Lomami'),
(5, 'Haut-Uele'),
(6, 'Ituri'),
(7, 'KasaÃ¯'),
(8, 'KasaÃ¯-Central'),
(9, 'KasaÃ¯-Oriental'),
(10, 'Kinshasa'),
(11, 'Kongo-Central'),
(12, 'Kwango'),
(13, 'Kwilu'),
(14, 'Lomami'),
(15, 'Lualaba'),
(16, 'Mai-Ndombe'),
(17, 'Maniema'),
(18, 'Mongala'),
(19, 'Nord-kivu'),
(20, 'Nord-Ubangi'),
(21, 'Sankuru'),
(22, 'Sud-Kivu'),
(23, 'Sud-Ubangi'),
(24, 'Tanganyika'),
(25, 'Tshopo'),
(26, 'Tshuapa');

-- --------------------------------------------------------

--
-- Structure de la table `responsables`
--

DROP TABLE IF EXISTS `responsables`;
CREATE TABLE IF NOT EXISTS `responsables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matricule` varchar(100) NOT NULL,
  `idrole` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `postnom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `sexe` varchar(10) NOT NULL,
  `loginU` varchar(255) NOT NULL,
  `passwordU` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `telephone` varchar(30) NOT NULL,
  `etat` bit(1) NOT NULL DEFAULT b'1',
  `dateCreation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_ag` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idrole` (`idrole`),
  KEY `id_ag` (`id_ag`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `responsables`
--

INSERT INTO `responsables` (`id`, `matricule`, `idrole`, `nom`, `postnom`, `prenom`, `sexe`, `loginU`, `passwordU`, `email`, `adresse`, `telephone`, `etat`, `dateCreation`, `id_ag`) VALUES
(1, '2959', 1, 'YUMBA', 'NTUMBA', 'CLAUDE', 'Masculin', 'CLAUDE', '11111', 'claudeyumba@gmail.com', 'Lubumbashi', '202020', b'1', '2020-11-06 03:50:40', 1),
(2, '2952', 2, 'TATI', 'TATI', 'TATI', 'Masculin', 'TATI', '22222', 'tati@gmail.com', 'LUBUMBASHI', '29281', b'1', '2020-11-06 03:51:36', 1),
(3, '5067', 3, 'TITI', 'TITI', 'TITI', 'Feminin', 'TITI', '33333', 'titi@gmail.com', 'LUBUMBASHI', '29292', b'1', '2020-11-06 03:53:21', 1),
(4, '5033', 1, 'CLAUVIS', 'CLAUVIS', 'CLAUVIS', 'Masculin', 'Clauvis', '12345', 'clauvis@gmail.com', 'KOLWEZI', '10202', b'1', '2020-11-06 03:54:52', 2),
(5, '5077', 2, 'TOTO', 'TOTO', 'TOTO', 'Masculin', 'TOTO', '44444', 'toto@gmail.com', 'KOLWEZI', '290121', b'1', '2020-11-06 03:56:28', 2),
(6, '1732', 3, 'TATU', 'TATU', 'TATU', 'Masculin', 'TATU', '55555', 'tatu@gmail.com', 'KOLWEZI', '9292', b'1', '2020-11-06 04:02:19', 2);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomRole` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `nomRole`) VALUES
(1, 'Operateur'),
(2, 'Caissier 1'),
(3, 'Caissier 2');

-- --------------------------------------------------------

--
-- Structure de la table `transfert`
--

DROP TABLE IF EXISTS `transfert`;
CREATE TABLE IF NOT EXISTS `transfert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codeTrans` varchar(100) NOT NULL,
  `montantTrans` decimal(65,2) NOT NULL DEFAULT '2.00',
  `pourcentage` int(11) NOT NULL,
  `etat_transfert` tinyint(4) NOT NULL DEFAULT '0',
  `date_enreg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `client_id` int(11) NOT NULL,
  `agence_exp_id` int(11) NOT NULL,
  `agence_dest_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `agence_exp_id` (`agence_exp_id`),
  KEY `client_id` (`client_id`),
  KEY `agence_dest_id` (`agence_dest_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `transfert`
--

INSERT INTO `transfert` (`id`, `codeTrans`, `montantTrans`, `pourcentage`, `etat_transfert`, `date_enreg`, `client_id`, `agence_exp_id`, `agence_dest_id`) VALUES
(1, '62107', '20000.00', 20, 1, '2020-11-06 16:57:26', 1, 1, 2),
(2, '104177', '30000.00', 20, 1, '2020-11-06 18:59:44', 2, 1, 2),
(3, '170287', '7000.00', 10, 1, '2020-11-07 07:37:29', 3, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `visitors`
--

DROP TABLE IF EXISTS `visitors`;
CREATE TABLE IF NOT EXISTS `visitors` (
  `id` int(2) NOT NULL,
  `hits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `visitors`
--

INSERT INTO `visitors` (`id`, `hits`) VALUES
(0, 74);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `agence`
--
ALTER TABLE `agence`
  ADD CONSTRAINT `agence_ibfk_1` FOREIGN KEY (`idprov`) REFERENCES `provinces` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `beneficiaire`
--
ALTER TABLE `beneficiaire`
  ADD CONSTRAINT `beneficiaire_ibfk_1` FOREIGN KEY (`agence_ben_id`) REFERENCES `agence` (`idag`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `beneficiaire_ibfk_2` FOREIGN KEY (`client_ben_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `bon_retrail`
--
ALTER TABLE `bon_retrail`
  ADD CONSTRAINT `bon_retrail_ibfk_1` FOREIGN KEY (`agence_bon_id`) REFERENCES `agence` (`idag`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bon_retrail_ibfk_2` FOREIGN KEY (`beneficiaire_id`) REFERENCES `beneficiaire` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bon_retrail_ibfk_3` FOREIGN KEY (`etat_transaction`) REFERENCES `transfert` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`agence_id`) REFERENCES `agence` (`idag`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `guichets`
--
ALTER TABLE `guichets`
  ADD CONSTRAINT `guichets_ibfk_1` FOREIGN KEY (`idAg`) REFERENCES `agence` (`idag`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `responsables`
--
ALTER TABLE `responsables`
  ADD CONSTRAINT `responsables_ibfk_1` FOREIGN KEY (`idrole`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `responsables_ibfk_2` FOREIGN KEY (`id_ag`) REFERENCES `agence` (`idag`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `transfert`
--
ALTER TABLE `transfert`
  ADD CONSTRAINT `transfert_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfert_ibfk_2` FOREIGN KEY (`agence_exp_id`) REFERENCES `agence` (`idag`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfert_ibfk_3` FOREIGN KEY (`agence_dest_id`) REFERENCES `agence` (`idag`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
