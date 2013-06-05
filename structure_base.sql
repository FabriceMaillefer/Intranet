SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `articlebase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Ordre` int(11) NOT NULL,
  `Descriptif` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Quantite` double NOT NULL,
  `Unite` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `PrixUnitaire` double NOT NULL,
  `DateCreation` datetime NOT NULL,
  `type_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `articlefacture` (
  `id` int(11) NOT NULL,
  `facture_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6FAB55577F2DEE08` (`facture_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `articleoffre` (
  `id` int(11) NOT NULL,
  `offre_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9B1185894CC8505A` (`offre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `chantier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `offre_id` int(11) DEFAULT NULL,
  `Architecte` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Lieu` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateDebut` date DEFAULT NULL,
  `DateFin` date DEFAULT NULL,
  `DateCreation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9A1945A04CC8505A` (`offre_id`),
  KEY `IDX_9A1945A019EB6921` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Adresse` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NPA` int(11) DEFAULT NULL,
  `Localite` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateCreation` datetime NOT NULL,
  `Divers` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `facture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `chantier_id` int(11) DEFAULT NULL,
  `statut_id` int(11) NOT NULL,
  `DateCreation` datetime NOT NULL,
  `DateImpression` datetime DEFAULT NULL,
  `datePayement` datetime DEFAULT NULL,
  `ReferenceClient` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Rabais` double DEFAULT NULL,
  `TVA` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_313B5D8CD0C0049D` (`chantier_id`),
  KEY `IDX_313B5D8C19EB6921` (`client_id`),
  KEY `IDX_313B5D8CF6203804` (`statut_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `fos_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `fourniture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chantier_id` int(11) DEFAULT NULL,
  `Descriptif` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Quantite` double NOT NULL,
  `Date` date NOT NULL,
  `DateCreation` datetime NOT NULL,
  `Unite` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `type_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5CD967D7D0C0049D` (`chantier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `fourniture1d` (
  `id` int(11) NOT NULL,
  `longueur` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `fourniture2d` (
  `id` int(11) NOT NULL,
  `largeur` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `fourniture3d` (
  `id` int(11) NOT NULL,
  `hauteur` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `offre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `statut_id` int(11) NOT NULL,
  `DateCreation` datetime NOT NULL,
  `DateImpression` datetime DEFAULT NULL,
  `ReferenceClient` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TVA` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6E47A96B19EB6921` (`client_id`),
  KEY `IDX_6E47A96BF6203804` (`statut_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `statutfacture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Statut` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

INSERT INTO `statutfacture` (`id`, `Statut`) VALUES
(1, 'En création'),
(2, 'Envoyée au client'),
(3, 'Payée');

CREATE TABLE IF NOT EXISTS `statutoffre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Statut` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

INSERT INTO `statutoffre` (`id`, `Statut`) VALUES
(1, 'En création'),
(2, 'Envoyée au client'),
(3, 'Acceptée'),
(4, 'Refusée');


ALTER TABLE `articlefacture`
  ADD CONSTRAINT `FK_6FAB5557BF396750` FOREIGN KEY (`id`) REFERENCES `articlebase` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6FAB55577F2DEE08` FOREIGN KEY (`facture_id`) REFERENCES `facture` (`id`);

ALTER TABLE `articleoffre`
  ADD CONSTRAINT `FK_9B118589BF396750` FOREIGN KEY (`id`) REFERENCES `articlebase` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_9B1185894CC8505A` FOREIGN KEY (`offre_id`) REFERENCES `offre` (`id`);

ALTER TABLE `chantier`
  ADD CONSTRAINT `FK_9A1945A04CC8505A` FOREIGN KEY (`offre_id`) REFERENCES `offre` (`id`),
  ADD CONSTRAINT `FK_9A1945A019EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

ALTER TABLE `facture`
  ADD CONSTRAINT `FK_313B5D8CF6203804` FOREIGN KEY (`statut_id`) REFERENCES `statutfacture` (`id`),
  ADD CONSTRAINT `FK_313B5D8C19EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `FK_313B5D8CD0C0049D` FOREIGN KEY (`chantier_id`) REFERENCES `chantier` (`id`);

ALTER TABLE `fourniture`
  ADD CONSTRAINT `FK_5CD967D7D0C0049D` FOREIGN KEY (`chantier_id`) REFERENCES `chantier` (`id`);

ALTER TABLE `fourniture1d`
  ADD CONSTRAINT `FK_EB9A6B3EBF396750` FOREIGN KEY (`id`) REFERENCES `fourniture` (`id`) ON DELETE CASCADE;

ALTER TABLE `fourniture2d`
  ADD CONSTRAINT `FK_C0B738FDBF396750` FOREIGN KEY (`id`) REFERENCES `fourniture` (`id`) ON DELETE CASCADE;

ALTER TABLE `fourniture3d`
  ADD CONSTRAINT `FK_D9AC09BCBF396750` FOREIGN KEY (`id`) REFERENCES `fourniture` (`id`) ON DELETE CASCADE;

ALTER TABLE `offre`
  ADD CONSTRAINT `FK_6E47A96BF6203804` FOREIGN KEY (`statut_id`) REFERENCES `statutoffre` (`id`),
  ADD CONSTRAINT `FK_6E47A96B19EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
