-- phpMyAdmin SQL Dump
-- version 4.0.10.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 12 Janvier 2016 à 17:33
-- Version du serveur: 5.5.44-0ubuntu0.14.04.1
-- Version de PHP: 5.5.9-1ubuntu4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `zadmin_intranet`
--

-- --------------------------------------------------------

--
-- Structure de la table `Classes`
--

CREATE TABLE IF NOT EXISTS `Classes` (
  `idClasse` int(11) NOT NULL AUTO_INCREMENT,
  `nomClasse` varchar(32) NOT NULL,
  `delegue1` varchar(32) DEFAULT NULL,
  `delegue2` varchar(32) DEFAULT NULL,
  `idPromo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idClasse`),
  UNIQUE KEY `nomClasse` (`nomClasse`),
  KEY `delegue1` (`delegue1`),
  KEY `delegue2` (`delegue2`),
  KEY `idPromo` (`idPromo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Structure de la table `Disponibilites`
--

CREATE TABLE IF NOT EXISTS `Disponibilites` (
  `Enseignant` varchar(32) NOT NULL,
  `Disponibilites` text NOT NULL,
  KEY `idUtilisateur` (`Enseignant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `GroupeProjet`
--

CREATE TABLE IF NOT EXISTS `GroupeProjet` (
  `idGroupe` int(11) NOT NULL AUTO_INCREMENT,
  `chefGroupe` varchar(32) NOT NULL,
  `idProjet` int(11) DEFAULT NULL,
  `dateSoutenance` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idGroupe`),
  KEY `chefGroupe` (`chefGroupe`,`idProjet`),
  KEY `chefGroupe_2` (`chefGroupe`),
  KEY `idProjet` (`idProjet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Structure de la table `Planning`
--

CREATE TABLE IF NOT EXISTS `Planning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Titre` varchar(1000) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Description` varchar(1000) NOT NULL,
  `idPromo` int(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idPromo` (`idPromo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Structure de la table `Projets`
--

CREATE TABLE IF NOT EXISTS `Projets` (
  `idProjet` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `remarques` text,
  `tuteur` varchar(32) NOT NULL,
  `tuteur_bis` varchar(32) DEFAULT NULL,
  `actif` tinyint(4) NOT NULL,
  `idPromo` int(11) NOT NULL,
  PRIMARY KEY (`idProjet`),
  KEY `tuteur` (`tuteur`),
  KEY `tuteur_2` (`tuteur`),
  KEY `tuteur_bis` (`tuteur_bis`),
  KEY `idPromo` (`idPromo`),
  KEY `idPromo_2` (`idPromo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Structure de la table `Promotions`
--

CREATE TABLE IF NOT EXISTS `Promotions` (
  `idPromo` int(11) NOT NULL AUTO_INCREMENT,
  `niveau` varchar(32) NOT NULL,
  PRIMARY KEY (`idPromo`),
  KEY `niveau` (`niveau`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateurs`
--

CREATE TABLE IF NOT EXISTS `Utilisateurs` (
  `login` varchar(32) NOT NULL,
  `nom` varchar(32) NOT NULL,
  `prenom` varchar(32) NOT NULL,
  `idGroupe` int(11) DEFAULT NULL,
  `idClasse` int(11) DEFAULT NULL,
  PRIMARY KEY (`login`),
  KEY `idGroupe` (`idGroupe`),
  KEY `idGroupe_2` (`idGroupe`),
  KEY `idGroupe_3` (`idGroupe`),
  KEY `idClasse` (`idClasse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Voeux`
--

CREATE TABLE IF NOT EXISTS `Voeux` (
  `idGroupe` int(16) NOT NULL,
  `idProjet` int(16) NOT NULL,
  `classement` int(16) NOT NULL,
  KEY `idProjet` (`idProjet`),
  KEY `idGroupe` (`idGroupe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Classes`
--
ALTER TABLE `Classes`
  ADD CONSTRAINT `fk_promo` FOREIGN KEY (`idPromo`) REFERENCES `Promotions` (`idPromo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_del1` FOREIGN KEY (`delegue1`) REFERENCES `Utilisateurs` (`login`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_del2` FOREIGN KEY (`delegue2`) REFERENCES `Utilisateurs` (`login`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Disponibilites`
--
ALTER TABLE `Disponibilites`
  ADD CONSTRAINT `fk_dispo` FOREIGN KEY (`Enseignant`) REFERENCES `Utilisateurs` (`login`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `GroupeProjet`
--
ALTER TABLE `GroupeProjet`
  ADD CONSTRAINT `fk_GroupChiefUser` FOREIGN KEY (`chefGroupe`) REFERENCES `Utilisateurs` (`login`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idProjet` FOREIGN KEY (`idProjet`) REFERENCES `Projets` (`idProjet`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Planning`
--
ALTER TABLE `Planning`
  ADD CONSTRAINT `Planning_ibfk_1` FOREIGN KEY (`idPromo`) REFERENCES `Promotions` (`idPromo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Projets`
--
ALTER TABLE `Projets`
  ADD CONSTRAINT `fk_creator` FOREIGN KEY (`tuteur`) REFERENCES `Utilisateurs` (`login`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_promoId` FOREIGN KEY (`idPromo`) REFERENCES `Promotions` (`idPromo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tutor_bis` FOREIGN KEY (`tuteur_bis`) REFERENCES `Utilisateurs` (`login`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  ADD CONSTRAINT `fk_appartientClasse` FOREIGN KEY (`idClasse`) REFERENCES `Classes` (`idClasse`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_appartientGroupe` FOREIGN KEY (`idGroupe`) REFERENCES `GroupeProjet` (`idGroupe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Voeux`
--
ALTER TABLE `Voeux`
  ADD CONSTRAINT `Voeux_ibfk_1` FOREIGN KEY (`idGroupe`) REFERENCES `GroupeProjet` (`idGroupe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Voeux_ibfk_2` FOREIGN KEY (`idProjet`) REFERENCES `Projets` (`idProjet`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
